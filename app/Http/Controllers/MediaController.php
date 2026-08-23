<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    /**
     * Common MIME type lookup for instant, zero-overhead Content-Type resolution.
     */
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
    ];

    /**
     * Securely stream media files from Cloudflare R2 / storage disks with edge caching and CORS.
     */
    public function show(string $path)
    {
        // Sanitize path to prevent directory traversal
        $path = ltrim($path, '/\\');
        if (str_contains($path, '..')) {
            abort(403, 'Invalid media path.');
        }

        // Strip leading redundant prefixes if present
        $cleanPath = preg_replace('#^(media|storage|public)/+#', '', $path);

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $defaultMime = self::MIME_TYPES[$extension] ?? null;

        $headers = [
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'Access-Control-Allow-Origin' => '*',
            'X-Content-Type-Options' => 'nosniff',
        ];

        // 1. Check Cloudflare R2 disk (if configured)
        if (config('filesystems.disks.r2.key') || config('filesystems.default') === 'r2') {
            foreach (array_unique([$path, $cleanPath]) as $targetPath) {
                try {
                    $r2 = Storage::disk('r2');
                    if ($r2->exists($targetPath)) {
                        $mimeType = $defaultMime;
                        if (!$mimeType) {
                            try {
                                $mimeType = $r2->mimeType($targetPath);
                            } catch (\Throwable) {
                                $mimeType = 'application/octet-stream';
                            }
                        }

                        $stream = $r2->readStream($targetPath);
                        if ($stream && is_resource($stream)) {
                            return response()->stream(function () use ($stream) {
                                fpassthru($stream);
                                if (is_resource($stream)) {
                                    fclose($stream);
                                }
                            }, 200, array_merge($headers, ['Content-Type' => $mimeType]));
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning("MediaController: R2 read error for [{$targetPath}]: " . $e->getMessage());
                }
            }
        }

        // 2. Check default configured disk (if not r2)
        $defaultDisk = config('filesystems.default');
        if ($defaultDisk && $defaultDisk !== 'r2') {
            foreach (array_unique([$path, $cleanPath]) as $targetPath) {
                try {
                    $disk = Storage::disk($defaultDisk);
                    if ($disk->exists($targetPath)) {
                        $mimeType = $defaultMime ?? $disk->mimeType($targetPath) ?? 'application/octet-stream';
                        $stream = $disk->readStream($targetPath);
                        if ($stream && is_resource($stream)) {
                            return response()->stream(function () use ($stream) {
                                fpassthru($stream);
                                if (is_resource($stream)) {
                                    fclose($stream);
                                }
                            }, 200, array_merge($headers, ['Content-Type' => $mimeType]));
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning("MediaController: Default disk [{$defaultDisk}] read error for [{$targetPath}]: " . $e->getMessage());
                }
            }
        }

        // 3. Check public storage disk (storage/app/public)
        foreach (array_unique([$path, $cleanPath]) as $targetPath) {
            try {
                if (Storage::disk('public')->exists($targetPath)) {
                    $fileHeaders = $defaultMime ? array_merge($headers, ['Content-Type' => $defaultMime]) : $headers;
                    return response()->file(Storage::disk('public')->path($targetPath), $fileHeaders);
                }
            } catch (\Throwable) {}
        }

        // 4. Check local storage disk (storage/app/private)
        foreach (array_unique([$path, $cleanPath]) as $targetPath) {
            try {
                if (Storage::disk('local')->exists($targetPath)) {
                    $fileHeaders = $defaultMime ? array_merge($headers, ['Content-Type' => $defaultMime]) : $headers;
                    return response()->file(Storage::disk('local')->path($targetPath), $fileHeaders);
                }
            } catch (\Throwable) {}
        }

        // 5. Check public root assets directory
        foreach (array_unique([$path, $cleanPath, 'storage/' . $cleanPath]) as $candidate) {
            $publicFilePath = public_path($candidate);
            if (file_exists($publicFilePath) && is_file($publicFilePath)) {
                $fileHeaders = $defaultMime ? array_merge($headers, ['Content-Type' => $defaultMime]) : $headers;
                return response()->file($publicFilePath, $fileHeaders);
            }
        }

        abort(404, 'Image not found.');
    }
}

