<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsAdminActivity;

class Post extends Model
{
    use HasFactory, LogsAdminActivity;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'is_published',
        'user_id',
        'admin_user_id',
        'tags',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'is_published' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::saved(function ($post) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });

        static::deleted(function ($post) {
            \Illuminate\Support\Facades\Cache::forget('dynamic_sitemap_xml');
        });
    }

    public function getAuthorAttribute()
    {
        if ($this->adminUser) {
            return $this->adminUser->name;
        }

        if ($this->user) {
            return $this->user->name;
        }

        return 'Unknown Author';
    }

    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return null;
        }

        if (str_starts_with($this->featured_image, 'http')) {
            return $this->featured_image;
        }

        return \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($this->featured_image);
    }
}