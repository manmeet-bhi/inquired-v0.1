@extends('layouts.cms')

@section('title', 'Edit Testimonial - Anywhereroles')

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
                <div class="cms-form-group">
                    <label for="name" class="cms-label">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $testimonial->name) }}" required
                        class="cms-input" placeholder="e.g. John Doe">
                    @error('name') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="cms-label">Email Address (Optional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $testimonial->email) }}"
                        class="cms-input" placeholder="e.g. john@example.com">
                    @error('email') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Role / Company -->
                <div>
                    <label for="role_company" class="cms-label">Role & Company</label>
                    <input type="text" name="role_company" id="role_company" value="{{ old('role_company', $testimonial->role_company) }}" placeholder="e.g. Software Engineer at Google"
                        class="cms-input">
                    @error('role_company') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="cms-label">Testimonial Message</label>
                    <textarea name="message" id="message" rows="4" required
                        class="cms-textarea" placeholder="Your testimonial message...">{{ old('message', $testimonial->message) }}</textarea>
                    @error('message') <p class="mt-1 text-sm text-red-600 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Is Approved -->
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="is_approved" id="is_approved" value="1" {{ old('is_approved', $testimonial->is_approved) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_approved" class="ml-2 block text-sm text-slate-900">
                        Approve and show publicly
                    </label>
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
