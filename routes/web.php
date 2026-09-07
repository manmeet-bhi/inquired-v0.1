<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\JobController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/api/jobs/{type}', [JobController::class, 'getJobsByType'])->middleware('throttle:60,1')->name('api.jobs.type');

if (app()->environment('local')) {
    Route::get('/test-mail', function () {
        return [
            'host' => config('mail.mailers.smtp.host'),
            'resolved_ip' => gethostbyname(config('mail.mailers.smtp.host')),
            'ip_literal' => gethostbyname('smtp.gmail.com')
        ];
    });
}


// Dynamic SEO Routes (Sitemap & Robots)
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/robots.txt', [App\Http\Controllers\SitemapController::class, 'robots'])->name('robots.txt');

// Public Media Route (serves images securely from Cloudflare R2 / storage)
Route::get('/media/{path}', [App\Http\Controllers\MediaController::class, 'show'])->where('path', '.*')->name('media.show');

// Public Routes
Route::get('/search', [SearchController::class, 'index'])->middleware('throttle:60,1')->name('search');
Route::get('/onsite-jobs', [App\Http\Controllers\JobController::class, 'onsite'])->name('onsite-jobs');
Route::get('/remote-jobs', [App\Http\Controllers\JobController::class, 'remote'])->name('remote-jobs');
Route::get('/hybrid-jobs', [App\Http\Controllers\JobController::class, 'hybrid'])->name('hybrid-jobs');
Route::get('/internships', [App\Http\Controllers\JobController::class, 'internships'])->name('internships');
Route::get('/fresher-jobs', [App\Http\Controllers\JobController::class, 'freshers'])->name('freshers-jobs');
Route::get('/part-time-jobs', [App\Http\Controllers\JobController::class, 'partTime'])->name('part-time-jobs');
Route::get('/jobs/{job}/{slug?}', [App\Http\Controllers\JobController::class, 'show'])->name('jobs.show')->where('job', '[0-9]+');
Route::get('/companies', [App\Http\Controllers\JobController::class, 'companies'])->name('companies');
Route::get('/startup-companies', [App\Http\Controllers\JobController::class, 'startupCompanies'])->name('startup-companies');
Route::get('/mnc-companies', [App\Http\Controllers\JobController::class, 'mncCompanies'])->name('mnc-companies');
Route::get('/unicorn-companies', [App\Http\Controllers\JobController::class, 'unicornCompanies'])->name('unicorn-companies');
Route::get('/categories', [App\Http\Controllers\JobController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [App\Http\Controllers\JobController::class, 'categoryShow'])->name('category.show');
Route::get('/company/{slug}', [App\Http\Controllers\JobController::class, 'companyShow'])->name('company.show');





// Blog Routes
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/blog/tag/{tag}', [App\Http\Controllers\BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/{post}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Static Pages
Route::get('/about', function () { 
    $pageSeo = \App\Models\PageSeo::getSeoForSlug('about');
    return view('pages.about', compact('pageSeo')); 
})->name('about');
Route::get('/for-employers', function () { 
    $pageSeo = \App\Models\PageSeo::getSeoForSlug('for-employers');
    return view('pages.for-employers', compact('pageSeo')); 
})->name('for-employers');
Route::post('/for-employers', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'company_name' => 'required|string|max:255',
        'work_email' => 'required|email|max:255',
        'job_title' => 'required|string|max:255',
        'post_url' => 'required|url|max:500',
        'description' => 'nullable|string|max:10000',
    ], [
        'company_name.required' => 'Please enter your company name.',
        'work_email.required' => 'Please enter your work email address.',
        'work_email.email' => 'Please enter a valid email address.',
        'job_title.required' => 'Please enter the job title.',
        'post_url.required' => 'Please provide the post URL or application link.',
        'post_url.url' => 'Please provide a valid URL (e.g. https://example.com/jobs/123).',
    ]);

    // Forward submission seamlessly to Google Form
    try {
        \Illuminate\Support\Facades\Http::asForm()
            ->timeout(6)
            ->post('https://docs.google.com/forms/d/e/1FAIpQLScSxGQ_oycyJ8gMguHlPmrbFSTZPQxVwvNk5-Pb7vQ0KWCowg/formResponse', [
                'entry.1150005109' => $data['company_name'],
                'entry.1977925638' => $data['work_email'],
                'entry.540841493'  => $data['job_title'],
                'entry.586345545'  => $data['post_url'],
                'entry.1660808911' => $data['description'] ?? '',
            ]);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::warning('Google Form sync warning: ' . $e->getMessage());
    }

    \Illuminate\Support\Facades\Log::info('Employer Job Submission:', $data);

    return redirect()->route('for-employers')->with('success', 'Thank you! Your job opening has been submitted successfully. Our team will review and publish it shortly.');
})->name('for-employers.submit');
Route::get('/employer-policy', function () { 
    $pageSeo = \App\Models\PageSeo::getSeoForSlug('employer-policy');
    return view('pages.employer-policy', compact('pageSeo')); 
})->name('employer-policy');
Route::get('/contact', function () { 
    $pageSeo = \App\Models\PageSeo::getSeoForSlug('contact');
    return view('pages.contact', compact('pageSeo')); 
})->name('contact');
Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:5000',
    ], [
        'name.required' => 'Please enter your name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please provide a valid email address.',
        'message.required' => 'Please enter your message.',
    ]);

    // Forward message seamlessly to Google Form
    try {
        \Illuminate\Support\Facades\Http::asForm()
            ->timeout(6)
            ->post('https://docs.google.com/forms/d/e/1FAIpQLSeE4cMHnj6M5WYurIX2mJ4avsPhhDiI5m1n5uG37ItUtbHKUQ/formResponse', [
                'entry.1111861586' => $data['name'],
                'entry.1762541306' => $data['email'],
                'entry.1462769164' => $data['message'],
            ]);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::warning('Contact Google Form sync warning: ' . $e->getMessage());
    }

    \Illuminate\Support\Facades\Log::info('Contact Form Message:', [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);

    return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent successfully. We will get back to you shortly.');
})->name('contact.submit');
Route::get('/feedback', function () { 
    $pageSeo = \App\Models\PageSeo::getSeoForSlug('feedback');
    return view('pages.feedback', compact('pageSeo')); 
})->name('feedback');
Route::post('/feedback', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'category' => 'required|string|max:100',
        'rating' => 'required|string|max:50',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'feedback' => 'required|string|max:5000',
        'agree_testimonial' => 'nullable|string|in:Yes,No',
    ], [
        'category.required' => 'Please select a feedback category.',
        'rating.required' => 'Please select your overall experience rating.',
        'name.required' => 'Please enter your name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please provide a valid email address.',
        'feedback.required' => 'Please enter your feedback or suggestions.',
    ]);

    $agreeTestimonial = ($request->has('agree_testimonial') && $request->input('agree_testimonial') === 'Yes') ? 'Yes' : 'No';
    $data['agree_testimonial'] = $agreeTestimonial;

    // Forward submission seamlessly to Google Form
    try {
        \Illuminate\Support\Facades\Http::asForm()
            ->timeout(6)
            ->post('https://docs.google.com/forms/d/e/1FAIpQLScPF-ByCv0GURyBG1YFmYKqvdwZpiV_ciFv4b9DCv5AEPA7Bw/formResponse', [
                'entry.1893968062' => $data['category'],
                'entry.631378487'  => $data['rating'],
                'entry.384078751'  => $data['name'],
                'entry.449612881'  => $data['email'],
                'entry.1604087922' => $data['feedback'],
                'entry.952404610'  => $agreeTestimonial,
            ]);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::warning('Feedback Google Form sync warning: ' . $e->getMessage());
    }

    \Illuminate\Support\Facades\Log::info('Feedback Form Submission:', $data);

    return redirect()->route('feedback')->with('success', 'Thank you for your valuable feedback! We review every submission to make Inaquired better.');
})->name('feedback.submit');
Route::get('/support', function () { 
    $pageSeo = \App\Models\PageSeo::getSeoForSlug('contact');
    return view('pages.contact', compact('pageSeo')); 
})->name('support');
Route::get('/privacy', function () { return view('pages.privacy'); })->name('privacy');
Route::get('/terms', function () { return view('pages.terms'); })->name('terms');
Route::get('/cookies', function () { return view('pages.cookies'); })->name('cookies');
Route::get('/testimonials', function (\Illuminate\Http\Request $request) {
    $pageSeo = \Illuminate\Support\Facades\Cache::remember('testimonials_index_seo', 3600, function() {
        return \App\Models\PageSeo::getSeoForSlug('testimonials');
    });
    $page = $request->get('page', 1);
    $topTestimonials = \Illuminate\Support\Facades\Cache::remember('testimonials_top_5', 3600, function() {
        $featured = \App\Models\Testimonial::where('is_featured', true)->latest()->take(5)->get();
        if ($featured->isEmpty()) {
            $featured = \App\Models\Testimonial::latest()->take(3)->get();
        }
        return $featured;
    });
    $featuredIds = $topTestimonials->pluck('id')->toArray();
    $testimonials = \Illuminate\Support\Facades\Cache::remember("testimonials_page_{$page}", 3600, function() use ($featuredIds) {
        return \App\Models\Testimonial::whereNotIn('id', $featuredIds)
            ->latest()
            ->paginate(9);
    });
    return view('pages.testimonials', compact('topTestimonials', 'testimonials', 'pageSeo'));
})->name('testimonials');
Route::get('/sitemap', function () { return view('pages.sitemap'); })->name('sitemap');

