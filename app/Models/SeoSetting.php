<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getGlobalSettings()
    {
        return \Illuminate\Support\Facades\Cache::remember('global_seo_settings', 3600, function() {
            $settings = static::all()->pluck('value', 'key');
            
            return [
                // Basic SEO
                'site_title' => $settings->get('site_title', 'Anywhereroles - Find Your Dream Job'),
                'meta_description' => $settings->get('meta_description', 'Find your dream job with top companies. Explore remote, onsite, and internship opportunities.'),
                'meta_keywords' => $settings->get('meta_keywords', 'jobs, careers, employment, job search'),
                'meta_canonical' => $settings->get('meta_canonical', ''),
                
                // Social SEO
                'og_title' => $settings->get('og_title', ''),
                'og_description' => $settings->get('og_description', ''),
                'og_type' => $settings->get('og_type', 'website'),
                'og_url' => $settings->get('og_url', ''),
                'og_site_name' => $settings->get('og_site_name', 'Anywhereroles'),
                'og_locale' => $settings->get('og_locale', 'en_US'),
                'twitter_card' => $settings->get('twitter_card', 'summary_large_image'),
                'twitter_site' => $settings->get('twitter_site', ''),
                'twitter_title' => $settings->get('twitter_title', ''),
                'twitter_description' => $settings->get('twitter_description', ''),
                'twitter_creator' => $settings->get('twitter_creator', ''),

                // Technical SEO
                'viewport' => $settings->get('viewport', 'width=device-width, initial-scale=1.0'),
                'charset' => $settings->get('charset', 'UTF-8'),
                'theme_color' => $settings->get('theme_color', '#2563eb'),
                'preconnect_urls' => $settings->get('preconnect_urls', ''),
                'robots_txt' => $settings->get('robots_txt', "User-agent: *\nDisallow: /cms/\nDisallow: /admin/\nSitemap: " . url('/sitemap.xml')),
                'global_noindex' => (bool)$settings->get('global_noindex', false),
                'global_nofollow' => (bool)$settings->get('global_nofollow', false),
                'favicon' => $settings->get('favicon'),

                // Structured Data
                'schema_json' => $settings->get('schema_json', ''),

                // Legacy variables (kept to prevent breaking before view edits)
                'facebook_url' => $settings->get('facebook_url', ''),
                'twitter_url' => $settings->get('twitter_url', ''),
                'og_default_image' => $settings->get('og_default_image'),
            ];
        });
    }
}
