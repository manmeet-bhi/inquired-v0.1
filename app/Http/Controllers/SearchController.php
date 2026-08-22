<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Company;
use App\Models\JobCategory;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', $request->get('keyword', ''));
        $location = $request->get('location', $request->get('city', ''));
        $type = $request->get('type', '');
        $workType = $request->get('work_type', '');
        $category = $request->get('category', '');
        $level = $request->get('level', '');
        $company = $request->get('company', '');
        $featured = $request->get('featured', '');
        
        // New filters
        $datePosted = $request->get('date_posted', '');
        $salaryRanges = $request->get('salary', []);
        $jobTypes = $request->get('job_type', []);
        $categories = $request->get('categories', []);
        $sortBy = $request->get('sort_by', 'relevant');
        
        $jobs = collect();
        $companies = collect();
        $totalResults = 0;
        
        // Smart Query Parsing
        if (!empty($query) && empty($location)) {
            // Check for explicit "location" keyword
            if (stripos($query, ' location ') !== false) {
                $parts = preg_split('/ location /i', $query);
                if (count($parts) > 1) {
                    $query = trim($parts[0]);
                    $location = trim($parts[1]);
                    $request->merge(['keyword' => $query, 'location' => $location]); // Update request for view consistency
                }
            }
            // Check for " in " keyword
            elseif (stripos($query, ' in ') !== false) {
                $parts = preg_split('/ in /i', $query);
                // Ensure the part after "in" is not too long to be a location (basic heuristic)
                if (count($parts) > 1 && strlen($parts[1]) < 30) {
                    $query = trim($parts[0]);
                    $location = trim($parts[1]);
                    $request->merge(['keyword' => $query, 'location' => $location]);
                }
            }
        }
        
        // Build the cache key based on all request parameters
        $page = $request->get('page', 1);
        $allParams = serialize($request->all());
        $cacheKey = "search_results_p{$page}_" . md5($allParams);

        $results = \Illuminate\Support\Facades\Cache::remember($cacheKey, 1800, function() use ($request, $query, $location, $level, $company, $featured, $sortBy, $categories) {
            // Build the jobs query
            $jobsQuery = Job::with(['company', 'category'])
                ->where('is_active', true);
            
            // Apply search filters
            if (!empty($query)) {
                $jobsQuery->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('content', 'LIKE', "%{$query}%")
                      ->orWhereHas('company', function($companyQuery) use ($query) {
                          $companyQuery->where('name', 'LIKE', "%{$query}%");
                      });
                });
            }
            
            // Apply other filters
            if ($request->has('date') && $request->date !== 'all') {
                $days = (int) $request->date;
                $jobsQuery->where('created_at', '>=', now()->subDays($days));
            }

            if ($request->has('salary') && $request->salary !== 'any') {
                $range = explode('-', $request->salary);
                if (count($range) === 2) {
                    $min = (float) $range[0] * 100000;
                    $max = (float) $range[1] * 100000;
                    
                    $jobsQuery->where(function($q) use ($min, $max) {
                        $q->whereBetween('salary_min', [$min, $max])
                          ->orWhereBetween('salary_max', [$min, $max])
                          ->orWhere(function($subQ) use ($min, $max) {
                              $subQ->where('salary_min', '<=', $min)
                                   ->where('salary_max', '>=', $max);
                          });
                    });
                }
            }
            
            $mode = $request->get('mode', $request->get('work_type'));
            if ($mode && $mode !== 'all' && $mode !== 'any') {
                $jobsQuery->where('work_type', $mode);
            }
            
            $jobType = $request->get('type', $request->get('job_type'));
            if ($jobType && $jobType !== 'all') {
                if (is_array($jobType)) {
                     $jobsQuery->whereIn('type', $jobType);
                } else {
                     $jobsQuery->where('type', $jobType);
                }
            }

            if (!empty($categories)) {
                $jobsQuery->whereHas('category', function($q) use ($categories) {
                    $q->whereIn('slug', $categories);
                });
            }
            
            if ($location) {
                 $jobsQuery->where('location', 'LIKE', "%{$location}%");
            }

            if ($level) {
                $jobsQuery->where('level', $level);
            }
            if ($company) {
                 $jobsQuery->whereHas('company', function($q) use ($company) {
                    $q->where('slug', $company);
                });
            }
            if ($featured) {
                $jobsQuery->where('is_featured', true);
            }
            
            switch ($sortBy) {
                case 'salary_high':
                    $jobsQuery->orderBy('salary_max', 'desc');
                    break;
                case 'salary_low':
                    $jobsQuery->orderBy('salary_min', 'asc');
                    break;
                case 'date_new':
                    $jobsQuery->latest();
                    break;
                case 'date_old':
                    $jobsQuery->oldest();
                    break;
                default:
                    $jobsQuery->orderBy('is_featured', 'desc')->latest();
                    break;
            }
            
            $jobsPaginated = $jobsQuery->paginate(21);
            return [
                'jobs' => $jobsPaginated,
                'totalResults' => $jobsPaginated->total()
            ];
        });

        $jobs = $results['jobs'];
        $totalResults = $results['totalResults'];
        
        // Get filter options
        $allCategories = \Illuminate\Support\Facades\Cache::remember('search_all_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });
        $trendingSearches = collect();
        
        return view('search-results', compact(
            'query', 'location', 'type', 'workType', 'category', 'level', 'company', 'featured',
            'datePosted', 'salaryRanges', 'jobTypes', 'categories', 'sortBy',
            'jobs', 'totalResults', 'allCategories', 'trendingSearches'
        ));
    }
}