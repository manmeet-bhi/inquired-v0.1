@extends('layouts.app')

@section('title', $company->name . ' Jobs - Career Opportunities & Openings')

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        <!-- Company Profile Header -->
        <div class="mb-8 pb-8 border-b border-slate-100">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 flex-1 min-w-0">
                    {{-- Company Information --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2.5 mb-2">
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight break-words">{{ $company->name }}</h1>
                        </div>

                        @if(!empty($company->tagline))
                            <p class="text-sm sm:text-base text-slate-600 font-normal mb-3 max-w-2xl leading-relaxed">{{ $company->tagline }}</p>
                        @endif

                        {{-- Separate Industry Tags (1 Open Position badge removed) --}}
                        <div class="flex flex-wrap items-center gap-2 sm:gap-2.5 text-xs sm:text-sm text-slate-600">
                            @if($company->industry)
                                @php
                                    $industries = array_filter(array_map('trim', preg_split('/[,|\/]+/', $company->industry)));
                                @endphp
                                @foreach($industries as $index => $ind)
                                    <span class="inline-flex items-center gap-1.5 font-medium text-slate-700 bg-slate-100 px-3 py-1 rounded-lg">
                                        @if($index === 0)
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        @endif
                                        {{ $ind }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Action / Links: 1. About (icon + text), 2. Website (icon only), 3. LinkedIn (icon only) --}}
                <div class="flex items-center flex-wrap sm:flex-nowrap gap-2.5 flex-shrink-0">
                    {{-- 1. About Button: i icon + text --}}
                    <button type="button" onclick="openAboutModal()" 
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm hover:border-blue-200 hover:text-blue-600 hover:bg-blue-50/50 shadow-xs transition-all cursor-pointer"
                            title="About {{ $company->name }}">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4m0-4h.01"></path>
                        </svg>
                        <span>About</span>
                    </button>

                    {{-- 2. Website Button: Icon only --}}
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:border-blue-200 hover:text-blue-600 hover:bg-blue-50/50 shadow-xs transition-all flex-shrink-0 group"
                           title="Official Website">
                            <svg class="w-4 h-4 text-slate-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </a>
                    @endif

                    {{-- 3. LinkedIn Button: Icon only --}}
                    @if($company->linkedin_url)
                        <a href="{{ $company->linkedin_url }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:border-[#0077b5]/30 hover:text-[#0077b5] hover:bg-blue-50/50 shadow-xs transition-all flex-shrink-0 group"
                           title="LinkedIn Profile">
                            <svg class="w-4 h-4 text-[#0077b5]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                    @endif
                </div>

            </div>
        </div>

        <!-- About Company Modal -->
        <div id="about-modal" 
             class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity"
             role="dialog" 
             aria-modal="true" 
             aria-labelledby="modal-company-title"
             onclick="handleBackdropClick(event)">
            
            <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[85vh] transition-transform">
                
                <!-- Modal Header -->
                <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                    <div class="min-w-0">
                        <h3 id="modal-company-title" class="text-base sm:text-lg font-bold text-slate-900 truncate">About {{ $company->name }}</h3>
                        <p class="text-xs text-slate-500 font-medium">Company Overview & Details</p>
                    </div>
                    <button type="button" 
                            onclick="closeAboutModal()" 
                            class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors flex-shrink-0 cursor-pointer"
                            aria-label="Close modal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 sm:p-8 overflow-y-auto space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed">
                    @if(!empty($company->description))
                        <div class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                            {!! nl2br(e(html_entity_decode($company->description))) !!}
                        </div>
                    @else
                        <p class="text-slate-500 text-sm italic">
                            No detailed description available for {{ $company->name }} yet.
                        </p>
                    @endif

                    @if($company->founded_year || $company->address)
                    <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-2 text-xs">
                        @if($company->founded_year)
                            <span class="bg-slate-100 text-slate-700 font-medium px-3 py-1 rounded-full">Founded: {{ $company->founded_year }}</span>
                        @endif
                        @if($company->address)
                            <span class="bg-slate-100 text-slate-700 font-medium px-3 py-1 rounded-full">HQ: {{ $company->address }}</span>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-blue-600 hover:underline flex items-center gap-1">
                                Visit Website ↗
                            </a>
                        @endif
                        @if($company->linkedin_url)
                            <a href="{{ $company->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-[#0077b5] hover:underline flex items-center gap-1">
                                LinkedIn Profile ↗
                            </a>
                        @endif
                    </div>
                    <button type="button" onclick="closeAboutModal()" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-xs cursor-pointer">
                        Close
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Filter Button -->
        <div class="lg:hidden mb-6">
            <button onclick="toggleFilters()" class="w-full flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-900 shadow-sm">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                    </svg>
                    Filter Openings
                </span>
                <svg class="w-5 h-5 transform transition-transform" id="filter-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-16">
            <!-- Sidebar Filters -->
            <aside id="filters-panel" class="hidden lg:block w-full lg:w-80 flex-shrink-0">
                <x-job-filters :categories="$categories" :showWorkType="true" :showCategories="false" />
            </aside>

            <!-- Main Content -->
            <div class="flex-grow min-w-0">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">
                        Showing {{ $jobs->total() }} {{ $jobs->total() === 1 ? 'Opening' : 'Openings' }} at {{ $company->name }}
                    </h2>
                    
                    <form method="GET" class="flex items-center gap-2">
                        @foreach(request()->except('sort') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="sort" onchange="this.form.submit()" class="text-xs font-bold text-gray-900 bg-transparent border-none outline-none cursor-pointer focus:ring-0">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>New to Old</option>
                            <option value="oldest" {{ request('sort', 'oldest') == 'oldest' ? 'selected' : '' }}>Old to New</option>
                            <option value="salary-desc" {{ request('sort') == 'salary-desc' ? 'selected' : '' }}>Salary: High to Low</option>
                            <option value="salary-asc" {{ request('sort') == 'salary-asc' ? 'selected' : '' }}>Salary: Low to High</option>
                        </select>
                    </form>
                </div>

                <!-- Job Cards List -->
                @if($jobs->count() > 0)
                <div class="border-t border-gray-100 mb-8">
                    @foreach($jobs as $job)
                        <x-job-card :job="$job" layout="row" />
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($jobs->hasPages())
                    <div class="flex justify-center">
                        {{ $jobs->appends(request()->query())->links() }}
                    </div>
                @endif
                @else
                <div class="py-20 text-center bg-gray-50/50 rounded-2xl border border-gray-100 p-8">
                    <div class="bg-gray-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No active openings matching your filter</h3>
                    <p class="text-gray-500 mt-2 text-sm">Adjust filters to explore other roles at {{ $company->name }}.</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

<script>
    function toggleFilters() {
        const panel = document.getElementById('filters-panel');
        const arrow = document.getElementById('filter-arrow');
        panel.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function openAboutModal() {
        const modal = document.getElementById('about-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeAboutModal() {
        const modal = document.getElementById('about-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    function handleBackdropClick(event) {
        if (event.target.id === 'about-modal') {
            closeAboutModal();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAboutModal();
        }
    });
</script>
@endsection