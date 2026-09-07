@extends('layouts.app')

@section('title', 'Inaquired | Discover your ambition')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-50 via-white to-indigo-50 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23e2e8f0\" fill-opacity=\"0.3\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"1.5\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-32">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm border border-indigo-100 rounded-full text-sm font-medium text-slate-700 mb-8 shadow-sm">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                <span>New opportunities added daily</span>
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-slate-900 font-unbounded leading-[1.1] mb-8">
                Discover work that<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">matches your spirit.</span>
            </h1>
            
            <p class="text-lg sm:text-xl text-slate-600 max-w-3xl mx-auto mb-12 leading-relaxed">
               No inflated titles. No misleading description. Just roles that align authentic source and real experience
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30 active:scale-95 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Browse Jobs</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 relative z-20 -mt-12 sm:-mt-20">
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 p-8 sm:p-10 fade-in" style="animation-delay: 0.3s;">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 font-unbounded text-center mb-8">
                Find roles that <span class="text-indigo-600">perfectly align </span>with your skills and goals.
            </h2>
            
            <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <input type="text" name="keyword" placeholder="Job title, roles or company" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium">
                </div>
                
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <input type="text" name="location" placeholder="City" class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium">
                </div>
                
                <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30 active:scale-95 transition-all duration-300 whitespace-nowrap flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Search</span>
                </button>
            </form>
        </div>
    </div>
</main>

<!-- Latest Jobs Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
        <div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 font-unbounded leading-tight">
                Latest <span class="text-indigo-600">Jobs</span>
            </h2>
            <p class="text-slate-500 font-medium mt-2">Fresh opportunities added daily — apply before they're gone.</p>
        </div>
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-700 transition-colors group whitespace-nowrap">
            <span>View all jobs</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    @if(isset($latestJobs) && $latestJobs->count() > 0)
        <div class="border-t border-gray-100">
            @foreach($latestJobs as $job)
                <x-job-card :job="$job" layout="row" />
            @endforeach
        </div>


    @else
        <div class="text-center py-16 text-slate-400">
            <p class="text-lg font-medium">No jobs available right now. Check back soon!</p>
        </div>
    @endif
</section>

<!-- Categories Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-20">
    <div class="grid lg:grid-cols-3 gap-16">
        <div class="col-span-1">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 font-unbounded leading-tight mb-6">
                Explore and find roles that align with your <span class="text-indigo-600">skills</span>
            </h2>
            <a href="{{ route('categories') }}" class="inline-flex items-center text-indigo-600 font-bold hover:text-indigo-700 transition-colors group">
                <span class="mr-2">View all categories</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="lg:col-span-2">
            <div class="flex flex-wrap gap-3">
                @if($categories && $categories->count() > 0)
                    @php $halfCount = ceil($categories->count() / 2); @endphp
                    @foreach($categories as $index => $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="px-6 py-3 border border-slate-300 rounded-full hover:bg-white hover:border-indigo-600 hover:shadow-md transition-all duration-300 font-medium text-slate-700 hover:text-slate-900 bg-slate-50 hover:scale-105 text-sm whitespace-nowrap {{ $index >= $halfCount ? 'hidden category-hidden' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                    @if($categories->count() > $halfCount)
                        <button onclick="showAllCategories()" id="showMoreBtn" class="px-6 py-3 rounded-full hover:bg-indigo-50 transition-all duration-300 font-medium text-indigo-600 hover:text-indigo-700 bg-white text-sm border border-indigo-600">
                            Show more >
                        </button>
                    @endif
                @else
                    <a href="{{ route('categories') }}" class="px-6 py-3 rounded-full hover:bg-indigo-50 transition-all duration-300 font-medium text-indigo-600 hover:text-indigo-700 bg-white text-sm border border-indigo-600">
                        View all
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

@if(isset($posts) && $posts->count() > 0)
<!-- From the Blog Section -->
<section class="max-w-7xl mx-auto px-6 py-24">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
        <div class="max-w-2xl">
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900">
                From the <span class="text-indigo-600">Blog</span>
            </h2>
            <p class="text-lg text-slate-600 mt-4 leading-relaxed">
                The latest career insights, hiring trends, and remote work stories curated by our editorial team.
            </p>
        </div>
        <a href="{{ route('blog') }}" class="hidden md:inline-flex items-center font-semibold text-indigo-600 hover:text-indigo-700 transition-colors group">
            View all posts
            <svg class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>

    @php $featuredPost = $posts->first(); @endphp
    <div class="featured-card relative overflow-hidden bg-white border border-slate-200 rounded-3xl p-8 md:p-12 shadow-sm hover:shadow-xl transition-all duration-500 mb-12 group cursor-pointer">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full -mr-20 -mt-20 blur-3xl opacity-50 transition-opacity group-hover:opacity-100"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center gap-12">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider rounded-full">Last Updated</span>
                    <span class="text-sm text-slate-400 font-medium">{{ $featuredPost->created_at->format('M d, Y') }}</span>
                </div>
                <h3 class="text-3xl md:text-5xl font-bold text-slate-900 leading-[1.15] mb-6">{{ $featuredPost->title }}</h3>
                <p class="text-lg text-slate-600 leading-relaxed max-w-2xl">
                    {{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 200) }}
                </p>
            </div>
            <div class="flex shrink-0">
                <div class="featured-arrow flex items-center justify-center w-20 h-20 md:w-28 md:h-28 rounded-full bg-indigo-600 text-white transition-all duration-300 shadow-lg shadow-indigo-600/20">
                    <svg class="h-8 w-8 md:h-12 md:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </div>
        </div>
        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="absolute inset-0 z-20"></a>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-16">
        @foreach($posts->skip(1)->take(4) as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="blog-card group flex flex-col justify-between bg-white border border-slate-200 p-8 rounded-3xl hover:border-indigo-200 hover:shadow-lg transition-all">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Article</span>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <span class="text-xs text-slate-400">{{ $post->created_at->format('M d, Y') }}</span>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors mb-4">{{ $post->title }}</h4>
                    <p class="text-slate-600 leading-relaxed line-clamp-3">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}
                    </p>
                </div>
                <div class="mt-8 flex items-center text-slate-900 font-bold group-hover:text-indigo-600 transition-colors">
                    Read article <span class="arrow-icon ml-2 transition-transform">→</span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="flex justify-center">
        <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white hover:bg-slate-50 text-indigo-600 font-bold rounded-2xl shadow-lg shadow-slate-200/50 hover:shadow-indigo-600/10 active:scale-95 transition-all duration-300 border border-indigo-100 group">
            <span>Explore More Articles</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
</section>
@endif

<script>
function showAllCategories() {
    document.querySelectorAll('.category-hidden').forEach(el => el.classList.remove('hidden'));
    document.getElementById('showMoreBtn').style.display = 'none';
}
</script>
@include('partials.trademark-disclaimer')
@endsection

@push('styles')
<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
</style>
@endpush
