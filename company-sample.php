<?php
/**
 * Inaquired - Enhanced Company Page Sample & Feature Showcase
 * 
 * This file serves as a reference implementation and interactive sample
 * showcasing all missing features and enhancements for the Company page.
 * 
 * Access via: http://localhost/inaquired/company-sample.php
 */

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

$laravelBootstrapped = false;
$company = null;
$jobs = [];
$similarCompanies = [];

if (file_exists(__DIR__ . '/bootstrap/app.php') && class_exists(\Illuminate\Contracts\Console\Kernel::class)) {
    try {
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        $laravelBootstrapped = true;

        // Fetch a real sample company (preferably Stripe, Google, or first active)
        $company = \App\Models\Company::where('is_active', true)
            ->whereNotNull('tagline')
            ->withCount('jobs')
            ->first() ?? \App\Models\Company::where('is_active', true)->first();

        if ($company) {
            $jobs = \App\Models\Job::where('company_id', $company->id)
                ->where('is_active', true)
                ->with('category')
                ->latest()
                ->get();

            // Fetch similar companies in the same industry or type
            $similarCompanies = \App\Models\Company::where('is_active', true)
                ->where('id', '!=', $company->id)
                ->where(function($q) use ($company) {
                    if ($company->type) $q->where('type', $company->type);
                    if ($company->industry) $q->orWhere('industry', 'LIKE', '%' . explode(',', $company->industry)[0] . '%');
                })
                ->withCount('jobs')
                ->limit(3)
                ->get();
        }
    } catch (\Throwable $e) {
        $laravelBootstrapped = false;
    }
}

// Fallback Mock Data if DB is empty or not bootstrapped
if (!$company) {
    $company = (object) [
        'id' => 1,
        'name' => 'Stripe',
        'slug' => 'stripe',
        'type' => 'unicorn',
        'tagline' => 'Financial infrastructure for the internet — powering modern commerce worldwide.',
        'description' => "Stripe is a technology company that builds economic infrastructure for the internet. Businesses of every size—from new startups to public companies—use our software to accept payments and manage their businesses online.\n\nFounded in 2010, Stripe is dual-headquartered in San Francisco and Dublin, with thousands of employees collaborating remotely across the globe.",
        'industry' => 'Fintech, Payments, SaaS, Cloud Infrastructure',
        'website' => 'https://stripe.com',
        'linkedin_url' => 'https://linkedin.com/company/stripe',
        'founded_year' => 2010,
        'address' => 'San Francisco, CA & Dublin, Ireland',
        'jobs_count' => 4,
    ];

    $jobs = collect([
        (object) [
            'id' => 101,
            'title' => 'Senior Full Stack Engineer (Core Payments)',
            'slug' => 'senior-full-stack-engineer',
            'location' => 'Remote / San Francisco',
            'type' => 'full-time',
            'work_type' => 'remote',
            'experience' => '4-7 yrs',
            'level' => 'Senior',
            'salary_min' => 2800000,
            'salary_max' => 4200000,
            'is_featured' => true,
            'created_at' => now()->subDays(2),
            'category' => (object) ['name' => 'Engineering & Development'],
        ],
        (object) [
            'id' => 102,
            'title' => 'Product Designer - Merchant Dashboard',
            'slug' => 'product-designer-merchant-dashboard',
            'location' => 'Hybrid (Bangalore / Remote)',
            'type' => 'full-time',
            'work_type' => 'hybrid',
            'experience' => '3-5 yrs',
            'level' => 'Mid-Level',
            'salary_min' => 1800000,
            'salary_max' => 2600000,
            'is_featured' => false,
            'created_at' => now()->subDays(4),
            'category' => (object) ['name' => 'Design & Creative'],
        ],
        (object) [
            'id' => 103,
            'title' => 'DevOps & Cloud Infrastructure Engineer',
            'slug' => 'devops-cloud-infrastructure-engineer',
            'location' => 'Remote (India)',
            'type' => 'full-time',
            'work_type' => 'remote',
            'experience' => '3-6 yrs',
            'level' => 'Mid-Senior',
            'salary_min' => 2200000,
            'salary_max' => 3400000,
            'is_featured' => true,
            'created_at' => now()->subDays(5),
            'category' => (object) ['name' => 'DevOps & Cloud'],
        ],
        (object) [
            'id' => 104,
            'title' => 'Technical Support & Integration Specialist',
            'slug' => 'technical-support-specialist',
            'location' => 'Bangalore, India',
            'type' => 'full-time',
            'work_type' => 'onsite',
            'experience' => '1-3 yrs',
            'level' => 'Junior',
            'salary_min' => 800000,
            'salary_max' => 1400000,
            'is_featured' => false,
            'created_at' => now()->subDays(7),
            'category' => (object) ['name' => 'Customer Support'],
        ]
    ]);

    $similarCompanies = collect([
        (object) ['id' => 2, 'name' => 'Figma', 'slug' => 'figma', 'type' => 'startup', 'industry' => 'Design, SaaS', 'jobs_count' => 3, 'website' => 'https://figma.com'],
        (object) ['id' => 3, 'name' => 'Google', 'slug' => 'google', 'type' => 'mnc', 'industry' => 'Technology, Search', 'jobs_count' => 8, 'website' => 'https://google.com'],
        (object) ['id' => 4, 'name' => 'Shopify', 'slug' => 'shopify', 'type' => 'enterprise', 'industry' => 'E-commerce, SaaS', 'jobs_count' => 5, 'website' => 'https://shopify.com'],
    ]);
}

