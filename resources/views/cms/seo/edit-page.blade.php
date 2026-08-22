@extends('layouts.cms')

@section('title', 'Edit Page SEO - CMS')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Edit Page SEO</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <form action="{{ route('cms.seo.pages.update', $pageSeo) }}" method="POST" enctype="multipart/form-data" id="seoForm">
            @csrf
            @method('PUT')
            
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-xl font-semibold text-slate-900">Page Information</h2>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Page Type Display (Read-only) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Page Type</label>
                        <div class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-slate-600">
                            {{ ucfirst($pageSeo->page_type) }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            @if($pageSeo->page_type === 'job')
                                Job
                            @elseif($pageSeo->page_type === 'post') 
                                Blog Post
                            @elseif($pageSeo->page_type === 'category') 
                                Category
                            @elseif($pageSeo->page_type === 'company') 
                                Company
                            @else 
                                Page Identifier
                            @endif
                        </label>
                        <div class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-slate-600">
                            @if($pageSeo->page_type === 'job' && $pageSeo->job)
                                {{ $pageSeo->job->title }}
                            @elseif($pageSeo->page_type === 'post' && $pageSeo->post)
                                {{ $pageSeo->post->title }}
                            @elseif($pageSeo->page_type === 'category' && $pageSeo->category)
                                {{ $pageSeo->category->name }}
                            @elseif($pageSeo->page_type === 'company' && $pageSeo->company)
                                {{ $pageSeo->company->name }}
                            @elseif($pageSeo->page_type === 'static')
                                @php
                                    $staticPages = \App\Models\PageSeo::getStaticPageSlugs();
                                @endphp
                                {{ $staticPages[$pageSeo->slug] ?? $pageSeo->slug }}
                            @else
                                {{ $pageSeo->page_id ?: 'Static Page' }}
                            @endif
                        </div>
                    </div>
                </div>

                <!-- URL Slug -->
                <div>
                    <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">URL Slug</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 py-2 border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm rounded-l-lg">
                            {{ url('/') }}/
                        </span>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $pageSeo->slug) }}"
                               class="flex-1 px-3 py-2 border border-slate-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               required>
                    </div>
                </div>

                <!-- SEO Meta Information -->
                <div class="mb-10 border-b border-slate-100 pb-10">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">SEO Meta Information</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="meta_title" class="block text-sm font-semibold text-slate-700 mb-2">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $pageSeo->meta_title) }}"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" 
                                   maxlength="255" required>
                            <div class="flex justify-between text-xs text-slate-500 mt-1">
                                <span>Recommended: 30-60 characters</span>
                                <span id="titleCount">{{ \Illuminate\Support\Str::length($pageSeo->meta_title) }}/60</span>
                            </div>
                        </div>
                        
                        <div>
                            <label for="meta_description" class="block text-sm font-semibold text-slate-700 mb-2">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" 
                                      class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" 
                                      maxlength="255" required>{{ old('meta_description', $pageSeo->meta_description) }}</textarea>
                            <div class="flex justify-between text-xs text-slate-500 mt-1">
                                <span>Recommended: 120-160 characters</span>
                                <span id="descCount">{{ \Illuminate\Support\Str::length($pageSeo->meta_description) }}/160</span>
                            </div>
                        </div>
                        
                        <div>
                            <label for="meta_keywords" class="block text-sm font-semibold text-slate-700 mb-2">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $pageSeo->meta_keywords) }}"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" 
                                   placeholder="keyword1, keyword2, keyword3">
                        </div>
                        
                        <div>
                            <label for="canonical_url" class="block text-sm font-semibold text-slate-700 mb-2">Canonical URL</label>
                            <input type="url" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $pageSeo->canonical_url) }}"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm">
                        </div>
                    </div>
                </div>

                <!-- Social SEO Section -->
                <div class="mb-10 border-b border-slate-100 pb-10">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <i data-lucide="share-2" class="w-5 h-5 mr-2 text-indigo-600"></i> Social SEO
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Open Graph -->
                        <div class="space-y-5 p-6 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm">
                            <h4 class="font-bold text-slate-800 mb-3 border-b border-slate-200 pb-2">Open Graph (Facebook, LinkedIn)</h4>
                            <div>
                                <label for="og_title" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Title</label>
                                <input type="text" id="og_title" name="og_title" value="{{ old('og_title', $pageSeo->og_title) }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leaves empty to use meta title">
                            </div>
                            <div>
                                <label for="og_description" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Description</label>
                                <textarea id="og_description" name="og_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leaves empty to use meta description">{{ old('og_description', $pageSeo->og_description) }}</textarea>
                            </div>
                            <div>
                                <label for="og_image" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Image</label>
                                <input type="file" id="og_image" name="og_image" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                                @if($pageSeo->og_image)
                                    <div class="mt-2 text-xs flex flex-col gap-1">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($pageSeo->og_image) }}" alt="Current OG Image" class="w-24 h-12 object-cover rounded border border-slate-300">
                                        <span class="text-slate-500">Current image</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Twitter -->
                        <div class="space-y-5 p-6 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm">
                            <h4 class="font-bold text-slate-800 mb-3 border-b border-slate-200 pb-2">Twitter Card</h4>
                            <div>
                                <label for="twitter_title" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Title</label>
                                <input type="text" id="twitter_title" name="twitter_title" value="{{ old('twitter_title', $pageSeo->twitter_title) }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leaves empty to use OG or Meta title">
                            </div>
                            <div>
                                <label for="twitter_description" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Description</label>
                                <textarea id="twitter_description" name="twitter_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leaves empty to use OG or Meta description">{{ old('twitter_description', $pageSeo->twitter_description) }}</textarea>
                            </div>
                            <div>
                                <label for="twitter_image" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Image</label>
                                <input type="file" id="twitter_image" name="twitter_image" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                                @if($pageSeo->twitter_image)
                                    <div class="mt-2 text-xs flex flex-col gap-1">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($pageSeo->twitter_image) }}" alt="Current Twitter Image" class="w-24 h-12 object-cover rounded border border-slate-300">
                                        <span class="text-slate-500">Current image</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Structured Data Section -->
                <div class="mb-10 border-b border-slate-100 pb-10">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <i data-lucide="code" class="w-5 h-5 mr-2 text-green-600"></i> Structured Data
                    </h3>
                    <div>
                        <label for="schema_json" class="block text-sm font-semibold text-slate-700 mb-2">Schema JSON (Page Specific)</label>
                        <p class="text-xs text-slate-500 mb-2">Insert specific structural valid JSON-LD without the script tags. This overrides the global schema.</p>
                        <textarea id="schema_json" name="schema_json" style="font-family: monospace" rows="6" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder='{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "headline": "Example Title"
}'>{{ old('schema_json', $pageSeo->schema_json) }}</textarea>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="mb-10 border-b border-slate-100 pb-10">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Advanced Settings</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="noindex" name="noindex" value="1" 
                                   {{ old('noindex', $pageSeo->noindex) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                            <label for="noindex" class="ml-2 block text-sm text-slate-700">
                                NoIndex (Prevent search engines from indexing this page)
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="nofollow" name="nofollow" value="1" 
                                   {{ old('nofollow', $pageSeo->nofollow) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                            <label for="nofollow" class="ml-2 block text-sm text-slate-700">
                                NoFollow (Prevent search engines from following links on this page)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- SEO Preview -->
                <div class="mb-10 border-b border-slate-100 pb-10">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">SEO Preview</h3>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <div class="text-blue-600 text-lg font-medium" id="previewTitle">{{ $pageSeo->meta_title }}</div>
                        <div class="text-green-600 text-sm" id="previewUrl">{{ url('/') }}/{{ $pageSeo->slug }}</div>
                        <div class="text-slate-600 text-sm mt-1" id="previewDescription">{{ $pageSeo->meta_description }}</div>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-slate-200 flex justify-between items-center bg-slate-50/30 rounded-b-lg">
                <a href="{{ route('cms.seo.pages') }}" class="inline-flex items-center px-5 py-2.5 font-semibold text-sm text-slate-700 hover:text-slate-900 bg-white border border-slate-200 hover:border-slate-300 rounded-xl transition-all shadow-sm whitespace-nowrap">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Pages
                </a>
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 flex items-center justify-center font-semibold text-base transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95 whitespace-nowrap">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    Update Page SEO
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = '{{ url('/') }}';
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');
    const slug = document.getElementById('slug');
    const titleCount = document.getElementById('titleCount');
    const descCount = document.getElementById('descCount');
    const previewTitle = document.getElementById('previewTitle');
    const previewUrl = document.getElementById('previewUrl');
    const previewDescription = document.getElementById('previewDescription');

    if (metaTitle) {
        metaTitle.addEventListener('input', function() {
            if (titleCount) titleCount.textContent = this.value.length + '/60';
            if (previewTitle) previewTitle.textContent = this.value;
        });
    }

    if (metaDescription) {
        metaDescription.addEventListener('input', function() {
            if (descCount) descCount.textContent = this.value.length + '/160';
            if (previewDescription) previewDescription.textContent = this.value;
        });
    }

    if (slug) {
        slug.addEventListener('input', function() {
            if (previewUrl) previewUrl.textContent = baseUrl + '/' + this.value;
        });
    }
});
</script>
@endsection
