@extends('layouts.app')

@section('title', $company->name . ' Jobs - Career Opportunities & Openings')

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        <!-- Company Profile Header Card -->
        <div class="bg-gradient-to-br from-slate-50 via-white to-blue-50/40 rounded-3xl border border-slate-100 p-6 sm:p-8 lg:p-10 mb-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                
                <div class="flex flex-col sm:flex-row items-start gap-5 flex-1 min-w-0">
                    {{-- Logo --}}
                    @php
                        $firstAlphabet = strtoupper(substr($company->name ?? 'C', 0, 1));
                    @endphp
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl border border-slate-200 bg-white flex items-center justify-center overflow-hidden shadow-sm flex-shrink-0">
                        @if($company->logo_url)
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" loading="eager">
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-2xl uppercase" style="display:none;">
                                {{ $firstAlphabet }}
                            </div>
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-2xl uppercase">
                                {{ $firstAlphabet }}
                            </div>
                        @endif
                    </div>

                    {{-- Company Information --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2.5 mb-2">
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight break-words">{{ $company->name }}</h1>
                            @if($company->type)
                                <span class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-50 border border-blue-200/80 px-2.5 py-1 rounded-full">
                                    {{ ucfirst($company->type) }}
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs sm:text-sm text-slate-600 mb-4">
                            @if($company->industry)
                                <span class="inline-flex items-center gap-1.5 font-medium text-slate-700 bg-slate-100 px-3 py-1 rounded-lg">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $company->industry }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $jobs->total() }} {{ $jobs->total() === 1 ? 'Open Position' : 'Open Positions' }}
                            </span>
                        </div>

                        @if($company->description)
                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-4xl break-words">
                                {{ $company->description }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Action / Links --}}
                <div class="flex flex-wrap sm:flex-nowrap md:flex-col items-stretch gap-2.5 flex-shrink-0">
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm hover:border-blue-200 hover:text-blue-600 hover:bg-blue-50/50 shadow-xs transition-all">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m-9 9a9 9 0 019-9"></path></svg>
                            <span>Website</span>
                        </a>
                    @endif
                    @if($company->linkedin_url)
                        <a href="{{ $company->linkedin_url }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm hover:border-[#0077b5]/30 hover:text-[#0077b5] hover:bg-blue-50/50 shadow-xs transition-all">
                            <svg class="w-4 h-4 text-[#0077b5]" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            <span>LinkedIn</span>
                        </a>
                    @endif
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
</script>
@endsection