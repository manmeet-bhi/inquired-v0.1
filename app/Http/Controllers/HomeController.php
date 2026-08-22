<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Post;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\PageSeo;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest jobs for homepage
        $jobs = \Illuminate\Support\Facades\Cache::remember('home_latest_jobs', 3600, function() {
            return Job::with('company', 'category')
                ->where('is_active', true)
                ->orderBy('is_featured', 'desc')
                ->latest()
                ->limit(10)
                ->get();
        });
        
        // Get featured items (empty collection since Featured is removed)
        $featuredItems = collect();
        
        // Get onsite jobs
        $onsiteJobs = \Illuminate\Support\Facades\Cache::remember('home_onsite_jobs', 3600, function() {
            return Job::with('company')
                ->where('is_active', true)
                ->where('work_type', 'onsite')
                ->latest()
                ->limit(6)
                ->get();
        });
        
        // Get remote jobs
        $remoteJobs = \Illuminate\Support\Facades\Cache::remember('home_remote_jobs', 3600, function() {
            return Job::with('company')
                ->where('is_active', true)
                ->where('work_type', 'remote')
                ->latest()
                ->limit(6)
                ->get();
        });
        
        // Get internships
        $internships = \Illuminate\Support\Facades\Cache::remember('home_internship_jobs', 3600, function() {
            return Job::with('company')
                ->where('is_active', true)
                ->where('type', 'internship')
                ->orderBy('is_featured', 'desc')
                ->latest()
                ->limit(6)
                ->get();
        });
        
        // Get latest blog posts
        $posts = \Illuminate\Support\Facades\Cache::remember('home_latest_posts', 3600, function() {
            return Post::where('is_published', true)
                ->latest()
                ->take(6)
                ->get();
        });
        
        // Get trending searches (empty collection since TrendingSearch is removed)
        $trendingSearches = collect();
        
        // Get job categories with job counts and descriptions
        $categories = \Illuminate\Support\Facades\Cache::remember('home_categories', 3600, function() {
            return JobCategory::where('is_active', true)
                ->withCount(['jobs' => function($query) {
                    $query->where('is_active', true);
                }])
                ->select('id', 'name', 'slug', 'description', 'icon', 'icon_file', 'color')
                ->orderBy('sort_order')
                ->get();
        });
        
        // Get quick cards (empty collections since QuickCard is removed)
        $categoryCards = collect();
        $locationCards = collect();
        
        // Get latest jobs for homepage grid (40 cards)
        $latestJobs = \Illuminate\Support\Facades\Cache::remember('home_latest_jobs_grid', 3600, function() {
            return Job::with('company', 'category')
                ->where('is_active', true)
                ->latest()
                ->limit(40)
                ->get();
        });

        // Get SEO for homepage
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('home_page_seo', 3600, function() {
            return PageSeo::where('page_type', 'static')
                ->where('slug', 'home')
                ->first();
        });
        
        return view('index', compact('jobs', 'onsiteJobs', 'remoteJobs', 'internships', 'posts', 'featuredItems', 'trendingSearches', 'categories', 'categoryCards', 'locationCards', 'latestJobs', 'pageSeo'));
    }
}