<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\PageSeo;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SitemapService
{
    /**
     * Cache for noindexed pages to avoid redundant queries
     */
    private array $noindexList = [];

    /**
     * Track already added URLs to prevent any duplication
     */
    private array $addedUrls = [];

    /**
     * Generate standard-compliant XML Sitemap
     */
    public function generateXml(): string
    {
        $this->loadNoindexList();
        $this->addedUrls = [];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml"' . "\n";
        $xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // 1. Home Page (Highest Priority)
        if (!$this->isNoindexed('static', null, 'home')) {
            $latestJobDate = Job::where('is_active', true)->max('updated_at');
            $homeLastmod = $latestJobDate ? Carbon::parse($latestJobDate) : $this->getStaticLastmod('home');
            $xml .= $this->addUrl(url('/'), $homeLastmod, 'daily', '1.0');
        }

        // 2. Core Job Hubs & Static Pages
        $staticPages = PageSeo::getStaticPageSlugs();
        foreach ($staticPages as $slug => $name) {
            if ($slug === 'home' || $this->isNoindexed('static', null, $slug)) {
                continue;
            }

            $pageUrl = url('/' . $slug);
            $lastmod = $this->getStaticLastmod($slug);
            $changefreq = $this->staticChangeFrequency($slug);
            $priority = $this->staticPriority($slug);

            $xml .= $this->addUrl($pageUrl, $lastmod, $changefreq, $priority);
        }

        // 3. Dynamic Job Listings
        $jobs = Job::with('company')
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ->get();

        foreach ($jobs as $job) {
            if ($this->isNoindexed('job', $job->id)) {
                continue;
            }

            try {
                $jobUrl = route('jobs.show', [
                    'job' => $job->id,
                    'slug' => $job->slug ?: Str::slug($job->title ?: 'job'),
                ]);

                $lastmod = $job->updated_at ?? $job->created_at ?? now();
                $isRecent = $job->created_at && $job->created_at->diffInDays(now()) < 7;
                $changefreq = $isRecent ? 'daily' : 'weekly';
                $priority = $job->is_featured ? '0.90' : '0.80';

                $images = [];
                if ($job->company && $job->company->logo_url) {
                    $images[] = [
                        'loc' => $job->company->logo_url,
                        'title' => $job->title . ' at ' . ($job->company->name ?? 'Company'),
                    ];
                }

                $xml .= $this->addUrl($jobUrl, $lastmod, $changefreq, $priority, $images);
            } catch (\Throwable $e) {
                Log::warning('Skipping job during sitemap generation: ' . $e->getMessage(), [
                    'job_id' => $job->id,
                ]);
            }
        }

        // 4. Job Categories
        $categories = JobCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        foreach ($categories as $category) {
            if ($this->isNoindexed('category', $category->id)) {
                continue;
            }

            try {
                $categoryUrl = route('category.show', [
                    'slug' => $category->slug ?: Str::slug($category->name),
                ]);

                $xml .= $this->addUrl(
                    $categoryUrl,
                    $category->updated_at ?? now(),
                    'daily',
                    '0.80'
                );
            } catch (\Throwable $e) {
                Log::warning('Skipping category during sitemap generation: ' . $e->getMessage(), [
                    'category_id' => $category->id,
                ]);
            }
        }

        // 5. Companies
        $companies = Company::where('is_active', true)
            ->orderBy('name')
            ->get();

        foreach ($companies as $company) {
            if ($this->isNoindexed('company', $company->id)) {
                continue;
            }

            try {
                $companyUrl = route('company.show', [
                    'slug' => $company->slug ?: Str::slug($company->name),
                ]);

                $images = [];
                if ($company->logo_url) {
                    $images[] = [
                        'loc' => $company->logo_url,
                        'title' => $company->name,
                    ];
                }

                $xml .= $this->addUrl(
                    $companyUrl,
                    $company->updated_at ?? now(),
                    'weekly',
                    '0.70',
                    $images
                );
            } catch (\Throwable $e) {
                Log::warning('Skipping company during sitemap generation: ' . $e->getMessage(), [
                    'company_id' => $company->id,
                ]);
            }
        }

        // 6. Blog Posts
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        foreach ($posts as $post) {
            if ($this->isNoindexed('post', $post->id)) {
                continue;
            }

            try {
                $postUrl = route('blog.show', [
                    'post' => $post->slug ?? $post->id,
                ]);

                $lastmod = $post->updated_at ?? $post->published_at ?? $post->created_at ?? now();
                $isRecent = $post->published_at && $post->published_at->diffInDays(now()) < 14;
                $changefreq = $isRecent ? 'weekly' : 'monthly';

                $images = [];
                if ($post->featured_image_url) {
                    $images[] = [
                        'loc' => $post->featured_image_url,
                        'title' => $post->title,
                    ];
                }

                $xml .= $this->addUrl($postUrl, $lastmod, $changefreq, '0.70', $images);
            } catch (\Throwable $e) {
                Log::warning('Skipping blog post during sitemap generation: ' . $e->getMessage(), [
                    'post_id' => $post->id,
                ]);
            }
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Clear dynamic sitemap cache
     */
    public static function flushCache(): void
    {
        Cache::forget('dynamic_sitemap_xml');
    }

    /**
     * Ping Search Engines (Google, Bing)
     */
    public function notifySearchEngines(): void
    {
        $sitemapUrl = url('/sitemap.xml');

        foreach ([
            'Google' => 'https://www.google.com/ping?sitemap=',
            'Bing' => 'https://www.bing.com/ping?sitemap=',
        ] as $name => $endpoint) {
            try {
                Http::timeout(5)->get($endpoint . urlencode($sitemapUrl));
            } catch (\Throwable $e) {
                Log::info("Search engine ping ({$name}) notification attempt: " . $e->getMessage());
            }
        }
    }

    /**
     * Format a single URL node according to sitemaps.org specification
     */
    private function addUrl(
        string $url,
        $lastModified = null,
        string $changeFrequency = 'weekly',
        string $priority = '0.70',
        array $images = []
    ): string {
        // Prevent duplicate URLs
        if (isset($this->addedUrls[$url])) {
            return '';
        }
        $this->addedUrls[$url] = true;

        $date = $lastModified instanceof Carbon ? $lastModified : Carbon::parse($lastModified ?? now());
        $lastmod = $date->utc()->format('Y-m-d\TH:i:s+00:00');
        $escapedUrl = htmlspecialchars($url, ENT_XML1, 'UTF-8');

        $node = "  <url>\n";
        $node .= "    <loc>{$escapedUrl}</loc>\n";
        $node .= "    <lastmod>{$lastmod}</lastmod>\n";
        $node .= "    <changefreq>{$changeFrequency}</changefreq>\n";
        $node .= "    <priority>{$priority}</priority>\n";

        // Google Image Sitemap extension
        foreach ($images as $img) {
            if (!empty($img['loc'])) {
                $imgLoc = htmlspecialchars($img['loc'], ENT_XML1, 'UTF-8');
                $imgTitle = !empty($img['title']) ? htmlspecialchars($img['title'], ENT_XML1, 'UTF-8') : '';

                $node .= "    <image:image>\n";
                $node .= "      <image:loc>{$imgLoc}</image:loc>\n";
                if ($imgTitle) {
                    $node .= "      <image:title>{$imgTitle}</image:title>\n";
                }
                $node .= "    </image:image>\n";
            }
        }

        $node .= "  </url>\n";

        return $node;
    }

    private function loadNoindexList(): void
    {
        $noindexed = PageSeo::getNoindexedPages();
        $this->noindexList = [];

        foreach ($noindexed as $item) {
            if ($item->page_type === 'static') {
                $this->noindexList["static:{$item->slug}"] = true;
            } else {
                $this->noindexList["{$item->page_type}:{$item->page_id}"] = true;
            }
        }
    }

    private function isNoindexed(string $type, $id = null, $slug = null): bool
    {
        if ($type === 'static') {
            return isset($this->noindexList["static:{$slug}"]);
        }
        return isset($this->noindexList["{$type}:{$id}"]);
    }

    private function getStaticLastmod(string $slug): Carbon
    {
        $seo = PageSeo::where('page_type', 'static')->where('slug', $slug)->first();
        return $seo && $seo->updated_at ? $seo->updated_at : now()->startOfDay();
    }

    private function staticChangeFrequency(string $slug): string
    {
        return in_array($slug, [
            'jobs', 'remote-jobs', 'onsite-jobs', 'hybrid-jobs', 'internships',
            'fresher-jobs', 'part-time-jobs', 'companies', 'categories', 'blog',
            'unicorn-companies', 'startup-companies', 'mnc-companies'
        ], true) ? 'daily' : 'monthly';
    }

    private function staticPriority(string $slug): string
    {
        return match ($slug) {
            'jobs', 'remote-jobs', 'onsite-jobs', 'hybrid-jobs', 'internships', 'fresher-jobs', 'part-time-jobs' => '0.90',
            'companies', 'categories', 'blog', 'unicorn-companies', 'startup-companies', 'mnc-companies' => '0.80',
            default => '0.50',
        };
    }
}
