@extends('layouts.cms')

@section('title', 'Add Testimonial - Inaquired')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Add Testimonial</h1>
            <p class="mt-2 text-sm text-slate-500">Create a new testimonial manually.</p>
        </div>
        <a href="{{ route('cms.testimonials.index') }}" class="text-slate-500 hover:text-slate-700 font-medium flex items-center transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
            Back to list
        </a>
    </div>

    <div class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
        <form action="{{ route('cms.testimonials.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-6">
                <!-- Full Name -->
                <div class="cms-form-group">
                    <label for="name" class="cms-label">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="cms-input" placeholder="e.g. John Doe">
                    @error('name') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Role / Company -->
                <div class="cms-form-group">
                    <label for="role_company" class="cms-label">Role & Company</label>
                    <input type="text" name="role_company" id="role_company" value="{{ old('role_company') }}" placeholder="e.g. Software Engineer at Google"
                        class="cms-input">
                    @error('role_company') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Message -->
                <div class="cms-form-group">
                    <label for="message" class="cms-label">Testimonial Message <span class="text-red-500">*</span></label>
                    <textarea name="message" id="message" rows="5" required
                        class="cms-textarea" placeholder="Write the testimonial message here...">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" class="cms-btn cms-btn-primary w-full sm:w-auto">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Save Testimonial</span>
                </button>
                <a href="{{ route('cms.testimonials.index') }}" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
