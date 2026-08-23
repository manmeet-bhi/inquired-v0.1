@extends('layouts.app')

@section('title', $job->title . ' | ' . ($job->company->name ?? 'Company'))
@section('meta_description', 'Apply for ' . $job->title . ' position at ' . ($job->company->name ?? 'Company') . '. ' . Str::limit(strip_tags($job->content ?? ''), 150))
@section('meta_keywords', $job->title . ', ' . ($job->company->name ?? 'Company') . ', jobs, careers, ' . ($job->category->name ?? 'employment'))

@section('content')
<style>
    body { font-family: 'Inter', sans-serif; color: #1e293b; line-height: 1.6; }
    .premium-shadow { box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.05); }
    .section-divider { border-bottom: 1px solid #f1f5f9; padding-bottom: 2.5rem; margin-bottom: 2.5rem; }
    .related-job-card:hover { border-color: #2563eb; background: #f8fafc; }
    
    /* Smooth scrolling for anchor links */
    html { scroll-behavior: smooth; }

    /* Custom scrollbar for a cleaner look */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    /* Line clamp utility for mobile job titles */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom Checkmark Bullets for All Lists in Job Description */
    .prose ul, .prose ol {
        list-style-type: none !important;
        padding-left: 0 !important;
    }
    .prose ul li, .prose ol li {
        position: relative;
        padding-left: 2rem !important;
        margin-bottom: 0.75rem;
    }
    .prose ul li::before, .prose ol li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0.35rem;
        width: 1.25rem;
        height: 1.25rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234f46e5' stroke-width='3'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M5 13l4 4L19 7'/%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>

<body class="bg-[#fcfcfd] antialiased">

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left Column: Content -->
            <div class="lg:col-span-8">
                
                <!-- Job Header -->
                <div class="mb-8 md:mb-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8">
                        <div class="flex items-start gap-4 flex-1 min-w-0">
                            {{-- Company Logo --}}
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl border border-slate-200 flex items-center justify-center overflow-hidden bg-white shadow-sm flex-shrink-0">
                                @if($job->company && $job->company->logo_url)
                                    <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" loading="lazy">
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xl sm:text-2xl uppercase" style="display:none;">
                                        {{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xl sm:text-2xl uppercase">
                                        {{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight break-words">{{ $job->title }}</h1>
                                    @if($job->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ $job->company ? route('company.show', $job->company->slug ?? $job->company->id) : '#' }}" class="text-sm sm:text-base md:text-lg text-blue-600 hover:text-blue-700 font-semibold inline-block mt-0.5">{{ $job->company->name ?? 'Company' }}</a>
                            </div>
                        </div>
                        <!-- Primary Apply Button (Desktop Sidebar Only) -->
                        @if($job->application_url)
                            <a href="{{ $job->application_url }}" target="_blank" class="hidden sm:inline-block lg:hidden bg-blue-600 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 text-center">
                                Apply Now
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 md:gap-3">
                        @if($job->location)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $job->location }}
                            </span>
                        @endif
                        @if($job->work_type)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                                {{ ucfirst($job->work_type) }}
                            </span>
                        @endif
                        @if($job->employment_type)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ ucfirst($job->employment_type) }}
                            </span>
                        @endif
                        @if($job->category)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                {{ $job->category->name }}
                            </span>
                        @endif
                        @if($job->salary_min && $job->salary_max)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-green-50 text-green-700 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                @if($job->type === 'internship')
                                    ₹{{ $job->salary_min > 1000 ? number_format($job->salary_min/1000, 0) . 'k' : number_format($job->salary_min) }} - {{ $job->salary_max > 1000 ? number_format($job->salary_max/1000, 0) . 'k' : number_format($job->salary_max) }}/month
                                @else
                                    ₹{{ number_format($job->salary_min/100000, 1) }}L – ₹{{ number_format($job->salary_max/100000, 1) }}L
                                @endif
                            </span>
                        @endif
                        @if($job->type && $job->type !== $job->employment_type)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-purple-50 text-purple-700 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                {{ ucfirst($job->type) }}
                            </span>
                        @endif
                        @if($job->experience_level)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-orange-50 text-orange-700 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                                {{ $job->experience_level }}
                            </span>
                        @endif
                        @if($job->job_id)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs md:sm font-bold flex items-center gap-1.5 border border-slate-200">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                                Job ID: {{ $job->job_id }}
                            </span>
                        @endif
                        @if($job->experience)
                            <span class="px-3 md:px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-xs md:sm font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                                {{ $job->experience }}
                            </span>
                        @endif
                    <!-- Posted Time -->
                        <span class="px-3 md:px-4 py-1.5 rounded-full bg-gray-50 text-gray-600 text-xs md:sm font-bold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"/><path d="M3 10h18"/><path d="m16 20 2 2 4-4"/></svg>
                            {{ $job->created_at->diffForHumans() }}
                        </span>
                        
                        <!-- Views Count -->
                        <span class="px-3 md:px-4 py-1.5 rounded-full bg-sky-50 text-sky-600 text-xs md:sm font-bold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ number_format($job->views_count) }} Applicants
                        </span>
                    </div>
                </div>

                <!-- Main Content Sections -->
                <div class="bg-white rounded-[24px] md:rounded-[32px] p-6 sm:p-8 lg:p-10 premium-shadow border border-slate-100">
                    
                    <!-- Content -->
                    @if($job->content)
                    <section class="section-divider">
                        <div class="text-slate-600 text-base md:text-lg prose prose-blue max-w-none">
                            {!! $job->content !!}
                        </div>
                    </section>
                    @endif

                    <!-- About Company -->
                    <section id="apply-section">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6 mt-8">About Company</h2>
                        @php
                            $companyDesc = $job->company && $job->company->description ? $job->company->description : ($job->company->name ?? 'Company') . ' is a leading organization committed to excellence and innovation. Join our team and be part of our mission to make a meaningful impact in the industry.';
                            $isLongDesc = strlen($companyDesc) > 200;
                        @endphp
                        
                        <div x-data="{ expanded: false }" class="relative mb-6">
                            <p class="text-slate-600 text-sm md:text-base transition-all duration-300"
                               :class="expanded ? '' : 'line-clamp-3'">
                                {{ $companyDesc }}
                            </p>
                            @if($isLongDesc)
                                <button @click="expanded = !expanded" 
                                        class="mt-2 text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors inline-flex items-center gap-1">
                                    <span x-text="expanded ? 'Show Less' : 'Show More'"></span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            @endif
                        </div>
                        
                        <!-- Industry Tags -->
                        @if($job->company && $job->company->industry)
                            <div class="mb-6">
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $industries = array_map('trim', explode(',', $job->company->industry));
                                        $visibleIndustries = array_slice($industries, 0, 4);
                                        $remainingCount = count($industries) - 4;
                                    @endphp
                                    @foreach($visibleIndustries as $industry)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs md:text-sm font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ ucfirst($industry) }}
                                        </span>
                                    @endforeach
                                    @if($remainingCount > 0)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs md:text-sm font-medium bg-slate-50 text-slate-600 border border-slate-200">
                                            +{{ $remainingCount }} more
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($job->company && ($job->company->website || $job->company->linkedin_url))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8 pt-6 border-t border-slate-50">
                            @if($job->company->website)
                            <a href="{{ $job->company->website }}" target="_blank" class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-100 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m-9 9a9 9 0 019-9"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Official Website</p>
                                    <p class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">Visit Website</p>
                                </div>
                            </a>
                            @endif

                            @if($job->company->linkedin_url)
                            <a href="{{ $job->company->linkedin_url }}" target="_blank" class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-100 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-[#0a66c2]" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">LinkedIn Profile</p>
                                    <p class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">Follow on LinkedIn</p>
                                </div>
                            </a>
                            @endif
                        </div>
                        @endif
                    </section>
                </div>

                <!-- Legal Disclaimer -->
                @include('partials.trademark-disclaimer')
            </div>

            <!-- Right Column: Sidebar -->
            <div class="lg:col-span-4">
                <div class="space-y-8 pb-24 lg:pb-0">
                    
                    <!-- Apply Button (Desktop Sidebar Only) -->
                    @if($job->application_url)
                        <div class="hidden lg:block mb-8">
                            <a href="{{ $job->application_url }}" target="_blank" class="block w-full bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 text-center text-lg transform hover:-translate-y-1">
                                Apply Now
                            </a>
                        </div>
                    @endif

                    <!-- People Also See (Related Jobs) -->
                    <div class="bg-white rounded-3xl p-6 premium-shadow border border-slate-100">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                            People also see
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($relatedJobs as $relatedJob)
                            <!-- Job {{ $loop->iteration }} -->
                            <a href="{{ route('jobs.show', [$relatedJob->id, Str::slug($relatedJob->title)]) }}" class="block p-4 rounded-2xl border border-slate-100 related-job-card transition-all group">
                                <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">{{ $relatedJob->company->name ?? 'Company' }}</p>
                                <h4 class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ Str::limit($relatedJob->title, 40) }}</h4>
                                <div class="flex items-center gap-2 mt-2 text-xs text-slate-500">
                                    <span>{{ $relatedJob->location ?? ($relatedJob->work_type ? ucfirst($relatedJob->work_type) : 'Remote') }}</span>
                                    <span>•</span>
                                    <span>
                                        @if($relatedJob->salary_min && $relatedJob->salary_max)
                                            @if($relatedJob->type === 'internship')
                                                ₹{{ $relatedJob->salary_min > 1000 ? number_format($relatedJob->salary_min/1000, 0) . 'k' : number_format($relatedJob->salary_min) }}+/month
                                            @else
                                                ₹{{ number_format($relatedJob->salary_min/100000, 1) }}L+
                                            @endif
                                        @else
                                            Competitive
                                        @endif
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>


                    </div>

                    <!-- Share Job Section -->
                    <div class="relative w-full" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-900 font-bold py-4 px-6 rounded-3xl transition-all premium-shadow">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 12v3a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h7"/><path d="M16 3h5v5"/><path d="m21 3-6 6"/></svg>
                                <span>Share this</span>
                            </span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 left-0 bg-white border border-slate-100 shadow-xl rounded-2xl p-4 mt-2 z-50"
                             style="display: none;">
                            <div class="space-y-4">
                                <!-- Copy Link -->
                                <button onclick="copyToClipboard(this)" class="w-full flex items-center justify-center gap-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold py-3.5 rounded-xl transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                    <span class="button-text">Copy Link</span>
                                </button>

                                <div class="border-t border-slate-100 my-2"></div>

                                <div class="flex flex-col gap-2 pt-2">
                                    <!-- WhatsApp -->
                                    <a href="https://wa.me/?text={{ rawurlencode('Check out this job: ' . $job->title . ' at ' . ($job->company->name ?? 'Company') . ' - ' . route('jobs.show', [$job->id, Str::slug($job->title)])) }}" target="_blank" title="Share on WhatsApp" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 border border-green-200 transition-all group">
                                        <span class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-lg shadow-sm group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-0.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        </span>
                                        <span class="font-semibold text-sm text-green-700">WhatsApp</span>
                                    </a>

                                    <!-- Telegram -->
                                    <a href="https://t.me/share/url?url={{ rawurlencode(route('jobs.show', [$job->id, Str::slug($job->title)])) }}&text={{ rawurlencode('Check out this job: ' . $job->title) }}" target="_blank" title="Share on Telegram" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border border-blue-200 transition-all group">
                                        <span class="flex items-center justify-center w-8 h-8 text-white rounded-lg shadow-sm group-hover:scale-110 transition-transform" style="background-color: #0088cc;">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-3.155 16.793l.892-4.223 7.641-6.848c.361-.318-.135-.558-.583-.244l-9.697 6.073-4.145-1.3c-.902-.279-.908-.888.196-1.32l16.279-6.302c.749-.283 1.411.177 1.167 1.397l-2.75 13.044c-.204.922-.738 1.144-1.503.714l-4.156-3.078-2.008 1.942c-.22.219-.405.405-.83.405l.298-4.26z"/></svg>
                                        </span>
                                        <span class="font-semibold text-sm" style="color: #0088cc;">Telegram</span>
                                    </a>

                                    <!-- Email -->
                                    @php
                                        $shareSubject = 'Job Opportunity: ' . $job->title . ' at ' . ($job->company->name ?? 'Company');
                                        $shareBody = "Hi,\n\nI found this job and thought you might be interested:\n\n" . $job->title . " at " . ($job->company->name ?? 'Company') . "\n\nApply here: " . route('jobs.show', [$job->id, Str::slug($job->title)]);
                                        $mailtoUrl = 'mailto:?subject=' . rawurlencode($shareSubject) . '&body=' . rawurlencode($shareBody);
                                    @endphp
                                    <a href="{{ $mailtoUrl }}" title="Share via Email" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-slate-50 to-slate-100 hover:from-slate-100 hover:to-slate-200 border border-slate-200 transition-all group">
                                        <span class="flex items-center justify-center w-8 h-8 text-white rounded-lg shadow-sm group-hover:scale-110 transition-transform" style="background-color: #475569;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </span>
                                        <span class="font-semibold text-sm" style="color: #475569;">Email</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Enhanced Mobile Action Bar (Sticky Footer) -->
    <div class="sm:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-100 p-4 z-50 shadow-[0_-10px_30px_-10px_rgba(0,0,0,0.08)]">
        <div class="flex items-center gap-4 max-w-lg mx-auto">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-slate-900 break-words line-clamp-2">{{ $job->title }}</p>
                <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wide truncate">{{ $job->company->name ?? 'Company' }}</p>
            </div>
            @if($job->application_url)
                <a href="{{ filter_var($job->application_url, FILTER_VALIDATE_URL) ? $job->application_url : '#' }}" target="_blank" rel="noopener noreferrer" class="flex-[1.5] bg-blue-600 text-white text-center font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/20 active:scale-95 transition-transform text-sm">
                    Apply Now
                </a>
            @endif
        </div>
    </div>

    <!-- Application Modal -->
    <div id="applicationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-900">Apply for {{ $job->title }}</h3>
                <button onclick="closeApplicationModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="applicationForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
                    <input type="text" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Resume</label>
                    <input type="file" accept=".pdf,.doc,.docx" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Submit Application
                    </button>
                    <button type="button" onclick="closeApplicationModal()" class="flex-1 border border-slate-300 text-slate-700 font-medium py-2 px-4 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function copyToClipboard(button) {
            const textToCopy = window.location.href;
            const dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = textToCopy;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);

            // Visual feedback
            const textEl = button.querySelector('.button-text');
            const originalText = textEl.innerText;
            textEl.innerText = "Link Copied!";
            button.classList.add('bg-green-50', 'text-green-600', 'border-green-200');
            button.classList.remove('bg-slate-50', 'text-slate-700', 'border-slate-200');
            
            setTimeout(() => {
                textEl.innerText = originalText;
                button.classList.remove('bg-green-50', 'text-green-600', 'border-green-200');
                button.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-200');
            }, 2000);
        }

        function showApplicationModal() {
            document.getElementById('applicationModal').classList.remove('hidden');
        }
        
        function closeApplicationModal() {
            document.getElementById('applicationModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('applicationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeApplicationModal();
            }
        });
        
        // Handle application form submission
        document.getElementById('applicationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Application submitted successfully!');
            closeApplicationModal();
        });
    </script>

    <!-- Job Posting Schema -->
    <script type="application/ld+json">
        {!! app('App\Http\Controllers\SeoController')->generateJobPostingSchema($job->id) !!}
    </script>
</body>
@endsection
