<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsAdminActivity;

class Company extends Model
{
    use HasFactory, LogsAdminActivity;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'website',
        'linkedin_url',
        'email',
        'phone',
        'address',
        'industry',
        'type',
        'founded_year',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'founded_year' => 'integer'
    ];

    protected static function booted()
    {
        static::deleting(function ($company) {
            // Also delete associated Page SEO record if any
            try {
                \App\Models\PageSeo::where('page_type', 'company')->where('page_id', $company->id)->each(function ($pageSeo) {
                    $pageSeo->delete();
                });
            } catch (\Throwable) {}
        });

        static::saved(function ($company) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });

        static::deleted(function ($company) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}