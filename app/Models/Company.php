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
        'description',
        'logo',
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

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }

        if (str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }

        $disk = env('FILESYSTEM_DISK', config('filesystems.default'));
        return \Illuminate\Support\Facades\Storage::disk($disk)->url($this->logo);
    }
}