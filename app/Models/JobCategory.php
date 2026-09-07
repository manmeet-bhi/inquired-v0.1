<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'icon',
        'icon_file',
        'color',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::deleting(function ($category) {
            if (!empty($category->icon_file)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->delete($category->icon_file);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Category deletion error for icon [{$category->icon_file}]: " . $e->getMessage());
                }
                if (file_exists(public_path('assets/icons/categories/' . $category->icon_file))) {
                    @unlink(public_path('assets/icons/categories/' . $category->icon_file));
                }
            }

            // Also delete associated Page SEO record if any
            try {
                \App\Models\PageSeo::where('page_type', 'category')->where('page_id', $category->id)->each(function ($pageSeo) {
                    $pageSeo->delete();
                });
            } catch (\Throwable) {}
        });

        static::saved(function ($category) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });

        static::deleted(function ($category) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getIconUrlAttribute()
    {
        if (!$this->icon_file) {
            return null;
        }

        if (str_starts_with($this->icon_file, 'http://') || str_starts_with($this->icon_file, 'https://')) {
            return $this->icon_file;
        }

        if (str_starts_with($this->icon_file, 'icons/')) {
            return media_url($this->icon_file);
        }

        if (file_exists(public_path('assets/icons/categories/' . $this->icon_file))) {
            return asset('assets/icons/categories/' . $this->icon_file);
        }

        return media_url('icons/' . $this->icon_file);
    }
}