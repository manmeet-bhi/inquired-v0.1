<?php

namespace App\Console\Commands;

use App\Services\SitemapService;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'seo:generate-sitemap';
    protected $description = 'Generate XML sitemap for the job portal';

    public function __construct(private readonly SitemapService $sitemapService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Generating sitemap...');

        file_put_contents(public_path('sitemap.xml'), $this->sitemapService->generateXml());
        $this->info('Sitemap generated successfully at: ' . public_path('sitemap.xml'));

        $this->info('Notifying search engines...');
        $this->sitemapService->notifySearchEngines();
        $this->info('Sitemap generation completed.');

        return self::SUCCESS;
    }
}