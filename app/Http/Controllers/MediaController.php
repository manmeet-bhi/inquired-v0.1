<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    /**
     * Securely stream media files from Cloudflare R2 / local storage with edge caching.
     */
    public function show(string $path)
    {
        // Sanitize path to prevent directory traversal
        $path = ltrim($path, '/\\');
        if (str_contains($path, '..')) {
            abort(403, 'Invalid media path.');
        }

        $defaultDisk = config('filesystems.default');
        $disk = Storage::disk($defaultDisk);

        // 1. Try default storage disk (e.g. Cloudflare R2)
        try {
            if ($disk->exists($path)) {
                $mimeType = $disk->mimeType($path) ?? 'image/png';
                
                return response()->stream(function () use ($disk, $path) {
                    $stream = $disk->readStream($path);
                    if ($stream) {
                        fpassthru($stream);
                        if (is_resource($stream)) {
                            fclose($stream);
                        }
                    }
                }, 200, [
                    'Content-Type' => $mimeType,
                    'Cache-Control' => 'public, max-age=31536000, immutable',
                ]);
            }
        } catch (\Throwable $e) {
            // If remote disk read fails, try local fallback
        }

        // 2. Try public storage disk fallback
        if (Storage::disk('public')->exists($path)) {
            return response()->file(Storage::disk('public')->path($path), [
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }

        // 3. Try public assets directory fallback
        $publicFilePath = public_path($path);
        if (file_exists($publicFilePath) && is_file($publicFilePath)) {
            return response()->file($publicFilePath, [
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }

        abort(404, 'Image not found.');
    }
}
