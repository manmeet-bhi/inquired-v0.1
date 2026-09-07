<?php

namespace App\Services;

use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToRetrieveMetadata;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareR2Adapter implements FilesystemAdapter
{
    protected string $accountId;
    protected string $token;
    protected string $bucket;
    protected string $baseUrl;

    private const MIME_TYPES = [
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'avif' => 'image/avif',
        'pdf'  => 'application/pdf',
        'mp4'  => 'video/mp4',
        'txt'  => 'text/plain',
        'json' => 'application/json',
        'xml'  => 'application/xml',
        'css'  => 'text/css',
        'js'   => 'application/javascript',
    ];

    public function __construct(string $accountId, string $token, string $bucket)
    {
        $this->accountId = $accountId;
        $this->token = $token;
        $this->bucket = $bucket;
        $this->baseUrl = "https://api.cloudflare.com/client/v4/accounts/{$accountId}/r2/buckets/{$bucket}/objects";
    }

    protected function sanitizePath(string $path): string
    {
        return ltrim($path, '/\\');
    }

    protected function detectMimeType(string $path): string
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return self::MIME_TYPES[$extension] ?? 'application/octet-stream';
    }

    public function fileExists(string $path): bool
    {
        $path = $this->sanitizePath($path);
        if (empty($path)) {
            return false;
        }

        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->get("{$this->baseUrl}?prefix=" . urlencode($path) . "&per_page=5");

            if ($response->successful()) {
                $results = $response->json('result', []);
                foreach ($results as $item) {
                    if (($item['key'] ?? '') === $path) {
                        return true;
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning("CloudflareR2Adapter::fileExists error for [{$path}]: " . $e->getMessage());
        }

        return false;
    }

    public function directoryExists(string $path): bool
    {
        $path = rtrim($this->sanitizePath($path), '/') . '/';
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->get("{$this->baseUrl}?prefix=" . urlencode($path) . "&per_page=1");

            if ($response->successful()) {
                $results = $response->json('result', []);
                return !empty($results);
            }
        } catch (\Throwable $e) {
            Log::warning("CloudflareR2Adapter::directoryExists error for [{$path}]: " . $e->getMessage());
        }

        return false;
    }

    public function write(string $path, string $contents, Config $config): void
    {
        $path = $this->sanitizePath($path);
        $mimeType = $config->get('ContentType') ?? $this->detectMimeType($path);

        try {
            $response = Http::withToken($this->token)
                ->timeout(30)
                ->withBody($contents, $mimeType)
                ->put("{$this->baseUrl}/{$path}");

            if (!$response->successful()) {
                throw UnableToWriteFile::atLocation($path, $response->body());
            }
        } catch (\Throwable $e) {
            if ($e instanceof UnableToWriteFile) {
                throw $e;
            }
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function writeStream(string $path, $resource, Config $config): void
    {
        $contents = stream_get_contents($resource);
        if ($contents === false) {
            throw UnableToWriteFile::atLocation($path, 'Failed to read input resource stream.');
        }

        $this->write($path, $contents, $config);
    }

    public function read(string $path): string
    {
        $path = $this->sanitizePath($path);

        try {
            $response = Http::withToken($this->token)
                ->timeout(30)
                ->get("{$this->baseUrl}/{$path}");

            if (!$response->successful()) {
                throw UnableToReadFile::fromLocation($path, "Status: " . $response->status());
            }

            return $response->body();
        } catch (\Throwable $e) {
            if ($e instanceof UnableToReadFile) {
                throw $e;
            }
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    public function readStream(string $path)
    {
        $contents = $this->read($path);
        $stream = fopen('php://temp', 'r+');
        if ($stream === false) {
            throw UnableToReadFile::fromLocation($path, 'Failed to open temporary stream.');
        }

        fwrite($stream, $contents);
        rewind($stream);

        return $stream;
    }

    public function delete(string $path): void
    {
        $path = $this->sanitizePath($path);

        try {
            $response = Http::withToken($this->token)
                ->timeout(15)
                ->delete("{$this->baseUrl}/{$path}");

            if (!$response->successful() && $response->status() !== 404) {
                throw UnableToDeleteFile::atLocation($path, $response->body());
            }
        } catch (\Throwable $e) {
            if ($e instanceof UnableToDeleteFile) {
                throw $e;
            }
            throw UnableToDeleteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function deleteDirectory(string $path): void
    {
        $path = rtrim($this->sanitizePath($path), '/') . '/';
        foreach ($this->listContents($path, true) as $item) {
            if ($item instanceof FileAttributes) {
                $this->delete($item->path());
            }
        }
    }

    public function createDirectory(string $path, Config $config): void
    {
        $path = rtrim($this->sanitizePath($path), '/') . '/';
        // Create an empty folder placeholder in R2
        $this->write($path, '', $config);
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // R2 objects inherit bucket visibility or public domain settings
    }

    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, null, 'public');
    }

    public function mimeType(string $path): FileAttributes
    {
        return new FileAttributes($path, null, null, null, $this->detectMimeType($path));
    }

    public function lastModified(string $path): FileAttributes
    {
        $path = $this->sanitizePath($path);
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->get("{$this->baseUrl}?prefix=" . urlencode($path) . "&per_page=1");

            if ($response->successful()) {
                $items = $response->json('result', []);
                if (!empty($items[0]['last_modified'])) {
                    $timestamp = strtotime($items[0]['last_modified']);
                    return new FileAttributes($path, null, null, $timestamp);
                }
            }
        } catch (\Throwable) {}

        return new FileAttributes($path, null, null, time());
    }

    public function fileSize(string $path): FileAttributes
    {
        $path = $this->sanitizePath($path);
        try {
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->get("{$this->baseUrl}?prefix=" . urlencode($path) . "&per_page=1");

            if ($response->successful()) {
                $items = $response->json('result', []);
                if (isset($items[0]['size'])) {
                    return new FileAttributes($path, (int) $items[0]['size']);
                }
            }
        } catch (\Throwable) {}

        throw UnableToRetrieveMetadata::fileSize($path);
    }

    public function listContents(string $path, bool $deep): iterable
    {
        $path = $this->sanitizePath($path);
        $prefix = empty($path) ? '' : rtrim($path, '/') . '/';
        $cursor = null;

        do {
            $url = "{$this->baseUrl}?per_page=1000";
            if (!empty($prefix)) {
                $url .= "&prefix=" . urlencode($prefix);
            }
            if (!empty($cursor)) {
                $url .= "&cursor=" . urlencode($cursor);
            }

            try {
                $response = Http::withToken($this->token)->timeout(15)->get($url);
                if (!$response->successful()) {
                    break;
                }

                $data = $response->json('result', []);
                foreach ($data as $item) {
                    $key = $item['key'] ?? '';
                    if (empty($key)) continue;

                    if (str_ends_with($key, '/')) {
                        yield new DirectoryAttributes(rtrim($key, '/'));
                    } else {
                        yield new FileAttributes(
                            $key,
                            $item['size'] ?? null,
                            'public',
                            isset($item['last_modified']) ? strtotime($item['last_modified']) : null,
                            $item['http_metadata']['contentType'] ?? $this->detectMimeType($key)
                        );
                    }
                }

                $cursor = $response->json('result_info.cursor', null);
            } catch (\Throwable $e) {
                Log::warning("CloudflareR2Adapter::listContents error: " . $e->getMessage());
                break;
            }
        } while ($cursor !== null);
    }

    public function move(string $source, string $destination, Config $config): void
    {
        $this->copy($source, $destination, $config);
        $this->delete($source);
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        $contents = $this->read($source);
        $this->write($destination, $contents, $config);
    }
}