// User Registration Route
Route::get('/register', function () { 
    return redirect()->route('home'); 
})->name('register');

// CMS Routes
Route::get('/cms', function () {
    return redirect()->route('cms.login');
});

    if (app()->environment('local')) {
        Route::get('/cms/debug-email', [App\Http\Controllers\DebugController::class, 'debugEmail']);
        Route::get('/cms/test-resend/{email}', [App\Http\Controllers\DebugController::class, 'testResend']);
    }

Route::middleware(['throttle:6,1'])->group(function () {
    Route::get('/cms/login', [App\Http\Controllers\CmsAuthController::class, 'showLogin'])->name('cms.login');
    Route::post('/cms/login', [App\Http\Controllers\CmsAuthController::class, 'login']);
    Route::get('/cms/forgot-password', [App\Http\Controllers\CmsAuthController::class, 'showForgotPassword'])->name('cms.password.request');
    Route::post('/cms/forgot-password', [App\Http\Controllers\CmsAuthController::class, 'sendResetLink'])->name('cms.password.email');
    Route::get('/cms/reset-password/{token}', [App\Http\Controllers\CmsAuthController::class, 'showResetPassword'])->name('cms.password.reset');
    Route::post('/cms/reset-password', [App\Http\Controllers\CmsAuthController::class, 'resetPassword'])->name('cms.password.update');
    Route::get('/cms/verify-email/{id}', [App\Http\Controllers\CmsAuthController::class, 'verifyEmail'])->name('cms.users.verify_email');
    
    // 2FA Routes
    Route::get('/cms/verify', [App\Http\Controllers\CmsAuthController::class, 'show2fa'])->name('cms.verify.show');
    Route::post('/cms/verify', [App\Http\Controllers\CmsAuthController::class, 'verify2fa'])->name('cms.verify.submit');
    Route::post('/cms/verify/resend', [App\Http\Controllers\CmsAuthController::class, 'resend2fa'])->name('cms.verify.resend');
});

