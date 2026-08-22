<?php

namespace App\Http\Controllers;

use App\Services\SitemapService;
use App\Models\SeoSetting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function __construct(private readonly SitemapService $sitemapService)
    {
    }

    /**
     * Return dynamic sitemap XML with HTTP caching.
     */
    public function index(): Response
    {
        // Cache XML for 1 hour, auto-invalidated on CMS updates
        $xml = Cache::remember('dynamic_sitemap_xml', 3600, function () {
            return $this->sitemapService->generateXml();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'X-Robots-Tag' => 'noindex, follow',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
        ]);
    }

    /**
     * Return dynamic robots.txt pointing to the current domain's sitemap.
     */
    public function robots(): Response
    {
        $globalSettings = SeoSetting::getGlobalSettings();
        $sitemapUrl = url('/sitemap.xml');

        if (!empty($globalSettings['robots_txt'])) {
            $content = $globalSettings['robots_txt'];
            // Replace hardcoded sitemap URL with dynamic current host
            $content = preg_replace('/Sitemap:\s*https?:\/\/[^\r\n]+/i', 'Sitemap: ' . $sitemapUrl, $content);
            if (!str_contains($content, 'Sitemap:')) {
                $content .= "\n\nSitemap: " . $sitemapUrl;
            }
        } else {
            $content = "User-agent: *\n" .
                "Disallow: /cms/\n" .
                "Disallow: /search\n" .
                "Disallow: /media/\n" .
                "Allow: /\n\n" .
                "Sitemap: " . $sitemapUrl . "\n";
        }

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
