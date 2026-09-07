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

        // 1. If it's a local project asset or project logo, serve strictly locally from public directory (0 R2 bandwidth)
        $publicCandidates = [
            $path,
            $cleanPath,
            'assets/' . $cleanPath,
            'assets/logos/' . basename($cleanPath),
            'assets/favicon/' . basename($cleanPath),
            'assets/icons/' . $cleanPath,
            'assets/images/' . $cleanPath,
            'assets/css/' . basename($cleanPath),
            'assets/js/' . basename($cleanPath),
            'storage/' . $cleanPath,
        ];

        foreach (array_unique($publicCandidates) as $candidate) {
            $publicFilePath = public_path($candidate);
            if (file_exists($publicFilePath) && is_file($publicFilePath)) {
                $fileHeaders = $defaultMime ? array_merge($headers, ['Content-Type' => $defaultMime]) : $headers;
                return response()->file($publicFilePath, $fileHeaders);
            }
        }

        // 2. For company logos and uploaded media (blog, icons, og-images, seo, uploads), check Cloudflare R2
        $isUploadedMedia = str_starts_with($cleanPath, 'company-logos/') 
            || str_starts_with($cleanPath, 'company-logo/')
            || str_starts_with($cleanPath, 'blog/')
            || str_starts_with($cleanPath, 'post-images/')
            || str_starts_with($cleanPath, 'icons/')
            || str_starts_with($cleanPath, 'og-images/')
            || str_starts_with($cleanPath, 'seo/')
            || str_starts_with($cleanPath, 'uploads/');

        if ($isUploadedMedia && (config('filesystems.disks.r2.token') || config('filesystems.disks.r2.key') || config('filesystems.default') === 'r2')) {
            $r2Candidates = [$cleanPath];

            if (str_starts_with($cleanPath, 'company-logos/')) {
                $r2Candidates[] = 'company-logo/' . substr($cleanPath, 14);
            } elseif (str_starts_with($cleanPath, 'company-logo/')) {
                $r2Candidates[] = 'company-logos/' . substr($cleanPath, 13);
            } elseif (str_starts_with($cleanPath, 'blog/')) {
                $r2Candidates[] = 'post-images/' . substr($cleanPath, 5);
            } elseif (str_starts_with($cleanPath, 'post-images/')) {
                $r2Candidates[] = 'blog/' . substr($cleanPath, 12);
            } elseif (str_starts_with($cleanPath, 'og-images/')) {
                $r2Candidates[] = 'seo/og-images/' . substr($cleanPath, 10);
            } elseif (str_starts_with($cleanPath, 'seo/og-images/')) {
                $r2Candidates[] = 'og-images/' . substr($cleanPath, 14);
            }

            $r2 = Storage::disk('r2');
            foreach (array_unique($r2Candidates) as $targetPath) {
                try {
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

        // 3. Fallback: check local storage disks
        $storageDisks = ['public', 'local'];
        foreach ($storageDisks as $diskName) {
            try {
                $disk = Storage::disk($diskName);
                if ($disk->exists($cleanPath)) {
                    $fileHeaders = $defaultMime ? array_merge($headers, ['Content-Type' => $defaultMime]) : $headers;
                    return response()->file($disk->path($cleanPath), $fileHeaders);
                }
            } catch (\Throwable) {}
        }

        abort(404, 'Image not found.');
    }
}
