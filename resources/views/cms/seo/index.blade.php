@extends('layouts.cms')

@section('title', 'SEO Management - CMS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">SEO Management</h1>
    </div>

    <!-- Inline SEO Stats Toggle -->
    <div class="mb-8">
        <button type="button" onclick="document.getElementById('seo-stats').classList.toggle('hidden')" class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-xl hover:bg-indigo-100 transition-colors text-sm font-semibold whitespace-nowrap">
            <i data-lucide="bar-chart-2" class="w-4 h-4 mr-2"></i>
            Toggle SEO Stats
        </button>
    </div>

    <!-- Inline SEO Stats -->
    <div id="seo-stats" class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-8 flex flex-wrap items-center gap-6 text-sm hidden">
        <div class="flex items-center text-blue-800">
            <i data-lucide="search" class="w-4 h-4 mr-2"></i>
            <span class="font-medium mr-1">SEO Score:</span> <strong>{{ $seoScore ?? 0 }}%</strong>
        </div>
        <div class="flex items-center text-blue-800">
            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
            <span class="font-medium mr-1">Optimized Pages:</span> <strong>{{ \App\Models\PageSeo::count() }}</strong>
        </div>
        <div class="flex items-center text-blue-800">
            <i data-lucide="activity" class="w-4 h-4 mr-2"></i>
            <span class="font-medium mr-1">Last Updated:</span> <strong>{{ now()->format('M d, Y') }}</strong>
        </div>
    </div>

    <!-- Global SEO Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 mb-8">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                <i data-lucide="globe" class="w-5 h-5 mr-2"></i>
                Global SEO Settings
            </h2>
        </div>
        
        <form action="{{ route('cms.seo.global.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')
            
            <!-- Basic SEO Section -->
            <div class="mb-10 border-b border-slate-100 pb-10">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-4">
                        <i data-lucide="search" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    Basic SEO
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Site Title</label>
                            <input type="text" name="site_title" value="{{ old('site_title', $globalSettings['site_title'] ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" required>{{ old('meta_description', $globalSettings['meta_description'] ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Keywords (optional)</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $globalSettings['meta_keywords'] ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Canonical URL</label>
                            <input type="url" name="meta_canonical" value="{{ old('meta_canonical', $globalSettings['meta_canonical'] ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" placeholder="https://example.com">
                        </div>
                        <div class="flex gap-6 pt-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <label class="flex items-center text-sm font-medium text-slate-700 cursor-pointer">
                                <input type="checkbox" name="global_noindex" value="1" {{ old('global_noindex', !empty($globalSettings['global_noindex']) ? '1' : '') ? 'checked' : '' }} class="mr-3 h-5 w-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500"> NoIndex
                            </label>
                            <label class="flex items-center text-sm font-medium text-slate-700 cursor-pointer">
                                <input type="checkbox" name="global_nofollow" value="1" {{ old('global_nofollow', !empty($globalSettings['global_nofollow']) ? '1' : '') ? 'checked' : '' }} class="mr-3 h-5 w-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500"> NoFollow
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social SEO Section -->
            <div class="mb-10 border-b border-slate-100 pb-10">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center mr-4">
                        <i data-lucide="share-2" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    Social SEO
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Open Graph -->
                    <div class="space-y-5 p-6 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm">
                        <h4 class="font-bold text-slate-800 mb-4 border-b border-slate-200 pb-3">Open Graph (Facebook, LinkedIn)</h4>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Title</label>
                            <input type="text" name="og_title" value="{{ old('og_title', $globalSettings['og_title'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Description</label>
                            <textarea name="og_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">{{ old('og_description', $globalSettings['og_description'] ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Type</label>
                                <input type="text" name="og_type" value="{{ old('og_type', $globalSettings['og_type'] ?? 'website') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Locale</label>
                                <input type="text" name="og_locale" value="{{ old('og_locale', $globalSettings['og_locale'] ?? 'en_US') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Site Name</label>
                                <input type="text" name="og_site_name" value="{{ old('og_site_name', $globalSettings['og_site_name'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG URL</label>
                                <input type="url" name="og_url" value="{{ old('og_url', $globalSettings['og_url'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Image</label>
                            <input type="file" name="og_default_image" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                            @if(!empty($globalSettings['og_default_image']))
                                <div class="mt-3 p-3 bg-white border border-slate-100 rounded-xl text-xs flex items-center justify-between">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($globalSettings['og_default_image']) }}" class="h-10 rounded shadow-sm">
                                    <label class="text-red-500 font-bold cursor-pointer hover:text-red-600 flex items-center">
                                        <input type="checkbox" name="remove_og_image" value="1" class="mr-2"> Remove File
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Twitter -->
                    <div class="space-y-5 p-6 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm">
                        <h4 class="font-bold text-slate-800 mb-4 border-b border-slate-200 pb-3">Twitter Card</h4>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Title</label>
                            <input type="text" name="twitter_title" value="{{ old('twitter_title', $globalSettings['twitter_title'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Description</label>
                            <textarea name="twitter_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors">{{ old('twitter_description', $globalSettings['twitter_description'] ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Card Type</label>
                                <select name="twitter_card" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors">
                                    <option value="summary_large_image" {{ old('twitter_card', $globalSettings['twitter_card'] ?? '') == 'summary_large_image' ? 'selected' : '' }}>summary_large_image</option>
                                    <option value="summary" {{ old('twitter_card', $globalSettings['twitter_card'] ?? '') == 'summary' ? 'selected' : '' }}>summary</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Site (@@handle)</label>
                                <input type="text" name="twitter_site" value="{{ old('twitter_site', $globalSettings['twitter_site'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Creator (@@handle)</label>
                            <input type="text" name="twitter_creator" value="{{ old('twitter_creator', $globalSettings['twitter_creator'] ?? '') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical SEO Section -->
            <div class="mb-10 border-b border-slate-100 pb-10">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mr-4">
                        <i data-lucide="settings" class="w-5 h-5 text-slate-600"></i>
                    </div>
                    Technical SEO
                </h3>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Robots.txt Content</label>
                    <textarea name="robots_txt" style="font-family: monospace" rows="6" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-500/20 focus:border-slate-500 bg-slate-50 transition-colors hover:bg-white text-sm" required>{{ old('robots_txt', $globalSettings['robots_txt'] ?? '') }}</textarea>
                </div>
            </div>

            <!-- Structured Data Section -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mr-4">
                        <i data-lucide="code" class="w-5 h-5 text-green-600"></i>
                    </div>
                    Structured Data
                </h3>
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 shadow-inner">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Schema JSON (Global)</label>
                    <p class="text-xs text-slate-500 mb-4">Insert your organization or global structural valid JSON-LD without the script tags.</p>
                    <textarea name="schema_json" style="font-family: monospace" rows="8" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 bg-white text-sm shadow-sm" placeholder='{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "url": "https://example.com"
}'>{{ old('schema_json', $globalSettings['schema_json'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-10 pt-8 border-t border-slate-200">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 flex items-center justify-center font-semibold text-base transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95 whitespace-nowrap">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    Save Global Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                <i data-lucide="file-text" class="w-5 h-5 mr-2 text-blue-600"></i>
                Page SEO
            </h3>
            <p class="text-slate-600 mb-4">Manage SEO settings for individual pages and dynamic content.</p>
            <a href="{{ route('cms.seo.pages') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors whitespace-nowrap">
                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>
                Manage Pages
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                <i data-lucide="search" class="w-5 h-5 mr-2 text-purple-600"></i>
                Search Engine Indexing
            </h3>
            <p class="text-slate-600 mb-4">Upload verification files for Search Engine mass indexing, and manage sitemaps.</p>
            <a href="{{ route('cms.seo.indexing') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition-colors whitespace-nowrap">
                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>
                Manage Indexing
            </a>
        </div>
    </div>
</div>
@endsection