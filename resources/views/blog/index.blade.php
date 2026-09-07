@extends('layouts.blog')

@section('title', !empty($currentTag) ? 'Posts tagged with #' . $currentTag . ' - Inaquired' : 'Inaquired - Inaquired Central')

@push('styles')
<style>
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
             <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">inaquired</span> central
            </h1>
            <p class="text-lg md:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Access a comprehensive collection of guidance and resources for securing your dream job - interview tips, cover letter templates, insights into job market trends, and more!
            </p>
        </div>
    </header>

    @if(!empty($currentTag))
        <!-- Active Tag Filter Notification Banner -->
        <div class="max-w-7xl mx-auto px-4 mb-8">
            <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 flex flex-wrap items-center justify-between gap-4 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm font-semibold border border-indigo-100/80">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400">Filtered by topic</p>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">#{{ $currentTag }}</h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-medium text-slate-500 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200/70">
                        {{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}
                    </span>
                    <a href="{{ route('blog') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-indigo-600 bg-slate-50 hover:bg-slate-100 border border-slate-200 px-3.5 py-1.5 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Clear filter
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content: Articles -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @if($posts->count() > 0)
            
            @if(empty($currentTag) && $posts->currentPage() === 1)
                {{-- Standard View: Featured Hero Post + Grid (Page 1) --}}
                @php $featuredPost = $posts->first(); @endphp
                <div class="flex flex-col lg:flex-row gap-12 items-start mb-20">
                    <!-- Featured Image -->
                    <div class="w-full lg:w-1/2">
                        <div class="rounded-3xl overflow-hidden bg-slate-100 aspect-video relative group shadow-sm">
                            @if($featuredPost->featured_image_url)
                                 <img src="{{ $featuredPost->featured_image_url }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="eager">
                            @else
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
                        @if($featuredPost->tags)
                            @php
                                $fTags = is_array($featuredPost->tags) ? $featuredPost->tags : explode(',', $featuredPost->tags ?? '');
                            @endphp
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach(array_slice($fTags, 0, 3) as $ftag)
                                    @if(trim($ftag))
                                        <a href="{{ route('blog.tag', ['tag' => trim($ftag)]) }}" class="text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white px-3 py-1 rounded-full border border-indigo-100 transition-colors">
                                            #{{ trim($ftag) }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif

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

                <!-- Remaining Posts Grid -->
                @if($posts->count() > 1)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 auto-rows-fr mt-12">
                        @foreach($posts->skip(1) as $post)
                            <article class="flex">
                                <div class="group flex flex-col bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:border-indigo-100 transition-all duration-300 w-full">
                                     <a href="{{ route('blog.show', $post->slug) }}" class="block aspect-video bg-white relative overflow-hidden border-b border-slate-100 flex-shrink-0">
                                         @if($post->featured_image_url)
                                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                         @else
                                            <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                         @endif
                                     </a>
                                     
                                     <div class="p-6 flex flex-col flex-grow">
                                         <div class="flex items-center justify-between gap-2 mb-3">
                                             <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">{{ $post->category ?? 'Article' }}</span>
                                             <span class="text-xs text-slate-400">{{ $post->created_at->format('M d, Y') }}</span>
                                         </div>

                                         <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2" title="{{ $post->title }}">
                                             <a href="{{ route('blog.show', $post->slug) }}">
                                                 {{ $post->title }}
                                             </a>
                                         </h3>

                                         <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-4 flex-grow">
                                             {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                                         </p>

                                         <!-- Post Tags -->
                                         @if($post->tags)
                                             @php
                                                 $pTags = is_array($post->tags) ? $post->tags : explode(',', $post->tags ?? '');
                                             @endphp
                                             <div class="flex flex-wrap gap-1.5 mb-4">
                                                 @foreach(array_slice($pTags, 0, 3) as $ptag)
                                                     @if(trim($ptag))
                                                         <a href="{{ route('blog.tag', ['tag' => trim($ptag)]) }}" class="text-[11px] font-semibold text-slate-600 bg-slate-100 hover:bg-indigo-600 hover:text-white px-2.5 py-1 rounded-md transition-colors">
                                                             #{{ trim($ptag) }}
                                                         </a>
                                                     @endif
                                                 @endforeach
                                             </div>
                                         @endif

                                         <a href="{{ route('blog.show', $post->slug) }}" class="flex items-center text-indigo-600 font-bold text-sm group-hover:gap-2 transition-all mt-auto pt-2 border-t border-slate-50">
                                             Read article <span class="ml-1">→</span>
                                         </a>
                                     </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

            @else
                {{-- Grid View for Page 2+ or Filtered Tag Results --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 auto-rows-fr">
                    @foreach($posts as $post)
                        <article class="flex">
                            <div class="group flex flex-col bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:border-indigo-100 transition-all duration-300 w-full">
                                 <a href="{{ route('blog.show', $post->slug) }}" class="block aspect-video bg-white relative overflow-hidden border-b border-slate-100 flex-shrink-0">
                                     @if($post->featured_image_url)
                                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                     @else
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                     @endif
                                 </a>
                                 
                                 <div class="p-6 flex flex-col flex-grow">
                                     <div class="flex items-center justify-between gap-2 mb-3">
                                         <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">{{ $post->category ?? 'Article' }}</span>
                                         <span class="text-xs text-slate-400">{{ $post->created_at->format('M d, Y') }}</span>
                                     </div>

                                     <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2" title="{{ $post->title }}">
                                         <a href="{{ route('blog.show', $post->slug) }}">
                                             {{ $post->title }}
                                         </a>
                                     </h3>

                                     <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-4 flex-grow">
                                         {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                                     </p>

                                     <!-- Post Tags -->
                                     @if($post->tags)
                                         @php
                                             $pTags = is_array($post->tags) ? $post->tags : explode(',', $post->tags ?? '');
                                         @endphp
                                         <div class="flex flex-wrap gap-1.5 mb-4">
                                             @foreach(array_slice($pTags, 0, 3) as $ptag)
                                                 @if(trim($ptag))
                                                     <a href="{{ route('blog.tag', ['tag' => trim($ptag)]) }}" class="text-[11px] font-semibold {{ !empty($currentTag) && strtolower(trim($ptag)) === strtolower($currentTag) ? 'bg-indigo-600 text-white' : 'text-slate-600 bg-slate-100 hover:bg-indigo-600 hover:text-white' }} px-2.5 py-1 rounded-md transition-colors">
                                                         #{{ trim($ptag) }}
                                                     </a>
                                                 @endif
                                             @endforeach
                                         </div>
                                     @endif

                                     <a href="{{ route('blog.show', $post->slug) }}" class="flex items-center text-indigo-600 font-bold text-sm group-hover:gap-2 transition-all mt-auto pt-2 border-t border-slate-50">
                                         Read article <span class="ml-1">→</span>
                                     </a>
                                 </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            @if($posts->hasPages())
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-10 border-t border-slate-100">
                    <p class="text-sm text-slate-500 font-medium">
                        Showing page <span class="font-bold text-slate-800">{{ $posts->currentPage() }}</span> of <span class="font-bold text-slate-800">{{ $posts->lastPage() }}</span> (<span class="font-bold text-slate-800">{{ $posts->total() }}</span> total articles)
                    </p>
                    <div>
                        {{ $posts->links() }}
                    </div>
                </div>
            @endif

        @else
            <div class="text-center py-20 bg-white rounded-2xl border border-slate-100 max-w-xl mx-auto p-8 shadow-xs">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-3 text-lg font-bold">
                    #
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1.5">No articles found</h3>
                <p class="text-sm text-slate-500 mb-6">
                    @if(!empty($currentTag))
                        There are currently no published articles tagged with <strong class="text-slate-800">#{{ $currentTag }}</strong>.
                    @else
                        There are no published articles yet. Check back soon!
                    @endif
                </p>
                @if(!empty($currentTag))
                    <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white font-semibold text-xs hover:bg-indigo-700 transition-colors shadow-xs">
                        View All Articles
                    </a>
                @endif
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
