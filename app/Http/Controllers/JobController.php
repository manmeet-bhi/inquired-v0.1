<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Post;
use App\Models\Company;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        // Get SEO for jobs page
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('jobs_index_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('jobs');
        });
        
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "jobs_index_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true);
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        // Fetch all categories for filter
        $categories = \Illuminate\Support\Facades\Cache::remember('jobs_filter_categories', 3600, function() {
            return JobCategory::where('is_active', true)
                ->withCount('jobs')
                ->orderBy('name')
                ->get();
        });
            
        return view('jobs.index', compact('jobs', 'categories', 'pageSeo'));
    }

    public function show($id, $slug = null)
    {
        $job = \Illuminate\Support\Facades\Cache::remember("job_show_{$id}", 3600, function() use ($id) {
            return Job::with(['company', 'category'])
                ->where('is_active', true)
                ->findOrFail($id);
        });

        // Check for unique view (we don't cache this as it varies per user/session)
        $viewedKey = 'viewed_job_' . $job->id;
        if (!session()->has($viewedKey)) {
            $job->increment('views_count');
            session()->put($viewedKey, true);
        }
        
        // Get SEO for this specific job
        $pageSeo = \Illuminate\Support\Facades\Cache::remember("job_seo_{$id}", 3600, function() use ($job) {
            return \App\Models\PageSeo::where('page_type', 'job')
                ->where('page_id', $job->id)
                ->first();
        });
        
        $relatedJobs = \Illuminate\Support\Facades\Cache::remember("job_related_{$job->id}_{$job->category_id}", 3600, function() use ($job) {
            return Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('category_id', $job->category_id)
                ->where('id', '!=', $job->id)
                ->limit(11)
                ->get();
        });
            
        return view('jobs.show', compact('job', 'relatedJobs', 'pageSeo'));
    }

    public function onsite(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('jobs_onsite_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('onsite-jobs');
        });
        
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "jobs_onsite_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('work_type', 'onsite');
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        $categories = \Illuminate\Support\Facades\Cache::remember('jobs_onsite_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });
            
        return view('jobs.onsite', compact('jobs', 'categories', 'pageSeo'));
    }

    public function remote(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('jobs_remote_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('remote-jobs');
        });
        
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "jobs_remote_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('work_type', 'remote');
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        $categories = \Illuminate\Support\Facades\Cache::remember('jobs_remote_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });
            
        return view('jobs.remote', compact('jobs', 'categories', 'pageSeo'));
    }

    public function hybrid(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('jobs_hybrid_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('hybrid-jobs');
        });
        
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "jobs_hybrid_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('work_type', 'hybrid');
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        $categories = \Illuminate\Support\Facades\Cache::remember('jobs_hybrid_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });
            
        return view('jobs.hybrid', compact('jobs', 'categories', 'pageSeo'));
    }

    public function internships(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('jobs_internships_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('internships');
        });
        
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "jobs_internships_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('type', 'internship');
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        $categories = \Illuminate\Support\Facades\Cache::remember('jobs_internships_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });
            
        return view('jobs.internships', compact('jobs', 'categories', 'pageSeo'));
    }

    public function partTime(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('jobs_part_time_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('part-time-jobs');
        });
        
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "jobs_part_time_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('type', 'part-time');
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        $categories = \Illuminate\Support\Facades\Cache::remember('jobs_part_time_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });
            
        return view('jobs.part-time', compact('jobs', 'categories', 'pageSeo'));
    }

    public function freshers(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('jobs_freshers_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('fresher-jobs');
        });
        
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "jobs_freshers_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where(function($q) {
                    $q->where('experience', 'Freshers')
                      ->orWhere('level', 'entry');
                });
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        $categories = \Illuminate\Support\Facades\Cache::remember('jobs_freshers_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });
            
        return view('jobs.freshers', compact('jobs', 'categories', 'pageSeo'));
    }

    public function companies(Request $request)
    {
        // If only unicorn is selected as company type, show the dedicated unicorn-companies view
        if ($request->has('company_type') && is_array($request->company_type) && count($request->company_type) === 1 && $request->company_type[0] === 'unicorn') {
            return $this->unicornCompanies($request);
        }

        $pageSeo = \Illuminate\Support\Facades\Cache::remember('companies_index_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('companies');
        });

        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "companies_index_p{$page}_" . md5($filters);

        $companies = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($request) {
            $query = Company::where('is_active', true)
                ->withCount('jobs')
                ->select('id', 'name', 'slug', 'description', 'logo', 'website', 'linkedin_url', 'industry', 'type', 'founded_year', 'address', 'is_active');

            // Filter by Company Type
            if ($request->has('company_type') && is_array($request->company_type)) {
                $query->whereIn('type', $request->company_type);
            }

            // Filter by Categories (companies that have jobs in selected categories)
            if ($request->has('categories') && is_array($request->categories)) {
                $query->whereHas('jobs.category', function ($q) use ($request) {
                    $q->whereIn('slug', $request->categories);
                });
            }

            return $query->orderBy('name')->paginate(12)->withQueryString();
        });

        // Fetch categories for filter
        $categories = \Illuminate\Support\Facades\Cache::remember('companies_filter_categories', 3600, function() {
            return JobCategory::where('is_active', true)
                ->withCount('jobs')
                ->orderBy('name')
                ->get();
        });
            
        return view('jobs.companies', compact('companies', 'categories', 'pageSeo'));
    }

    public function startupCompanies(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('startup_companies_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('startup-companies');
        });

        $page = $request->get('page', 1);
        $cacheKey = "startup_companies_p{$page}";

        $companies = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() {
            return Company::where('is_active', true)
                ->where('type', 'startup')
                ->withCount('jobs')
                ->select('id', 'name', 'slug', 'description', 'logo', 'website', 'linkedin_url', 'industry', 'type', 'founded_year', 'address', 'is_active')
                ->orderBy('name')
                ->paginate(12);
        });

            
        return view('pages.startup-companies', compact('companies', 'pageSeo'));
    }

    public function mncCompanies(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('mnc_companies_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('mnc-companies');
        });

        $page = $request->get('page', 1);
        $cacheKey = "mnc_companies_p{$page}";

        $companies = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() {
            return Company::where('is_active', true)
                ->where('type', 'mnc')
                ->withCount('jobs')
                ->select('id', 'name', 'slug', 'description', 'logo', 'website', 'linkedin_url', 'industry', 'type', 'founded_year', 'address', 'is_active')
                ->orderBy('name')
                ->paginate(12);
        });

            
        return view('pages.mnc-companies', compact('companies', 'pageSeo'));
    }

    public function unicornCompanies(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('unicorn_companies_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('unicorn-companies') ?? \App\Models\PageSeo::getSeoForSlug('companies');
        });

        $page = $request->get('page', 1);
        $cacheKey = "unicorn_companies_p{$page}";

        $companies = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() {
            return Company::where('is_active', true)
                ->where('type', 'unicorn')
                ->withCount('jobs')
                ->select('id', 'name', 'slug', 'description', 'logo', 'website', 'linkedin_url', 'industry', 'type', 'founded_year', 'address', 'is_active')
                ->orderBy('name')
                ->paginate(12);
        });

            
        return view('pages.unicorn-companies', compact('companies', 'pageSeo'));
    }

    public function categories(Request $request)
    {
        $pageSeo = \Illuminate\Support\Facades\Cache::remember('categories_index_seo', 3600, function() {
            return \App\Models\PageSeo::getSeoForSlug('categories');
        });

        $page = $request->get('page', 1);
        $cacheKey = "categories_index_p{$page}";

        $categories = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() {
            return JobCategory::where('is_active', true)
                ->withCount('jobs')
                ->orderBy('name')
                ->paginate(21);
        });
            
        return view('jobs.categories', compact('categories', 'pageSeo'));
    }

    public function categoryShow($slug, Request $request)
    {
        $category = \Illuminate\Support\Facades\Cache::remember("category_by_slug_{$slug}", 3600, function() use ($slug) {
            return JobCategory::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
        });
        
        // Get SEO for this category
        $pageSeo = \Illuminate\Support\Facades\Cache::remember("category_seo_{$category->id}", 3600, function() use ($category) {
            return \App\Models\PageSeo::where('page_type', 'category')
                ->where('page_id', $category->id)
                ->first();
        });
            
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "category_jobs_{$category->id}_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($category, $request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('category_id', $category->id);
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        return view('jobs.category', compact('jobs', 'category', 'pageSeo'));
    }

    public function companyShow($slug, Request $request)
    {
        $company = \Illuminate\Support\Facades\Cache::remember("company_by_slug_{$slug}", 3600, function() use ($slug) {
            return Company::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
        });
        
        // Get SEO for this company
        $pageSeo = \Illuminate\Support\Facades\Cache::remember("company_seo_{$company->id}", 3600, function() use ($company) {
            return \App\Models\PageSeo::where('page_type', 'company')
                ->where('page_id', $company->id)
                ->first();
        });
            
        $page = $request->get('page', 1);
        $filters = serialize($request->all());
        $cacheKey = "company_jobs_{$company->id}_p{$page}_" . md5($filters);

        $jobs = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($company, $request) {
            $query = Job::with(['company', 'category'])
                ->where('is_active', true)
                ->where('company_id', $company->id);
            $this->applyFilters($query, $request);
            return $query->paginate(11)->withQueryString();
        });
            
        $categories = \Illuminate\Support\Facades\Cache::remember('company_show_categories', 3600, function() {
            return JobCategory::where('is_active', true)->orderBy('name')->get();
        });

        return view('jobs.company', compact('jobs', 'company', 'categories', 'pageSeo'));
    }

    public function getJobsByType($type)
    {
        $jobs = Job::where('is_active', true)
            ->where('type', $type)
            ->latest()
            ->get();
        
        return response()->json($jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->title,
                'company' => $job->company,
                'location' => $job->location,
                'type' => $job->type,
                'employment_type' => $job->employment_type ?? 'full-time',
                'salary' => $job->salary,
                'is_featured' => $job->is_featured ?? false,
                'company_logo' => $job->company_logo,
                'created_at' => $job->created_at->diffForHumans(),
            ];
        }));
    }
    
    private function applyFilters($query, Request $request)
    {
        // Date Posted Filter
        if ($request->has('date') && $request->date !== 'all') {
            $days = (int) $request->date;
            $query->where('created_at', '>=', now()->subDays($days));
        }
        
        // Salary Filter
        if ($request->has('salary') && $request->salary !== 'any') {
            $range = explode('-', $request->salary);
            if (count($range) === 2) {
                $min = (float) $range[0] * 100000; // Convert LPA to actual amount
                $max = (float) $range[1] * 100000;
                $query->where(function($q) use ($min, $max) {
                    $q->whereBetween('salary_min', [$min, $max])
                      ->orWhereBetween('salary_max', [$min, $max])
                      ->orWhere(function($subQ) use ($min, $max) {
                          $subQ->where('salary_min', '<=', $min)
                               ->where('salary_max', '>=', $max);
                      });
                });
            }
        }
        
        // Work Mode Filter (for internships)
        if ($request->has('mode') && $request->mode !== 'all') {
            $query->where('work_type', $request->mode);
        }
        
        // Job Type Filter (employment type)
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Categories Filter
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('slug', $request->categories);
            });
        }
        
        // Location/City Filter
        $location = $request->get('location', $request->get('city'));
        if ($location && $location !== 'all') {
            $query->where('location', 'LIKE', '%' . $location . '%');
        }

        // Sort By
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('is_featured', 'desc')->oldest();
                break;
            case 'newest':
                $query->orderBy('is_featured', 'desc')->latest();
                break;
            case 'salary-desc':
                $query->orderBy('is_featured', 'desc')->orderByRaw('COALESCE(salary_max, 0) DESC');
                break;
            case 'salary-asc':
                $query->orderBy('is_featured', 'desc')->orderByRaw('COALESCE(salary_min, 0) ASC');
                break;
            default: // newest
                $query->orderBy('is_featured', 'desc')->latest();
                break;
        }
    }
}