@extends('layouts.cms')

@section('title', 'Write New Post')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Create New Post</h1>
    </div>

    <form action="{{ route('cms.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3 space-y-6">
                <!-- Title Section -->
                <div class="cms-card p-6">
                    <div class="cms-form-group">
                        <label class="cms-label">Post Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                               class="cms-input @error('title') border-red-500 @enderror" 
                               placeholder="Enter post title" required>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-slate-500 font-medium">The main headline of your post</p>
                            <span id="title-counter" class="text-xs text-slate-400 font-medium">0 characters</span>
                        </div>
                        @error('title')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Excerpt Section -->
                <div class="cms-card p-6">
                    <div class="cms-form-group">
                        <label class="cms-label">Excerpt <span class="text-xs text-slate-400 font-normal ml-2">(Optional)</span></label>
                        <textarea name="excerpt" rows="3" 
                                  class="cms-input resize-none @error('excerpt') border-red-500 @enderror" 
                                  placeholder="Brief summary of the post...">{{ old('excerpt') }}</textarea>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-slate-500 font-medium">Appears in previews and search results</p>
                            <span id="excerpt-counter" class="text-xs text-slate-400 font-medium">0 characters</span>
                        </div>
                        @error('excerpt')<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Content Editor Section -->
                <div class="cms-card overflow-visible">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <label class="cms-label !mb-0">Content <span class="text-rose-500">*</span></label>
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <span>Words: <span id="word-counter" class="font-semibold text-slate-900">0</span></span>
                        </div>
                    </div>
                    
                    <div id="editor-container" class="min-h-[500px]">
                        <div id="content-editor" style="min-height: 500px;"></div>
                        <textarea name="content" id="content-textarea" class="hidden">{{ old('content') }}</textarea>
                    </div>
                    
                    @error('content')<p class="text-red-500 text-xs font-semibold mt-2 px-4 pb-4">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Settings -->
            <!-- Featured Image -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Featured Image</h3>
                    
                    <div class="space-y-4">
                        <div class="relative">
                            <input type="file" name="featured_image" accept="image/*" id="featured-image-input" class="hidden">
                            <div onclick="document.getElementById('featured-image-input').click()" 
                                 class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center cursor-pointer hover:border-indigo-500 hover:bg-slate-50 transition-all">
                                <div class="space-y-2">
                                    <i data-lucide="image" class="w-8 h-8 text-slate-400 mx-auto"></i>
                                    <p class="text-sm text-slate-600">Click to upload</p>
                                    <p class="text-xs text-slate-500">JPG, PNG up to 2MB</p>
                                </div>
                            </div>
                            
                            <div id="image-preview" class="hidden mt-4">
                                <div class="relative">
                                    <img id="preview-img" class="w-full h-40 object-cover rounded-lg border border-slate-200">
                                    <button type="button" onclick="removeImage()" 
                                            class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('featured_image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Publish Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags') }}" 
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400" 
                                   placeholder="e.g. tutorial, news">
                            <p class="text-xs text-slate-500 mt-1">Comma separated</p>
                            @error('tags')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="cms-card p-6">
                    <div class="space-y-3">
                        <button type="submit" class="cms-btn cms-btn-primary w-full">
                            <span class="btn-spinner"></span>
                            <i data-lucide="check" class="w-4 h-4 btn-text"></i>
                            <span class="btn-text">Publish Post</span>
                        </button>
                        
                        <a href="{{ route('cms.posts') }}" class="cms-btn cms-btn-secondary w-full text-center">
                            Cancel
                        </a>
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

if (titleInput && titleCounter) {
    titleInput.addEventListener('input', function() {
        titleCounter.textContent = this.value.length + ' characters';
    });
}

if (excerptInput && excerptCounter) {
    excerptInput.addEventListener('input', function() {
        excerptCounter.textContent = this.value.length + ' characters';
    });
}
</script>
@endsection