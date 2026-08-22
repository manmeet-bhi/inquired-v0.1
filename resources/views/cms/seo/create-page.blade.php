@extends('layouts.cms')

@section('title', 'Create Page SEO - CMS')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Create Page SEO</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <form action="{{ route('cms.seo.pages.store') }}" method="POST" enctype="multipart/form-data" id="seoForm">
            @csrf
            
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-xl font-semibold text-slate-900">Page Information</h2>
            </div>
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="page_type" class="block text-sm font-semibold text-slate-700 mb-2">Page Type</label>
                        <select id="page_type" name="page_type" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" required>
                            <option value="">Select page type</option>
                            <option value="static" {{ old('page_type') === 'static' ? 'selected' : '' }}>Static Page</option>
                            <option value="post" {{ old('page_type') === 'post' ? 'selected' : '' }}>Blog Post</option>
                            <option value="job" {{ old('page_type') === 'job' ? 'selected' : '' }}>Job Page</option>
                            <option value="category" {{ old('page_type') === 'category' ? 'selected' : '' }}>Category Page</option>
                            <option value="company" {{ old('page_type') === 'company' ? 'selected' : '' }}>Company Page</option>
                        </select>
                    </div>

                    <div id="entity-selector-wrapper" class="hidden">
                        <label for="page_id" class="block text-sm font-semibold text-slate-700 mb-2">Related Record</label>
                        <select id="page_id" name="page_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm">
                            <option value="">Select a page type first</option>
                        </select>
                    </div>
                </div>

                <!-- URL Slug -->
                <div>
                    <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">URL Slug</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 py-2 border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm rounded-l-lg">
                            {{ url('/') }}/
                        </span>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                               class="flex-1 px-3 py-2 border border-slate-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                               placeholder="page-url-slug" required>
                    </div>
                    <p class="text-xs text-slate-500 mt-1" id="slug-help">Enter a unique slug for static pages or select a record above.</p>
                </div>

                <div>
                    <label for="meta_title" class="block text-sm font-semibold text-slate-700 mb-2">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm"
                           maxlength="255" required>
                    <div class="flex justify-between text-xs text-slate-500 mt-1">
                        <span>Recommended: 30-60 characters</span>
                        <span id="titleCount">0/60</span>
                    </div>
                </div>
                
                <div>
                    <label for="meta_description" class="block text-sm font-semibold text-slate-700 mb-2">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                              class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm"
                              maxlength="255" required>{{ old('meta_description') }}</textarea>
                    <div class="flex justify-between text-xs text-slate-500 mt-1">
                        <span>Recommended: 120-160 characters</span>
                        <span id="descCount">0/160</span>
                    </div>
                </div>

                <div>
                    <label for="meta_keywords" class="block text-sm font-semibold text-slate-700 mb-2">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm" 
                           placeholder="keyword1, keyword2, keyword3">
                </div>
                
                <div>
                    <label for="canonical_url" class="block text-sm font-semibold text-slate-700 mb-2">Canonical URL</label>
                    <input type="url" id="canonical_url" name="canonical_url" value="{{ old('canonical_url') }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm"
                           placeholder="https://example.com/canonical-url">
                </div>
            </div>

            <!-- Social SEO Section -->
            <div class="mb-10 border-b border-slate-100 pb-10 px-6">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="share-2" class="w-5 h-5 mr-2 text-indigo-600"></i> Social SEO
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Open Graph -->
                    <div class="space-y-5 p-6 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm">
                        <h4 class="font-bold text-slate-800 mb-3 border-b border-slate-200 pb-2">Open Graph (Facebook, LinkedIn)</h4>
                        <div>
                            <label for="og_title" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Title</label>
                            <input type="text" id="og_title" name="og_title" value="{{ old('og_title') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leave empty to use meta title">
                        </div>
                        <div>
                            <label for="og_description" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Description</label>
                            <textarea id="og_description" name="og_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leave empty to use meta description">{{ old('og_description') }}</textarea>
                        </div>
                        <div>
                            <label for="og_image" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">OG Image</label>
                            <input type="file" id="og_image" name="og_image" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                        </div>
                    </div>
                    
                    <!-- Twitter -->
                    <div class="space-y-5 p-6 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm">
                        <h4 class="font-bold text-slate-800 mb-3 border-b border-slate-200 pb-2">Twitter Card</h4>
                        <div>
                            <label for="twitter_title" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Title</label>
                            <input type="text" id="twitter_title" name="twitter_title" value="{{ old('twitter_title') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leave empty to use OG or Meta title">
                        </div>
                        <div>
                            <label for="twitter_description" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Description</label>
                            <textarea id="twitter_description" name="twitter_description" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors" maxlength="255" placeholder="Leave empty to use OG or Meta description">{{ old('twitter_description') }}</textarea>
                        </div>
                        <div>
                            <label for="twitter_image" class="block text-xs font-semibold text-slate-600 mb-2 tracking-wide uppercase">Twitter Image</label>
                            <input type="file" id="twitter_image" name="twitter_image" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Structured Data Section -->
            <div class="mb-10 border-b border-slate-100 pb-10 px-6">
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
}'>{{ old('schema_json') }}</textarea>
                </div>
            </div>

            <!-- Advanced Settings -->
            <div class="mb-10 border-b border-slate-100 pb-10 px-6">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Advanced Settings</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="noindex" name="noindex" value="1" 
                               {{ old('noindex') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="noindex" class="ml-2 block text-sm text-slate-700">
                            NoIndex (Prevent search engines from indexing this page)
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="nofollow" name="nofollow" value="1" 
                               {{ old('nofollow') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="nofollow" class="ml-2 block text-sm text-slate-700">
                            NoFollow (Prevent search engines from following links on this page)
                        </label>
                    </div>
                </div>
            </div>

            <!-- SEO Live Preview -->
            <div class="mb-10 border-b border-slate-100 pb-10 px-6">
                <h3 class="text-xl font-bold text-slate-800 mb-6">SEO Search Preview</h3>
                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                    <div class="text-blue-600 text-lg font-medium" id="previewTitle">Page Meta Title</div>
                    <div class="text-green-600 text-sm" id="previewUrl">{{ url('/') }}/page-slug</div>
                    <div class="text-slate-600 text-sm mt-1" id="previewDescription">Page description preview will appear here.</div>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-slate-200 flex justify-between items-center bg-slate-50/30 rounded-b-lg">
                <a href="{{ route('cms.seo.pages') }}" class="inline-flex items-center px-5 py-2.5 font-semibold text-sm text-slate-700 hover:text-slate-900 bg-white border border-slate-200 hover:border-slate-300 rounded-xl transition-all shadow-sm whitespace-nowrap">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Pages
                </a>
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 flex items-center justify-center font-semibold text-base transition-all shadow-lg hover:shadow-blue-500/20 active:scale-95 whitespace-nowrap">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    Create Page SEO
                </button>
            </div>
        </form>
    </div>
</div>

@php
    $staticPages = \App\Models\PageSeo::getStaticPageSlugs();
    $pageTypeOptions = [
        'job' => $jobs->map(fn ($job) => ['id' => $job->id, 'label' => $job->title, 'slug' => "jobs/{$job->id}/" . ($job->slug ?: \Illuminate\Support\Str::slug($job->title))])->values(),
        'post' => $posts->map(fn ($post) => ['id' => $post->id, 'label' => $post->title, 'slug' => "blog/{$post->id}"])->values(),
        'category' => $categories->map(fn ($category) => ['id' => $category->id, 'label' => $category->name, 'slug' => "category/" . $category->slug])->values(),
        'company' => $companies->map(fn ($company) => ['id' => $company->id, 'label' => $company->name, 'slug' => "company/" . $company->slug])->values(),
    ];
@endphp

<script>
document.addEventListener('DOMContentLoaded', function () {
    const baseUrl = '{{ url('/') }}';
    const pageType = document.getElementById('page_type');
    const pageId = document.getElementById('page_id');
    const slug = document.getElementById('slug');
    const entitySelectorWrapper = document.getElementById('entity-selector-wrapper');
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');
    const titleCount = document.getElementById('titleCount');
    const descCount = document.getElementById('descCount');
    const previewTitle = document.getElementById('previewTitle');
    const previewUrl = document.getElementById('previewUrl');
    const previewDescription = document.getElementById('previewDescription');
    const staticPages = @json($staticPages);
    const pageTypeOptions = @json($pageTypeOptions);

    function setSelectOptions(items) {
        pageId.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Select related record';
        pageId.appendChild(placeholder);

        items.forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.label;
            option.dataset.slug = item.slug || '';
            pageId.appendChild(option);
        });
    }

    function syncTypeUi() {
        const type = pageType.value;
        const isStatic = type === 'static' || type === '';

        entitySelectorWrapper.classList.toggle('hidden', isStatic);
        pageId.required = !isStatic;

        if (type && !isStatic) {
            setSelectOptions(pageTypeOptions[type] || []);
            slug.placeholder = 'Slug auto-fills from the selected record';
            if (!pageId.value) {
                slug.value = '';
            }
        } else {
            pageId.innerHTML = '<option value="">Select a page type first</option>';
            pageId.required = false;
            pageId.value = '';
            slug.placeholder = 'e.g. about, terms, privacy';
        }
        updatePreview();
    }

    function updatePreview() {
        if (previewTitle && metaTitle) previewTitle.textContent = metaTitle.value || 'Page Meta Title';
        if (previewDescription && metaDescription) previewDescription.textContent = metaDescription.value || 'Page description preview will appear here.';
        if (previewUrl && slug) previewUrl.textContent = baseUrl + '/' + (slug.value || 'page-slug');
        if (titleCount && metaTitle) titleCount.textContent = metaTitle.value.length + '/60';
        if (descCount && metaDescription) descCount.textContent = metaDescription.value.length + '/160';
    }

    pageType.addEventListener('change', syncTypeUi);
    pageId.addEventListener('change', function () {
        const selected = pageId.options[pageId.selectedIndex];
        if (selected && selected.dataset.slug) {
            slug.value = selected.dataset.slug;
        }
        updatePreview();
    });

    if (metaTitle) metaTitle.addEventListener('input', updatePreview);
    if (metaDescription) metaDescription.addEventListener('input', updatePreview);
    if (slug) slug.addEventListener('input', updatePreview);

    syncTypeUi();
    updatePreview();
});
</script>
@endsection
