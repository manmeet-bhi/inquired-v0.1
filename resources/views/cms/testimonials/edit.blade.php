@extends('layouts.cms')

@section('title', 'Edit Testimonial - Inaquired')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Testimonial</h1>
            <p class="mt-2 text-sm text-slate-500">Update the testimonial from {{ $testimonial->name }}.</p>
        </div>
        <a href="{{ route('cms.testimonials.index') }}" class="text-slate-500 hover:text-slate-700 font-medium flex items-center transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
            Back to list
        </a>
    </div>

    <div class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
        <form action="{{ route('cms.testimonials.update', $testimonial) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Full Name -->
                <div class="cms-form-group">
                    <label for="name" class="cms-label">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $testimonial->name) }}" required
                        class="cms-input" placeholder="e.g. John Doe">
                    @error('name') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Role / Company -->
                <div class="cms-form-group">
                    <label for="role_company" class="cms-label">Role & Company</label>
                    <input type="text" name="role_company" id="role_company" value="{{ old('role_company', $testimonial->role_company) }}" placeholder="e.g. Software Engineer at Google"
                        class="cms-input">
                    @error('role_company') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Featured Toggle -->
                <div class="cms-form-group bg-slate-50 border border-slate-200/80 rounded-xl p-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 mt-1">
                        <div>
                            <span class="text-sm font-semibold text-slate-900 flex items-center gap-1.5">
                                <i data-lucide="star" class="w-4 h-4 text-amber-500 fill-amber-400"></i>
                                Feature on top spotlight carousel
                            </span>
                            <p class="text-xs text-slate-500 mt-0.5">When enabled, this story will be highlighted in the top carousel on the testimonials page and excluded from the bottom community grid.</p>
                        </div>
                    </label>
                </div>

                <!-- Message -->
                <div class="cms-form-group">
                    <label for="message" class="cms-label">Testimonial Message <span class="text-red-500">*</span></label>
                    <textarea name="message" id="message" rows="5" required
                        class="cms-textarea" placeholder="Write the testimonial message here...">{{ old('message', $testimonial->message) }}</textarea>
                    @error('message') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" class="cms-btn cms-btn-primary w-full sm:w-auto">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Update Testimonial</span>
                </button>
                <a href="{{ route('cms.testimonials.index') }}" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
