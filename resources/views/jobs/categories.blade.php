@extends('layouts.app')

@section('title', 'Job Categories - Browse Jobs by Industry & Category | Inaquired')
@section('meta_description', 'Explore career opportunities across 24+ high-demand industry categories. Find remote, hybrid, and onsite roles matching your specialty.')

@push('styles')
<link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
<link href="{{ asset('assets/fonts/unbounded.css') }}" rel="stylesheet">
<style>
.brand-font {
    font-family: 'Unbounded', 'Inter', sans-serif;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hover-lift {
    transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.28s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.28s ease;
}
.hover-lift:hover {
    transform: translateY(-4px);
}
.gradient-text-blue {
    background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
@endpush

@section('content')
<div class="bg-slate-50/50 min-h-[70vh]">

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">

        <!-- Header Hero Section -->
        <div class="text-center max-w-3xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50/80 border border-blue-100 mb-4 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-700">Explore Verticals</span>
            </div>

            <h1 class="brand-font text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                Browse Jobs by <br class="hidden sm:inline"/>
                <span class="gradient-text-blue">Industry Category</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto mb-8">
                Discover your next career move across curated job disciplines, emerging technologies, and business domains.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('categories') }}" method="GET" class="max-w-xl mx-auto">
                <div class="relative flex items-center shadow-md shadow-slate-200/50 rounded-2xl bg-white border border-slate-200/90 focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-100 transition-all">
                    <div class="pl-4 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories (e.g. AI, DevOps, Design, Sales)..." class="w-full py-3.5 pl-3 pr-24 text-sm sm:text-base font-medium text-slate-800 bg-transparent rounded-2xl focus:outline-none placeholder-slate-400">
                    
                    @if(request('search'))
                    <a href="{{ route('categories') }}" class="mr-2 text-xs font-bold text-slate-400 hover:text-slate-600 p-1">
                        Clear
                    </a>
                    @endif

                    <button type="submit" class="mr-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-xl transition-colors shadow-sm">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <div class="w-full">
            <!-- Results Bar -->
            <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-200/80">
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                    @if($categories->total() > 0)
                        Showing {{ $categories->firstItem() ?? 0 }}-{{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} Categories
                    @else
                        No Categories Found
                    @endif
                </h2>
                
                @if(request()->has('search'))
                    <a href="{{ route('categories') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1 rounded-full transition-colors flex items-center gap-1 border border-blue-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Clear Filters
                    </a>
                @endif
            </div>

            @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="group block bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 hover-lift hover:border-blue-300 hover:shadow-xl hover:shadow-blue-500/5 transition-all relative overflow-hidden h-full flex flex-col justify-between">
                        <!-- Top Accent Shimmer Line -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-blue-500/0 to-transparent group-hover:via-blue-500 transition-all duration-500"></div>

                        <div>
                            <!-- Category Header -->
                            <div class="flex items-start justify-between gap-4 mb-4">
                                @if($category->icon_file)
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center p-2.5 border border-slate-100 group-hover:border-blue-200 transition-transform group-hover:scale-110 duration-300">
                                        <img src="{{ $category->icon_url ?? asset('assets/icons/categories/' . $category->icon_file) }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                                    </div>
                                @elseif($category->icon)
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center p-3 border border-slate-100 group-hover:border-blue-200 transition-transform group-hover:scale-110 duration-300">
                                        {!! $category->icon !!}
                                    </div>
                                @else
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:border-blue-200 transition-transform group-hover:scale-110 duration-300">
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                @endif

                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-blue-50 text-blue-700 border border-blue-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                    {{ $category->jobs_count }} {{ Str::plural('Job', $category->jobs_count) }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-2 leading-snug">
                                {{ $category->name }}
                            </h3>

                            @if($category->description)
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-4">
                                {{ $category->description }}
                            </p>
                            @endif
                        </div>

                        <!-- Card Action Footer -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-500 group-hover:text-blue-600 transition-colors">
                            <span>Explore Opportunities</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($categories->hasPages())
                <div class="flex justify-center mt-12">
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            @endif
            @else
            <div class="py-20 text-center bg-white rounded-3xl border border-slate-200 p-8">
                <div class="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-2xl">
                    🔍
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">No categories found</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mb-6">Try searching with different keywords or clear your active search query.</p>
                <a href="{{ route('categories') }}" class="inline-flex px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-colors">
                    View All Categories
                </a>
            </div>
            @endif
        </div>
    </main>
</div>
@endsection