<?php

namespace App\Traits;

use App\Models\PageSeo;
use App\Models\SeoSetting;

trait HasSeo
{
    public static function getSeoData($slug = null, $pageType = 'static', $pageId = null)
    {
        // Try to get specific page SEO first
        $pageSeo = null;
        
        if ($slug) {
            $pageSeo = PageSeo::getSeoForSlug($slug);
        } elseif ($pageType && $pageId) {
            $pageSeo = PageSeo::getForPage($pageType, $pageId);
        }
        
        // Get global settings as fallback
        $globalSettings = SeoSetting::getGlobalSettings();
        
        return [
            'title' => $pageSeo->meta_title ?? $globalSettings['site_title'],
            'description' => $pageSeo->meta_description ?? $globalSettings['meta_description'],
            'keywords' => $pageSeo->meta_keywords ?? $globalSettings['meta_keywords'],
            'canonical' => $pageSeo->canonical_url ?? null,
            'og_title' => $pageSeo->og_title ?? $pageSeo->meta_title ?? $globalSettings['site_title'],
            'og_description' => $pageSeo->og_description ?? $pageSeo->meta_description ?? $globalSettings['meta_description'],
            'og_image' => media_url($pageSeo->og_image ?? $globalSettings['og_default_image']),
            'noindex' => $pageSeo->noindex ?? $globalSettings['global_noindex'],
            'nofollow' => $pageSeo->nofollow ?? $globalSettings['global_nofollow'],
            'favicon' => !empty($globalSettings['favicon']) ? media_url($globalSettings['favicon']) : asset('assets/favicon/favicon.ico'),
        ];
    }
}