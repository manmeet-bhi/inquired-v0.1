@extends('layouts.cms')

@section('title', 'Write New Post')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Create New Post</h1>
            <p class="text-sm text-slate-500 mt-1">Draft a new article, resource, or career guide for the blog</p>
        </div>
        <a href="{{ route('cms.posts') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2 rounded-xl hover:bg-slate-50 transition-colors shadow-xs">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Posts
        </a>
    </div>

    <form action="{{ route('cms.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Main Column: Post Content (8 cols) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Title Section -->
                <div class="cms-card p-6">
                    <div class="cms-form-group">
                        <label class="cms-label">Post Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="cms-input text-lg font-semibold @error('title') border-red-500 @enderror" 
                               placeholder="Enter an engaging post title..." required>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-slate-500 font-medium">The primary headline of your post</p>
                            <span id="title-counter" class="text-xs text-slate-400 font-medium">0 characters</span>
                        </div>
                        @error('title')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Excerpt Section -->
                <div class="cms-card p-6">
                    <div class="cms-form-group">
                        <label class="cms-label">Excerpt <span class="text-xs text-slate-400 font-normal ml-2">(Short Summary)</span></label>
                        <textarea name="excerpt" rows="3" 
                                  class="cms-input resize-none @error('excerpt') border-red-500 @enderror" 
                                  placeholder="Brief summary of the post appearing in cards, SEO snippets, and social shares...">{{ old('excerpt') }}</textarea>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-slate-500 font-medium">Recommended: 120-160 characters</p>
                            <span id="excerpt-counter" class="text-xs text-slate-400 font-medium">0 characters</span>
                        </div>
                        @error('excerpt')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Content Editor Section -->
                <div class="cms-card overflow-visible">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between">
                        <label class="cms-label !mb-0 font-bold text-slate-800 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-indigo-600"></i>
                            Post Content <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center gap-2 text-xs text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                            <span>Words: <span id="word-counter" class="font-bold text-slate-900">0</span></span>
                        </div>
                    </div>
                    
                    <div id="editor-container" class="min-h-[520px]">
                        <div id="content-editor" style="min-height: 520px;"></div>
                        <textarea name="content" id="content-textarea" class="hidden">{{ old('content') }}</textarea>
                    </div>
                    
                    @error('content')<p class="text-red-500 text-xs font-semibold mt-2 px-4 pb-4">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Right Sidebar Column: Settings & Collapsible Cards (4 cols) -->
            <div class="lg:col-span-4 space-y-5 lg:sticky lg:top-8">
                
                <!-- Action / Save Card -->
                <div class="cms-card p-5 bg-gradient-to-b from-white to-slate-50/50 border border-slate-200 shadow-sm">
                    <div class="space-y-3">
                        <button type="submit" class="cms-btn cms-btn-primary w-full py-3.5 px-6 flex items-center justify-center gap-2.5 text-base font-bold shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30 transition-all">
                            <span class="btn-spinner"></span>
                            <i data-lucide="check-circle-2" class="w-5 h-5 btn-text"></i>
                            <span class="btn-text">Publish Post</span>
                        </button>
                        
                        <a href="{{ route('cms.posts') }}" class="cms-btn cms-btn-secondary w-full py-2.5 text-center text-sm font-semibold">
                            Cancel & Discard
                        </a>
                    </div>
                </div>

                <!-- Collapsible Card 1: Publish Settings -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleCollapse('section-publish', this)" class="w-full px-5 py-4 flex items-center justify-between bg-slate-50/80 hover:bg-slate-100/80 transition-colors text-left border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <i data-lucide="sliders" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Publish Settings</h3>
                                <p class="text-xs text-slate-500">Status, visibility & tags</p>
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform duration-200 transform rotate-180 collapse-chevron"></i>
                    </button>
                    
                    <div id="section-publish" class="p-5 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Status</label>
                            <select name="status" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Private)</option>
                                <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published (Live)</option>
                            </select>
                            @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags') }}" 
                                   class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 bg-white" 
                                   placeholder="e.g. career, interview, resume">
                            <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1">
                                <i data-lucide="info" class="w-3 h-3 text-slate-400"></i>
                                Separate multiple tags with commas
                            </p>
                            @error('tags')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Collapsible Card 2: Featured Image -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleCollapse('section-featured-image', this)" class="w-full px-5 py-4 flex items-center justify-between bg-slate-50/80 hover:bg-slate-100/80 transition-colors text-left border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
                                <i data-lucide="image" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Featured Image</h3>
                                <p class="text-xs text-slate-500">Header visual & thumbnail</p>
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform duration-200 transform rotate-180 collapse-chevron"></i>
                    </button>
                    
                    <div id="section-featured-image" class="p-5 space-y-4">
                        <div class="relative">
                            <input type="file" name="featured_image" accept="image/*" id="featured-image-input" class="hidden">
                            <div onclick="document.getElementById('featured-image-input').click()" 
                                 class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center cursor-pointer hover:border-indigo-500 hover:bg-indigo-50/30 transition-all group">
                                <div class="space-y-2">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 group-hover:bg-indigo-100 text-slate-500 group-hover:text-indigo-600 flex items-center justify-center mx-auto transition-colors">
                                        <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700 group-hover:text-indigo-600 transition-colors">Click to upload image</p>
                                    <p class="text-xs text-slate-400">JPG, PNG, WebP up to 2MB</p>
                                </div>
                            </div>
                            
                            <div id="image-preview" class="hidden mt-4">
                                <div class="relative group rounded-xl overflow-hidden border border-slate-200 shadow-xs">
                                    <img id="preview-img" class="w-full h-44 object-cover">
                                    <button type="button" onclick="removeImage()" 
                                            class="absolute top-2 right-2 p-1.5 bg-red-600/90 text-white rounded-lg hover:bg-red-700 transition-colors shadow-sm flex items-center gap-1 text-xs font-semibold">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Remove</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('featured_image')<p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
// Image preview functionality
const imageInput = document.getElementById('featured-image-input');
const imagePreview = document.getElementById('image-preview');
const previewImg = document.getElementById('preview-img');

if (imageInput) {
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
}

function removeImage() {
    imageInput.value = '';
    imagePreview.classList.add('hidden');
    previewImg.src = '';
}

// Character counters
const titleInput = document.querySelector('input[name="title"]');
const titleCounter = document.getElementById('title-counter');
const excerptInput = document.querySelector('textarea[name="excerpt"]');
const excerptCounter = document.getElementById('excerpt-counter');

function updateCounters() {
    if (titleInput && titleCounter) {
        titleCounter.textContent = titleInput.value.length + ' characters';
    }
    if (excerptInput && excerptCounter) {
        excerptCounter.textContent = excerptInput.value.length + ' characters';
    }
}

if (titleInput) {
    titleInput.addEventListener('input', updateCounters);
}

if (excerptInput) {
    excerptInput.addEventListener('input', updateCounters);
}

// Initial count on page load
updateCounters();

// Collapsible Sections Handler
function toggleCollapse(sectionId, buttonElement) {
    const section = document.getElementById(sectionId);
    const chevron = buttonElement.querySelector('.collapse-chevron');
    
    if (!section) return;
    
    const isHidden = section.classList.contains('hidden');
    if (isHidden) {
        section.classList.remove('hidden');
        if (chevron) chevron.classList.add('rotate-180');
    } else {
        section.classList.add('hidden');
        if (chevron) chevron.classList.remove('rotate-180');
    }
}
</script>
@endsection