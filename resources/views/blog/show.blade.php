@extends('layouts.blog')

@section('title', $pageSeo ? $pageSeo->meta_title : ($post->title . ' - Inaquired Blog'))
@section('meta_description', $pageSeo ? $pageSeo->meta_description : ($post->excerpt ?: 'Read ' . $post->title))
@section('meta_keywords', $pageSeo ? $pageSeo->meta_keywords : '')
@section('og_title', $pageSeo && $pageSeo->og_title ? $pageSeo->og_title : ($post->title . ' - Inaquired Blog'))
@section('og_description', $pageSeo && $pageSeo->og_description ? $pageSeo->og_description : ($post->excerpt ?: 'Read ' . $post->title))
@section('og_image', $pageSeo && $pageSeo->og_image ? media_url($pageSeo->og_image) : ($post->featured_image_url ?: ''))

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 lg:px-12 py-12">
        <!-- Back Button -->
        <div class="mb-8 max-w-7xl mx-auto">
            <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-indigo-600 transition-colors font-medium">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to Blog
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 max-w-7xl mx-auto">
            <!-- Left Column: Reading Section -->
            <div class="w-full lg:w-2/3 lg:max-w-3xl">
                <!-- Article Header -->
                <article class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 lg:p-12 mb-8">
                    <div>
                        <!-- Meta Information -->
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-600 bg-purple-50 px-3 py-1.5 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                {{ $post->read_time ?? '5' }} min read
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-900 mb-8 leading-tight font-unbounded">
                            {{ $post->title }}
                        </h1>

                        <!-- Featured Image -->
                        @if($post->featured_image_url)
                            <div class="mb-8 -mx-8 lg:-mx-12">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full max-h-[500px] object-cover" loading="eager">
                            </div>
                        @endif

                        <!-- Excerpt -->
                        @if($post->excerpt)
                            <div class="text-xl text-slate-600 leading-relaxed mb-8 pb-8 border-b border-slate-200 italic">
                                {{ $post->excerpt }}
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="prose prose-lg max-w-none" id="article-content">
                             {!! nl2br($post->content) !!}
                        </div>

                        <!-- Tags -->
                        @if($post->tags)
                            <div class="mt-12 pt-8 border-t border-slate-200">
                                <h3 class="text-xs font-bold text-slate-900 mb-4 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    Related Topics
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $tags = is_array($post->tags) ? $post->tags : explode(',', $post->tags ?? '');
                                    @endphp
                                    @foreach($tags as $tag)
                                        @if(trim($tag))
                                            <a href="{{ route('blog.tag', ['tag' => trim($tag)]) }}" 
                                               class="group inline-flex items-center gap-1.5 bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-600 hover:to-purple-600 text-indigo-700 hover:text-white text-sm font-semibold px-4 py-2 rounded-full border border-indigo-100 hover:border-transparent hover:shadow-md transition-all">
                                                <span class="text-indigo-400 group-hover:text-indigo-200 font-bold">#</span>
                                                <span>{{ trim($tag) }}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif


                    </div>
                </article>

            </div>

            <!-- Right Column: Sidebar -->
            <div class="hidden lg:block lg:w-1/3 lg:max-w-sm">
                <div class="sticky top-24 space-y-6">
                    <!-- Table of Contents -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h3 class="font-bold text-slate-900 mb-4 text-base flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            Table of Contents
                        </h3>
                        <nav id="toc-container" class="space-y-2">
                            <!-- JS injected links -->
                        </nav>
                    </div>

                    <!-- Author Card -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-sm border border-indigo-100 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div>
                                <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Author</p>
                                <p class="text-base font-bold text-slate-900">Inaquired</p>
                            </div>
                        </div>
                    </div>

                    <!-- More Articles -->
                    @if($relatedPosts && $relatedPosts->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            More Articles
                        </h4>
                        <div class="space-y-4">
                            @foreach($relatedPosts as $relatedPost)
                            <a href="{{ route('blog.show', $relatedPost->slug) }}" class="group block">
                                <div class="flex gap-3">
                                    @if($relatedPost->featured_image_url)
                                    <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-slate-100">
                                        <img src="{{ $relatedPost->featured_image_url }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" loading="lazy">
                                    </div>
                                    @else
                                    <div class="w-20 h-20 flex-shrink-0 rounded-lg bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2 mb-1">
                                            {{ $relatedPost->title }}
                                        </h5>
                                        <p class="text-xs text-slate-500">{{ $relatedPost->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="relative w-full pb-8" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-900 font-bold py-4 px-6 rounded-3xl transition-all shadow-sm">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                <span>Share this</span>
                            </span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 left-0 bg-white border border-slate-100 shadow-xl rounded-2xl p-4 mt-2 z-50" 
                             style="display: none;">
                            <div class="space-y-4">
                                <!-- Copy Link Button -->
                                <button onclick="copyToClipboard(this)" class="w-full flex items-center justify-center gap-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold py-3.5 rounded-xl transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                    <span class="button-text">Copy Link</span>
                                </button>
                                
                                <div class="border-t border-slate-100 my-2"></div>

                                <div class="flex flex-col gap-2 pt-2">
                                    <!-- Telegram -->
                                    <a href="https://t.me/share/url?url={{ rawurlencode(request()->url()) }}&text={{ rawurlencode($post->title) }}" 
                                       target="_blank" 
                                       class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border border-blue-200 transition-all group">
                                        <span class="flex items-center justify-center w-8 h-8 text-white rounded-lg shadow-sm group-hover:scale-110 transition-transform" style="background-color: #0088cc;">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-3.155 16.793l.892-4.223 7.641-6.848c.361-.318-.135-.558-.583-.244l-9.697 6.073-4.145-1.3c-.902-.279-.908-.888.196-1.32l16.279-6.302c.749-.283 1.411.177 1.167 1.397l-2.75 13.044c-.204.922-.738 1.144-1.503.714l-4.156-3.078-2.008 1.942c-.22.219-.405.405-.83.405l.298-4.26z"/></svg>
                                        </span>
                                        <span class="font-semibold text-sm" style="color: #0088cc;">Telegram</span>
                                    </a>

                                    <!-- WhatsApp -->
                                    <a href="https://wa.me/?text={{ rawurlencode($post->title . ' - ' . request()->url()) }}" 
                                       target="_blank" 
                                       class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 border border-green-200 transition-all group">
                                        <span class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-lg shadow-sm group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-0.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        </span>
                                        <span class="font-semibold text-sm text-green-700">WhatsApp</span>
                                    </a>

                                    <!-- Email -->
                                    <a href="mailto:?subject={{ rawurlencode($post->title) }}&body={{ rawurlencode(request()->url()) }}" 
                                       title="Share via Email" 
                                       class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-slate-50 to-slate-100 hover:from-slate-100 hover:to-slate-200 border border-slate-200 transition-all group">
                                        <span class="flex items-center justify-center w-8 h-8 text-white rounded-lg shadow-sm group-hover:scale-110 transition-transform" style="background-color: #475569;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </span>
                                        <span class="font-semibold text-sm" style="color: #475569;">Email</span>
                                    </a>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Table of Contents Generator
        const content = document.getElementById('article-content');
        const toc = document.getElementById('toc-container');
        
        if (content && toc) {
            const headers = content.querySelectorAll('h2');
            
            if (headers.length === 0) {
                toc.parentElement.style.display = 'none';
            } else {
                headers.forEach((header, index) => {
                    if (!header.id) {
                        header.id = 'section-' + (index + 1);
                    }
                    
                    const link = document.createElement('a');
                    link.href = '#' + header.id;
                    link.className = 'block text-sm text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all py-2 px-3 rounded-lg font-medium';
                    link.textContent = (index + 1) + '. ' + header.textContent;
                    
                    toc.appendChild(link);
                    
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        header.scrollIntoView({ behavior: 'smooth' });
                    });
                });
            }
        }
    });
</script>

<script>
function copyToClipboard(button) {
    let buttonTextEl = button ? button.querySelector('.button-text') : null;
    let originalText = buttonTextEl ? buttonTextEl.innerText : "";
    
    navigator.clipboard.writeText(window.location.href).then(function() {
        if(buttonTextEl) {
            buttonTextEl.innerText = "Link Copied!";
            button.classList.add('bg-green-50', 'text-green-600', 'border-green-200');
            button.classList.remove('bg-slate-50', 'text-slate-700', 'border-slate-200');
            setTimeout(() => {
                buttonTextEl.innerText = originalText;
                button.classList.remove('bg-green-50', 'text-green-600', 'border-green-200');
                button.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-200');
            }, 2000);
        } else {
            alert('Link copied to clipboard!');
        }
    });
}
</script>

@endsection