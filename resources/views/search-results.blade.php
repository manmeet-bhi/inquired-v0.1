@extends('layouts.app')

@section('title', 'Search Jobs - Inaquired')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <header class="pt-16 pb-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Search Form -->
            <form method="GET" action="{{ route('search') }}" class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-4 justify-center">
                    <div class="flex-1 relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <input type="text" name="keyword" value="{{ $query }}" placeholder="Job title, keywords, or company" 
                               class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium">
                    </div>
                    <div class="flex-1 relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <input type="text" name="location" value="{{ $location }}" placeholder="City, country, or 'Remote'" 
                               class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium">
                    </div>
                    <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30 active:scale-95 transition-all duration-300 whitespace-nowrap flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Search Jobs</span>
                    </button>
                </div>
            </form>
            
            @if($query || $location)
                <p class="mt-4 text-gray-500 font-medium">
                    Found {{ number_format($totalResults) }} {{ Str::plural('result', $totalResults) }}
                    @if($query) for <span class="text-gray-900 font-bold">"{{ $query }}"</span> @endif
                    @if($location) in <span class="text-gray-900 font-bold">"{{ $location }}"</span> @endif
                </p>
            @endif
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <!-- Mobile Filter Button -->
        <div class="lg:hidden mb-6">
            <button onclick="toggleFilters()" class="w-full flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-900 shadow-sm">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                    </svg>
                    Filters
                </span>
                <svg class="w-5 h-5 transform transition-transform" id="filter-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-16">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-80">
                 <x-job-filters :categories="$allCategories" :showWorkType="true" />
            </aside>

            <!-- Results -->
            <div class="flex-grow">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">
                        @if($totalResults > 0)
                            Showing {{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }} of {{ $totalResults }} Jobs
                        @else
                            No Jobs Found
                        @endif
                    </h2>
                    <form method="GET" class="flex items-center gap-2">
                        @foreach(request()->except('sort_by') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="sort_by" onchange="this.form.submit()" class="text-xs font-bold text-gray-900 bg-transparent border-none outline-none cursor-pointer focus:ring-0">
                            <option value="relevant" {{ request('sort_by', 'relevant') === 'relevant' ? 'selected' : '' }}>Most Relevant</option>
                            <option value="date_new" {{ request('sort_by') === 'date_new' ? 'selected' : '' }}>New to Old</option>
                            <option value="date_old" {{ request('sort_by') === 'date_old' ? 'selected' : '' }}>Old to New</option>
                            <option value="salary_high" {{ request('sort_by') === 'salary_high' ? 'selected' : '' }}>Salary: High to Low</option>
                            <option value="salary_low" {{ request('sort_by') === 'salary_low' ? 'selected' : '' }}>Salary: Low to High</option>
                        </select>
                    </form>
                </div>

                @if($jobs && $jobs->count() > 0)
                    <div class="border-t border-gray-100 mb-8">
                        @foreach($jobs as $job)
                            <x-job-card :job="$job" layout="row" :type="$job->work_type ?? ($job->type === 'internship' ? 'internship' : 'job')" />
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($jobs->hasPages())
                        <div class="flex justify-center">
                            {{ $jobs->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Results -->
                    <div class="py-20 text-center">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No jobs found</h3>
                        <p class="text-gray-500 mb-6 text-sm">We couldn't find any jobs matching your search.</p>
                        <a href="{{ route('search') }}" class="inline-block px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition-colors text-sm">
                            Clear Search
                        </a>
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
    
    if (panel.classList.contains('hidden')) {
        panel.classList.remove('hidden');
        panel.classList.add('block');
        arrow.style.transform = 'rotate(180deg)';
    } else {
        panel.classList.add('hidden');
        panel.classList.remove('block');
        arrow.style.transform = 'rotate(0deg)';
    }
}

function clearAllFilters() {
    // Just redirect to the base search route to clear everything, 
    // OR keep the 'q' and 'location' and clear others.
    // Let's keep q and location.
    const url = new URL(window.location);
    const params = new URLSearchParams();
    
    if (url.searchParams.get('keyword')) params.set('keyword', url.searchParams.get('keyword'));
    if (url.searchParams.get('location')) params.set('location', url.searchParams.get('location'));
    
    window.location.search = params.toString();
}

document.addEventListener('DOMContentLoaded', function() {
    const categorySearch = document.getElementById('category-search');
    const categoryItems = document.querySelectorAll('.category-item');
    const showMoreBtn = document.getElementById('show-more-categories');
    
    // Search functionality for categories
    if(categorySearch) {
        categorySearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            categoryItems.forEach(item => {
                const label = item.querySelector('span').textContent.toLowerCase();
                if(label.includes(searchTerm)) {
                    item.classList.remove('hidden-by-search');
                    item.style.display = 'flex';
                } else {
                    item.classList.add('hidden-by-search');
                    item.style.display = 'none';
                }
            });

            if(searchTerm.length > 0) {
                if(showMoreBtn) showMoreBtn.style.display = 'none';
            } else {
                // Reset view
                categoryItems.forEach((item, index) => {
                    item.classList.remove('hidden-by-search');
                    if(index < 7) {
                        item.style.display = 'flex';
                        item.classList.remove('hidden');
                    } else {
                        if(showMoreBtn && showMoreBtn.textContent.includes('Show More')) {
                            item.style.display = 'none';
                            item.classList.add('hidden');
                        } else {
                            item.style.display = 'flex';
                        }
                    }
                });
                if(showMoreBtn) showMoreBtn.style.display = 'block';
            }
        });
    }

    // Show More functionality
    if(showMoreBtn) {
        showMoreBtn.addEventListener('click', function() {
            const isShowingMore = this.textContent.includes('Show Less');
            
            if(!isShowingMore) {
                categoryItems.forEach(item => {
                    item.classList.remove('hidden');
                    item.style.display = 'flex';
                });
                this.textContent = '- Show Less';
            } else {
                categoryItems.forEach((item, index) => {
                    if(index >= 7) {
                        item.classList.add('hidden');
                        item.style.display = 'none';
                    }
                });
                this.textContent = '+ {{ isset($allCategories) ? $allCategories->count() - 7 : 0 }} More';
            }
        });
    }
});
</script>
@include('partials.trademark-disclaimer')
@endsection