@extends('layouts.app')

@section('title', 'Fresher Jobs - Find Entry Level Opportunities')

@section('content')
<div class="bg-white">


    <main class="max-w-7xl mx-auto px-6 py-12">
        <!-- Mobile Filter Button -->
        <div class="lg:hidden mb-6">
            <button onclick="toggleFilters()" class="w-full flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-900">
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
                <x-job-filters :categories="$categories" />
            </aside>

        <!-- Main Content -->
        <div class="flex-grow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Fresher Jobs - {{ $jobs->total() }} Verified Vacancies</h2>
                <form method="GET" class="flex items-center gap-2">
                    @foreach(request()->except('sort') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="sort" onchange="this.form.submit()" class="text-xs font-bold text-gray-900 bg-transparent border-none outline-none cursor-pointer">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>New to Old</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Old to New</option>
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
                    {{ $jobs->links() }}
                </div>
            @endif
            @else
            <div class="py-20 text-center">
                <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">No fresher jobs found</h3>
                <p class="text-gray-500">Try adjusting your filters to find more opportunities.</p>
            </div>
            @endif
        </div>
    </main>
</div>


@endsection
