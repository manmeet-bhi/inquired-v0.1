<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsAdminActivity;

class Job extends Model
{
    use HasFactory, LogsAdminActivity;

    protected $fillable = [
        'title',
        'slug',
        'job_id',
        'company_id',
        'category_id',
        'location',
        'experience',
        'type',
        'work_type',
        'level',
        'salary_min',
        'salary_max',
        'salary_currency',
        'content',
        'application_deadline',
        'external_url',
        'application_url',
        'is_featured',
        'is_active',
        'admin_created_by'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'application_deadline' => 'date'
    ];

    protected static function booted()
    {
        static::saved(function ($job) {
            \Illuminate\Support\Facades\Cache::flush();
        });

        static::deleted(function ($job) {
            \Illuminate\Support\Facades\Cache::flush();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_created_by');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRemote($query)
    {
        return $query->where('work_type', 'remote');
    }

    public function scopeOnsite($query)
    {
        return $query->where('work_type', 'onsite');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedSalaryAttribute()
    {
        if ($this->salary_min && $this->salary_max) {
            return '₹' . number_format($this->salary_min) . ' - ₹' . number_format($this->salary_max);
        }
        return null;
    }

    public function getStipendAttribute()
    {
        // For internships, use salary_min as monthly stipend
        if ($this->type === 'internship' && $this->salary_min) {
            return $this->salary_min;
        }
        return null;
    }
}