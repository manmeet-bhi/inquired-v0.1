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
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all');
        if (!in_array($tab, ['all', 'office', 'remote', 'hybrid'])) {
            $tab = 'all';
        }

        // Get latest jobs (top 21 jobs) based on selected tab
        $cacheKey = "home_latest_jobs_tab_{$tab}";
        $latestJobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($tab) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true);
            
            if ($tab === 'office') {
                $query->where('work_type', 'onsite');
            } elseif ($tab === 'remote') {
                $query->where('work_type', 'remote');
            } elseif ($tab === 'hybrid') {
                $query->where('work_type', 'hybrid');
            }
            
            return $query->latest()->limit(21)->get();
        });
        
        // Empty collections for backward compatibility
        $featuredItems = collect();
        $trendingSearches = collect();
        $categoryCards = collect();
        $locationCards = collect();
        $jobs = collect();
        $onsiteJobs = collect();
        $remoteJobs = collect();
        $internships = collect();
        
        // Get latest blog posts
        $posts = \Illuminate\Support\Facades\Cache::remember('home_latest_posts', 3600, function() {
            return Post::where('is_published', true)
                ->latest()
                ->take(6)
                ->get();
        });
        
        // Get job categories with job counts and descriptions
        $categories = \Illuminate\Support\Facades\Cache::remember('home_categories', 3600, function() {
            return JobCategory::where('is_active', true)
                ->withCount(['jobs' => function($query) {
                    $query->where('is_active', true);
                }])
                ->select('id', 'name', 'slug', 'description', 'color')
                ->orderBy('sort_order')
                ->get();
        });

        // Get SEO for homepage
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('home_page_seo', 3600, function() {
            return PageSeo::where('page_type', 'static')
                ->where('slug', 'home')
                ->first();
        });
        
        return view('index', compact(
            'latestJobs',
            'tab',
            'categories',
            'posts',
            'pageSeo',
            'jobs',
            'onsiteJobs',
            'remoteJobs',
            'internships',
            'featuredItems',
            'trendingSearches',
            'categoryCards',
            'locationCards'
        ));
    }
}