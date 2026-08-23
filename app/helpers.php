<?php

if (!function_exists('getSeoData')) {
    function getSeoData($slug = null, $pageType = 'static', $pageId = null)
    {
        return \App\Traits\HasSeo::getSeoData($slug, $pageType, $pageId);
    }
}

if (!function_exists('renderSeoMeta')) {
    function renderSeoMeta($slug = null, $pageType = 'static', $pageId = null)
    {
        $seoData = getSeoData($slug, $pageType, $pageId);
        
        return view('components.seo-meta', $seoData)->render();
    }
}

if (!function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Clean redundant prefixes if present in stored DB path
        $cleanPath = ltrim($path, '/\\');

        // If custom R2 public domain/CDN is explicitly set (and not localhost in production)
        $r2Url = config('filesystems.disks.r2.url');
        if (!empty($r2Url) && !str_contains($r2Url, 'localhost') && !str_contains($r2Url, '127.0.0.1')) {
            return rtrim($r2Url, '/') . '/' . $cleanPath;
        }

        // Always resolve through the /media route dynamically adapting to current APP_URL
        return url('media/' . $cleanPath);
    }
}

if (!function_exists('sanitize_html')) {
    function sanitize_html($content)
    {
        return \App\Services\HtmlSanitizer::clean($content);
    }
}