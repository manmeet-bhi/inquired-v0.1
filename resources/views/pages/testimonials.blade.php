@extends('layouts.app')

@section('title', 'User Success Stories | Inaquired')
@section('meta_description', 'Read success stories from professionals who found their dream jobs through Inaquired. Real testimonials from our community.')

@push('styles')
<link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
<style>
    .testimonial-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    /* Decorative Quote Background */
    .quote-icon {
        position: absolute;
        top: -10px;
        right: 20px;
        font-size: 120px;
        color: rgba(59, 130, 246, 0.08);
        font-family: serif;
        pointer-events: none;
        line-height: 1;
    }

    .slide-container {
        display: none;
    }
    .slide-container.active {
        display: block;
        animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .gradient-text {
        background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endpush

@section('content')
<div class="bg-white min-h-[60vh]">
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-6 mt-6">
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-6 py-12">
        
        {{-- ONLY SHOW FEATURED SPOTLIGHT & SHARE YOUR STORY ON PAGE 1 --}}
        @if($testimonials->currentPage() === 1)
        <div class="bg-white rounded-2xl border border-gray-100 p-8 overflow-hidden mb-16">
            
            <!-- User Provided Design Inside Standard Container -->
            <div class="flex flex-col lg:flex-row text-slate-900">
        
                <!-- LEFT SIDE: Testimonial Slider (60% width on desktop) -->
                <div class="w-full lg:w-3/5 lg:pr-12 flex flex-col justify-center relative mb-16 lg:mb-0">
                    <!-- Decorative background element -->
                    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-30 -translate-x-1/2 -translate-y-1/2"></div>
                    
                    <div class="relative z-10">
                        <header class="mb-16">
                            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 border border-blue-100 mb-6">
                                <span class="flex h-2 w-2 rounded-full bg-blue-600 mr-2 animate-pulse"></span>
                                <span class="text-blue-700 text-xs font-bold tracking-widest uppercase">Community Stories</span>
                            </div>
                            <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                Real Stories from <br/>
                                <span class="gradient-text">Real Professionals</span>
                            </h2>
                        </header>
        
                        <div class="relative min-h-[320px] lg:min-h-[400px]">
                            @forelse($topTestimonials as $index => $testimonial)
                            <div class="slide-container {{ $index === 0 ? 'active' : '' }}">
                                <div class="testimonial-card p-6 lg:p-14 bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100">
                                    <div class="quote-icon">“</div>
                                    @php
                                        $isLong = strlen($testimonial->message) > 150;
                                    @endphp
                                    <div class="mb-10 relative">
                                        <p class="text-slate-700 text-xl lg:text-3xl leading-relaxed font-medium transition-all duration-300 {{ $isLong ? 'line-clamp-3' : '' }}">
                                            "{{ $testimonial->message }}"
                                        </p>
                                        @if($isLong)
                                        <button onclick="toggleTestimonial(this)" class="text-blue-600 text-base font-bold mt-3 hover:text-blue-800 transition-colors">Show More</button>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-lg lg:text-xl tracking-tight">{{ $testimonial->name }}</h4>
                                        <p class="text-blue-600 font-semibold text-xs lg:text-sm uppercase tracking-wider">{{ $testimonial->role_company }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="slide-container active">
                                <div class="testimonial-card p-6 lg:p-14 bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100">
                                    <div class="quote-icon">“</div>
                                    <p class="text-slate-700 text-xl lg:text-3xl leading-relaxed mb-10 font-medium">
                                        No testimonials yet. Be the first to share your success story!
                                    </p>
                                </div>
                            </div>
                            @endforelse

                            <!-- Navigation Controls -->
                            <div class="flex items-center space-x-4 lg:space-x-6 mt-8 lg:mt-12">
                                <button onclick="prevSlide()" class="p-3 lg:p-4 rounded-2xl bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 transition-all shadow-sm active:scale-95" aria-label="Previous slide">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <div class="flex space-x-2 lg:space-x-3" id="dots-container"></div>
                                <button onclick="nextSlide()" class="p-3 lg:p-4 rounded-2xl bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 transition-all shadow-sm active:scale-95" aria-label="Next slide">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- RIGHT SIDE: Submission Form -->
                <div class="w-full lg:w-2/5 p-6 lg:p-12 bg-slate-50 lg:border-l border-slate-200 flex flex-col justify-start relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Share Your Story</h3>
                        <p class="text-slate-600 mb-8 leading-relaxed">
                            How has Inaquired helped your career? We'd love to hear from you! Sharing your journey helps inspire others in the community to find their dream roles.
                        </p>

                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                            <i data-lucide="message-square-heart" class="w-12 h-12 text-blue-500 mx-auto mb-4"></i>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Tell us about your experience</h4>
                            <p class="text-sm text-slate-500 mb-6">Click the button below to easily submit your success story via our secure Google Form.</p>
                            
                            <a href="https://docs.google.com/forms/d/e/1FAIpQLScnO6c0UuhC9dadeDGaB00ZDi9VLCxGrfQ-YEEB_hh5-6Dybg/viewform?usp=publish-editor" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 active:scale-95 group">
                                Share My Story
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
        
            </div>
            
        </div>
        @else
        <div class="text-center mb-10 pt-4">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-3">Community Stories</h1>
            <p class="text-slate-500 max-w-2xl mx-auto">Page {{ $testimonials->currentPage() }} &bull; Explore genuine feedback and success stories from Inaquired members.</p>
        </div>
        @endif

        <!-- All Testimonials Grid -->
        @if($testimonials->count() > 0)
        <div class="{{ $testimonials->currentPage() === 1 ? 'mt-0' : 'mt-4' }}">
            @if($testimonials->currentPage() === 1)
            <div class="text-center mb-10">
                <h3 class="text-3xl font-bold text-slate-900 mb-3">More Community Stories</h3>
                <p class="text-slate-500 max-w-2xl mx-auto">Explore what other professionals have experienced with Inaquired.</p>
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($testimonials as $index => $item)
                @php
                    $words = explode(' ', strip_tags($item->message));
                    $preview = implode(' ', array_slice($words, 0, 50));
                    $isTruncated = count($words) > 50;
                @endphp
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-100 transition-all cursor-pointer group"
                     onclick="openStoryModal({{ $index }})">
                    <div class="text-blue-500/10 group-hover:text-blue-500/20 transition-colors mb-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
                    </div>
                    <p class="text-slate-600 leading-relaxed text-sm mb-4">
                        "{{ $preview }}{{ $isTruncated ? '...' : '' }}"
                    </p>
                    <div class="border-t border-slate-100 pt-4">
                        <h4 class="font-bold text-slate-900 text-sm leading-tight">{{ $item->name }}</h4>
                        <p class="text-blue-600 text-xs font-semibold uppercase tracking-wider mt-0.5">{{ $item->role_company ?? 'Professional' }}</p>
                    </div>
                    @if($isTruncated)
                    <p class="text-blue-600 text-xs font-semibold mt-3 group-hover:underline">Read full story →</p>
                    @endif
                </div>
                @endforeach
            </div>
            
            @if($testimonials->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $testimonials->links() }}
            </div>
            @endif
        </div>
        @endif

        <!-- Story Modal -->
        <div id="storyModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(0,0,0,0.5);backdrop-filter:blur(4px)">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <span id="modalCounter" class="text-xs font-semibold text-slate-400 uppercase tracking-widest"></span>
                    <button onclick="closeStoryModal()" class="p-2 rounded-xl hover:bg-slate-100 transition-colors" aria-label="Close modal">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="overflow-y-auto px-6 py-6 flex-1">
                    <div class="text-blue-500/10 mb-4">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
                    </div>
                    <p id="modalMessage" class="text-slate-700 leading-relaxed text-base mb-6"></p>
                    <div class="border-t border-slate-100 pt-4">
                        <h4 id="modalName" class="font-bold text-slate-900"></h4>
                        <p id="modalRole" class="text-blue-600 text-xs font-semibold uppercase tracking-wider mt-0.5"></p>
                    </div>
                </div>
                <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                    <button onclick="modalPrev()" class="flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 hover:border-blue-400 hover:text-blue-600 transition-all text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        Prev
                    </button>
                    <button onclick="modalNext()" class="flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 hover:border-blue-400 hover:text-blue-600 transition-all text-sm font-semibold">
                        Next
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection

@section('scripts')
<script>
    // ---- Top slider ----
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide-container');
    const dotsContainer = document.getElementById('dots-container');

    if (slides.length > 0 && dotsContainer) {
        slides.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.className = `h-2 rounded-full transition-all duration-300 ${i === 0 ? 'w-10 bg-blue-600' : 'w-2 bg-slate-200'}`;
            dot.id = `dot-${i}`;
            dotsContainer.appendChild(dot);
        });

        function showSlide(index) {
            slides[currentSlide].classList.remove('active');
            const currentDot = document.getElementById(`dot-${currentSlide}`);
            if (currentDot) currentDot.className = 'h-2 w-2 rounded-full bg-slate-200 transition-all duration-300';
            
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            
            const nextDot = document.getElementById(`dot-${currentSlide}`);
            if (nextDot) nextDot.className = 'h-2 w-10 rounded-full bg-blue-600 transition-all duration-300';
        }

        window.nextSlide = () => showSlide(currentSlide + 1);
        window.prevSlide = () => showSlide(currentSlide - 1);

        let autoInterval = setInterval(window.nextSlide, 8000);
        document.querySelectorAll('button').forEach(btn => btn.addEventListener('click', () => {
            clearInterval(autoInterval);
            autoInterval = setInterval(window.nextSlide, 8000);
        }));
    }

    window.toggleTestimonial = function(btn) {
        const el = btn.previousElementSibling;
        const collapsed = el.classList.toggle('line-clamp-3');
        btn.innerText = collapsed ? 'Show More' : 'Show Less';
    };

    // ---- Story Modal ----
    const storyData = @json($testimonials->map(fn($t) => ['name' => $t->name, 'role' => $t->role_company ?? 'Professional', 'message' => $t->message]));
    const totalStories = storyData.length;
    let modalIndex = 0;

    function openStoryModal(index) {
        modalIndex = index;
        renderModal();
        const modal = document.getElementById('storyModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeStoryModal() {
        const modal = document.getElementById('storyModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function renderModal() {
        const item = storyData[modalIndex];
        if (!item) return;
        document.getElementById('modalMessage').textContent = '\u201c' + item.message + '\u201d';
        document.getElementById('modalName').textContent = item.name;
        document.getElementById('modalRole').textContent = item.role;
        document.getElementById('modalCounter').textContent = 'Story ' + (modalIndex + 1) + ' of ' + totalStories;
    }

    function modalNext() {
        if (!totalStories) return;
        modalIndex = (modalIndex + 1) % totalStories;
        renderModal();
    }

    function modalPrev() {
        if (!totalStories) return;
        modalIndex = (modalIndex - 1 + totalStories) % totalStories;
        renderModal();
    }

    document.getElementById('storyModal').addEventListener('click', function(e) {
        if (e.target === this) closeStoryModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeStoryModal();
        if (e.key === 'ArrowRight') modalNext();
        if (e.key === 'ArrowLeft') modalPrev();
    });
</script>
@endsection