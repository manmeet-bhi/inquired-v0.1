@extends('layouts.app')

@section('title', 'Job Categories - Browse Jobs by Category | Inaquired')
@section('meta_description', 'Browse jobs by category. Find opportunities across technology, design, business, and more.')

@push('styles')
<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush

@section('content')
<div class="bg-white min-h-[70vh]">

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

        <div class="w-full">
            <!-- Header & Results Count -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Job Categories</h1>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mt-1">
                        @if($categories->total() > 0)
                            Showing {{ $categories->firstItem() ?? 0 }}-{{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} Categories
                        @else
                            No Categories Found
                        @endif
                    </p>
                </div>
                
                @if(request()->has('search'))
                    <a href="{{ route('categories') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg transition-colors inline-flex items-center gap-1 self-start sm:self-auto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Clear Search
                    </a>
                @endif
            </div>

            @if($categories->count() > 0)
            <!-- Design 5: Compact Dense 4-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="block bg-white rounded-xl border border-gray-200 p-4 hover:border-blue-400 hover:shadow-xs transition-all group">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <div class="flex items-center gap-2.5 min-w-0">
                                @if($category->icon_file)
                                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center p-1.5 border border-blue-100 flex-shrink-0">
                                        <img src="{{ $category->icon_url ?? asset('assets/icons/categories/' . $category->icon_file) }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                                    </div>
                                @elseif($category->icon)
                                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center p-1.5 border border-blue-100 flex-shrink-0 [&_svg]:w-4 [&_svg]:h-4">
                                        {!! $category->icon !!}
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-100 flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="text-xs font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ $category->name }}</h3>
                            </div>
                            <span class="text-[11px] font-semibold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded whitespace-nowrap">{{ $category->jobs_count }}</span>
                        </div>

                        @if($category->description)
                        <p class="text-[11px] text-gray-500 line-clamp-1 mt-1">{{ $category->description }}</p>
                        @endif
                    </a>
                @endforeach
            </div>

            @if($categories->hasPages())
                <div class="flex justify-center mt-10">
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            @endif
            @else
            <div class="py-16 text-center">
                <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">No categories found</h3>
                <p class="text-xs text-gray-500 mt-1">Try searching for other terms or clear your search query.</p>
                <a href="{{ route('categories') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-colors">
                    View All Categories
                </a>
            </div>
            @endif
        </div>
    </main>
</div>
@endsection