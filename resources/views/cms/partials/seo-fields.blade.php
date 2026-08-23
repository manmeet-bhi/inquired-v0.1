<!-- SEO Settings Section -->
<div class="bg-white rounded-lg shadow-sm border border-slate-200 mt-8">
    <div class="px-6 py-4 border-b border-slate-200">
        <h3 class="text-lg font-semibold text-slate-900 flex items-center">
            <i data-lucide="search" class="w-5 h-5 mr-2"></i>
            SEO Settings
        </h3>
        <p class="text-sm text-slate-600 mt-1">Optimize this job for search engines</p>
    </div>
    
    <div class="p-6 space-y-6">
        <!-- URL Slug -->
        <div>
            <label for="slug" class="block text-sm font-medium text-slate-700 mb-2">URL Slug</label>
            <div class="flex">
                <span class="inline-flex items-center px-3 py-2 border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm rounded-l-lg">
                    {{ url('/jobs') }}/{{ $job->id ?? 'ID' }}/
                </span>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $job->slug ?? '') }}"
                       class="flex-1 px-3 py-2 border border-slate-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       placeholder="job-title-slug">
            </div>
            <p class="text-xs text-slate-500 mt-1">Leave empty to auto-generate from job title</p>
        </div>

        <!-- SEO Title -->
        <div>
            <label for="seo_title" class="block text-sm font-medium text-slate-700 mb-2">SEO Title</label>
            <input type="text" id="seo_title" name="seo_title" value="{{ old('seo_title', $job->seo_title ?? '') }}"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                   maxlength="60" placeholder="Leave empty to use job title">
            <div class="flex justify-between text-xs text-slate-500 mt-1">
                <span>Recommended: 30-60 characters</span>
                <span id="seoTitleCount">{{ strlen(old('seo_title', $job->seo_title ?? '')) }}/60</span>
            </div>
        </div>

        <!-- SEO Description -->
        <div>
            <label for="seo_description" class="block text-sm font-medium text-slate-700 mb-2">SEO Description</label>
            <textarea id="seo_description" name="seo_description" rows="3" 
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                      maxlength="160" placeholder="Leave empty to use job overview">{{ old('seo_description', $job->seo_description ?? '') }}</textarea>
            <div class="flex justify-between text-xs text-slate-500 mt-1">
                <span>Recommended: 120-160 characters</span>
                <span id="seoDescCount">{{ strlen(old('seo_description', $job->seo_description ?? '')) }}/160</span>
            </div>
        </div>

        <!-- SEO Keywords -->
        <div>
            <label for="seo_keywords" class="block text-sm font-medium text-slate-700 mb-2">SEO Keywords</label>
            <input type="text" id="seo_keywords" name="seo_keywords" value="{{ old('seo_keywords', $job->seo_keywords ?? '') }}"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                   placeholder="keyword1, keyword2, keyword3">
            <p class="text-xs text-slate-500 mt-1">Separate keywords with commas (max 10 recommended)</p>
        </div>

        <!-- Open Graph Settings -->
        <div class="border-t border-slate-200 pt-6">
            <h4 class="text-md font-semibold text-slate-900 mb-4">Open Graph Settings</h4>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="og_title" class="block text-sm font-medium text-slate-700 mb-2">OG Title</label>
                    <input type="text" id="og_title" name="og_title" value="{{ old('og_title', $job->og_title ?? '') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           maxlength="60" placeholder="Leave empty to use SEO title">
                </div>
                
                <div>
                    <label for="og_description" class="block text-sm font-medium text-slate-700 mb-2">OG Description</label>
                    <textarea id="og_description" name="og_description" rows="2" 
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                              maxlength="160" placeholder="Leave empty to use SEO description">{{ old('og_description', $job->og_description ?? '') }}</textarea>
                </div>
            </div>
            
            <div class="mt-4">
                <label for="og_image" class="block text-sm font-medium text-slate-700 mb-2">OG Image</label>
                <input type="file" id="og_image" name="og_image" accept=".jpg,.jpeg,.png" 
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @if(isset($job) && $job->og_image)
                    <div class="mt-2">
                        <img src="{{ media_url($job->og_image) }}" alt="Current OG Image" class="w-32 h-16 object-cover rounded">
                        <p class="text-xs text-slate-500 mt-1">Current image (upload new to replace)</p>
                    </div>
                @endif
                <p class="text-xs text-slate-500 mt-1">Recommended: 1200x630px, JPG/PNG format</p>
            </div>
        </div>

        <!-- Advanced SEO Settings -->
        <div class="border-t border-slate-200 pt-6">
            <h4 class="text-md font-semibold text-slate-900 mb-4">Advanced Settings</h4>
            
            <div class="space-y-4">
                <div>
                    <label for="canonical_url" class="block text-sm font-medium text-slate-700 mb-2">Canonical URL</label>
                    <input type="url" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $job->canonical_url ?? '') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Leave empty to use default job URL">
                </div>
                
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="seo_noindex" name="seo_noindex" value="1" 
                               {{ old('seo_noindex', $job->seo_noindex ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="seo_noindex" class="ml-2 block text-sm text-slate-700">
                            NoIndex (Hide from search engines)
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="seo_nofollow" name="seo_nofollow" value="1" 
                               {{ old('seo_nofollow', $job->seo_nofollow ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="seo_nofollow" class="ml-2 block text-sm text-slate-700">
                            NoFollow (Prevent link following)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Preview -->
        <div class="border-t border-slate-200 pt-6">
            <h4 class="text-md font-semibold text-slate-900 mb-4">SEO Preview</h4>
            <div class="bg-slate-50 rounded-lg p-4">
                <div class="text-blue-600 text-lg font-medium" id="seoPreviewTitle">{{ $job->title ?? 'Job Title' }} - Company Name</div>
                <div class="text-green-600 text-sm" id="seoPreviewUrl">{{ url('/jobs') }}/{{ $job->id ?? 'ID' }}/job-title-slug</div>
                <div class="text-slate-600 text-sm mt-1" id="seoPreviewDescription">{{ Str::limit($job->overview ?? 'Job description will appear here', 160) }}</div>
            </div>
        </div>

        <!-- SEO Audit Button -->
        <div class="border-t border-slate-200 pt-6">
            <button type="button" onclick="runJobSeoAudit()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                <i data-lucide="search" class="w-4 h-4 inline mr-2"></i>
                Run SEO Audit
            </button>
            <div id="seoAuditResults" class="mt-4 hidden"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const seoTitleInput = document.getElementById('seo_title');
    const seoDescInput = document.getElementById('seo_description');
    const overviewInput = document.getElementById('overview') || document.getElementById('content');
    
    // Character counters
    if (seoTitleInput) {
        seoTitleInput.addEventListener('input', function() {
            const countEl = document.getElementById('seoTitleCount');
            if (countEl) countEl.textContent = this.value.length + '/60';
            updateSeoPreview();
        });
    }
    
    if (seoDescInput) {
        seoDescInput.addEventListener('input', function() {
            const countEl = document.getElementById('seoDescCount');
            if (countEl) countEl.textContent = this.value.length + '/160';
            updateSeoPreview();
        });
    }
    
    // Auto-generate slug from title
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            if (!slugInput.value) {
                const slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                slugInput.value = slug;
                updateSeoPreview();
            }
        });
    }
    
    if (slugInput) {
        slugInput.addEventListener('input', updateSeoPreview);
    }
    
    function updateSeoPreview() {
        const title = (seoTitleInput && seoTitleInput.value) || (titleInput ? titleInput.value : 'Job Title');
        const description = (seoDescInput && seoDescInput.value) || (overviewInput ? overviewInput.value.replace(/<[^>]*>?/gm, '').substring(0, 160) : 'Job description');
        const slug = (slugInput && slugInput.value) || 'job-title-slug';
        const jobId = '{{ $job->id ?? "ID" }}';
        
        const previewTitle = document.getElementById('seoPreviewTitle');
        const previewUrl = document.getElementById('seoPreviewUrl');
        const previewDescription = document.getElementById('seoPreviewDescription');

        if (previewTitle) previewTitle.textContent = title + ' - Company Name';
        if (previewUrl) previewUrl.textContent = '{{ url("/jobs") }}/' + jobId + '/' + slug;
        if (previewDescription) previewDescription.textContent = description;
    }
});

function runJobSeoAudit() {
    const title = (document.getElementById('seo_title')?.value) || (document.getElementById('title')?.value) || '';
    const contentEl = document.getElementById('overview') || document.getElementById('content');
    const description = (document.getElementById('seo_description')?.value) || (contentEl ? contentEl.value.replace(/<[^>]*>?/gm, '').substring(0, 160) : '');
    const keywords = document.getElementById('seo_keywords')?.value || '';
    
    fetch('{{ route('cms.seo.audit') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            type: 'job',
            id: '{{ $job->id ?? null }}',
            title: title,
            description: description,
            keywords: keywords
        })
    })
    .then(response => response.json())
    .then(data => {
        const resultsDiv = document.getElementById('seoAuditResults');
        resultsDiv.classList.remove('hidden');
        
        let html = `<div class="bg-white border border-slate-200 rounded-lg p-4">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold ${data.score >= 80 ? 'bg-green-100 text-green-600' : data.score >= 60 ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600'}">
                    ${data.score}
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-semibold">SEO Score: ${data.score}/100</h4>
                </div>
            </div>`;
        
        if (data.issues.length > 0) {
            html += `<div class="mb-4">
                <h5 class="font-medium text-red-600 mb-2">Issues Found:</h5>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">`;
            data.issues.forEach(issue => {
                html += `<li>${issue}</li>`;
            });
            html += `</ul></div>`;
        }
        
        if (data.suggestions.length > 0) {
            html += `<div>
                <h5 class="font-medium text-blue-600 mb-2">Suggestions:</h5>
                <ul class="list-disc list-inside text-sm text-blue-600 space-y-1">`;
            data.suggestions.forEach(suggestion => {
                html += `<li>${suggestion}</li>`;
            });
            html += `</ul></div>`;
        }
        
        html += `</div>`;
        resultsDiv.innerHTML = html;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to run SEO audit. Please try again.');
    });
}
</script>