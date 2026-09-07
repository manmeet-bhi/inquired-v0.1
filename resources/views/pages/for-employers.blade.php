@extends('layouts.app')

@section('title', 'For Employers - Put Your Openings Here | Inaquired')
@section('meta_description', 'Post your job openings on Inaquired. Submit your company name, job title, and application link to reach thousands of active, qualified job seekers.')

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-3xl mx-auto px-6 py-12 sm:py-16">
        
        <!-- Header Section -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wider mb-4">
                <span>Employer & Recruiter Portal</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-[#0F172A] mb-4 lowercase font-unbounded tracking-tight leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">put your openings</span> here
            </h1>
            <p class="text-base sm:text-lg text-gray-600 max-w-xl mx-auto leading-relaxed">
                Connect your open roles with thousands of qualified, active job seekers worldwide. Fill out the form below to submit your job listing to Inaquired.
            </p>
        </div>

        @if(session('success'))
            <!-- Animated Success Card with Right Tick & Add Another Button -->
            <div class="bg-white rounded-2xl border border-emerald-100 p-8 sm:p-12 shadow-sm text-center">
                <!-- Animated SVG Checkmark / Tick -->
                <div class="checkmark-wrapper w-20 h-20 rounded-full bg-emerald-50 border border-emerald-200/80 flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <svg class="checkmark-svg w-12 h-12 text-emerald-500" viewBox="0 0 52 52">
                        <circle class="checkmark-circle" cx="26" cy="26" r="24" fill="none"/>
                        <path class="checkmark-check" fill="none" stroke-linecap="round" stroke-linejoin="round" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>

                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 brand-font mb-3 tracking-tight">
                    Job Opening Submitted!
                </h2>
                <p class="text-gray-600 max-w-md mx-auto text-sm sm:text-base mb-8 leading-relaxed">
                    {{ session('success') }}
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-xs mx-auto">
                    <a href="{{ route('for-employers') }}" class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-600/20 transition-all transform hover:scale-[1.02] active:scale-[0.98] text-sm tracking-normal cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Another Opening</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Error Summary (if any) -->
            @if($errors->any())
                <div class="mb-8 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-900 shadow-sm">
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

            <!-- Job Submission Form Card -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 sm:p-10 shadow-sm hover:shadow-md transition-shadow">
                <form action="{{ route('for-employers.submit') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Row 1: Company Name & Work Email (Side by Side) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-semibold text-gray-900 mb-2">
                                Company Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="company_name" 
                                name="company_name" 
                                value="{{ old('company_name') }}" 
                                required 
                                placeholder="e.g. Acme Corp, Microsoft, Stripe"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('company_name') ? 'border-red-300 ring-1 ring-red-300' : 'border-gray-200' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                            >
                            @error('company_name')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Work Email -->
                        <div>
                            <label for="work_email" class="block text-sm font-semibold text-gray-900 mb-2">
                                Work Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="work_email" 
                                name="work_email" 
                                value="{{ old('work_email') }}" 
                                required 
                                placeholder="e.g. hiring@yourcompany.com"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('work_email') ? 'border-red-300 ring-1 ring-red-300' : 'border-gray-200' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                            >
                            @error('work_email')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 2: Job Title -->
                    <div>
                        <label for="job_title" class="block text-sm font-semibold text-gray-900 mb-2">
                            Job Title <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="job_title" 
                            name="job_title" 
                            value="{{ old('job_title') }}" 
                            required 
                            placeholder="e.g. Senior Frontend Engineer, Product Designer, Marketing Intern"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('job_title') ? 'border-red-300 ring-1 ring-red-300' : 'border-gray-200' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                        >
                        @error('job_title')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row 3: Post URL -->
                    <div>
                        <label for="post_url" class="block text-sm font-semibold text-gray-900 mb-2">
                            Post URL <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="url" 
                            id="post_url" 
                            name="post_url" 
                            value="{{ old('post_url') }}" 
                            required 
                            placeholder="https://careers.yourcompany.com/job/123 or ATS link"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('post_url') ? 'border-red-300 ring-1 ring-red-300' : 'border-gray-200' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                        >
                        @error('post_url')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row 4: Description (Optional) -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                            Description <span class="text-gray-400 font-normal text-xs">(optional)</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="5" 
                            placeholder="Enter complete job description, requirements, responsibilities, compensation range, or key highlights..."
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('description') ? 'border-red-300 ring-1 ring-red-300' : 'border-gray-200' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 placeholder:text-gray-400 text-sm font-normal leading-relaxed transition-all"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Policy & Privacy Disclaimers -->
                    <p class="text-xs text-gray-500 leading-relaxed">
                        By submitting your opening, you confirm the listing is accurate and agree to our 
                        <a href="{{ route('employer-policy') }}" class="text-blue-600 font-medium hover:underline">Employer Listing Policy</a> and 
                        <a href="{{ route('employer-policy') }}#privacy" class="text-blue-600 font-medium hover:underline">Employer Privacy</a>.
                    </p>

                    <!-- Row 5: CTA Button Submit -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-700 transition-all transform hover:scale-[1.01] active:scale-[0.99] shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2 w-full text-base cursor-pointer"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <span>Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </main>
</div>

<!-- Animated Checkmark Styles -->
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
@endsection