$industries = !empty($company->industry) ? array_filter(array_map('trim', preg_split('/[,|\/]+/', $company->industry))) : [];
$typeLabel = ucfirst($company->type ?? 'Company');
$typeColor = match(strtolower($company->type ?? '')) {
    'unicorn' => 'bg-purple-50 text-purple-700 border-purple-200',
    'startup' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    'mnc', 'indian_mnc' => 'bg-blue-50 text-blue-700 border-blue-200',
    'enterprise' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
    default => 'bg-slate-50 text-slate-700 border-slate-200'
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($company->name) ?> - Enhanced Company Profile Sample</title>
    
    <!-- Tailwind CSS CDN for instant standalone rendering -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Unbounded:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-unbounded { font-family: 'Unbounded', sans-serif; }
        .tab-btn.active {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    <!-- Top Notice Banner -->
    <div class="bg-indigo-900 text-white px-4 py-2 text-xs font-semibold flex items-center justify-between">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between flex-wrap gap-2">
            <span class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span><strong>Sample Reference File:</strong> Showcasing all company page features (Search within company, Stats bar, Share actions, Job alerts, Similar brands).</span>
            </span>
            <a href="public/companies" class="text-indigo-200 hover:text-white underline font-bold">Return to Companies Directory →</a>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="public/" class="font-unbounded text-xl font-bold tracking-tight text-blue-600 uppercase flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-blue-600 rounded-full"></span>
                inaquired
            </a>
            <div class="flex items-center gap-3">
                <a href="public/companies" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Browse Companies</a>
                <a href="public/jobs" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">Find Jobs</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- 1. Breadcrumbs Feature -->
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400" aria-label="Breadcrumb">
            <a href="public/" class="hover:text-slate-600 transition-colors">Home</a>
            <span>/</span>
            <a href="public/companies" class="hover:text-slate-600 transition-colors">Companies</a>
            <span>/</span>
            <?php if (!empty($company->type)): ?>
                <a href="public/<?= strtolower($company->type) ?>-companies" class="hover:text-slate-600 transition-colors"><?= $typeLabel ?>s</a>
                <span>/</span>
            <?php endif; ?>
            <span class="text-slate-700 font-bold"><?= htmlspecialchars($company->name) ?></span>
        </nav>

        <!-- 2. Company Profile Hero Header -->
        <section class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm relative overflow-hidden">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                
                <!-- Left: Logo Avatar & Info -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 flex-1 min-w-0">
                    <!-- Brand Avatar -->
                    <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center font-unbounded text-2xl sm:text-3xl font-black shadow-md flex-shrink-0">
                        <?= strtoupper(substr($company->name, 0, 1)) ?>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2.5 mb-1.5">
                            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight font-unbounded"><?= htmlspecialchars($company->name) ?></h1>
                            
                            <!-- Verified Employer Badge -->
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-0.5 rounded-full" title="Verified Employer Profile">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span>Verified</span>
                            </span>

                            <!-- Company Type Badge -->
                            <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full border <?= $typeColor ?>">
                                <?= $typeLabel ?>
                            </span>
                        </div>

                        <?php if(!empty($company->tagline)): ?>
                            <p class="text-sm sm:text-base text-slate-600 font-medium mb-3 max-w-2xl leading-relaxed">
                                <?= htmlspecialchars($company->tagline) ?>
                            </p>
                        <?php endif; ?>

                        <!-- Meta Info Row (Industry Tags, Founded, HQ) -->
                        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
                            <?php foreach(array_slice($industries, 0, 3) as $ind): ?>
                                <span class="bg-slate-100 text-slate-700 font-semibold px-2.5 py-1 rounded-lg"><?= htmlspecialchars($ind) ?></span>
                            <?php endforeach; ?>

                            <?php if(!empty($company->founded_year)): ?>
                                <span class="text-slate-400">•</span>
                                <span class="text-slate-500 font-medium">Est. <?= htmlspecialchars($company->founded_year) ?></span>
                            <?php endif; ?>

                            <?php if(!empty($company->address)): ?>
                                <span class="text-slate-400">•</span>
                                <span class="text-slate-500 font-medium flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <?= htmlspecialchars($company->address) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right: Action Buttons (Share, Alert, Website, LinkedIn) -->
                <div class="flex items-center flex-wrap gap-2.5 flex-shrink-0 w-full lg:w-auto">
                    <!-- Share Button -->
                    <button type="button" onclick="openShareModal()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50/50 shadow-xs transition-all">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        <span>Share</span>
                    </button>

                    <!-- Job Alerts Subscription Trigger -->
                    <button type="button" onclick="openAlertModal()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>Get Alerts</span>
                    </button>

                    <!-- Official Website Link -->
                    <?php if(!empty($company->website)): ?>
                        <a href="<?= htmlspecialchars($company->website) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50/50 shadow-xs transition-all" title="Visit Official Website">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    <?php endif; ?>

                    <!-- LinkedIn Profile Link -->
                    <?php if(!empty($company->linkedin_url)): ?>
                        <a href="<?= htmlspecialchars($company->linkedin_url) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-[#0077b5] hover:border-[#0077b5]/30 hover:bg-blue-50/50 shadow-xs transition-all" title="LinkedIn Profile">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 3. Key Hiring Stats Bar Feature -->
            <div class="mt-8 pt-6 border-t border-slate-100 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Open Positions</p>
                    <p class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5"><?= count($jobs) ?></p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Work Mode</p>
                    <p class="text-sm sm:text-base font-bold text-slate-800 mt-1">Remote & Hybrid</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Industry Sector</p>
                    <p class="text-sm sm:text-base font-bold text-slate-800 mt-1 truncate"><?= $industries[0] ?? 'Technology' ?></p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Hiring Status</p>
                    <p class="text-sm sm:text-base font-bold text-emerald-600 mt-1 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        Actively Hiring
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Layout with Job Search & Filter Toolbar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left 2 Cols: Interactive Job Openings Section -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- 4. Real-time Search & Filter Controls within Company Openings -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <h2 class="text-sm font-black uppercase tracking-wider text-slate-900 font-unbounded">
                            Job Openings (<?= count($jobs) ?>)
                        </h2>
                        <span class="text-xs font-medium text-slate-500">Filter roles at <?= htmlspecialchars($company->name) ?></span>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <!-- Search Box within Company Jobs -->
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" id="job-search-input" oninput="filterCompanyJobs()" placeholder="Search roles by title, keyword, tech stack..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>

                        <!-- Work Mode Selector Filter -->
                        <select id="work-type-filter" onchange="filterCompanyJobs()" class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option value="all">All Modes</option>
                            <option value="remote">Remote Only</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="onsite">Onsite</option>
                        </select>
                    </div>

                    <!-- Filter Tags (All, Engineering, Design, Full-time) -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                        <button type="button" onclick="setCategoryFilter('all', this)" class="tab-btn active px-3 py-1.5 rounded-lg border border-slate-200 font-bold transition-all">All Roles</button>
                        <button type="button" onclick="setCategoryFilter('engineering', this)" class="tab-btn px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition-all">Engineering</button>
                        <button type="button" onclick="setCategoryFilter('design', this)" class="tab-btn px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition-all">Design</button>
                        <button type="button" onclick="setCategoryFilter('remote', this)" class="tab-btn px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-600 font-bold hover:bg-slate-100 transition-all">Remote</button>
                    </div>
                </div>

                <!-- 5. Job Cards List -->
                <div id="company-jobs-list" class="space-y-4">
                    <?php if(count($jobs) > 0): ?>
                        <?php foreach($jobs as $job): ?>
                            <div class="company-job-item bg-white p-5 rounded-2xl border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all group"
                                 data-title="<?= strtolower($job->title) ?>"
                                 data-mode="<?= strtolower($job->work_type ?? 'onsite') ?>"
                                 data-category="<?= strtolower($job->category->name ?? '') ?>">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="space-y-1.5 flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-bold text-slate-900 group-hover:text-blue-600 text-base sm:text-lg transition-colors"><?= htmlspecialchars($job->title) ?></h3>
                                            <?php if(!empty($job->is_featured)): ?>
                                                <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Featured</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                            <span class="flex items-center gap-1 font-medium text-slate-600">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                                <?= htmlspecialchars($job->location ?? 'Remote') ?>
                                            </span>
                                            <span>•</span>
                                            <span class="font-medium text-slate-600"><?= ucfirst($job->type ?? 'Full Time') ?></span>
                                            <span>•</span>
                                            <span class="font-bold text-blue-600">
                                                ₹<?= number_format($job->salary_min/100000, 1) ?> - <?= number_format($job->salary_max/100000, 1) ?> LPA
                                            </span>
                                        </div>
                                    </div>
                                    <a href="public/jobs/<?= $job->id ?>" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex-shrink-0">
                                        <span>Apply Now</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center">
                            <p class="text-slate-500 font-medium">No open positions found at <?= htmlspecialchars($company->name) ?> right now.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Empty state for search -->
                <div id="no-jobs-found" class="hidden bg-white p-12 rounded-2xl border border-slate-200 text-center">
                    <p class="text-slate-700 font-bold text-base mb-1">No positions match your search</p>
                    <p class="text-slate-500 text-xs">Try adjusting your keywords or clearing the filter.</p>
                </div>
            </div>

            <!-- Right Col: Company Details & Sidebar Widgets -->
            <div class="space-y-6">
                
                <!-- 6. About Company Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 font-unbounded">About the Organization</h3>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        <?= htmlspecialchars($company->description ?? 'No description available.') ?>
                    </p>
                    <div class="pt-4 border-t border-slate-100 flex flex-col gap-2.5 text-xs text-slate-600 font-medium">
                        <?php if(!empty($company->website)): ?>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Website:</span>
                                <a href="<?= htmlspecialchars($company->website) ?>" target="_blank" class="text-blue-600 font-bold hover:underline truncate max-w-[180px]"><?= parse_url($company->website, PHP_URL_HOST) ?? $company->website ?> ↗</a>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($company->founded_year)): ?>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Founded:</span>
                                <span class="text-slate-800 font-bold"><?= htmlspecialchars($company->founded_year) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($company->address)): ?>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Headquarters:</span>
                                <span class="text-slate-800 font-bold truncate max-w-[180px]"><?= htmlspecialchars($company->address) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 7. Job Alerts Widget Feature -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white space-y-4 shadow-md">
                    <div class="space-y-1">
                        <h4 class="font-black text-base font-unbounded">Never miss a role at <?= htmlspecialchars($company->name) ?></h4>
                        <p class="text-xs text-blue-100">Get notified directly when new career opportunities are published.</p>
                    </div>
                    <form onsubmit="handleAlertSubscribe(event)" class="space-y-2">
                        <input type="email" required placeholder="Enter your email..." class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-blue-200 text-xs focus:bg-white focus:text-slate-900 focus:outline-none transition-all">
                        <button type="submit" class="w-full py-2.5 bg-white hover:bg-blue-50 text-blue-700 font-bold rounded-xl text-xs shadow-sm transition-all">
                            Notify Me of New Jobs
                        </button>
                    </form>
                </div>

                <!-- 8. Similar Companies Widget Feature -->
                <?php if(count($similarCompanies) > 0): ?>
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 font-unbounded">Similar Brands Hiring</h3>
                        <div class="divide-y divide-slate-100">
                            <?php foreach($similarCompanies as $sim): ?>
                                <a href="public/company/<?= $sim->slug ?? $sim->id ?>" class="py-3 flex items-center justify-between gap-3 group block hover:bg-slate-50/60 rounded-xl px-2 -mx-2 transition-colors">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-slate-100 group-hover:bg-blue-50 group-hover:text-blue-600 text-slate-700 font-bold text-xs flex items-center justify-center font-unbounded transition-colors flex-shrink-0">
                                            <?= strtoupper(substr($sim->name, 0, 1)) ?>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-bold text-xs text-slate-900 group-hover:text-blue-600 truncate transition-colors"><?= htmlspecialchars($sim->name) ?></h4>
                                            <p class="text-[11px] text-slate-400 truncate"><?= htmlspecialchars(explode(',', $sim->industry ?? '')[0] ?? 'Tech') ?></p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md flex-shrink-0">
                                        <?= $sim->jobs_count ?? 1 ?> <?= ($sim->jobs_count ?? 1) === 1 ? 'Job' : 'Jobs' ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </main>

    <!-- Share Modal -->
    <div id="share-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl border border-slate-100 space-y-5">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-base text-slate-900">Share <?= htmlspecialchars($company->name) ?></h3>
                <button onclick="closeShareModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center">✕</button>
            </div>
            <p class="text-xs text-slate-500">Share this company career profile with peers and friends.</p>
            <div class="grid grid-cols-3 gap-3">
                <a href="https://api.whatsapp.com/send?text=Check%20out%20open%20roles%20at%20<?= urlencode($company->name) ?>%20on%20Inaquired:%20<?= urlencode('http://localhost/inaquired/public/company/' . $company->slug) ?>" target="_blank" class="p-3 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl text-center text-xs font-bold transition-all">
                    WhatsApp
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('http://localhost/inaquired/public/company/' . $company->slug) ?>" target="_blank" class="p-3 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl text-center text-xs font-bold transition-all">
                    LinkedIn
                </a>
                <a href="https://twitter.com/intent/tweet?text=Explore%20jobs%20at%20<?= urlencode($company->name) ?>&url=<?= urlencode('http://localhost/inaquired/public/company/' . $company->slug) ?>" target="_blank" class="p-3 bg-slate-100 text-slate-800 hover:bg-slate-200 rounded-xl text-center text-xs font-bold transition-all">
                    X / Twitter
                </a>
            </div>
            <div class="flex items-center gap-2 pt-2">
                <input type="text" id="share-link-input" readonly value="http://localhost/inaquired/public/company/<?= $company->slug ?? $company->id ?>" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 select-all font-mono">
                <button onclick="copyShareLink()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold whitespace-nowrap">
                    Copy Link
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden bg-slate-900 text-white px-5 py-3 rounded-2xl shadow-xl text-xs font-bold transition-all transform translate-y-2">
        <span id="toast-message">Link copied to clipboard!</span>
    </div>

    <script>
        function filterCompanyJobs() {
            const query = (document.getElementById('job-search-input')?.value || '').toLowerCase().trim();
            const mode = (document.getElementById('work-type-filter')?.value || 'all').toLowerCase();
            const items = document.querySelectorAll('.company-job-item');
            let visibleCount = 0;

            items.forEach(item => {
                const title = item.dataset.title || '';
                const itemMode = item.dataset.mode || '';
                const matchesQuery = query === '' || title.includes(query);
                const matchesMode = mode === 'all' || itemMode.includes(mode);

                if (matchesQuery && matchesMode) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            const noJobsEl = document.getElementById('no-jobs-found');
            if (noJobsEl) {
                noJobsEl.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        function setCategoryFilter(cat, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
                b.classList.remove('bg-blue-600', 'text-white');
                b.classList.add('bg-slate-50', 'text-slate-600');
            });
            btn.classList.add('active');
            btn.classList.remove('bg-slate-50', 'text-slate-600');
            btn.classList.add('bg-blue-600', 'text-white');

            const items = document.querySelectorAll('.company-job-item');
            let visibleCount = 0;
            items.forEach(item => {
                const category = item.dataset.category || '';
                const mode = item.dataset.mode || '';
                let match = false;
                if (cat === 'all') match = true;
                else if (cat === 'remote') match = mode.includes('remote');
                else match = category.includes(cat);

                item.style.display = match ? 'block' : 'none';
                if (match) visibleCount++;
            });

            const noJobsEl = document.getElementById('no-jobs-found');
            if (noJobsEl) {
                noJobsEl.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        function openShareModal() {
            document.getElementById('share-modal')?.classList.remove('hidden');
        }

        function closeShareModal() {
            document.getElementById('share-modal')?.classList.add('hidden');
        }

        function copyShareLink() {
            const input = document.getElementById('share-link-input');
            if (input) {
                input.select();
                navigator.clipboard.writeText(input.value);
                showToast('Link copied to clipboard!');
                closeShareModal();
            }
        }

        function openAlertModal() {
            showToast('Email alert setup initialized.');
        }

        function handleAlertSubscribe(e) {
            e.preventDefault();
            showToast('Subscribed! You will receive new openings for this company.');
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            const msgEl = document.getElementById('toast-message');
            if (toast && msgEl) {
                msgEl.textContent = msg;
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3500);
            }
        }
    </script>
</body>
</html>
