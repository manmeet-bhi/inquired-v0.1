@extends('layouts.cms')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('cms.categories') }}" class="text-slate-600 hover:text-slate-900 mr-4">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Category</h1>
        </div>
    </div>

    <div class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
        <form action="{{ route('cms.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="cms-form-group">
                    <label for="name" class="cms-label">Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required class="cms-input @error('name') border-red-500 @enderror" placeholder="e.g. Technology">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="cms-label">Slug *</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required class="cms-input @error('slug') border-red-500 @enderror">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="cms-label">Icon (Emoji or HTML)</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="💻 or <i class='icon'></i>" class="cms-input">
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="cms-label">Color</label>
                    <input type="color" id="color" name="color" value="{{ old('color', $category->color ?? '#3B82F6') }}" class="w-full h-10 px-2 py-1 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('color') border-red-500 @enderror">
                    @error('color')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon File Upload -->
                <div class="md:col-span-2">
                    <label for="icon_file" class="cms-label">Icon File (SVG)</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" id="icon_file" name="icon_file" accept=".svg" class="cms-input @error('icon_file') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-slate-500">Upload an SVG file for the category icon (max 1MB)</p>
                        </div>
                        @if($category->icon_file)
                            <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                                <img src="{{ $category->icon_url ?? asset('assets/icons/categories/' . $category->icon_file) }}" alt="Current icon" class="w-10 h-10 object-contain">
                            </div>
                        @endif
                    </div>
                    @if($category->icon_file)
                        <p class="mt-1 text-sm text-slate-500">Current icon will be replaced if you upload a new one</p>
                    @endif
                    @error('icon_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="cms-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="cms-textarea" placeholder="Enter category description...">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_active" class="ml-2 text-sm font-medium text-slate-700">Active</label>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Active categories will be visible on the website</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" class="cms-btn cms-btn-primary w-full sm:w-auto">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Update Category</span>
                </button>
                <a href="{{ route('cms.categories') }}" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;

    nameInput.addEventListener('input', function() {
        // Only auto-generate slug if it hasn't been manually changed
        if (slugInput.value === originalSlug || slugInput.value === '') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });
});
</script>
@endsection