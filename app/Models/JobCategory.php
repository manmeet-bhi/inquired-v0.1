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
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::deleting(function ($category) {
            // Delete associated Page SEO record if any
            try {
                \App\Models\PageSeo::where('page_type', 'category')->where('page_id', $category->id)->each(function ($pageSeo) {
                    $pageSeo->delete();
                });
            } catch (\Throwable) {}
        });

        static::saved(function ($category) {
            \Illuminate\Support\Facades\Cache::flush();
        });

        static::deleted(function ($category) {
            \Illuminate\Support\Facades\Cache::flush();
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
}