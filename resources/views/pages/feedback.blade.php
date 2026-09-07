@extends('layouts.app')

@section('title', 'Share Your Feedback - Inaquired')
@section('meta_description', 'Help us improve Inaquired. Share your suggestions, ideas, bug reports, or general thoughts on your experience.')

@push('styles')
<style>
    @keyframes checkmarkStroke {
        100% { stroke-dashoffset: 0; }
    }
    @keyframes checkmarkScale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.15, 1.15, 1); }
    }
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2.5;
        stroke: #10b981;
        fill: none;
        animation: checkmarkStroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke-width: 3.5;
        stroke: #10b981;
        animation: checkmarkStroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.45s forwards;
    }
    .checkmark-wrapper {
        animation: checkmarkScale 0.4s ease-in-out 0.75s both;
    }
</style>
@endpush

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wider mb-4">
                <span>Community & Feedback</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                Share Your Feedback
            </h1>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Your thoughts and suggestions help us build a better platform for job seekers and employers around the world. We appreciate you taking the time.
            </p>
        </div>

        <!-- Main Grid Container (Side by side on medium & large screens) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- LEFT COLUMN: Why Feedback Matters & Quick Guidance (5 cols on md & lg) -->
            <div class="md:col-span-5 lg:col-span-5 space-y-6">
                
                <!-- Feedback Impact Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">How Your Input Helps</h2>
                    
                    <div class="space-y-4">
                        <!-- Feature Ideas -->
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50/70 border border-gray-100">
                            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-0.5">Feature Ideas</h3>
                                <p class="text-xs text-gray-600 leading-relaxed">Tell us what filters, tools, or resources would make your job search easier.</p>
                            </div>
                        </div>

                        <!-- Bug Reports -->
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50/70 border border-gray-100">
                            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-0.5">Report Issues</h3>
                                <p class="text-xs text-gray-600 leading-relaxed">Spotted a broken link or layout glitch? Let us know so we can fix it promptly.</p>
                            </div>
                        </div>

                        <!-- Experience Quality -->
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50/70 border border-gray-100">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-0.5">Platform Experience</h3>
                                <p class="text-xs text-gray-600 leading-relaxed">Share your honest impressions on design, search speed, and usability.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Direct Support Box -->
                <div class="bg-blue-50/60 rounded-2xl border border-blue-100 p-6 sm:p-8 shadow-sm">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2">Need Immediate Support?</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        If you need urgent assistance with a specific inquiry, you can also reach us via our dedicated contact page.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center text-xs font-semibold text-blue-700 bg-white px-4 py-3 rounded-xl border border-blue-100 shadow-sm hover:bg-blue-50/50 hover:text-blue-800 transition-colors gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Go to Contact Us Page</span>
                    </a>
                </div>

            </div>

            <!-- RIGHT COLUMN: Feedback Form (7 cols on md & lg) -->
            <div class="md:col-span-7 lg:col-span-7">
                
                @if(session('success'))
                    <!-- Animated Success Card -->
                    <div class="bg-white rounded-2xl border border-emerald-100 p-8 sm:p-12 shadow-sm text-center">
                        <!-- Animated SVG Checkmark / Tick -->
                        <div class="checkmark-wrapper w-20 h-20 rounded-full bg-emerald-50 border border-emerald-200/80 flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <svg class="checkmark-svg w-12 h-12 text-emerald-500" viewBox="0 0 52 52">
                                <circle class="checkmark-circle" cx="26" cy="26" r="24" fill="none"/>
                                <path class="checkmark-check" fill="none" stroke-linecap="round" stroke-linejoin="round" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3 tracking-tight">
                            Feedback Received!
                        </h2>
                        <p class="text-gray-600 max-w-md mx-auto text-sm sm:text-base mb-8 leading-relaxed">
                            {{ session('success') }}
                        </p>

                        <div class="flex justify-center">
                            <a href="{{ route('feedback') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-600/20 transition-all transform hover:scale-[1.02] active:scale-[0.98] text-sm tracking-normal cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Submit Another Feedback</span>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Error Summary (if any) -->
                    @if($errors->any())
                        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-900 shadow-sm">
                            <div class="flex items-center gap-2 font-bold mb-2 text-sm text-red-800">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Please fix the following:</span>
                            </div>
                            <ul class="list-disc pl-5 text-xs text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Feedback Form Card -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-10 shadow-sm hover:shadow-md transition-shadow" x-data="{ selectedRating: '{{ old('rating', 'good') }}' }">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Send Us Your Feedback</h2>
                            <p class="text-sm text-gray-600">Please share your experience and let us know what we can do better.</p>
                        </div>

                        <form action="{{ route('feedback.submit') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Topic / Category -->
                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Feedback Category <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="category" 
                                    name="category" 
                                    required 
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('category') ? 'border-red-300 ring-1 ring-red-300 bg-red-50/20' : 'border-gray-200 bg-white' }} focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-gray-900 text-sm font-normal transition-all"
                                >
                                    <option value="General Feedback & Thoughts" {{ old('category') == 'General Feedback & Thoughts' ? 'selected' : '' }}>General Feedback & Thoughts</option>
                                    <option value="Feature Suggestions / Idea" {{ old('category') == 'Feature Suggestions / Idea' ? 'selected' : '' }}>Feature Suggestions / Idea</option>
                                    <option value="Bug or Technical Issue" {{ old('category') == 'Bug or Technical Issue' ? 'selected' : '' }}>Bug or Technical Issue</option>
                                    <option value="Job Listing Accuracy / Quality" {{ old('category') == 'Job Listing Accuracy / Quality' ? 'selected' : '' }}>Job Listing Accuracy / Quality</option>
                                    <option value="Employer & Recuter Portal" {{ old('category') == 'Employer & Recuter Portal' ? 'selected' : '' }}>Employer & Recruiter Portal</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Experience Rating -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    Overall Experience <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    
                                    <!-- Rating 1: Excellent -->
                                    <label 
                                        @click="selectedRating = 'Exellent'" 
                                        :class="selectedRating === 'Exellent' ? 'border-blue-500 bg-blue-50/50 text-blue-700 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                        class="flex flex-col items-center justify-center p-3 rounded-xl border text-center cursor-pointer transition-all"
                                    >
                                        <input type="radio" name="rating" value="Exellent" class="sr-only" :checked="selectedRating === 'Exellent'">
                                        <span class="text-2xl mb-1">😍</span>
                                        <span class="text-xs font-semibold">Excellent</span>
                                    </label>

                                    <!-- Rating 2: Good -->
                                    <label 
                                        @click="selectedRating = 'Good'" 
                                        :class="selectedRating === 'Good' ? 'border-blue-500 bg-blue-50/50 text-blue-700 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                        class="flex flex-col items-center justify-center p-3 rounded-xl border text-center cursor-pointer transition-all"
                                    >
                                        <input type="radio" name="rating" value="Good" class="sr-only" :checked="selectedRating === 'Good'">
                                        <span class="text-2xl mb-1">😊</span>
                                        <span class="text-xs font-semibold">Good</span>
                                    </label>

                                    <!-- Rating 3: Neutral -->
                                    <label 
                                        @click="selectedRating = 'Netural'" 
                                        :class="selectedRating === 'Netural' ? 'border-blue-500 bg-blue-50/50 text-blue-700 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                        class="flex flex-col items-center justify-center p-3 rounded-xl border text-center cursor-pointer transition-all"
                                    >
                                        <input type="radio" name="rating" value="Netural" class="sr-only" :checked="selectedRating === 'Netural'">
                                        <span class="text-2xl mb-1">😐</span>
                                        <span class="text-xs font-semibold">Neutral</span>
                                    </label>

                                    <!-- Rating 4: Needs Improvement -->
                                    <label 
                                        @click="selectedRating = 'Needs Work'" 
                                        :class="selectedRating === 'Needs Work' ? 'border-blue-500 bg-blue-50/50 text-blue-700 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                        class="flex flex-col items-center justify-center p-3 rounded-xl border text-center cursor-pointer transition-all"
                                    >
                                        <input type="radio" name="rating" value="Needs Work" class="sr-only" :checked="selectedRating === 'Needs Work'">
                                        <span class="text-2xl mb-1">😕</span>
                                        <span class="text-xs font-semibold">Needs Work</span>
                                    </label>

                                </div>
                                @error('rating')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name (Optional) & Email Row -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                                        Your Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        required
                                        placeholder="e.g. John Doe"
                                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 ring-1 ring-red-300 bg-red-50/20' : 'border-gray-200 bg-white' }} focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                                    >
                                    @error('name')
                                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email') }}" 
                                        required 
                                        placeholder="e.g. john@example.com"
                                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-300 ring-1 ring-red-300 bg-red-50/20' : 'border-gray-200 bg-white' }} focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                                    >
                                    @error('email')
                                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Feedback Details -->
                            <div>
                                <label for="feedback" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Your Feedback & Suggestions <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="feedback" 
                                    name="feedback" 
                                    rows="5" 
                                    required
                                    placeholder="Tell us what's working well, what needs improvement, or any specific ideas you have..."
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('feedback') ? 'border-red-300 ring-1 ring-red-300 bg-red-50/20' : 'border-gray-200 bg-white' }} focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-gray-900 placeholder:text-gray-400 text-sm font-normal leading-relaxed transition-all resize-y"
                                >{{ old('feedback') }}</textarea>
                                @error('feedback')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Privacy Note -->
                            <p class="text-xs text-gray-500 leading-relaxed">
                                We respect your privacy. Submissions are kept confidential in accordance with our 
                                <a href="{{ route('privacy') }}" class="text-blue-600 font-medium hover:underline">Privacy Policy</a>.
                            </p>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button 
                                    type="submit" 
                                    class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 transition-all transform hover:scale-[1.01] active:scale-[0.99] text-base cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    <span>Submit Feedback</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
