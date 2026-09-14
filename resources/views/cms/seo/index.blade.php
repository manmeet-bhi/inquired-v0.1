@extends('layouts.cms')

@section('title', 'SEO Management - CMS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">SEO Management</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ ($seoScore ?? 0) >= 80 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                    Health Score: {{ $seoScore ?? 0 }}%
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ url('/sitemap.xml') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white text-slate-700 hover:text-slate-900 border border-slate-200 hover:border-slate-300 rounded-xl text-xs font-semibold shadow-xs transition-all">
                <i data-lucide="map" class="w-4 h-4 text-emerald-600"></i>
                <span>View Sitemap.xml</span>
                <i data-lucide="external-link" class="w-3 h-3 text-slate-400"></i>
            </a>
            <a href="https://search.google.com/test/rich-results" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white text-slate-700 hover:text-slate-900 border border-slate-200 hover:border-slate-300 rounded-xl text-xs font-semibold shadow-xs transition-all">
                <i data-lucide="check-circle" class="w-4 h-4 text-blue-600"></i>
                <span>Rich Results Test</span>
                <i data-lucide="external-link" class="w-3 h-3 text-slate-400"></i>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between text-sm shadow-xs">
            <div class="flex items-center gap-2.5">
                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center justify-between text-sm shadow-xs">
            <div class="flex items-center gap-2.5">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm shadow-xs">
            <div class="flex items-center gap-2 mb-2 font-semibold text-rose-900">
                <i data-lucide="alert-octagon" class="w-4 h-4 text-rose-600"></i>
                <span>Please fix the following validation errors:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs text-rose-700 ml-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-slate-200 bg-white rounded-t-xl px-2 pt-2 shadow-xs">
        <nav class="flex space-x-1 sm:space-x-2 overflow-x-auto no-scrollbar" aria-label="SEO Tabs" id="seoTabsNav">
            
            <button type="button" onclick="switchSeoTab('basic')" id="tab-btn-basic" class="seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-indigo-600 border-indigo-600 bg-indigo-50/50 rounded-t-lg">
                <i data-lucide="search" class="w-4 h-4"></i>
                <span>Basic SEO</span>
            </button>

            <button type="button" onclick="switchSeoTab('social')" id="tab-btn-social" class="seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-slate-500 hover:text-slate-700 border-transparent hover:border-slate-300 rounded-t-lg">
                <i data-lucide="share-2" class="w-4 h-4"></i>
                <span>Social SEO</span>
            </button>

            <button type="button" onclick="switchSeoTab('technical')" id="tab-btn-technical" class="seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-slate-500 hover:text-slate-700 border-transparent hover:border-slate-300 rounded-t-lg">
                <i data-lucide="settings-2" class="w-4 h-4"></i>
                <span>Technical SEO</span>
            </button>

            <button type="button" onclick="switchSeoTab('schema')" id="tab-btn-schema" class="seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-slate-500 hover:text-slate-700 border-transparent hover:border-slate-300 rounded-t-lg">
                <i data-lucide="code-2" class="w-4 h-4"></i>
                <span>Schema</span>
            </button>

            <button type="button" onclick="switchSeoTab('pages')" id="tab-btn-pages" class="seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-slate-500 hover:text-slate-700 border-transparent hover:border-slate-300 rounded-t-lg">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                <span>Page SEO</span>
                <span class="px-2 py-0.5 text-[11px] rounded-full bg-slate-100 text-slate-600 font-medium">
                    {{ \App\Models\PageSeo::count() }}
                </span>
            </button>

            <button type="button" onclick="switchSeoTab('indexing')" id="tab-btn-indexing" class="seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-slate-500 hover:text-slate-700 border-transparent hover:border-slate-300 rounded-t-lg">
                <i data-lucide="globe" class="w-4 h-4"></i>
                <span>Search Engine Indexing</span>
            </button>

        </nav>
    </div>

    <!-- TAB 1: BASIC SEO -->
    <div id="tab-content-basic" class="seo-tab-content space-y-6">
        <form action="{{ route('cms.seo.global.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="current_tab" value="basic">

            <!-- Preserve fields from other tabs when submitting -->
            <input type="hidden" name="og_title" value="{{ $globalSettings['og_title'] ?? '' }}">
            <input type="hidden" name="og_description" value="{{ $globalSettings['og_description'] ?? '' }}">
            <input type="hidden" name="og_type" value="{{ $globalSettings['og_type'] ?? 'website' }}">
            <input type="hidden" name="og_locale" value="{{ $globalSettings['og_locale'] ?? 'en_US' }}">
            <input type="hidden" name="og_site_name" value="{{ $globalSettings['og_site_name'] ?? '' }}">
            <input type="hidden" name="og_url" value="{{ $globalSettings['og_url'] ?? '' }}">
            <input type="hidden" name="twitter_card" value="{{ $globalSettings['twitter_card'] ?? 'summary_large_image' }}">
            <input type="hidden" name="twitter_site" value="{{ $globalSettings['twitter_site'] ?? '' }}">
            <input type="hidden" name="twitter_title" value="{{ $globalSettings['twitter_title'] ?? '' }}">
            <input type="hidden" name="twitter_description" value="{{ $globalSettings['twitter_description'] ?? '' }}">
            <input type="hidden" name="twitter_creator" value="{{ $globalSettings['twitter_creator'] ?? '' }}">
            <input type="hidden" name="schema_json" value="{{ $globalSettings['schema_json'] ?? '' }}">
            <input type="hidden" name="robots_txt" value="{{ $globalSettings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /cms/\n\nSitemap: " . url('/sitemap.xml') }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form Column -->
                <div class="lg:col-span-2 space-y-6 min-w-0">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
                        <div class="border-b border-slate-100 pb-4">
                            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="search" class="w-4 h-4 text-indigo-600"></i>
                                Site Identity & Global Meta Tags
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">Default meta information served to Google, Bing, and web crawlers.</p>
                        </div>

                        <!-- Site Title -->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label for="site_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Site Title <span class="text-rose-500">*</span></label>
                                <span class="text-[11px] text-slate-400"><span id="site_title_count">{{ strlen($globalSettings['site_title'] ?? '') }}</span> / 60 characters</span>
                            </div>
                            <input type="text" id="site_title" name="site_title" value="{{ old('site_title', $globalSettings['site_title'] ?? '') }}" oninput="updateBasicPreview()" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white text-sm transition-colors text-slate-900 font-medium" placeholder="Inaquired - Discover Verified Career Opportunities" required>
                            <p class="text-[11px] text-slate-500 mt-1">Appears as the primary clickable headline in search engine result pages.</p>
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label for="meta_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Meta Description <span class="text-rose-500">*</span></label>
                                <span class="text-[11px] text-slate-400"><span id="meta_desc_count">{{ strlen($globalSettings['meta_description'] ?? '') }}</span> / 160 characters</span>
                            </div>
                            <textarea id="meta_description" name="meta_description" rows="3" oninput="updateBasicPreview()" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white text-sm transition-colors text-slate-800" placeholder="Explore top jobs, curated career openings, industry hiring trends, and company insights." required>{{ old('meta_description', $globalSettings['meta_description'] ?? '') }}</textarea>
                            <p class="text-[11px] text-slate-500 mt-1">A concise summary of your platform (recommended 140–160 characters).</p>
                        </div>

                        <!-- Keywords & Canonical -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="meta_keywords" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keywords (Optional)</label>
                                <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $globalSettings['meta_keywords'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white text-sm transition-colors" placeholder="jobs, careers, tech hiring, internships">
                                <p class="text-[11px] text-slate-500 mt-1">Comma-separated meta keywords.</p>
                            </div>

                            <div>
                                <label for="meta_canonical" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Canonical URL</label>
                                <input type="url" id="meta_canonical" name="meta_canonical" value="{{ old('meta_canonical', $globalSettings['meta_canonical'] ?? '') }}" oninput="updateBasicPreview()" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white text-sm transition-colors" placeholder="{{ url('/') }}">
                                <p class="text-[11px] text-slate-500 mt-1">Preferred URL for search engine indexing.</p>
                            </div>
                        </div>

                        <!-- Directives & Favicon -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-4 border-t border-slate-100">
                            <!-- Crawling Directives -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Search Directives</label>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-3">
                                    <label class="flex items-center gap-3 text-xs font-medium text-slate-700 cursor-pointer select-none">
                                        <input type="checkbox" name="global_noindex" value="1" {{ old('global_noindex', !empty($globalSettings['global_noindex']) ? '1' : '') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 shrink-0">
                                        <span>NoIndex (Prevent search indexing)</span>
                                    </label>
                                    <label class="flex items-center gap-3 text-xs font-medium text-slate-700 cursor-pointer select-none">
                                        <input type="checkbox" name="global_nofollow" value="1" {{ old('global_nofollow', !empty($globalSettings['global_nofollow']) ? '1' : '') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 shrink-0">
                                        <span>NoFollow (Do not follow outbound links)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Favicon Upload -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Site Favicon</label>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                                    <input type="file" name="favicon" accept=".ico,.png,.svg" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @if(!empty($globalSettings['favicon']))
                                        <div class="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ media_url($globalSettings['favicon']) }}" class="w-5 h-5 rounded shadow-2xs">
                                                <span class="text-slate-600">Current Favicon</span>
                                            </div>
                                            <label class="text-rose-600 hover:text-rose-700 cursor-pointer font-medium flex items-center gap-2 select-none">
                                                <input type="checkbox" name="remove_favicon" value="1" class="rounded text-rose-600 h-4 w-4 border-slate-300 focus:ring-rose-500 shrink-0">
                                                <span>Remove</span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Save Action -->
                        <div class="pt-4 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-indigo-500/20 active:scale-95 transition-all">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                <span>Save Basic SEO</span>
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Google Live Preview Column -->
                <div class="space-y-6 min-w-0 w-full">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 min-w-0 overflow-hidden">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center gap-1.5">
                            <i data-lucide="eye" class="w-3.5 h-3.5 text-indigo-500"></i>
                            Google Search Result Preview
                        </h4>

                        <!-- Google SERP Card -->
                        <div class="border border-slate-200 rounded-xl p-4 bg-white shadow-xs space-y-2 font-sans min-w-0 max-w-full overflow-hidden">
                            <div class="flex items-center gap-2.5 min-w-0 w-full overflow-hidden">
                                <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200/80 flex items-center justify-center text-[10px] text-slate-500 font-bold shrink-0 overflow-hidden">
                                    @if(!empty($globalSettings['favicon']))
                                        <img src="{{ media_url($globalSettings['favicon']) }}" class="w-4 h-4 rounded-full object-contain">
                                    @else
                                        <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-400"></i>
                                    @endif
                                </div>
                                <div class="flex flex-col min-w-0 flex-1 overflow-hidden">
                                    <span class="text-[12px] text-slate-800 font-medium leading-tight truncate">{{ parse_url(url('/'), PHP_URL_HOST) }}</span>
                                    <span id="preview_serp_url" class="text-[11px] text-slate-500 truncate block font-normal" style="overflow-wrap: anywhere; word-break: break-all;">{{ $globalSettings['meta_canonical'] ?? url('/') }}</span>
                                </div>
                            </div>

                            <h5 id="preview_serp_title" class="text-base text-[#1a0dab] hover:underline cursor-pointer font-medium leading-snug line-clamp-2 block break-words" style="overflow-wrap: anywhere; word-break: break-word; max-width: 100%;">
                                {{ $globalSettings['site_title'] ?? 'Inaquired - Discover Career Opportunities' }}
                            </h5>

                            <p id="preview_serp_desc" class="text-xs text-[#4d5156] leading-relaxed line-clamp-3 block break-words" style="overflow-wrap: anywhere; word-break: break-word; max-width: 100%;">
                                {{ $globalSettings['meta_description'] ?? 'Explore top jobs, curated career openings, industry hiring trends, and company insights.' }}
                            </p>
                        </div>

                        <!-- Recommendations Box -->
                        <div class="mt-4 p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs space-y-2 text-slate-600">
                            <div class="font-semibold text-slate-800 flex items-center gap-1.5">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>Optimization Best Practices</span>
                            </div>
                            <ul class="space-y-1 text-[11px] text-slate-500 list-disc list-inside">
                                <li>Keep titles under 60 characters for zero truncation.</li>
                                <li>Descriptions between 140–160 chars maximize CTR.</li>
                                <li>Ensure canonical URLs include full https protocol.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 2: SOCIAL SEO -->
    <div id="tab-content-social" class="seo-tab-content space-y-6 hidden">
        <form action="{{ route('cms.seo.global.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="current_tab" value="social">

            <!-- Preserve fields from other tabs -->
            <input type="hidden" name="site_title" value="{{ $globalSettings['site_title'] ?? 'Inaquired' }}">
            <input type="hidden" name="meta_description" value="{{ $globalSettings['meta_description'] ?? 'Platform' }}">
            <input type="hidden" name="meta_keywords" value="{{ $globalSettings['meta_keywords'] ?? '' }}">
            <input type="hidden" name="meta_canonical" value="{{ $globalSettings['meta_canonical'] ?? '' }}">
            <input type="hidden" name="schema_json" value="{{ $globalSettings['schema_json'] ?? '' }}">
            <input type="hidden" name="robots_txt" value="{{ $globalSettings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /cms/\n\nSitemap: " . url('/sitemap.xml') }}">
            @if(!empty($globalSettings['global_noindex'])) <input type="hidden" name="global_noindex" value="1"> @endif
            @if(!empty($globalSettings['global_nofollow'])) <input type="hidden" name="global_nofollow" value="1"> @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Open Graph Card -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5 flex flex-col justify-between">
                    <div class="space-y-5">
                        <div class="border-b border-slate-100 pb-3.5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                    <i data-lucide="facebook" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Open Graph (Facebook & LinkedIn)</h3>
                                    <p class="text-[11px] text-slate-500">Shared previews on Facebook, LinkedIn, WhatsApp & Slack.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">OG Title</label>
                            <input type="text" name="og_title" value="{{ old('og_title', $globalSettings['og_title'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="{{ $globalSettings['site_title'] ?? 'Inaquired' }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">OG Description</label>
                            <textarea name="og_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="{{ $globalSettings['meta_description'] ?? 'Discover top jobs and company insights' }}">{{ old('og_description', $globalSettings['og_description'] ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">OG Type</label>
                                <input type="text" name="og_type" value="{{ old('og_type', $globalSettings['og_type'] ?? 'website') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">OG Locale</label>
                                <input type="text" name="og_locale" value="{{ old('og_locale', $globalSettings['og_locale'] ?? 'en_US') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">OG Site Name</label>
                                <input type="text" name="og_site_name" value="{{ old('og_site_name', $globalSettings['og_site_name'] ?? '') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" placeholder="Inaquired">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">OG URL</label>
                                <input type="url" name="og_url" value="{{ old('og_url', $globalSettings['og_url'] ?? '') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" placeholder="{{ url('/') }}">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Default Share Image (1200x630)</label>
                            <input type="file" name="og_default_image" accept=".jpg,.jpeg,.png" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if(!empty($globalSettings['og_default_image']))
                                <div class="mt-2.5 p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ media_url($globalSettings['og_default_image']) }}" class="h-8 w-12 object-cover rounded shadow-2xs">
                                        <span class="text-slate-600 font-medium truncate max-w-[160px]">Active OG Image</span>
                                    </div>
                                    <label class="text-rose-600 hover:text-rose-700 cursor-pointer font-medium flex items-center gap-2 select-none">
                                        <input type="checkbox" name="remove_og_image" value="1" class="rounded text-rose-600 h-4 w-4 border-slate-300 focus:ring-rose-500 shrink-0">
                                        <span>Remove</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm shadow-sm active:scale-95 transition-all">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Save Open Graph</span>
                        </button>
                    </div>
                </div>

                <!-- Twitter Card -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5 flex flex-col justify-between">
                    <div class="space-y-5">
                        <div class="border-b border-slate-100 pb-3.5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-xs">
                                    <i data-lucide="twitter" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Twitter / X Card</h3>
                                    <p class="text-[11px] text-slate-500">Rich cards rendered when shared on Twitter/X.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Twitter Title</label>
                            <input type="text" name="twitter_title" value="{{ old('twitter_title', $globalSettings['twitter_title'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500" placeholder="{{ $globalSettings['site_title'] ?? 'Inaquired' }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Twitter Description</label>
                            <textarea name="twitter_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500" placeholder="{{ $globalSettings['meta_description'] ?? 'Discover verified careers' }}">{{ old('twitter_description', $globalSettings['twitter_description'] ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Twitter Card Layout</label>
                            <select name="twitter_card" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 bg-white">
                                <option value="summary_large_image" {{ old('twitter_card', $globalSettings['twitter_card'] ?? '') == 'summary_large_image' ? 'selected' : '' }}>summary_large_image (Large Hero Card)</option>
                                <option value="summary" {{ old('twitter_card', $globalSettings['twitter_card'] ?? '') == 'summary' ? 'selected' : '' }}>summary (Small Thumbnail)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Twitter Site (&#64;handle)</label>
                                <input type="text" name="twitter_site" value="{{ old('twitter_site', $globalSettings['twitter_site'] ?? '') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" placeholder="&#64;inaquired">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Twitter Creator (&#64;handle)</label>
                                <input type="text" name="twitter_creator" value="{{ old('twitter_creator', $globalSettings['twitter_creator'] ?? '') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm" placeholder="&#64;inaquired">
                            </div>
                        </div>

                        <div class="p-3 bg-sky-50 rounded-xl border border-sky-100 text-xs text-sky-800">
                            <span class="font-semibold">Tip:</span> If no Twitter specific image is specified, Twitter uses the default Open Graph image above.
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-semibold text-sm shadow-sm active:scale-95 transition-all">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Save Twitter Cards</span>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- TAB 3: TECHNICAL SEO -->
    <div id="tab-content-technical" class="seo-tab-content space-y-6 hidden">
        <form action="{{ route('cms.seo.global.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="current_tab" value="technical">

            <!-- Preserve fields from other tabs -->
            <input type="hidden" name="site_title" value="{{ $globalSettings['site_title'] ?? 'Inaquired' }}">
            <input type="hidden" name="meta_description" value="{{ $globalSettings['meta_description'] ?? 'Platform' }}">
            <input type="hidden" name="meta_keywords" value="{{ $globalSettings['meta_keywords'] ?? '' }}">
            <input type="hidden" name="meta_canonical" value="{{ $globalSettings['meta_canonical'] ?? '' }}">
            <input type="hidden" name="og_title" value="{{ $globalSettings['og_title'] ?? '' }}">
            <input type="hidden" name="og_description" value="{{ $globalSettings['og_description'] ?? '' }}">
            <input type="hidden" name="og_type" value="{{ $globalSettings['og_type'] ?? 'website' }}">
            <input type="hidden" name="og_locale" value="{{ $globalSettings['og_locale'] ?? 'en_US' }}">
            <input type="hidden" name="og_site_name" value="{{ $globalSettings['og_site_name'] ?? '' }}">
            <input type="hidden" name="og_url" value="{{ $globalSettings['og_url'] ?? '' }}">
            <input type="hidden" name="twitter_card" value="{{ $globalSettings['twitter_card'] ?? 'summary_large_image' }}">
            <input type="hidden" name="twitter_site" value="{{ $globalSettings['twitter_site'] ?? '' }}">
            <input type="hidden" name="twitter_title" value="{{ $globalSettings['twitter_title'] ?? '' }}">
            <input type="hidden" name="twitter_description" value="{{ $globalSettings['twitter_description'] ?? '' }}">
            <input type="hidden" name="twitter_creator" value="{{ $globalSettings['twitter_creator'] ?? '' }}">
            <input type="hidden" name="schema_json" value="{{ $globalSettings['schema_json'] ?? '' }}">
            @if(!empty($globalSettings['global_noindex'])) <input type="hidden" name="global_noindex" value="1"> @endif
            @if(!empty($globalSettings['global_nofollow'])) <input type="hidden" name="global_nofollow" value="1"> @endif

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="settings-2" class="w-4 h-4 text-indigo-600"></i>
                            Robots.txt Directives
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Control search engine bots, crawl limits, and disallowed internal endpoints.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="insertRobotsTemplate('standard')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            Standard Template
                        </button>
                        <button type="button" onclick="insertRobotsTemplate('allow_all')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            Allow All
                        </button>
                        <a href="{{ url('/robots.txt') }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            <span>Live File</span>
                            <i data-lucide="external-link" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <label for="robots_txt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Robots.txt Editor</label>
                    <textarea id="robots_txt" name="robots_txt" rows="10" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 font-mono text-sm leading-relaxed" style="background-color: #f8fafc !important; color: #0f172a !important; caret-color: #4f46e5 !important; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;" required>{{ old('robots_txt', $globalSettings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /cms/\n\nSitemap: " . url('/sitemap.xml')) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1">
                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                            Security Isolation
                        </span>
                        <p class="text-slate-500">Ensure <code>/cms/</code> is disallowed to protect administrative routes from indexation.</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1">
                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-600"></i>
                            Sitemap Auto-Discovery
                        </span>
                        <p class="text-slate-500">Always declare your <code>Sitemap: {{ url('/sitemap.xml') }}</code> in robots.txt.</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1">
                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-600"></i>
                            Instant Application
                        </span>
                        <p class="text-slate-500">Changes update <code>public/robots.txt</code> directly upon saving.</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm shadow-md active:scale-95 transition-all">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Save Technical Directives</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 4: SCHEMA (STRUCTURED DATA) -->
    <div id="tab-content-schema" class="seo-tab-content space-y-6 hidden">
        <form action="{{ route('cms.seo.global.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="current_tab" value="schema">

            <!-- Preserve fields from other tabs -->
            <input type="hidden" name="site_title" value="{{ $globalSettings['site_title'] ?? 'Inaquired' }}">
            <input type="hidden" name="meta_description" value="{{ $globalSettings['meta_description'] ?? 'Platform' }}">
            <input type="hidden" name="meta_keywords" value="{{ $globalSettings['meta_keywords'] ?? '' }}">
            <input type="hidden" name="meta_canonical" value="{{ $globalSettings['meta_canonical'] ?? '' }}">
            <input type="hidden" name="og_title" value="{{ $globalSettings['og_title'] ?? '' }}">
            <input type="hidden" name="og_description" value="{{ $globalSettings['og_description'] ?? '' }}">
            <input type="hidden" name="og_type" value="{{ $globalSettings['og_type'] ?? 'website' }}">
            <input type="hidden" name="og_locale" value="{{ $globalSettings['og_locale'] ?? 'en_US' }}">
            <input type="hidden" name="og_site_name" value="{{ $globalSettings['og_site_name'] ?? '' }}">
            <input type="hidden" name="og_url" value="{{ $globalSettings['og_url'] ?? '' }}">
            <input type="hidden" name="twitter_card" value="{{ $globalSettings['twitter_card'] ?? 'summary_large_image' }}">
            <input type="hidden" name="twitter_site" value="{{ $globalSettings['twitter_site'] ?? '' }}">
            <input type="hidden" name="twitter_title" value="{{ $globalSettings['twitter_title'] ?? '' }}">
            <input type="hidden" name="twitter_description" value="{{ $globalSettings['twitter_description'] ?? '' }}">
            <input type="hidden" name="twitter_creator" value="{{ $globalSettings['twitter_creator'] ?? '' }}">
            <input type="hidden" name="robots_txt" value="{{ $globalSettings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /cms/\n\nSitemap: " . url('/sitemap.xml') }}">
            @if(!empty($globalSettings['global_noindex'])) <input type="hidden" name="global_noindex" value="1"> @endif
            @if(!empty($globalSettings['global_nofollow'])) <input type="hidden" name="global_nofollow" value="1"> @endif

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="code-2" class="w-4 h-4 text-indigo-600"></i>
                            Global Schema JSON-LD Structured Data
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Insert valid JSON-LD schema (without &lt;script&gt; tags) to empower Google Rich Snippets & Knowledge Graph.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="insertSchemaTemplate('org')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            Organization Template
                        </button>
                        <button type="button" onclick="insertSchemaTemplate('website')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                            WebSite Search Template
                        </button>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="schema_json" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">JSON-LD Structure</label>
                        <span id="json_validity_badge" class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-slate-100 text-slate-600">Checking syntax...</span>
                    </div>
                    <textarea id="schema_json" name="schema_json" rows="12" oninput="validateJsonSyntax()" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 font-mono text-sm leading-relaxed" style="background-color: #f8fafc !important; color: #0f172a !important; caret-color: #4f46e5 !important; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;" placeholder='{
  "&#64;context": "https://schema.org",
  "&#64;type": "Organization",
  "name": "Inaquired",
  "url": "Website URL"
}'>{{ old('schema_json', $globalSettings['schema_json'] ?? '') }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="https://validator.schema.org/" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-1">
                        <span>Schema.org Validator Tool</span>
                        <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm shadow-md active:scale-95 transition-all">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Save Schema</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TAB 5: PAGE SEO -->
    <div id="tab-content-pages" class="seo-tab-content space-y-6 hidden">
        <!-- Action Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-indigo-600"></i>
                    Individual Page Meta Overrides
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Customize canonical tags, meta titles, descriptions, and noindex flags per individual URL.</p>
            </div>
            <a href="{{ route('cms.seo.pages.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-sm active:scale-95 transition-all">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Add Page SEO</span>
            </a>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <form method="GET" action="{{ route('cms.seo.index') }}#pages" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by slug, title, or keywords..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-slate-50/50 hover:bg-white transition-colors">
                </div>
                <button type="submit" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Filter</span>
                </button>
                @if(request()->has('search'))
                    <a href="{{ route('cms.seo.index') }}#pages" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-1.5">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        <span>Clear</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50/90 text-xs uppercase text-slate-500 font-semibold border-b border-slate-200 tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4">Page Details</th>
                            <th scope="col" class="px-6 py-4">Meta Lengths</th>
                            <th scope="col" class="px-6 py-4">Indexing</th>
                            <th scope="col" class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($pages as $page)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5 border border-indigo-100">
                                            <i data-lucide="{{ $page->page_type === 'job' ? 'briefcase' : ($page->page_type === 'company' ? 'building-2' : ($page->page_type === 'category' ? 'layers' : ($page->page_type === 'post' ? 'book-open' : 'file-text'))) }}" class="w-4 h-4"></i>
                                        </div>
                                        <div class="min-w-0 max-w-md">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <span class="font-semibold text-slate-900 truncate font-mono text-xs">{{ $page->slug }}</span>
                                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-md uppercase tracking-wider
                                                    @if($page->page_type === 'job') bg-blue-100 text-blue-800
                                                    @elseif($page->page_type === 'category') bg-emerald-100 text-emerald-800
                                                    @elseif($page->page_type === 'company') bg-purple-100 text-purple-800
                                                    @elseif($page->page_type === 'post') bg-amber-100 text-amber-800
                                                    @else bg-slate-100 text-slate-800 @endif">
                                                    {{ $page->page_type }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500 truncate">{{ $page->meta_title ?? 'No title defined' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1 text-xs text-slate-600">
                                        <span>Title: <strong class="{{ strlen($page->meta_title ?? '') > 60 ? 'text-rose-600' : 'text-slate-800' }}">{{ strlen($page->meta_title ?? '') }}</strong>/60</span>
                                        <span>Desc: <strong class="{{ strlen($page->meta_description ?? '') > 160 ? 'text-rose-600' : 'text-slate-800' }}">{{ strlen($page->meta_description ?? '') }}</strong>/160</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        @if($page->noindex)
                                            <span class="px-2 py-0.5 text-[11px] font-semibold bg-rose-100 text-rose-700 rounded-md border border-rose-200">NoIndex</span>
                                        @else
                                            <span class="px-2 py-0.5 text-[11px] font-semibold bg-emerald-100 text-emerald-700 rounded-md border border-emerald-200">Indexed</span>
                                        @endif
                                        @if($page->nofollow)
                                            <span class="px-2 py-0.5 text-[11px] font-semibold bg-amber-100 text-amber-700 rounded-md border border-amber-200">NoFollow</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ url($page->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="View Public Page">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('cms.seo.pages.edit', $page) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Page SEO">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('cms.seo.pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Delete SEO overrides for this page?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-2 border border-slate-200">
                                            <i data-lucide="file-question" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-800">No custom page SEO records found</p>
                                        <p class="text-xs text-slate-500 mt-1 mb-4">Pages without custom records use global SEO settings.</p>
                                        <a href="{{ route('cms.seo.pages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700 transition-colors">
                                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                            <span>Add Page SEO</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pages->hasPages())
                <div class="border-t border-slate-200 bg-slate-50/70 px-6 py-4">
                    {{ $pages->fragment('pages')->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- TAB 6: SEARCH ENGINE INDEXING -->
    <div id="tab-content-indexing" class="seo-tab-content space-y-6 hidden">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm shadow-xs">
                        <i data-lucide="map" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">XML Sitemap & Search Engine Indexing</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Automated XML sitemap generation for search engine crawlers (Google, Bing, Yahoo).</p>
                    </div>
                </div>

                <a href="{{ url('/sitemap.xml') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors shrink-0">
                    <span>Open Live Sitemap.xml</span>
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">
                <!-- Left: Sitemap URL & Regeneration -->
                <div class="space-y-5 bg-slate-50 border border-slate-200/80 rounded-xl p-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Primary XML Sitemap Index URL</label>
                        <div class="flex shadow-xs">
                            <input type="text" id="sitemap_url_input" value="{{ url('/sitemap.xml') }}" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-l-xl bg-white text-slate-800 text-xs font-mono select-all focus:outline-none" readonly>
                            <button type="button" onclick="copySitemapUrl()" class="px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border-y border-r border-indigo-200 rounded-r-xl text-xs font-semibold transition-colors flex items-center gap-1.5 shrink-0">
                                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                <span id="copy_btn_text">Copy URL</span>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1.5">Submit this URL once in Google Search Console and Bing Webmaster Tools.</p>
                    </div>

                    <form action="{{ route('cms.seo.sitemap.generate') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-emerald-500/20 active:scale-95 transition-all">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                            <span>Regenerate XML Sitemap Now</span>
                        </button>
                    </form>
                </div>

                <!-- Right: Sitemap Routes Summary & Search Engine Guidance -->
                <div class="space-y-4 bg-slate-50 border border-slate-200/80 rounded-xl p-5 text-xs text-slate-600">
                    <span class="font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-indigo-600"></i>
                        <span>Included Dynamic Endpoints</span>
                    </span>
                    <ul class="space-y-2 text-slate-600">
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                            <span><strong>Jobs & Internships</strong> - Active postings automatically included</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                            <span><strong>Company Profiles</strong> - Verified hiring organizations</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                            <span><strong>Categories & Disciplines</strong> - Browse directory URLs</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                            <span><strong>Published Blog Posts</strong> - Resource and guide articles</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Tab Switching Logic
    const availableTabs = ['basic', 'social', 'technical', 'schema', 'pages', 'indexing'];

    function switchSeoTab(tabId) {
        if (!availableTabs.includes(tabId)) tabId = 'basic';

        // Update URL hash
        window.location.hash = tabId;

        // Hide all tab contents
        document.querySelectorAll('.seo-tab-content').forEach(el => el.classList.add('hidden'));

        // Reset all tab button styles
        document.querySelectorAll('.seo-tab-btn').forEach(btn => {
            btn.className = 'seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-slate-500 hover:text-slate-700 border-transparent hover:border-slate-300 rounded-t-lg';
        });

        // Show selected tab content
        const targetContent = document.getElementById('tab-content-' + tabId);
        if (targetContent) targetContent.classList.remove('hidden');

        // Activate selected tab button
        const targetBtn = document.getElementById('tab-btn-' + tabId);
        if (targetBtn) {
            targetBtn.className = 'seo-tab-btn inline-flex items-center gap-2 px-4 py-3 text-sm font-semibold border-b-2 whitespace-nowrap transition-all text-indigo-600 border-indigo-600 bg-indigo-50/50 rounded-t-lg';
        }

        if (window.lucide) lucide.createIcons();
    }

    // Initialize Active Tab on Page Load from Hash
    document.addEventListener('DOMContentLoaded', () => {
        let initialTab = window.location.hash.replace('#', '');
        if (!availableTabs.includes(initialTab)) {
            initialTab = 'basic';
        }
        switchSeoTab(initialTab);
        updateBasicPreview();
        validateJsonSyntax();
    });

    // Real-time Basic Preview & Character Counters
    function updateBasicPreview() {
        const titleInput = document.getElementById('site_title');
        const descInput = document.getElementById('meta_description');
        const canonicalInput = document.getElementById('meta_canonical');

        const titleCount = document.getElementById('site_title_count');
        const descCount = document.getElementById('meta_desc_count');
        const serpTitle = document.getElementById('preview_serp_title');
        const serpDesc = document.getElementById('preview_serp_desc');
        const serpUrl = document.getElementById('preview_serp_url');

        if (titleInput && titleCount) {
            titleCount.innerText = titleInput.value.length;
            serpTitle.innerText = titleInput.value.trim() || 'Inaquired - Discover Verified Career Opportunities';
        }

        if (descInput && descCount) {
            descCount.innerText = descInput.value.length;
            serpDesc.innerText = descInput.value.trim() || 'Explore top jobs, curated career openings, industry hiring trends, and company insights.';
        }

        if (canonicalInput && serpUrl) {
            serpUrl.innerText = canonicalInput.value.trim() || window.location.origin;
        }
    }

    // Validate Schema JSON Syntax
    function validateJsonSyntax() {
        const textarea = document.getElementById('schema_json');
        const badge = document.getElementById('json_validity_badge');
        if (!textarea || !badge) return;

        const val = textarea.value.trim();
        if (!val) {
            badge.innerText = 'Empty (Optional)';
            badge.className = 'px-2 py-0.5 text-[11px] font-semibold rounded-full bg-slate-100 text-slate-500';
            return;
        }

        try {
            JSON.parse(val);
            badge.innerText = 'Valid JSON-LD';
            badge.className = 'px-2 py-0.5 text-[11px] font-semibold rounded-full bg-emerald-100 text-emerald-700';
        } catch (e) {
            badge.innerText = 'Invalid JSON Syntax';
            badge.className = 'px-2 py-0.5 text-[11px] font-semibold rounded-full bg-rose-100 text-rose-700';
        }
    }

    // Insert Robots.txt Templates
    function insertRobotsTemplate(type) {
        const textarea = document.getElementById('robots_txt');
        if (!textarea) return;

        const sitemapUrl = "{{ url('/sitemap.xml') }}";

        if (type === 'standard') {
            textarea.value = `User-agent: *\nAllow: /\nDisallow: /cms/\nDisallow: /api/\n\nSitemap: ${sitemapUrl}`;
        } else if (type === 'allow_all') {
            textarea.value = `User-agent: *\nAllow: /\n\nSitemap: ${sitemapUrl}`;
        }
    }

    // Insert Schema Templates
    function insertSchemaTemplate(type) {
        const textarea = document.getElementById('schema_json');
        if (!textarea) return;

        const siteUrl = "{{ url('/') }}";

        if (type === 'org') {
            const orgTemplate = {
                "\u0040context": "https://schema.org",
                "\u0040type": "Organization",
                "name": "Inaquired",
                "url": siteUrl,
                "logo": siteUrl + "/images/logo.png",
                "sameAs": [
                    "https://twitter.com/inaquired",
                    "https://linkedin.com/company/inaquired"
                ]
            };
            textarea.value = JSON.stringify(orgTemplate, null, 2);
        } else if (type === 'website') {
            const wsTemplate = {
                "\u0040context": "https://schema.org",
                "\u0040type": "WebSite",
                "name": "Inaquired",
                "url": siteUrl,
                "potentialAction": {
                    "\u0040type": "SearchAction",
                    "target": siteUrl + "/jobs?search={search_term_string}",
                    "query-input": "required name=search_term_string"
                }
            };
            textarea.value = JSON.stringify(wsTemplate, null, 2);
        }
        validateJsonSyntax();
    }

    // Copy Sitemap URL helper
    function copySitemapUrl() {
        const input = document.getElementById('sitemap_url_input');
        const btnText = document.getElementById('copy_btn_text');
        if (!input) return;

        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            if (btnText) {
                btnText.innerText = 'Copied!';
                setTimeout(() => { btnText.innerText = 'Copy'; }, 2000);
            }
        });
    }
</script>
@endsection
