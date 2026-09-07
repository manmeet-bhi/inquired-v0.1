@extends('layouts.cms')

@section('title', 'Edit Internship - CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/searchable-dropdown.css') }}">
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('cms.internships') }}" class="text-slate-600 hover:text-slate-900 mr-4">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Internship</h1>
        </div>
    </div>

    <div class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
        <form action="{{ route('cms.internships.update', $job) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="cms-form-group">
                    <label for="title" class="cms-label">Internship Title <span class="text-rose-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}" required class="cms-input @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job ID -->
                <div class="cms-form-group">
                    <label for="job_id" class="cms-label">Job ID <span class="text-slate-400 font-normal text-xs">(Optional)</span></label>
                    <input type="text" id="job_id" name="job_id" value="{{ old('job_id', $job->job_id) }}" placeholder="e.g. INT-1042, REQ-9821" class="cms-input @error('job_id') border-red-500 @enderror">
                    @error('job_id')
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

                <!-- Stipend Range -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="salary_min" class="cms-label">Monthly Stipend (Min)</label>
                        <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" min="0" placeholder="e.g. 10000" class="cms-input @error('salary_min') border-red-500 @enderror">
                        @error('salary_min')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salary_max" class="cms-label">Monthly Stipend (Max)</label>
                        <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" min="0" placeholder="e.g. 20000" class="cms-input @error('salary_max') border-red-500 @enderror">
                        @error('salary_max')
                            <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
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
                        <option value="">Select Category (Optional)</option>
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
                        <option value="entry" {{ old('level', $job->level) == 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="junior" {{ old('level', $job->level) == 'junior' ? 'selected' : '' }}>Junior Level</option>
                    </select>
                    @error('level')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                                    <label for="is_featured" class="text-sm font-bold text-slate-900 cursor-pointer">Feature this Internship</label>
                                    <p class="text-xs text-slate-500 mt-0.5">Highlight this listing with a "Featured" badge and prioritize it at the top of listings and the homepage.</p>
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
                                    <p class="text-xs text-slate-500 mt-0.5">When active, this internship is published and visible to candidates on public pages.</p>
                                </div>
                            </div>
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $job->is_active) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer mt-1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden field to maintain internship type -->
            <input type="hidden" name="type" value="internship">

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" class="cms-btn cms-btn-primary w-full sm:w-auto">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Update Internship</span>
                </button>
                <a href="{{ route('cms.internships') }}" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
lucide.createIcons();
</script>

<script src="{{ asset('assets/js/searchable-dropdown.js') }}"></script>
@include('cms.categories.partials.category-modal')
@include('cms.companies.partials.company-modal')
@endsection