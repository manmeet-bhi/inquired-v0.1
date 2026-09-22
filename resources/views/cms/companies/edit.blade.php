@extends('layouts.cms')

@section('title', 'Edit Company - CMS')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('cms.companies') }}" class="text-slate-600 hover:text-slate-900 mr-4">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Company</h1>
        </div>
    </div>

    <div class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
        <form action="{{ route('cms.companies.update', $company) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 cms-form-group">
                    <label for="name" class="cms-label">Company Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}" required class="cms-input @error('name') border-red-500 @enderror" placeholder="e.g. Acme Corp">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Short Subtitle / Description Snippet -->
                <div class="md:col-span-2 cms-form-group">
                    <label for="tagline" class="cms-label">Short Subtitle / Description Snippet</label>
                    <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $company->tagline) }}" class="cms-input @error('tagline') border-red-500 @enderror" placeholder="e.g. Pioneering next-generation AI solutions for global enterprises">
                    <p class="mt-1 text-xs text-slate-500">A concise highlight or summary displayed prominently on company cards.</p>
                    @error('tagline')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Industry -->
                <div>
                    <label for="industry" class="cms-label">Industry</label>
                    <input type="text" id="industry" name="industry" value="{{ old('industry', $company->industry) }}" class="cms-input" placeholder="e.g. Technology">
                    @error('industry')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Type -->
                <div>
                    <label for="type" class="cms-label">Company Type</label>
                    <select id="type" name="type" class="cms-select">
                        <option value="">Select Type</option>
                        <option value="startup" {{ old('type', $company->type) == 'startup' ? 'selected' : '' }}>Startup</option>
                        <option value="sme" {{ old('type', $company->type) == 'sme' ? 'selected' : '' }}>SME</option>
                        <option value="mnc" {{ old('type', $company->type) == 'mnc' ? 'selected' : '' }}>MNC</option>
                        <option value="indian_mnc" {{ old('type', $company->type) == 'indian_mnc' ? 'selected' : '' }}>Indian MNCs</option>
                        <option value="enterprise" {{ old('type', $company->type) == 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                        <option value="unicorn" {{ old('type', $company->type) == 'unicorn' ? 'selected' : '' }}>Unicorn</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Founded Year -->
                <div>
                    <label for="founded_year" class="cms-label">Founded Year</label>
                    <input type="number" id="founded_year" name="founded_year" value="{{ old('founded_year', $company->founded_year) }}" min="1800" max="{{ date('Y') }}" class="cms-input" placeholder="e.g. 2010">
                    @error('founded_year')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="cms-label">Website URL</label>
                    <input type="url" id="website" name="website" value="{{ old('website', $company->website) }}" placeholder="https://example.com" class="cms-input">
                    @error('website')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- LinkedIn -->
                <div>
                    <label for="linkedin_url" class="cms-label">LinkedIn URL</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $company->linkedin_url) }}" placeholder="https://linkedin.com/company/..." class="cms-input">
                    @error('linkedin_url')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="cms-label">Company Description</label>
                    <textarea id="description" name="description" rows="4" class="cms-textarea" placeholder="Describe the company...">{{ old('description', $company->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" class="cms-btn cms-btn-primary w-full sm:w-auto">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Update Company</span>
                </button>
                <a href="{{ route('cms.companies') }}" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.style.overflowY = 'hidden';
        const adjustHeight = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        };
        textarea.addEventListener('input', adjustHeight);
        adjustHeight(); // Initial adjustment
    });
});
</script>
@endsection