Route::prefix('cms')->name('cms.')->middleware(['cms.admin'])->group(function () {
    Route::post('/logout', [App\Http\Controllers\CmsAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/activity', [App\Http\Controllers\AdminController::class, 'activity'])->name('activity');
    Route::delete('/activity/clear', [App\Http\Controllers\AdminController::class, 'clearActivity'])->name('activity.clear');
    
    Route::get('/api/jobs/search', [App\Http\Controllers\AdminController::class, 'searchJobs'])->name('api.jobs.search');
    Route::get('/api/companies/search', [App\Http\Controllers\AdminController::class, 'searchCompanies'])->name('api.companies.search');
    if (app()->environment('local')) {
        Route::get('/debug/companies', function() {
            $companies = \App\Models\Company::select('id', 'name', 'industry')->orderBy('name')->get();
            return response()->json([
                'total' => $companies->count(),
                'companies' => $companies->take(10),
                'teleperformance_search' => \App\Models\Company::where('name', 'LIKE', '%teleperformance%')->get(['id', 'name'])
            ]);
        });
    }

    // Email Verification Routes
    Route::get('/verify-email', [App\Http\Controllers\CmsAuthController::class, 'showVerifyNotice'])->name('verification.notice');
    Route::get('/verify-check', [App\Http\Controllers\CmsAuthController::class, 'checkVerification'])->name('verification.check');
    Route::post('/verify-email/resend', [App\Http\Controllers\CmsAuthController::class, 'resendVerification'])->name('verification.resend');
    Route::post('/verify-email/change-email', [App\Http\Controllers\CmsAuthController::class, 'changeEmail'])->name('change_email');

    
    Route::middleware('superadmin')->group(function () {
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
        
        Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/{adminUser}/edit', [App\Http\Controllers\PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{adminUser}', [App\Http\Controllers\PermissionController::class, 'update'])->name('permissions.update');
    });
    
    Route::get('/profile', [App\Http\Controllers\AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\AdminController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/2fa', [App\Http\Controllers\AdminController::class, 'update2fa'])->name('profile.2fa');
    Route::post('/profile/2fa/send-code', [App\Http\Controllers\AdminController::class, 'send2faCode'])->name('profile.2fa.send-code');
    Route::post('/profile/2fa/recovery-codes', [App\Http\Controllers\AdminController::class, 'generateRecoveryCodes'])->name('profile.2fa.recovery-codes');
    Route::post('/profile/2fa/recovery-codes/email', [App\Http\Controllers\AdminController::class, 'sendRecoveryCodesEmail'])->name('profile.2fa.recovery-codes.email');
    Route::get('/profile/2fa/recovery-codes/download', [App\Http\Controllers\AdminController::class, 'downloadRecoveryCodes'])->name('profile.2fa.recovery-codes.download');
    
    // Jobs Management
    Route::get('/jobs', [App\Http\Controllers\AdminController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create', [App\Http\Controllers\AdminController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [App\Http\Controllers\AdminController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{job}/edit', [App\Http\Controllers\AdminController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{job}', [App\Http\Controllers\AdminController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/bulk-delete', [App\Http\Controllers\AdminController::class, 'bulkDeleteJobs'])->name('jobs.bulk-delete');
    Route::delete('/jobs/{job}', [App\Http\Controllers\AdminController::class, 'destroyJob'])->name('jobs.destroy');
    
    // Internships Management
    Route::get('/internships', [App\Http\Controllers\AdminController::class, 'internships'])->name('internships');
    Route::get('/internships/create', [App\Http\Controllers\AdminController::class, 'createInternship'])->name('internships.create');
    Route::post('/internships', [App\Http\Controllers\AdminController::class, 'storeInternship'])->name('internships.store');
    Route::get('/internships/{job}/edit', [App\Http\Controllers\AdminController::class, 'editInternship'])->name('internships.edit');
    Route::put('/internships/{job}', [App\Http\Controllers\AdminController::class, 'updateInternship'])->name('internships.update');
    Route::delete('/internships/bulk-delete', [App\Http\Controllers\AdminController::class, 'bulkDeleteInternships'])->name('internships.bulk-delete');
    Route::delete('/internships/{job}', [App\Http\Controllers\AdminController::class, 'destroyInternship'])->name('internships.destroy');
    
    // Companies Management
    Route::get('/companies', [App\Http\Controllers\AdminController::class, 'companies'])->name('companies');
    Route::get('/companies/create', [App\Http\Controllers\AdminController::class, 'createCompany'])->name('companies.create');
    Route::post('/companies', [App\Http\Controllers\AdminController::class, 'storeCompany'])->name('companies.store');
    Route::get('/companies/{company}/edit', [App\Http\Controllers\AdminController::class, 'editCompany'])->name('companies.edit');
    Route::put('/companies/{company}', [App\Http\Controllers\AdminController::class, 'updateCompany'])->name('companies.update');
    Route::delete('/companies/bulk-delete', [App\Http\Controllers\AdminController::class, 'bulkDeleteCompanies'])->name('companies.bulk-delete');
    Route::delete('/companies/{company}', [App\Http\Controllers\AdminController::class, 'destroyCompany'])->name('companies.destroy');
    
    // Testimonials Management
    Route::post('testimonials/{testimonial}/toggle-featured', [App\Http\Controllers\Admin\TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
    Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);
    
    // Categories Management
    Route::get('/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [App\Http\Controllers\AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [App\Http\Controllers\AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/bulk-delete', [App\Http\Controllers\AdminController::class, 'bulkDeleteCategories'])->name('categories.bulk-delete');
    Route::delete('/categories/{category}', [App\Http\Controllers\AdminController::class, 'destroyCategory'])->name('categories.destroy');
    
    // Posts Management
    Route::get('/posts', [App\Http\Controllers\AdminController::class, 'posts'])->name('posts');
    Route::get('/posts/create', [App\Http\Controllers\AdminController::class, 'createPost'])->name('posts.create');
    Route::post('/posts', [App\Http\Controllers\AdminController::class, 'storePost'])->name('posts.store');
    Route::get('/posts/{post}/edit', [App\Http\Controllers\AdminController::class, 'editPost'])->name('posts.edit');
    Route::put('/posts/{post}', [App\Http\Controllers\AdminController::class, 'updatePost'])->name('posts.update');
    Route::delete('/posts/bulk-delete', [App\Http\Controllers\AdminController::class, 'bulkDeletePosts'])->name('posts.bulk-delete');
    Route::delete('/posts/{post}', [App\Http\Controllers\AdminController::class, 'destroyPost'])->name('posts.destroy');
    
    Route::get('/seo', [App\Http\Controllers\SeoController::class, 'index'])->name('seo.index');
    Route::put('/seo/global', [App\Http\Controllers\SeoController::class, 'updateGlobalSettings'])->name('seo.global.update');
    Route::get('/seo/pages', [App\Http\Controllers\SeoController::class, 'pages'])->name('seo.pages');
    Route::get('/seo/indexing', [App\Http\Controllers\SeoController::class, 'indexing'])->name('seo.indexing');
    Route::post('/seo/indexing/upload', [App\Http\Controllers\SeoController::class, 'uploadVerificationFile'])->name('seo.indexing.upload');
    Route::delete('/seo/indexing/delete', [App\Http\Controllers\SeoController::class, 'deleteVerificationFile'])->name('seo.indexing.delete');
    Route::get('/seo/pages/create', [App\Http\Controllers\SeoController::class, 'createPage'])->name('seo.pages.create');
    Route::post('/seo/pages', [App\Http\Controllers\SeoController::class, 'storePage'])->name('seo.pages.store');
    Route::get('/seo/pages/{pageSeo}/edit', [App\Http\Controllers\SeoController::class, 'editPage'])->name('seo.pages.edit');
    Route::put('/seo/pages/{pageSeo}', [App\Http\Controllers\SeoController::class, 'updatePage'])->name('seo.pages.update');
    Route::delete('/seo/pages/{pageSeo}', [App\Http\Controllers\SeoController::class, 'destroyPage'])->name('seo.pages.destroy');
    Route::post('/seo/generate-slug', [App\Http\Controllers\SeoController::class, 'generateSlug'])->name('seo.generate-slug');

    // SEO Audit (used by CMS page edit to run quick audits)
    Route::post('/seo/audit', [App\Http\Controllers\SeoController::class, 'audit'])->name('seo.audit');

    Route::post('/seo/sitemap/generate', [App\Http\Controllers\SeoController::class, 'generateSitemap'])->name('seo.sitemap.generate');
    Route::get('/seo/job-schema', [App\Http\Controllers\SeoController::class, 'getJobPostingSchema'])->name('seo.job-schema');


});

Route::get('/health', function () {
    return response()->json(['status' => 'healthy', 'message' => 'Application is running.'], 200);
});

// End of Web Routes
