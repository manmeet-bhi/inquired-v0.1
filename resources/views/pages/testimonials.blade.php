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

    /* Mascot Animations */
    @keyframes mascotFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(1.5deg); }
    }
    @keyframes mascotShadow {
        0%, 100% { transform: scale(1); opacity: 0.35; }
        50% { transform: scale(0.85); opacity: 0.2; }
    }
    @keyframes handWave {
        0%, 100% { transform: rotate(0deg); transform-origin: 112px 95px; }
        25% { transform: rotate(18deg); transform-origin: 112px 95px; }
        50% { transform: rotate(-8deg); transform-origin: 112px 95px; }
        75% { transform: rotate(14deg); transform-origin: 112px 95px; }
    }
    @keyframes speechBounce {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-4px) scale(1.03); }
    }
    @keyframes sparkleSpin {
        0% { transform: rotate(0deg) scale(0.9); opacity: 0.7; }
        50% { transform: rotate(180deg) scale(1.2); opacity: 1; }
        100% { transform: rotate(360deg) scale(0.9); opacity: 0.7; }
    }
    @keyframes floatOrbit {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-7px) rotate(-8deg); }
    }
    @keyframes pulseGlow {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.15); opacity: 0.6; }
    }

    .animate-mascot-float {
        animation: mascotFloat 3.8s ease-in-out infinite;
    }
    .animate-mascot-shadow {
        animation: mascotShadow 3.8s ease-in-out infinite;
    }
    .animate-hand-wave {
        animation: handWave 2.5s ease-in-out infinite;
    }
    .animate-speech-bounce {
        animation: speechBounce 3s ease-in-out infinite;
    }
    .animate-sparkle-spin {
        animation: sparkleSpin 4s linear infinite;
    }
    .animate-float-orbit {
        animation: floatOrbit 3.2s ease-in-out infinite;
    }
    .animate-pulse-glow {
        animation: pulseGlow 3.5s ease-in-out infinite;
    }

    /* Button Animations */
    .btn-animated-gradient {
        background: linear-gradient(135deg, #2563eb, #4f46e5, #7c3aed, #2563eb, #06b6d4, #3b82f6);
        background-size: 300% 300%;
    }
    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    @keyframes btnAura {
        0%, 100% { transform: scale(0.98); opacity: 0.5; filter: blur(12px); }
        50% { transform: scale(1.03); opacity: 0.85; filter: blur(18px); }
    }
    @keyframes lightBeam {
        0% { transform: translateX(-140%) skewX(-20deg); }
        35%, 100% { transform: translateX(280%) skewX(-20deg); }
    }
    @keyframes arrowNudge {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(4px); }
    }
    @keyframes sparkleTwinkle {
        0%, 100% { transform: scale(0.7) rotate(0deg); opacity: 0.4; }
        50% { transform: scale(1.2) rotate(45deg); opacity: 1; }
    }

    .animate-gradient-flow {
        animation: gradientFlow 4s ease infinite;
    }
    .animate-btn-aura {
        animation: btnAura 3s ease-in-out infinite;
    }
    .animate-light-beam {
        animation: lightBeam 3.2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }
    .animate-arrow-nudge {
        animation: arrowNudge 1.8s ease-in-out infinite;
    }
    .animate-sparkle-twinkle {
        animation: sparkleTwinkle 2.5s ease-in-out infinite;
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

                        <!-- Character-Infused Submission Box -->
                        <div class="relative bg-gradient-to-b from-white via-white to-blue-50/50 p-6 sm:p-7 rounded-[2.5rem] border border-slate-200/90 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden text-center group">
                            
                            <!-- Decorative Glowing Aura Backgrounds -->
                            <div class="absolute -top-12 -right-12 w-36 h-36 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full blur-2xl pointer-events-none animate-pulse-glow"></div>
                            <div class="absolute -bottom-12 -left-12 w-36 h-36 bg-gradient-to-tr from-indigo-400/20 to-pink-400/20 rounded-full blur-2xl pointer-events-none"></div>

                            <!-- BIG ANIMATED MASCOT / CHARACTER SCENE -->
                            <div class="relative w-full max-w-[260px] h-48 mx-auto flex flex-col items-center justify-center mb-3">
                                
                                <!-- Floating Speech Balloon -->
                                <div class="absolute -top-1 left-2 sm:-left-2 z-20 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-2xl border border-blue-100 shadow-md text-[11px] font-extrabold text-slate-800 flex items-center gap-1.5 animate-speech-bounce">
                                    <span class="text-sm">🎉</span>
                                    <span>Got hired? Share it!</span>
                                    <span class="absolute -bottom-1.5 left-6 w-3 h-3 bg-white border-r border-b border-blue-100 transform rotate-45"></span>
                                </div>

                                <!-- Floating Orbit Elements -->
                                <div class="absolute top-2 right-2 z-20 text-base animate-sparkle-spin select-none pointer-events-none">⭐</div>
                                <div class="absolute bottom-6 -right-2 z-20 text-lg animate-float-orbit select-none pointer-events-none">🚀</div>
                                <div class="absolute bottom-8 -left-2 z-20 text-sm animate-pulse select-none pointer-events-none">💖</div>

                                <!-- Big Floating Mascot SVG -->
                                <div class="relative z-10 w-36 h-36 sm:w-40 sm:h-40 animate-mascot-float flex items-center justify-center">
                                    <svg viewBox="0 0 160 160" class="w-full h-full drop-shadow-xl overflow-visible" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="bodyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" stop-color="#3B82F6"/>
                                                <stop offset="50%" stop-color="#4F46E5"/>
                                                <stop offset="100%" stop-color="#7C3AED"/>
                                            </linearGradient>
                                            <linearGradient id="visorGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" stop-color="#0F172A"/>
                                                <stop offset="100%" stop-color="#1E293B"/>
                                            </linearGradient>
                                            <linearGradient id="headGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" stop-color="#FFFFFF"/>
                                                <stop offset="100%" stop-color="#E2E8F0"/>
                                            </linearGradient>
                                            <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" stop-color="#FDE047"/>
                                                <stop offset="100%" stop-color="#F59E0B"/>
                                            </linearGradient>
                                        </defs>

                                        <!-- Antenna -->
                                        <path d="M80 44V26" stroke="#94A3B8" stroke-width="4" stroke-linecap="round"/>
                                        <circle cx="80" cy="22" r="7" fill="url(#goldGrad)" stroke="#F59E0B" stroke-width="2" class="animate-pulse"/>
                                        <circle cx="80" cy="22" r="3" fill="#FFFFFF"/>

                                        <!-- Left Arm / Thumbs Up -->
                                        <g>
                                            <path d="M48 95C40 98 32 105 32 114C32 120 38 122 45 116L52 108" stroke="url(#bodyGrad)" stroke-width="10" stroke-linecap="round"/>
                                            <circle cx="30" cy="115" r="7" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="2"/>
                                            <path d="M28 112L31 115L36 109" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>

                                        <!-- Right Waving Arm -->
                                        <g class="animate-hand-wave">
                                            <path d="M112 95C122 92 130 82 134 72C136 67 132 63 126 67L116 78" stroke="url(#bodyGrad)" stroke-width="10" stroke-linecap="round"/>
                                            <circle cx="135" cy="68" r="8" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="2"/>
                                            <path d="M132 63C132 60 137 60 137 64" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round"/>
                                        </g>

                                        <!-- Body / Suit -->
                                        <rect x="48" y="85" width="64" height="52" rx="26" fill="url(#bodyGrad)"/>
                                        <!-- Suit Collar -->
                                        <path d="M58 86C65 92 95 92 102 86" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" opacity="0.6"/>
                                        <!-- Heart / Power Badge -->
                                        <circle cx="80" cy="108" r="11" fill="#FFFFFF" opacity="0.95"/>
                                        <path d="M80 114C80 114 73 109.5 73 106C73 104 74.5 102.5 76.5 102.5C77.8 102.5 79.2 103.4 80 104.3C80.8 103.4 82.2 102.5 83.5 102.5C85.5 102.5 87 104 87 106C87 109.5 80 114 80 114Z" fill="#EC4899"/>

                                        <!-- Cute Mascot Head Helmet -->
                                        <rect x="36" y="38" width="88" height="60" rx="28" fill="url(#headGrad)" stroke="#CBD5E1" stroke-width="2.5"/>
                                        <!-- Shiny Head Highlight -->
                                        <path d="M48 48C55 43 72 42 80 42" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round"/>

                                        <!-- Screen Visor Face -->
                                        <rect x="44" y="46" width="72" height="44" rx="20" fill="url(#visorGrad)"/>
                                        
                                        <!-- Visor Reflection Flare -->
                                        <path d="M52 52L64 52" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" opacity="0.6"/>
                                        <circle cx="106" cy="52" r="2" fill="#38BDF8" opacity="0.8"/>

                                        <!-- Happy Smiling Eyes ( ^   ^ ) -->
                                        <path d="M58 66C58 61 64 61 64 66" stroke="#38BDF8" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                                        <path d="M96 66C96 61 102 61 102 66" stroke="#38BDF8" stroke-width="3.5" stroke-linecap="round" fill="none"/>

                                        <!-- Rosy Blushing Cheeks -->
                                        <circle cx="54" cy="74" r="4" fill="#F43F5E" opacity="0.75"/>
                                        <circle cx="106" cy="74" r="4" fill="#F43F5E" opacity="0.75"/>

                                        <!-- Cute Joyful Smile -->
                                        <path d="M75 72C75 75.5 85 75.5 85 72" stroke="#FDE047" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                                    </svg>
                                </div>

                                <!-- Mascot Floor Shadow (Contracts/Expands with float) -->
                                <div class="w-24 h-3 bg-slate-400/40 rounded-full blur-[2px] animate-mascot-shadow -mt-2"></div>
                            </div>

                            <!-- Title & Description -->
                            <h4 class="text-xl font-extrabold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                                Tell us about your experience
                            </h4>
                            <p class="text-sm text-slate-500 mb-5 leading-relaxed max-w-sm mx-auto">
                                Click the button below to easily submit your success story via our feedback page.
                            </p>

                            <!-- Character Badges -->
                            <div class="flex items-center justify-center gap-2 mb-6 text-[11px] font-bold text-slate-600">
                                <span class="inline-flex items-center gap-1 bg-slate-100/90 px-2.5 py-1 rounded-full border border-slate-200/70">
                                    ⚡ 1-Min Quick
                                </span>
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full border border-blue-200/60">
                                    🌟 Inspires Community
                                </span>
                            </div>

                            <!-- Animated Button with Dynamic Glow & Shimmer -->
                            <div class="relative group/btn mt-2">
                                <!-- Ambient Pulsing Aura Glow Behind Button -->
                                <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 opacity-60 blur-lg transition-all duration-500 group-hover/btn:opacity-100 group-hover/btn:blur-xl animate-btn-aura pointer-events-none"></div>

                                <a href="{{ route('feedback') }}" class="relative overflow-hidden inline-flex items-center justify-center w-full py-4 px-6 text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] animate-gradient-flow btn-animated-gradient">
                                    <!-- Light Beam Passing Across -->
                                    <span class="absolute top-0 left-0 w-1/2 h-full bg-gradient-to-r from-transparent via-white/35 to-transparent pointer-events-none animate-light-beam"></span>

                                    <!-- Corner Sparkle Accent -->
                                    <span class="absolute top-2.5 right-3 text-xs animate-sparkle-twinkle select-none pointer-events-none">✨</span>
                                    
                                    <span class="relative z-10 flex items-center justify-center gap-2 tracking-wide drop-shadow-sm">
                                        <span>Share Your Story</span>
                                        <svg class="w-5 h-5 animate-arrow-nudge group-hover/btn:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
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