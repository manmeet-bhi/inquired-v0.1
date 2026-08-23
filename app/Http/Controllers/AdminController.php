<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Post;
use App\Models\JobCategory;
use App\Models\AdminUser;
use App\Models\Testimonial;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendRecoveryCodes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{


    public function dashboard()
    {
        $stats = [
            'total_jobs' => Job::where('type', '!=', 'internship')->count(),
            'total_internships' => Job::where('type', 'internship')->count(),
            'active_jobs' => Job::where('is_active', true)->count(),
            'total_companies' => Company::count(),
            'total_categories' => JobCategory::count(),
            'total_posts' => Post::count(),
            'recent_jobs' => Job::with('company')->where('type', '!=', 'internship')->latest()->take(6)->get(),
            'recent_internships' => Job::with('company')->where('type', 'internship')->latest()->take(5)->get(),
            'recent_posts' => Post::latest()->take(5)->get()
        ];
        
        return view('cms.dashboard', compact('stats'));
    }

    public function jobs(Request $request)
    {
        $this->checkPermission('jobs.view');
        $query = Job::with('company')->latest();
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('job_id', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhereHas('company', function($companyQuery) use ($search) {
                      $companyQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->has('featured') && $request->featured !== 'all') {
            $query->where('is_featured', $request->featured === 'featured');
        }
        
        $jobs = $query->paginate(21)->withQueryString();
        return view('cms.jobs.index', compact('jobs'));
    }

    public function createJob()
    {
        $this->checkPermission('jobs.create');
        $companies = Company::all();
        $categories = JobCategory::where('is_active', true)->get();
        return view('cms.jobs.create', compact('companies', 'categories'));
    }

    public function storeJob(Request $request)
    {
        $this->checkPermission('jobs.create');
        $rules = [
            'title' => 'required|string|max:255',
            'job_id' => 'nullable|string|max:100',
            'company_id' => 'required|exists:companies,id',
            'location' => 'required|string|max:255',
            'type' => 'required|in:full-time,part-time,contract,internship',
            'work_type' => 'required|in:onsite,remote,hybrid',
            'category_id' => 'nullable|exists:job_categories,id',
            'level' => 'required|in:entry,junior,mid,senior,lead,executive',
            'experience' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'content' => 'required|string',
            'application_url' => 'nullable|url'
        ];
        
        if ($request->has('has_apply_link') && $request->has_apply_link == '1') {
            $rules['application_url'] = 'required|url';
        }
        
        $request->validate($rules);

        $data = $request->all();
        $data['content'] = sanitize_html($request->content);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);
        $data['admin_created_by'] = Auth::guard('admin')->id();
        
        if (!$request->has('has_apply_link') || $request->has_apply_link != '1') {
            $data['application_url'] = null;
        }
        
        // Generate unique slug
        $company = Company::find($request->company_id);
        $baseSlug = Str::slug($request->title . '-' . $company->name);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Job::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $data['slug'] = $slug;
        
        Job::create($data);
        return redirect()->route('cms.jobs')->with('success', 'Job created successfully');
    }

    public function editJob(Job $job)
    {
        $this->checkPermission('jobs.edit');
        $companies = Company::all();
        $categories = JobCategory::where('is_active', true)->get();
        return view('cms.jobs.edit', compact('job', 'companies', 'categories'));
    }

    public function updateJob(Request $request, Job $job)
    {
        $this->checkPermission('jobs.edit');
        $rules = [
            'title' => 'required|string|max:255',
            'job_id' => 'nullable|string|max:100',
            'company_id' => 'required|exists:companies,id',
            'location' => 'required|string|max:255',
            'type' => 'required|in:full-time,part-time,contract,internship',
            'work_type' => 'required|in:onsite,remote,hybrid',
            'category_id' => 'nullable|exists:job_categories,id',
            'level' => 'required|in:entry,junior,mid,senior,lead,executive',
            'experience' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'content' => 'required|string',
            'application_url' => 'nullable|url'
        ];
        
        if ($request->has('has_apply_link') && $request->has_apply_link == '1') {
            $rules['application_url'] = 'required|url';
        }
        
        $request->validate($rules);

        $data = $request->all();
        $data['content'] = sanitize_html($request->content);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        
        if (!$request->has('has_apply_link') || $request->has_apply_link != '1') {
            $data['application_url'] = null;
        }
        
        // Generate unique slug if title or company changed
        if ($request->title !== $job->title || $request->company_id != $job->company_id) {
            $company = Company::find($request->company_id);
            $baseSlug = Str::slug($request->title . '-' . $company->name);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Job::where('slug', $slug)->where('id', '!=', $job->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $data['slug'] = $slug;
        }

        $job->update($data);
        return redirect()->route('cms.jobs')->with('success', 'Job updated successfully');
    }

    public function destroyJob(Job $job)
    {
        $this->checkPermission('jobs.delete');
        $job->delete();
        return redirect()->route('cms.jobs')->with('success', 'Job deleted successfully');
    }

    public function bulkDeleteJobs(Request $request)
    {
        $this->checkPermission('jobs.delete');
        $request->validate([
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:jobs,id'
        ]);

        Job::whereIn('id', $request->job_ids)->delete();
        
        $count = count($request->job_ids);
        return redirect()->route('cms.jobs')->with('success', "{$count} jobs deleted successfully");
    }

    public function internships(Request $request)
    {
        $this->checkPermission('jobs.view');
        $query = Job::where('type', 'internship')->with('company')->latest();
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('job_id', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhereHas('company', function($companyQuery) use ($search) {
                      $companyQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->has('featured') && $request->featured !== 'all') {
            $query->where('is_featured', $request->featured === 'featured');
        }
        
        $internships = $query->paginate(21)->withQueryString();
        return view('cms.internships.index', compact('internships'));
    }

    public function createInternship()
    {
        $this->checkPermission('jobs.create');
        $companies = Company::all();
        $categories = JobCategory::where('is_active', true)->get();
        return view('cms.internships.create', compact('companies', 'categories'));
    }

    public function storeInternship(Request $request)
    {
        $this->checkPermission('jobs.create');
        $request->validate([
            'title' => 'required|string|max:255',
            'job_id' => 'nullable|string|max:100',
            'company_id' => 'required|exists:companies,id',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:onsite,remote,hybrid',
            'category_id' => 'nullable|exists:job_categories,id',
            'level' => 'required|in:entry,junior',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'content' => 'required|string',
        ]);

        $data = $request->all();
        $data['content'] = sanitize_html($request->content);
        $data['type'] = 'internship';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);
        $data['admin_created_by'] = Auth::guard('admin')->id();
        
        $company = Company::find($request->company_id);
        $baseSlug = Str::slug($request->title . '-' . $company->name);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Job::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $data['slug'] = $slug;
        
        Job::create($data);
        return redirect()->route('cms.internships')->with('success', 'Internship created successfully');
    }

    public function editInternship(Job $job)
    {
        $this->checkPermission('jobs.edit');
        // Ensure we're editing an internship
        if ($job->type !== 'internship') {
            return redirect()->route('cms.internships')->with('error', 'Invalid internship');
        }
        
        $companies = Company::all();
        $categories = JobCategory::where('is_active', true)->get();
        return view('cms.internships.edit', compact('job', 'companies', 'categories'));
    }

    public function updateInternship(Request $request, Job $job)
    {
        $this->checkPermission('jobs.edit');
        // Ensure we're updating an internship
        if ($job->type !== 'internship') {
            return redirect()->route('cms.internships')->with('error', 'Invalid internship');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'job_id' => 'nullable|string|max:100',
            'company_id' => 'required|exists:companies,id',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:onsite,remote,hybrid',
            'category_id' => 'nullable|exists:job_categories,id',
            'level' => 'required|in:entry,junior',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'content' => 'required|string',
        ]);

        $data = $request->all();
        $data['content'] = sanitize_html($request->content);
        $data['type'] = 'internship'; // Ensure type remains internship
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        
        // Generate unique slug if title or company changed
        if ($request->title !== $job->title || $request->company_id != $job->company_id) {
            $company = Company::find($request->company_id);
            $baseSlug = Str::slug($request->title . '-' . $company->name);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Job::where('slug', $slug)->where('id', '!=', $job->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $data['slug'] = $slug;
        }

        $job->update($data);
        return redirect()->route('cms.internships')->with('success', 'Internship updated successfully');
    }

    public function destroyInternship(Job $job)
    {
        $this->checkPermission('jobs.delete');
        // Ensure we're deleting an internship
        if ($job->type !== 'internship') {
            return redirect()->route('cms.internships')->with('error', 'Invalid internship');
        }
        
        $job->delete();
        return redirect()->route('cms.internships')->with('success', 'Internship deleted successfully');
    }

    public function bulkDeleteInternships(Request $request)
    {
        $this->checkPermission('jobs.delete');
        $request->validate([
            'internship_ids' => 'required|array',
            'internship_ids.*' => 'exists:jobs,id'
        ]);

        Job::whereIn('id', $request->internship_ids)->where('type', 'internship')->delete();
        
        $count = count($request->internship_ids);
        return redirect()->route('cms.internships')->with('success', "{$count} internships deleted successfully");
    }

    public function companies(Request $request)
    {
        $this->checkPermission('companies.view');
        $query = Company::withCount('jobs')->latest();
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('industry', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        $companies = $query->paginate(10)->withQueryString();
        return view('cms.companies.index', compact('companies'));
    }

    public function createCompany()
    {
        $this->checkPermission('companies.create');
        return view('cms.companies.create');
    }

    public function storeCompany(Request $request)
    {
        $this->checkPermission('companies.create');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'industry' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        $data['description'] = sanitize_html($request->description);
        $data['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('company-logos', config('filesystems.default'));
        }

        $company = Company::create($data);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Company created successfully',
                'company' => $company
            ]);
        }

        return redirect()->route('cms.companies')->with('success', 'Company created successfully');
    }

    public function editCompany(Company $company)
    {
        $this->checkPermission('companies.edit');
        return view('cms.companies.edit', compact('company'));
    }

    public function updateCompany(Request $request, Company $company)
    {
        $this->checkPermission('companies.edit');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'industry' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        $data['description'] = sanitize_html($request->description);
        $data['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk(config('filesystems.default'))->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('company-logos', config('filesystems.default'));
        }

        $company->update($data);
        return redirect()->route('cms.companies')->with('success', 'Company updated successfully');
    }

    public function destroyCompany(Company $company)
    {
        $this->checkPermission('companies.delete');
        if ($company->logo) {
            Storage::disk(config('filesystems.default'))->delete($company->logo);
        }
        $company->delete();
        return redirect()->route('cms.companies')->with('success', 'Company deleted successfully');
    }

    public function bulkDeleteCompanies(Request $request)
    {
        $this->checkPermission('companies.delete');
        $request->validate([
            'company_ids' => 'required|array',
            'company_ids.*' => 'exists:companies,id'
        ]);

        $companies = Company::whereIn('id', $request->company_ids)->get();
        
        foreach ($companies as $company) {
            if ($company->logo) {
                Storage::disk(config('filesystems.default'))->delete($company->logo);
            }
            $company->delete();
        }
        
        $count = count($request->company_ids);
        return redirect()->route('cms.companies')->with('success', "{$count} companies deleted successfully");
    }

    public function categories()
    {
        $this->checkPermission('categories.view');
        $categories = JobCategory::withCount('jobs')->orderBy('name')->paginate(15);
        return view('cms.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        $this->checkPermission('categories.create');
        return view('cms.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $this->checkPermission('categories.create');
        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories',
            'slug' => 'required|string|max:255|unique:job_categories',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'icon_file' => 'nullable|file|mimes:svg|max:1024',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['description'] = sanitize_html($request->description);
        $data['is_active'] = $request->has('is_active');
        $data['color'] = $request->color ?? '#3B82F6';

        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            
            // Security: Basic SVG script check
            $svgContent = file_get_contents($file->getRealPath());
            if (stripos($svgContent, '<script') !== false || stripos($svgContent, 'onload') !== false) {
                return back()->with('error', 'The SVG file contains potentially malicious scripts.');
            }

            $filename = time() . '_' . Str::slug($request->name) . '.svg';
            $file->move(public_path('assets/icons/categories'), $filename);
            $data['icon_file'] = $filename;
        }

        $category = JobCategory::create($data);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => $category
            ]);
        }

        return redirect()->route('cms.categories')->with('success', 'Category created successfully');
    }

    public function editCategory(JobCategory $category)
    {
        $this->checkPermission('categories.edit');
        return view('cms.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, JobCategory $category)
    {
        $this->checkPermission('categories.edit');
        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:job_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'icon_file' => 'nullable|file|mimes:svg|max:1024',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['description'] = sanitize_html($request->description);
        $data['is_active'] = $request->has('is_active');
        $data['color'] = $request->color ?? '#3B82F6';

        if ($request->hasFile('icon_file')) {
            // Security: Basic SVG script check
            $file = $request->file('icon_file');
            $svgContent = file_get_contents($file->getRealPath());
            if (stripos($svgContent, '<script') !== false || stripos($svgContent, 'onload') !== false) {
                return back()->with('error', 'The SVG file contains potentially malicious scripts.');
            }

            // Delete old file if exists
            if ($category->icon_file && file_exists(public_path('assets/icons/categories/' . $category->icon_file))) {
                unlink(public_path('assets/icons/categories/' . $category->icon_file));
            }
            
            $file = $request->file('icon_file');
            $filename = time() . '_' . Str::slug($request->name) . '.svg';
            $file->move(public_path('assets/icons/categories'), $filename);
            $data['icon_file'] = $filename;
        }

        $category->update($data);
        return redirect()->route('cms.categories')->with('success', 'Category updated successfully');
    }

    public function destroyCategory(JobCategory $category)
    {
        $this->checkPermission('categories.delete');
        if ($category->jobs()->count() > 0) {
            return redirect()->route('cms.categories')->with('error', 'Cannot delete category with associated jobs');
        }
        
        $category->delete();
        return redirect()->route('cms.categories')->with('success', 'Category deleted successfully');
    }

    public function bulkDeleteCategories(Request $request)
    {
        $this->checkPermission('categories.delete');
        $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:job_categories,id'
        ]);

        $categories = JobCategory::whereIn('id', $request->category_ids)->get();
        $deletedCount = 0;
        $skippedCount = 0;
        
        foreach ($categories as $category) {
            if ($category->jobs()->count() > 0) {
                $skippedCount++;
                continue;
            }
            $category->delete();
            $deletedCount++;
        }
        
        $message = "{$deletedCount} categories deleted successfully";
        if ($skippedCount > 0) {
            $message .= ". {$skippedCount} categories skipped (have associated jobs)";
        }
        
        return redirect()->route('cms.categories')->with('success', $message);
    }

    public function searchJobs(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = 10;
        
        $query = Job::with('company')
            ->where('is_active', true);
            
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhereHas('company', function($companyQuery) use ($search) {
                      $companyQuery->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }
        
        $jobs = $query->latest()
            ->paginate($perPage, ['*'], 'page', $page);
            
        return response()->json([
            'jobs' => $jobs->items(),
            'pagination' => [
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'total' => $jobs->total()
            ]
        ]);
    }

    public function searchCompanies(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 3) {
            return response()->json(['companies' => []]);
        }
        
        $companies = Company::where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('industry', 'LIKE', "%{$query}%");
            })
            ->select('id', 'name', 'industry')
            ->orderBy('name')
            ->limit(20)
            ->get();
            
        return response()->json([
            'companies' => $companies,
            'debug' => [
                'query' => $query,
                'count' => $companies->count()
            ]
        ]);
    }

    // Continue with other methods (posts, users, featured, etc.)
    public function posts(Request $request)
    {
        $this->checkPermission('blog.view');
        $query = Post::with('adminUser')->latest();
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        $posts = $query->paginate(21)->withQueryString();
        return view('cms.posts.index', compact('posts'));
    }

    public function createPost()
    {
        $this->checkPermission('blog.create');
        return view('cms.posts.create');
    }

    public function storePost(Request $request)
    {
        $this->checkPermission('blog.create');
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'tags' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['content'] = sanitize_html($request->content);
        $data['excerpt'] = sanitize_html($request->excerpt);
        $data['admin_user_id'] = Auth::guard('admin')->id();
        
        // Generate unique slug
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $data['slug'] = $slug;
        $data['is_published'] = $request->status === 'published';
        
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('post-images', config('filesystems.default'));
        }

        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        Post::create($data);
        return redirect()->route('cms.posts')->with('success', 'Post created successfully');
    }

    public function editPost(Post $post)
    {
        $this->checkPermission('blog.edit');
        return view('cms.posts.edit', compact('post'));
    }

    public function updatePost(Request $request, Post $post)
    {
        $this->checkPermission('blog.edit');
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'tags' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['content'] = sanitize_html($request->content);
        $data['excerpt'] = sanitize_html($request->excerpt);
        
        // Generate unique slug if title changed
        if ($request->title !== $post->title) {
            $baseSlug = Str::slug($request->title);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $data['slug'] = $slug;
        }
        
        $data['is_published'] = $request->status === 'published';
        
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk(config('filesystems.default'))->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('post-images', config('filesystems.default'));
        }

        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        if ($request->status === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);
        return redirect()->route('cms.posts')->with('success', 'Post updated successfully');
    }

    public function destroyPost(Post $post)
    {
        $this->checkPermission('blog.delete');
        if ($post->featured_image) {
            Storage::disk(config('filesystems.default'))->delete($post->featured_image);
        }
        $post->delete();
        return redirect()->route('cms.posts')->with('success', 'Post deleted successfully');
    }

    public function bulkDeletePosts(Request $request)
    {
        $this->checkPermission('blog.delete');
        $request->validate([
            'post_ids' => 'required|array',
            'post_ids.*' => 'exists:posts,id'
        ]);

        $posts = Post::whereIn('id', $request->post_ids)->get();
        
        foreach ($posts as $post) {
            if ($post->featured_image) {
                Storage::disk(config('filesystems.default'))->delete($post->featured_image);
            }
            $post->delete();
        }
        
        $count = count($request->post_ids);
        return redirect()->route('cms.posts')->with('success', "{$count} posts deleted successfully");
    }

    public function users()
    {
        $users = AdminUser::latest()->paginate(10);
        return view('cms.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('cms.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,superadmin',
            'permissions' => 'nullable|array'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['is_active'] = true;

        $user = AdminUser::create($data);

        // Generate signed URL valid for 7 days
        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'cms.users.verify_email',
            now()->addDays(7),
            ['id' => $user->id]
        );

        // Send verification email
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AdminUserVerificationMail($user, $verificationUrl));

        return redirect()->route('cms.users')
            ->with('success', 'Admin user created successfully. A verification email has been sent.');
    }

    public function editUser(AdminUser $user)
    {
        return view('cms.users.edit', compact('user'));
    }

    public function updateUser(Request $request, AdminUser $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users,email,' . $user->id,
            'role' => 'required|in:admin,superadmin',
            'permissions' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('password');
        $data['is_active'] = $request->has('is_active');
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('cms.users')->with('success', 'Admin user updated successfully');
    }

    public function destroyUser(AdminUser $user)
    {
        if ($user->id === Auth::guard('admin')->id()) {
            return redirect()->route('cms.users')->with('error', 'Cannot delete your own account');
        }
        
        $user->delete();
        return redirect()->route('cms.users')->with('success', 'Admin user deleted successfully');
    }

    public function profile(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $qrCodeInline = null;
        $secret = null;

        if ($user->two_factor_enabled && $user->two_factor_type === 'google') {
            if (!$user->two_factor_secret) {
                $google2fa = new \PragmaRX\Google2FA\Google2FA();
                $user->two_factor_secret = $google2fa->generateSecretKey();
                $user->save();
            }
            
            $secret = $user->two_factor_secret;
            $qrCodeInline = $this->generateQrCode($user->email, $secret);
        }

        if ($request->ajax()) {
            return response()->json([
                'qrCodeInline' => $qrCodeInline,
                'secret' => $secret,
                'two_factor_enabled' => $user->two_factor_enabled,
                'two_factor_type' => $user->two_factor_type
            ]);
        }

        return view('cms.profile', compact('qrCodeInline', 'secret'));
    }

    /**
     * Generate a QR code SVG string for the given email and secret.
     */
    private function generateQrCode(string $email, string $secret): string
    {
        $google2fa = new \PragmaRX\Google2FA\Google2FA();
        $qrCodeUrl = $google2fa->getQRCodeUrl('Anywhereroles CMS', $email, $secret);

        $renderer = new \BaconQrCode\Renderer\Image\SvgImageBackEnd();
        $writer = new \BaconQrCode\Writer(new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(220),
            $renderer
        ));
        return $writer->writeString($qrCodeUrl);
    }

    /**
     * Generate 8 recovery codes for the authenticated admin.
     */
    public function generateRecoveryCodes(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = Str::random(10);
        }

        // Store hashed versions
        $hashedCodes = array_map(function($code) {
            return Hash::make($code);
        }, $codes);

        $admin->update([
            'two_factor_recovery_codes' => $hashedCodes
        ]);

        return response()->json([
            'success' => true,
            'codes' => $codes
        ]);
    }

    /**
     * Download recovery codes as a text file.
     */
    public function downloadRecoveryCodes()
    {
        $admin = Auth::guard('admin')->user();
        
        // This is tricky because we store hashed codes. 
        // We can only download them right after they are generated.
        // OR we can generate new ones and download them.
        
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = Str::random(10);
        }

        // Store hashed versions
        $hashedCodes = array_map(function($code) {
            return Hash::make($code);
        }, $codes);

        $admin->update([
            'two_factor_recovery_codes' => $hashedCodes
        ]);

        $content = "Anywhereroles CMS - Two-Factor Recovery Codes\n";
        $content .= "Generated on: " . now()->toDateTimeString() . "\n\n";
        $content .= "Keep these codes in a safe place. Each code can only be used once.\n\n";
        foreach ($codes as $code) {
            $content .= $code . "\n";
        }

        return response($content)
            ->withHeaders([
                'Content-Type' => 'text/plain',
                'Content-Disposition' => 'attachment; filename="anywhereroles-2fa-recovery-codes.txt"',
            ]);
    }

    /**
     * Send backup recovery codes to user email.
     */
    public function sendRecoveryCodesEmail(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->two_factor_recovery_codes) {
            return response()->json(['success' => false, 'message' => 'No recovery codes found.']);
        }

        // Generate new ones to send (since we can't read hashed ones)
        $codes = collect(range(1, 8))->map(function () {
            return Str::random(10);
        })->all();

        $user->two_factor_recovery_codes = collect($codes)->map(fn($code) => Hash::make($code))->all();
        $user->save();

        Mail::to($user->email)->send(new SendRecoveryCodes($user, $codes));

        return response()->json([
            'success' => true,
            'message' => 'New recovery codes have been generated and sent to your email.',
            'codes' => $codes
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users,email,' . Auth::guard('admin')->id()
        ]);

        Auth::guard('admin')->user()->update($request->only('name', 'email'));
        return redirect()->route('cms.profile')->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $admin = Auth::guard('admin')->user();
        
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('cms.profile')->with('success', 'Password updated successfully');
    }

    public function send2faCode(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $code = rand(100000, 999999);
        
        $admin->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10)
        ]);

        \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\TwoFactorCodeMail($admin, $code));

        return response()->json(['success' => true, 'message' => 'Verification code sent to your email.']);
    }

    public function update2fa(Request $request)
    {
        $request->validate([
            'two_factor_type' => 'required|in:email,google',
            'two_factor_enabled' => 'boolean'
        ]);

        $admin = Auth::guard('admin')->user();
        $newEnabled = $request->boolean('two_factor_enabled');
        $newType    = $request->two_factor_type;

        // Determine if this is a meaningful change that needs verification
        $isChange = ($newEnabled !== (bool) $admin->two_factor_enabled)
                 || ($newEnabled && $newType !== $admin->two_factor_type);

        // Security Verification logic
        // Use filled() not has() — has() returns true even for null values,
        // which would cause the verification branch to run on the first toggle click.
        if ($request->filled('code')) {
            $isValid = false;

            // Determine which method to validate against:
            // - If 2FA was already enabled with Google, validate the TOTP code.
            // - If user is setting up Google for the first time (2FA was off or was email),
            //   validate the TOTP against the stored secret (they scanned the QR in the modal).
            // - Otherwise validate the email OTP.
            $verifyVia = $request->input('verify_via', null);

            if ($newEnabled && $newType === 'google' && $admin->two_factor_secret) {
                // Validating a TOTP code from the newly scanned QR code
                $google2fa = new \PragmaRX\Google2FA\Google2FA();
                $isValid = $google2fa->verifyKey($admin->two_factor_secret, $request->code);
            } elseif ($admin->two_factor_enabled && $admin->two_factor_type === 'google') {
                // Validating existing Google 2FA (e.g. turning it OFF)
                $google2fa = new \PragmaRX\Google2FA\Google2FA();
                $isValid = $google2fa->verifyKey($admin->two_factor_secret, $request->code);
            } else {
                // Email OTP verification — cast to string to avoid NULL/type mismatch
                $isValid = $admin->two_factor_code !== null
                        && (string)$admin->two_factor_code === (string)$request->code
                        && $admin->two_factor_expires_at
                        && $admin->two_factor_expires_at->isFuture();
            }

            if (!$isValid) {
                return response()->json(['success' => false, 'message' => 'Invalid or expired verification code.'], 422);
            }
        } elseif ($isChange) {
            // Verification always required for any 2FA change.
            // If the user currently has 2FA enabled, verify via their existing method.
            // If they are enabling for the first time, verify via email first.
            $verifyVia = $admin->two_factor_enabled ? $admin->two_factor_type : 'email';

            // If enabling Google auth (new or switching), generate/reuse secret and QR code
            // so it can be shown inside the verification modal before code entry.
            $qrCodeInline = null;
            $tempSecret   = null;
            if ($newEnabled && $newType === 'google') {
                if (!$admin->two_factor_secret) {
                    $google2fa = new \PragmaRX\Google2FA\Google2FA();
                    $admin->two_factor_secret = $google2fa->generateSecretKey();
                    $admin->save();
                }
                $tempSecret   = $admin->two_factor_secret;
                $qrCodeInline = $this->generateQrCode($admin->email, $tempSecret);
            }

            // IMPORTANT: Always return type='google' when target is Google, so the frontend
            // shows the QR code inside the modal. If the user already has Google 2FA enabled,
            // verifyVia will already be 'google'. If they are switching FROM email TO google,
            // we use verifyVia='email' for auth but still surface 'google' as the modal type
            // with the QR attached so the user can scan and then enter the TOTP code.
            $modalType = ($newEnabled && $newType === 'google') ? 'google' : $verifyVia;

            // Return 422 so JavaScript's !response.ok detects this and shows the modal
            return response()->json([
                'success'               => false,
                'requires_verification' => true,
                'type'                  => $modalType,
                'verify_via'            => $verifyVia,
                'qrCodeInline'          => $qrCodeInline,
                'secret'                => $tempSecret,
            ], 422);
        }
        // No meaningful change and no code required — just save (e.g. no-op)

        $admin->two_factor_enabled = $newEnabled;
        $admin->two_factor_type    = $newType;

        if ($admin->two_factor_type === 'google' && !$admin->two_factor_secret) {
            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            $admin->two_factor_secret = $google2fa->generateSecretKey();
        }

        // Generate recovery codes if enabling for first time or if they don't exist
        if ($admin->two_factor_enabled && !$admin->two_factor_recovery_codes) {
            $codes = [];
            for ($i = 0; $i < 8; $i++) {
                $codes[] = Str::random(10);
            }
            $admin->two_factor_recovery_codes = array_map(fn($c) => Hash::make($c), $codes);
        }

        $admin->save();

        // Build response with optional QR code if type is google
        $qrCodeInline = null;
        $secret       = null;
        if ($admin->two_factor_enabled && $admin->two_factor_type === 'google' && $admin->two_factor_secret) {
            $secret       = $admin->two_factor_secret;
            $qrCodeInline = $this->generateQrCode($admin->email, $secret);
        }

        if ($request->ajax()) {
            return response()->json([
                'success'      => true,
                'message'      => 'Two-factor authentication settings updated successfully.',
                'enabled'      => $admin->two_factor_enabled,
                'type'         => $admin->two_factor_type,
                'qrCodeInline' => $qrCodeInline,
                'secret'       => $secret,
            ]);
        }

        return redirect()->route('cms.profile')->with('success', 'Two-factor authentication settings updated.');
    }

    public function testimonials()
    {
        $this->checkPermission('testimonials.manage');
        $testimonials = Testimonial::where('is_approved', false)->latest()->paginate(15);
        return view('cms.testimonials.index', compact('testimonials'));
    }

    public function approveTestimonial(Testimonial $testimonial)
    {
        $this->checkPermission('testimonials.manage');
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);
        $status = $testimonial->is_approved ? 'approved' : 'unapproved';
        return back()->with('success', "Testimonial {$status} successfully");
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $this->checkPermission('testimonials.manage');
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted successfully');
    }

    public function bulkApproveTestimonials(Request $request)
    {
        $this->checkPermission('testimonials.manage');
        $request->validate([
            'testimonial_ids' => 'required|array',
            'testimonial_ids.*' => 'exists:testimonials,id'
        ]);

        Testimonial::whereIn('id', $request->testimonial_ids)->update(['is_approved' => true]);

        return back()->with('success', 'Selected testimonials approved successfully');
    }

    public function bulkDeleteTestimonials(Request $request)
    {
        $this->checkPermission('testimonials.manage');
        $request->validate([
            'testimonial_ids' => 'required|array',
            'testimonial_ids.*' => 'exists:testimonials,id'
        ]);

        Testimonial::whereIn('id', $request->testimonial_ids)->delete();

        return back()->with('success', 'Selected testimonials deleted successfully');
    }

    public function activity()
    {
        $activities = \App\Models\ActivityLog::with('adminUser')->latest()->paginate(50);
        return view('cms.activity.index', compact('activities'));
    }

    public function clearActivity()
    {
        $currentUser = Auth::guard('admin')->user();
        if (!$currentUser || $currentUser->role !== 'superadmin') {
            return back()->with('error', 'Only superadmins are authorized to clear activity logs.');
        }

        \App\Models\ActivityLog::query()->delete();

        return redirect()->route('cms.activity')->with('success', 'All activity logs have been cleared successfully.');
    }
}