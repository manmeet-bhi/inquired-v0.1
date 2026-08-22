@extends('layouts.blog')

@section('title', 'Anywhereroles - Anywhereroles Central')

@push('styles')
<style>
    <link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
    body {
        font-family: 'Inter', sans-serif;
    }
</style>
@endpush

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp
    <!-- Hero Header -->
    <header class="py-16 md:py-24 px-4 bg-white">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-[#0F172A] mb-6 lowercase font-unbounded">
             <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">Anywhereroles</span> central
            </h1>
            <p class="text-lg md:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Access a comprehensive collection of guidance and resources for securing your dream job - interview tips, cover letter templates, insights into job market trends, and more!
            </p>
        </div>
    </header>

    <!-- Main Content: Featured Article -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        @if($posts->count() > 0)
            @php $featuredPost = $posts->first(); @endphp
            <div class="flex flex-col lg:flex-row gap-12 items-start mb-20">
                <!-- Featured Image -->
                <div class="w-full lg:w-1/2">
                    <div class="rounded-3xl overflow-hidden bg-slate-100 aspect-video relative group">
                        @if($featuredPost->featured_image_url)
                             <img src="{{ $featuredPost->featured_image_url }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="eager">
                        @else
                            <!-- SVG illustration placeholder -->
                            <div class="absolute inset-0 flex items-center justify-center p-8 bg-gradient-to-br from-blue-100 to-indigo-200">
                                <div class="relative w-full h-full flex items-center justify-center">
                                    <div class="w-24 h-32 bg-white shadow-lg rounded transform -rotate-12 absolute left-10 border-t-4 border-red-500 p-2">
                                        <div class="h-1 w-8 bg-slate-200 mb-1"></div>
                                        <div class="h-1 w-12 bg-slate-100"></div>
                                        <div class="mt-4 border border-red-500 text-[8px] text-red-500 font-bold text-center py-0.5">REJECTED</div>
                                    </div>
                                    <div class="w-24 h-32 bg-white shadow-xl rounded z-10 border-t-4 border-green-500 p-2">
                                        <div class="h-1 w-8 bg-slate-200 mb-1"></div>
                                        <div class="h-1 w-12 bg-slate-100"></div>
                                        <div class="mt-4 border border-green-500 text-[8px] text-green-500 font-bold text-center py-0.5">APPROVED</div>
                                    </div>
                                    <div class="w-24 h-32 bg-white shadow-lg rounded transform rotate-12 absolute right-10 border-t-4 border-red-500 p-2">
                                        <div class="h-1 w-8 bg-slate-200 mb-1"></div>
                                        <div class="h-1 w-12 bg-slate-100"></div>
                                        <div class="mt-4 border border-red-500 text-[8px] text-red-500 font-bold text-center py-0.5">REJECTED</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="w-full lg:w-1/2">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-[#0F172A] leading-tight mb-6">
                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="hover:text-indigo-600 transition-colors">
                            {{ $featuredPost->title }}
                        </a>
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-8 italic">
                        "{{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 150) }}"
                    </p>
                    <a href="{{ route('blog.show', $featuredPost->slug) }}" class="text-[#1E40AF] font-bold hover:underline flex items-center gap-2 text-lg">
                        Read More 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Other Posts Grid -->
            @if($posts->count() > 1)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 auto-rows-fr mt-12">
                @foreach($posts->skip(1) as $post)
                    <article class="flex">
                        <a href="{{ route('blog.show', $post->slug) }}" class="group flex flex-col bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:border-indigo-100 transition-all duration-300 w-full">
                             <div class="aspect-video bg-white relative overflow-hidden border-b border-slate-100 flex-shrink-0">
                                 @if($post->featured_image_url)
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                 @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                 @endif
                             </div>
                             <div class="p-6 flex flex-col flex-grow">
                                 <div class="flex items-center gap-2 mb-3">
                                     <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">{{Str::limit($post->category ?? 'Article', 20)}}</span>
                                     <span class="text-slate-300">•</span>
                                     <span class="text-xs text-slate-500">{{ $post->created_at->format('M d, Y') }}</span>
                                 </div>
                                 <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2" title="{{ $post->title }}">
                                     {{ $post->title }}
                                 </h3>
                                 <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-4 flex-grow">
                                     {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                                 </p>
                                 <div class="flex items-center text-indigo-600 font-bold text-sm group-hover:gap-2 transition-all">
                                     Read article <span class="ml-1">→</span>
                                 </div>
                             </div>
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $posts->links() }}
            </div>
            @endif

        @else
            <div class="text-center py-20">
                <p class="text-xl text-slate-500">No articles found.</p>
            </div>
        @endif
    </main>

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 z-50">
        <a href="{{ route('jobs.index') }}" class="bg-[#065F46] text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 hover:scale-105 transition-transform duration-200 hover:bg-[#054d38]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012-2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
            </svg>
            <span class="font-semibold text-sm">Looking for a job?</span>
        </a>
    </div>
@endsection
