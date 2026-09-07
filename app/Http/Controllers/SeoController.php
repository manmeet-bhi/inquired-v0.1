<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoSetting;
use App\Models\PageSeo;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\Post;
use App\Helpers\SeoHelper;
use App\Services\SitemapService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SeoController extends Controller
{
    public function __construct(private readonly SitemapService $sitemapService)
    {
    }

    public function index()
    {
        $this->checkPermission('seo.manage');
        $globalSettings = SeoSetting::getGlobalSettings();
        
        // Calculate a basic SEO score based on global settings completeness
        $score = 0;
        if (!empty($globalSettings['site_title']) && Str::length($globalSettings['site_title']) > 5) $score += 10;
        if (!empty($globalSettings['meta_description']) && Str::length($globalSettings['meta_description']) > 20) $score += 10;
        if (!empty($globalSettings['meta_keywords'])) $score += 5;
        if (!empty($globalSettings['og_title'])) $score += 10;
        if (!empty($globalSettings['twitter_title'])) $score += 10;
        if (!empty($globalSettings['schema_json'])) $score += 15;
        if (!empty($globalSettings['favicon'])) $score += 10;
        if (!empty($globalSettings['og_default_image'])) $score += 10;
        if (!$globalSettings['global_noindex']) $score += 10;
        if (!$globalSettings['global_nofollow']) $score += 10;
        
        $seoScore = $score;

        return view('cms.seo.index', compact('globalSettings', 'seoScore'));
    }

    public function indexing()
    {
        $this->checkPermission('seo.manage');
        // Get list of HTML verification files in public directory
        $files = File::glob(public_path('*.html'));
        $verificationFiles = array_map('basename', $files);
        
        return view('cms.seo.indexing', compact('verificationFiles'));
    }

    public function uploadVerificationFile(Request $request)
    {
        $this->checkPermission('seo.manage');
        $request->validate([
            'verification_file' => 'required|file|extensions:html,htm|max:1024',
        ], [
            'verification_file.extensions' => 'The verification file must be an HTML file (.html or .htm).',
        ]);

        if ($request->hasFile('verification_file')) {
            $file = $request->file('verification_file');
            $fileName = $file->getClientOriginalName();
            
            // Security: Only allow filenames that look like standard verification files
            // and don't overwrite existing system files.
            $allowedPatterns = [
                '/^google[a-f0-9]+\.html$/i',
                '/^BingSiteAuth\.html$/i',
                '/^loaderio-[a-f0-9]+\.html$/i',
                '/^apple-developer-site-association\.html$/i'
            ];

            $isAllowed = false;
            foreach ($allowedPatterns as $pattern) {
                if (preg_match($pattern, $fileName)) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                return back()->with('error', 'Invalid verification filename. Only standard Google/Bing/Loader.io verification files are allowed.');
            }

            // Prevent overwriting critical files even if they match patterns
            $forbiddenNames = ['index.html', 'default.html', 'home.html'];
            if (in_array(strtolower($fileName), $forbiddenNames)) {
                return back()->with('error', 'This filename is reserved and cannot be used.');
            }
            
            // Move to public directory
            $file->move(public_path(), $fileName);
            
            return back()->with('success', 'Verification file uploaded successfully!');
        }

        return back()->with('error', 'Please select a valid HTML file.');
    }

    public function deleteVerificationFile(Request $request)
    {
        $this->checkPermission('seo.manage');
        $request->validate([
            'file_name' => 'required|string',
        ]);

        $fileName = basename($request->file_name);
        $filePath = public_path($fileName);

        // Security: Ensure we only delete HTML files and they exist in the public directory
        // and aren't critical system files.
        $safeToDelete = str_ends_with(strtolower($fileName), '.html') && 
                       !in_array(strtolower($fileName), ['index.html', 'default.html']);

        if ($safeToDelete && file_exists($filePath)) {
            unlink($filePath);
            return back()->with('success', 'Verification file deleted successfully!');
        }

        return back()->with('error', 'File not found or invalid.');
    }

    public function updateGlobalSettings(Request $request)
    {
        $this->checkPermission('seo.manage');
        $request->validate([
            'site_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_canonical' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'og_type' => 'nullable|string|max:50',
            'og_url' => 'nullable|url|max:255',
            'og_site_name' => 'nullable|string|max:100',
            'og_locale' => 'nullable|string|max:20',
            'twitter_card' => 'nullable|string|max:50',
            'twitter_site' => 'nullable|string|max:100',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'twitter_creator' => 'nullable|string|max:100',
            'schema_json' => 'nullable|json',
            'robots_txt' => 'required|string',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'og_default_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $settings = [
            'site_title' => $request->site_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'meta_canonical' => $request->meta_canonical,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_type' => $request->og_type,
            'og_url' => $request->og_url,
            'og_site_name' => $request->og_site_name,
            'og_locale' => $request->og_locale,
            'twitter_card' => $request->twitter_card,
            'twitter_site' => $request->twitter_site,
            'twitter_title' => $request->twitter_title,
            'twitter_description' => $request->twitter_description,
            'twitter_creator' => $request->twitter_creator,
            'schema_json' => $request->schema_json,
            'robots_txt' => $request->robots_txt,
            'global_noindex' => $request->has('global_noindex') ? '1' : '0',
            'global_nofollow' => $request->has('global_nofollow') ? '1' : '0',
        ];

        foreach ($settings as $key => $value) {
            SeoSetting::set($key, $value);
        }

        // Handle favicon removal
        if ($request->has('remove_favicon')) {
            $oldFavicon = SeoSetting::get('favicon');
            if ($oldFavicon) {
                Storage::disk(config('filesystems.default'))->delete($oldFavicon);
                SeoSetting::set('favicon', null);
            }
        }
        // Handle favicon upload
        elseif ($request->hasFile('favicon')) {
            $oldFavicon = SeoSetting::get('favicon');
            if ($oldFavicon) {
                Storage::disk(config('filesystems.default'))->delete($oldFavicon);
            }
            $faviconPath = $request->file('favicon')->store('seo/favicon', config('filesystems.default'));
            SeoSetting::set('favicon', $faviconPath);
        }

        // Handle OG image removal
        if ($request->has('remove_og_image')) {
            $oldOgImage = SeoSetting::get('og_default_image');
            if ($oldOgImage) {
                Storage::disk(config('filesystems.default'))->delete($oldOgImage);
                SeoSetting::set('og_default_image', null);
            }
        }
        // Handle OG default image upload
        elseif ($request->hasFile('og_default_image')) {
            $oldOgImage = SeoSetting::get('og_default_image');
            if ($oldOgImage) {
                Storage::disk(config('filesystems.default'))->delete($oldOgImage);
            }
            $ogImagePath = $request->file('og_default_image')->store('og-images', config('filesystems.default'));
            SeoSetting::set('og_default_image', $ogImagePath);
        }

        // Update robots.txt file
        file_put_contents(public_path('robots.txt'), $request->robots_txt);

        // Clear the cached global settings
        Cache::forget('global_seo_settings');

        return redirect()->route('cms.seo.index')->with('success', 'Global SEO settings updated successfully!');
    }


    public function pages(Request $request)
    {
        $query = PageSeo::with(['job', 'category', 'company', 'post']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhere('meta_title', 'like', "%{$search}%")
                  ->orWhere('meta_description', 'like', "%{$search}%");
            });
        }

        $pages = $query->paginate(20)->withQueryString(); // Increased per page for compact list
        return view('cms.seo.pages', compact('pages'));
    }

    public function createPage()
    {
        $jobs = Job::where('is_active', true)->orderBy('title')->get(['id', 'title', 'slug']);
        $posts = Post::where('is_published', true)->orderBy('title')->get(['id', 'title', 'slug']);
        $categories = JobCategory::where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);
        $companies = Company::where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);
        
        return view('cms.seo.create-page', compact('jobs', 'posts', 'categories', 'companies'));
    }

    public function storePage(Request $request)
    {
        $data = $this->validatePageSeoRequest($request);

        $data['schema_json'] = $request->schema_json;
        $data['noindex'] = $request->has('noindex') ? 1 : 0;
        $data['nofollow'] = $request->has('nofollow') ? 1 : 0;

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('og-images', config('filesystems.default'));
        }

        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('og-images', config('filesystems.default'));
        }

        PageSeo::create($data);
        $this->flushSeoCachesByPayload($data);

        return redirect()->route('cms.seo.pages')->with('success', 'Page SEO created successfully!');
    }

    public function editPage(PageSeo $pageSeo)
    {
        $pageSeo->load(['job', 'post', 'category', 'company']);
        $jobs = Job::where('is_active', true)->orderBy('title')->get(['id', 'title', 'slug']);
        $posts = Post::where('is_published', true)->orderBy('title')->get(['id', 'title', 'slug']);
        $categories = JobCategory::where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);
        $companies = Company::where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);
        
        return view('cms.seo.edit-page', compact('pageSeo', 'jobs', 'posts', 'categories', 'companies'));
    }

    public function updatePage(Request $request, PageSeo $pageSeo)
    {
        $original = $pageSeo->only(['page_type', 'page_id', 'slug']);
        $data = $this->validatePageSeoRequest($request, $pageSeo);

        $data['schema_json'] = $request->schema_json;
        $data['noindex'] = $request->has('noindex') ? 1 : 0;
        $data['nofollow'] = $request->has('nofollow') ? 1 : 0;

        if ($request->has('remove_og_image')) {
            if ($pageSeo->og_image) {
                Storage::disk(config('filesystems.default'))->delete($pageSeo->og_image);
            }
            $data['og_image'] = null;
        } elseif ($request->hasFile('og_image')) {
            if ($pageSeo->og_image) {
                Storage::disk(config('filesystems.default'))->delete($pageSeo->og_image);
            }
            $data['og_image'] = $request->file('og_image')->store('og-images', config('filesystems.default'));
        }

        if ($request->has('remove_twitter_image')) {
            if ($pageSeo->twitter_image) {
                Storage::disk(config('filesystems.default'))->delete($pageSeo->twitter_image);
            }
            $data['twitter_image'] = null;
        } elseif ($request->hasFile('twitter_image')) {
            if ($pageSeo->twitter_image) {
                Storage::disk(config('filesystems.default'))->delete($pageSeo->twitter_image);
            }
            $data['twitter_image'] = $request->file('twitter_image')->store('og-images', config('filesystems.default'));
        }

        $pageSeo->update($data);
        $this->flushSeoCachesByPayload($original);
        $this->flushSeoCachesByPayload($pageSeo->fresh()->only(['page_type', 'page_id', 'slug']));

        return redirect()->route('cms.seo.pages')->with('success', 'Page SEO updated successfully!');
    }

    public function destroyPage(PageSeo $pageSeo)
    {
        $cacheContext = $pageSeo->only(['page_type', 'page_id', 'slug']);

        if ($pageSeo->og_image) {
            Storage::disk(config('filesystems.default'))->delete($pageSeo->og_image);
        }

        if ($pageSeo->twitter_image) {
            Storage::disk(config('filesystems.default'))->delete($pageSeo->twitter_image);
        }
        
        $pageSeo->delete();
        $this->flushSeoCachesByPayload($cacheContext);

        return redirect()->route('cms.seo.pages')->with('success', 'Page SEO deleted successfully!');
    }

    public function generateSlug(Request $request)
    {
        $title = $request->input('title');
        $slug = Str::slug($title);
        
        // Check uniqueness
        $originalSlug = $slug;
        $counter = 1;
        
        while (PageSeo::where('slug', $slug)->exists() || Job::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return response()->json(['slug' => $slug]);
    }

    public function audit(Request $request)
    {
        $data = $request->only(['type', 'id', 'title', 'description', 'keywords']);

        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');
        $keywords = trim($data['keywords'] ?? '');

        $issues = [];
        $suggestions = [];

        $score = 0;

        // Title length check
        $titleLen = Str::length($title);
        if ($titleLen === 0) {
            $issues[] = 'Meta title is missing.';
        } elseif ($titleLen < 30) {
            $issues[] = 'Meta title is shorter than recommended (30 chars).';
            $score += 10;
            $suggestions[] = 'Consider increasing the title length to 30-60 characters.';
        } elseif ($titleLen <= 60) {
            $score += 30;
        } else {
            $issues[] = 'Meta title is longer than 60 characters; consider shortening.';
            $score += 20;
        }

        // Description length check
        $descLen = Str::length($description);
        if ($descLen === 0) {
            $issues[] = 'Meta description is missing.';
        } elseif ($descLen < 120) {
            $issues[] = 'Meta description is shorter than recommended (120 chars).';
            $score += 10;
            $suggestions[] = 'Consider expanding the meta description to 120-160 characters.';
        } elseif ($descLen <= 160) {
            $score += 30;
        } else {
            $issues[] = 'Meta description is longer than 160 characters; consider shortening.';
            $score += 20;
        }

        // Keywords presence
        if (!empty($keywords)) {
            $score += 10;
        } else {
            $suggestions[] = 'Add comma-separated meta keywords if applicable.';
        }

        // Basic content checks
        if (stripos($title, "keyword") !== false || stripos($description, "keyword") !== false) {
            $score += 5;
        }

        // Normalize score to 0-100
        $score = max(0, min(100, $score + 35));

        return response()->json([
            'score' => (int) $score,
            'issues' => $issues,
            'suggestions' => $suggestions,
        ]);
    }



    public function generateSitemap()
    {
        file_put_contents(public_path('sitemap.xml'), $this->sitemapService->generateXml());
        $this->sitemapService->notifySearchEngines();

        return redirect()->route('cms.seo.index')->with('success', 'Sitemap generated and search engines notified!');
    }

    public function generateJobPostingSchema($jobId)
    {
        $job = Job::with(['company', 'category'])->findOrFail($jobId);

        return json_encode(SeoHelper::generateJobSchema($job), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function getJobPostingSchema(Request $request)
    {
        $jobId = $request->input('job_id');
        
        if (!$jobId) {
            return response()->json(['error' => 'Job ID is required'], 400);
        }

        try {
            $schema = $this->generateJobPostingSchema($jobId);
            return response()->json(['schema' => $schema]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Job not found'], 404);
        }
    }

    private function validatePageSeoRequest(Request $request, ?PageSeo $pageSeo = null): array
    {
        $payload = array_merge([
            'page_type' => $pageSeo?->page_type,
            'page_id' => $pageSeo?->page_id,
        ], $request->all());

        $validator = Validator::make($payload, [
            'page_type' => ['required', Rule::in(['static', 'job', 'category', 'company', 'post'])],
            'page_id' => ['nullable', 'integer'],
            'slug' => ['required', 'string', Rule::unique('page_seo', 'slug')->ignore($pageSeo?->id)],
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:255',
            'twitter_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'schema_json' => 'nullable|json',
        ]);

        $validator->after(function ($validator) use ($payload, $pageSeo) {
            $pageType = $payload['page_type'] ?? $pageSeo?->page_type;
            $pageId = $payload['page_id'] ?? $pageSeo?->page_id;

            if ($pageType !== 'static' && empty($pageId)) {
                $validator->errors()->add('page_id', 'A related record is required for dynamic SEO pages.');
                return;
            }

            $modelClass = $this->resolveSeoModelClass($pageType);

            if ($pageType !== 'static' && $modelClass && !$modelClass::whereKey($pageId)->exists()) {
                $validator->errors()->add('page_id', 'The selected related record does not exist.');
            }

            if ($pageType !== 'static' && $pageId) {
                $duplicate = PageSeo::query()
                    ->where('page_type', $pageType)
                    ->where('page_id', $pageId)
                    ->when($pageSeo, fn ($query) => $query->where('id', '!=', $pageSeo->id))
                    ->exists();

                if ($duplicate) {
                    $validator->errors()->add('page_id', 'SEO already exists for the selected record.');
                }
            }
        });

        return $validator->validated();
    }

    private function resolveSeoModelClass(string $pageType): ?string
    {
        return match ($pageType) {
            'job' => Job::class,
            'post' => Post::class,
            'category' => JobCategory::class,
            'company' => Company::class,
            default => null,
        };
    }

    private function flushSeoCachesByPayload(array $payload): void
    {
        $staticCacheMap = [
            'home' => 'home_page_seo',
            'jobs' => 'jobs_index_seo',
            'onsite-jobs' => 'jobs_onsite_seo',
            'remote-jobs' => 'jobs_remote_seo',
            'hybrid-jobs' => 'jobs_hybrid_seo',
            'internships' => 'jobs_internships_seo',
            'part-time-jobs' => 'jobs_part_time_seo',
            'fresher-jobs' => 'jobs_freshers_seo',
            'companies' => 'companies_index_seo',
            'startup-companies' => 'startup_companies_seo',
            'mnc-companies' => 'mnc_companies_seo',
            'categories' => 'categories_index_seo',
        ];

        if (($payload['page_type'] ?? null) === 'static' && !empty($payload['slug']) && isset($staticCacheMap[$payload['slug']])) {
            Cache::forget($staticCacheMap[$payload['slug']]);
        }

        if (!empty($payload['page_id'])) {
            match ($payload['page_type'] ?? null) {
                'job' => Cache::forget('job_seo_' . $payload['page_id']),
                'post' => Cache::forget('post_seo_' . $payload['page_id']),
                'category' => Cache::forget('category_seo_' . $payload['page_id']),
                'company' => Cache::forget('company_seo_' . $payload['page_id']),
                default => null,
            };
        }
    }
}
