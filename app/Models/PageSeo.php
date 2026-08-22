<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    protected $table = 'page_seo';
    
    protected $fillable = [
        'page_type', 'page_id', 'slug', 'meta_title', 'meta_description', 
        'meta_keywords', 'canonical_url', 'og_title', 'og_description', 
        'og_image', 'twitter_title', 'twitter_description', 'twitter_image', 
        'schema_json', 'noindex', 'nofollow'
    ];

    protected $casts = [
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function ($seo) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });

        static::deleted(function ($seo) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'page_id');
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'page_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'page_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'page_id');
    }

    public function getPageAttribute()
    {
        switch ($this->page_type) {
            case 'job':
                return $this->job;
            case 'category':
                return $this->category;
            case 'company':
                return $this->company;
            case 'post':
                return $this->post;
            default:
                return null;
        }
    }

    public function getPageNameAttribute()
    {
        switch ($this->page_type) {
            case 'job':
                return $this->job ? $this->job->title : 'Job #' . $this->page_id;
            case 'category':
                return $this->category ? $this->category->name : 'Category #' . $this->page_id;
            case 'company':
                return $this->company ? $this->company->name : 'Company #' . $this->page_id;
            case 'post':
                return $this->post ? $this->post->title : 'Post #' . $this->page_id;
            case 'static':
                return ucfirst(str_replace('-', ' ', $this->slug));
            default:
                return $this->slug;
        }
    }

    public static function getForPage($pageType, $pageId = null)
    {
        return static::where('page_type', $pageType)
                    ->where('page_id', $pageId)
                    ->first();
    }

    public static function createForPage($pageType, $pageId, $data)
    {
        return static::updateOrCreate(
            ['page_type' => $pageType, 'page_id' => $pageId],
            $data
        );
    }

    public static function getSeoForSlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    public static function getStaticPageSlugs()
    {
        return [
            'home' => 'Home',
            'jobs' => 'All Jobs',
            'remote-jobs' => 'Remote Jobs',
            'hybrid-jobs' => 'Hybrid Jobs',
            'onsite-jobs' => 'Onsite Jobs', 
            'internships' => 'Internships',
            'fresher-jobs' => 'Fresher Jobs',
            'part-time-jobs' => 'Part Time Jobs',
            'companies' => 'Companies',
            'categories' => 'Job Categories',
            'startup-companies' => 'Startup Companies',
            'mnc-companies' => 'MNC Companies',
            'unicorn-companies' => 'Unicorn Companies',
            'about' => 'About Us',
            'blog' => 'Blog',
            'contact' => 'Contact',
            'privacy' => 'Privacy Policy',
            'terms' => 'Terms of Service',
            'cookies' => 'Cookie Policy',
            'testimonials' => 'Testimonials',
            'support' => 'Support',
            'sitemap' => 'Sitemap',
        ];
    }

    /**
     * Get all pages that should NOT be indexed.
     */
    public static function getNoindexedPages()
    {
        return static::where('noindex', true)->get(['page_type', 'page_id', 'slug']);
    }
}
