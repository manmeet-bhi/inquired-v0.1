@extends('layouts.app')

@section('title', 'Job Categories - Browse Jobs by Category')

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
/* Custom Scrollbar for Categories */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
@endpush

@section('content')
<div class="bg-white">


    <main class="max-w-7xl mx-auto px-6 py-12">


        <div class="w-full">
            <!-- Results -->
            <div class="w-full">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">
                        @if($categories->total() > 0)
                            Showing {{ $categories->firstItem() ?? 0 }}-{{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} Categories
                        @else
                            No Categories Found
                        @endif
                    </h2>
                    
                    @if(request()->has('categories'))
                        <a href="{{ route('categories') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1 rounded-full transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Clear Filters
                        </a>
                    @endif
                </div>

                @if($categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="block bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-lg hover:border-blue-200 transition-all duration-300 group relative overflow-hidden h-full">
                            <!-- Category Header -->
                            <div class="flex items-center space-x-4">
                                @if($category->icon_file)
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl flex items-center justify-center p-2.5 border border-gray-100 group-hover:border-blue-100 transition-colors">
                                            <img src="{{ asset('assets/icons/categories/' . $category->icon_file) }}" alt="{{ $category->name }}" class="w-full h-full object-contain">
                                        </div>
                                    </div>
                                @elseif($category->icon)
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl flex items-center justify-center text-xl border border-gray-100 group-hover:border-blue-100 transition-colors">
                                            {!! $category->icon !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl flex items-center justify-center border border-gray-100 group-hover:border-blue-100 transition-colors">
                                            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors leading-tight truncate">{{ $category->name }}</h3>
                                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg mt-1 inline-block">
                                        {{ $category->jobs_count }} Jobs
                                    </span>
                                </div>
                                <div class="flex-shrink-0 text-gray-300 group-hover:text-blue-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
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
                <div class="py-20 text-center">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No categories found</h3>
                    <p class="text-gray-500">Try adjusting your filters to find more categories.</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>
</div>

@endsection

@push('scripts')
<script>
// Filters were removed from this page

</script>
@endpush