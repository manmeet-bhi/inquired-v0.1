@extends('layouts.cms')

@section('title', 'Edit Job - CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/searchable-dropdown.css') }}">
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('cms.jobs') }}" class="text-slate-600 hover:text-slate-900 mr-4">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Job</h1>
        </div>
    </div>

    <div class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
        <form action="{{ route('cms.jobs.update', $job) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 cms-form-group">
                    <label for="title" class="cms-label">Job Title <span class="text-rose-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}" required class="cms-input @error('title') border-red-500 @enderror" placeholder="e.g. Senior Software Engineer">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div class="cms-form-group">
                    <div class="flex items-center justify-between mb-2">
                        <label for="company_id" class="cms-label !mb-0">Company <span class="text-rose-500">*</span></label>
                        <button type="button" onclick="openCompanyModal()" class="text-indigo-600 hover:text-indigo-700 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1 transition-colors">
                            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i> Add New
                        </button>
                    </div>
                    <select id="company_id" name="company_id" required 
                            data-search-url="{{ route('cms.api.companies.search') }}"
                            class="searchable-company-dropdown cms-select @error('company_id') border-red-500 @enderror">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $job->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="cms-form-group">
                    <label for="location" class="cms-label">Location <span class="text-rose-500">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location', $job->location) }}" required class="cms-input @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Type -->
                <div class="cms-form-group">
                    <label for="type" class="cms-label">Job Type <span class="text-rose-500">*</span></label>
                    <select id="type" name="type" required class="cms-select @error('type') border-red-500 @enderror">
                        <option value="">Select Type</option>
                        <option value="full-time" {{ old('type', $job->type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('type', $job->type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ old('type', $job->type) == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="internship" {{ old('type', $job->type) == 'internship' ? 'selected' : '' }}>Internship</option>
                        <option value="freelancing" {{ old('type', $job->type) == 'freelancing' ? 'selected' : '' }}>Freelancing</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Work Type -->
                <div class="cms-form-group">
                    <label for="work_type" class="cms-label">Work Type <span class="text-rose-500">*</span></label>
                    <select id="work_type" name="work_type" required class="cms-select @error('work_type') border-red-500 @enderror">
                        <option value="">Select Work Type</option>
                        <option value="onsite" {{ old('work_type', $job->work_type) == 'onsite' ? 'selected' : '' }}>Onsite</option>
                        <option value="remote" {{ old('work_type', $job->work_type) == 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="hybrid" {{ old('work_type', $job->work_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('work_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="cms-form-group">
                    <div class="flex items-center justify-between mb-2">
                        <label for="category_id" class="cms-label !mb-0">Category</label>
                        <button type="button" onclick="openCategoryModal()" class="text-indigo-600 hover:text-indigo-700 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1 transition-colors">
                            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i> Add New
                        </button>
                    </div>
                    <select id="category_id" name="category_id" class="cms-select @error('category_id') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Level -->
                <div class="cms-form-group">
                    <label for="level" class="cms-label">Level <span class="text-rose-500">*</span></label>
                    <select id="level" name="level" required class="cms-select @error('level') border-red-500 @enderror">
                        <option value="">Select Level</option>
                        <option value="entry" {{ old('level', $job->level) == 'entry' ? 'selected' : '' }}>Entry</option>
                        <option value="junior" {{ old('level', $job->level) == 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="mid" {{ old('level', $job->level) == 'mid' ? 'selected' : '' }}>Mid</option>
                        <option value="senior" {{ old('level', $job->level) == 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="lead" {{ old('level', $job->level) == 'lead' ? 'selected' : '' }}>Lead</option>
                        <option value="executive" {{ old('level', $job->level) == 'executive' ? 'selected' : '' }}>Executive</option>
                    </select>
                    @error('level')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience -->
                <div class="cms-form-group">
                    <label for="experience" class="cms-label">Experience</label>
                    <select id="experience" name="experience" class="cms-select @error('experience') border-red-500 @enderror">
                        <option value="">Select Experience</option>
                        <option value="Freshers can apply" {{ old('experience', $job->experience) == 'Freshers can apply' ? 'selected' : '' }}>Freshers can apply</option>
                        <option value="0 - 1 Year" {{ old('experience', $job->experience) == '0 - 1 Year' ? 'selected' : '' }}>0 - 1 Year</option>
                        <option value="1-3 years" {{ old('experience', $job->experience) == '1-3 years' ? 'selected' : '' }}>1-3 years</option>
                        <option value="3-5 years" {{ old('experience', $job->experience) == '3-5 years' ? 'selected' : '' }}>3-5 years</option>
                        <option value="5-7 years" {{ old('experience', $job->experience) == '5-7 years' ? 'selected' : '' }}>5-7 years</option>
                        <option value="7-10 years" {{ old('experience', $job->experience) == '7-10 years' ? 'selected' : '' }}>7-10 years</option>
                        <option value="10+ years" {{ old('experience', $job->experience) == '10+ years' ? 'selected' : '' }}>10+ years</option>
                    </select>
                    @error('experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary Range -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="salary_min" class="cms-label">Minimum Salary</label>
                        <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" min="0" class="cms-input @error('salary_min') border-red-500 @enderror">
                        @error('salary_min')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salary_max" class="cms-label">Maximum Salary</label>
                        <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" min="0" class="cms-input @error('salary_max') border-red-500 @enderror">
                        @error('salary_max')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Application URL Toggle & Input -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center">
                        <input type="hidden" name="has_apply_link" value="0">
                        <input type="checkbox" id="has_apply_link" name="has_apply_link" value="1" 
                               {{ old('has_apply_link', $job->application_url ? '1' : '0') == '1' ? 'checked' : '' }} 
                               onchange="toggleApplyLink(this.checked)"
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="has_apply_link" class="ml-2 text-sm font-medium text-slate-700">Include Apply Link?</label>
                    </div>

                    <div id="apply_link_container" class="{{ old('has_apply_link', $job->application_url ? '1' : '0') == '1' ? '' : 'hidden' }}">
                        <label for="application_url" class="cms-label">Application URL</label>
                        <input type="url" id="application_url" name="application_url" value="{{ old('application_url', $job->application_url) }}" placeholder="https://example.com/apply" class="cms-input @error('application_url') border-red-500 @enderror">
                        @error('application_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content Editor Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-visible">
                        <div class="p-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                            <label class="block text-sm font-medium text-slate-700">Content <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span>Words: <span id="word-counter" class="font-medium text-slate-900">0</span></span>
                            </div>
                        </div>
                        
                        <!-- Editor Container -->
                        <div id="editor-container" class="min-h-[500px]">
                            <div id="content-editor" style="min-height: 500px;"></div>
                            <textarea name="content" id="content-textarea" class="hidden">{{ old('content', $job->content) }}</textarea>
                        </div>
                        
                        @error('content')<p class="text-red-500 text-xs mt-2 px-4 pb-4">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Featured & Active Options -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="cms-card p-5 bg-gradient-to-br from-amber-50/50 to-orange-50/30 border border-amber-200/80 rounded-xl">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-amber-100 text-amber-700 rounded-lg mt-0.5 flex-shrink-0">
                                    <i data-lucide="star" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <label for="is_featured" class="text-sm font-bold text-slate-900 cursor-pointer">Feature this Job</label>
                                    <p class="text-xs text-slate-500 mt-0.5">Highlight this listing with a "Featured" badge and prioritize it at the top of search listings and the homepage.</p>
                                </div>
                            </div>
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $job->is_featured) ? 'checked' : '' }} class="w-5 h-5 text-amber-600 border-slate-300 rounded focus:ring-amber-500 cursor-pointer mt-1">
                        </div>
                    </div>

                    <div class="cms-card p-5 bg-slate-50 border border-slate-200 rounded-xl">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-slate-200 text-slate-700 rounded-lg mt-0.5 flex-shrink-0">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <label for="is_active" class="text-sm font-bold text-slate-900 cursor-pointer">Active Status</label>
                                    <p class="text-xs text-slate-500 mt-0.5">When active, this job post is published and visible to candidates on public pages.</p>
                                </div>
                            </div>
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $job->is_active) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer mt-1">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" class="cms-btn cms-btn-primary w-full sm:w-auto">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Update Job Post</span>
                </button>
                <a href="{{ route('cms.jobs') }}" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleApplyLink(checked) {
        const container = document.getElementById('apply_link_container');
        const input = document.getElementById('application_url');
        
        if (checked) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
            input.value = '';
        }
    }

    // Initialize state (handled by Blade template mostly, but this ensures JS side is sync)
    // Actually we don't strictly need to run it on load if Blade sets the class correctly, but it's safe.
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('has_apply_link');
        // We trust the server-side rendering for initial display (class hidden or not), 
        // but let's make sure things are consistent.
        // If checked, ensure visible.
        if (checkbox.checked) {
            document.getElementById('apply_link_container').classList.remove('hidden');
        } else {
            document.getElementById('apply_link_container').classList.add('hidden');
        }
    });
</script>

<script src="{{ asset('js/searchable-dropdown.js') }}"></script>
@include('cms.categories.partials.category-modal')
@include('cms.companies.partials.company-modal')
@endsection