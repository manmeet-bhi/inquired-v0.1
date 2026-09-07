<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Prevent browser caching authenticated pages (fixes back-button security issue) -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'CMS - Inaquired')</title>
    @include('partials.favicons')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('assets/css/tailwind-full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/unbounded.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/lucide.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/cms-stylesheet.css') }}">
    <script src="{{ asset('assets/js/cms-script.js') }}"></script>
    <style>
        body, input, button, select, textarea { font-family: 'Inter', sans-serif; }
        .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .content-transition { transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hide-text { opacity: 0; width: 0; overflow: hidden; pointer-events: none; position: absolute; }
        .show-text { opacity: 1; width: auto; position: static; }
        [x-cloak] { display: none !important; }
        
        /* Ensure icons stay centered when sidebar is small */
        .nav-item { transition: all 0.2s ease-in-out; }
        .collapsed-nav-item { justify-content: center !important; padding-left: 0 !important; padding-right: 0 !important; }
        
        /* Dropdown Styles */
        .dropdown-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            margin-left: 1.5rem;
        }
        .dropdown-container.open {
            max-height: 500px;
            transition: max-height 0.5s ease-in;
        }
        .nav-item .chevron {
            transition: transform 0.3s ease;
        }
        .nav-item.dropdown-active .chevron {
            transform: rotate(180deg);
        }

        /* Mobile Responsive Adjustments */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -256px; /* -w-64 */
                height: 100vh;
                width: 256px;
                z-index: 50;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            #sidebar.mobile-open {
                left: 0;
            }
            #sidebarToggle {
                display: none; /* Hide desktop toggle on mobile */
            }
            #mobile-overlay {
                display: none;
            }
            #mobile-overlay.visible {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 overflow-hidden h-screen">

    <!-- Global Preloader (Style 3: Fluid Arc & Radar Glow) -->
    <div id="cms-preloader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-50 transition-opacity duration-300">
        <div class="flex flex-col items-center">
            <!-- Animated Circular Ring with Centered Logo -->
            <div class="relative w-24 h-24 flex items-center justify-center mb-3">
                <!-- Radar Glow Echo Wave -->
                <div class="cms-radar-ripple absolute inset-1.5 rounded-full bg-indigo-500/15"></div>
                
                <!-- SVG Fluid Spinner Arc Ring -->
                <svg class="w-full h-full animate-spin" viewBox="0 0 64 64" fill="none" style="animation-duration: 1.5s;">
                    <circle cx="32" cy="32" r="28" stroke="#e2e8f0" stroke-width="3" />
                    <circle cx="32" cy="32" r="28" stroke="url(#cmsPreloaderGradient)" stroke-width="3.5" stroke-linecap="round" class="cms-fluid-arc" />
                    <defs>
                        <linearGradient id="cmsPreloaderGradient" x1="0" y1="0" x2="64" y2="64" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#4f46e5" />
                            <stop offset="1" stop-color="#ec4899" />
                        </linearGradient>
                    </defs>
                </svg>

                <!-- Small Inaquired Logo -->
                <img src="{{ asset('assets/logos/logo-q.png') }}" alt="Inaquired" class="w-10 h-10 object-contain absolute z-10 drop-shadow-sm select-none">
            </div>

            <!-- Loading Text Indicator -->
            <p class="text-xs font-semibold text-slate-700 tracking-wider uppercase flex items-center justify-center gap-1">
                Loading
                <span class="inline-flex">
                    <span class="animate-bounce" style="animation-delay: -0.3s">.</span>
                    <span class="animate-bounce" style="animation-delay: -0.15s">.</span>
                    <span class="animate-bounce">.</span>
                </span>
            </p>
            <p class="text-[10px] text-slate-400 font-medium tracking-widest uppercase mt-0.5">INAQUIRED CMS</p>
        </div>
    </div>

    <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity duration-300"></div>

    <div class="flex h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-transition w-64 bg-white text-slate-800 flex flex-col relative z-30 border-r border-slate-200 shrink-0 shadow-xl lg:shadow-none">
            <!-- Desktop Toggle Button (Hidden on Mobile) -->
            <button id="sidebarToggle" class="absolute -right-3 top-9 bg-indigo-600 text-white rounded-full p-1.5 shadow-lg z-50 hover:bg-indigo-500 transition-colors border-2 border-white hidden lg:block">
                <i data-lucide="chevron-left" id="toggleIcon" class="w-3.5 h-3.5"></i>
            </button>

            <div class="h-20 flex items-center px-6 mb-4 overflow-hidden transition-all duration-300" id="logoArea">
                <img src="{{ asset('assets/logos/logo.png') }}" alt="Inaquired" class="logo-full h-10 object-contain transition-opacity duration-300">
                <img src="{{ asset('assets/logos/logo-q.png') }}" alt="Inaquired" class="logo-icon w-8 h-8 object-contain hidden transition-opacity duration-300">
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 space-y-2 overflow-y-auto">
                <a href="{{ route('cms.dashboard') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="layout-dashboard" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Dashboard</span>
                </a>
                <a href="{{ route('cms.jobs') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.jobs*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="briefcase" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Jobs</span>
                </a>
                <a href="{{ route('cms.internships') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.internships*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="graduation-cap" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Internships</span>
                </a>
                <a href="{{ route('cms.posts') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.posts*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="file-text" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Blog</span>
                </a>
                <a href="{{ route('cms.companies') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.companies*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="building" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Companies</span>
                </a>
                <a href="{{ route('cms.categories') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.categories*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="tag" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Categories</span>
                </a>
                @if(auth('admin')->user()->hasPermission('testimonials.manage'))
                <a href="{{ route('cms.testimonials.index') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.testimonials*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="message-square" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Testimonials</span>
                </a>
                @endif
                <a href="{{ route('cms.seo.index') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.seo*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="search" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">SEO</span>
                </a>

                @if(auth('admin')->user()->role === 'superadmin')
                <a href="{{ route('cms.users') }}" class="nav-item w-full flex items-center px-4 py-3 gap-3 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.users*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                    <i data-lucide="users" class="shrink-0 w-5 h-5"></i>
                    <span class="nav-text font-medium whitespace-nowrap">Users</span>
                </a>
                @endif
            </nav>


        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-y-auto">
            <!-- Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-20">
                
                <!-- Mobile Hamburger Button (Hidden on Desktop) -->
                <button id="mobileMenuToggle" class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-indigo-600 transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                <!-- Enhanced Search Bar -->
                <div class="relative flex-1 lg:flex-initial flex items-center gap-3 bg-slate-50/50 hover:bg-white px-3 sm:px-4 py-2 rounded-xl border border-slate-200/80 w-auto lg:w-full lg:max-w-xs transition-all duration-300 shadow-sm hover:shadow-md focus-within:ring-4 focus-within:ring-indigo-500/10 focus-within:border-indigo-500 focus-within:bg-white focus-within:shadow-lg focus-within:shadow-indigo-500/5 group backdrop-blur-sm mx-2 sm:mx-0">
                    <i data-lucide="search" class="text-slate-400 w-4 h-4 sm:w-5 sm:h-5 group-focus-within:text-indigo-500 transition-colors duration-300"></i>
                    <input type="text" id="searchInput" placeholder="Search..." 
                           class="bg-transparent border-none focus:outline-none text-sm w-full text-slate-700 placeholder-slate-400 !shadow-none !transform-none p-0" 
                           autocomplete="off">
                    

                    <!-- Search Results Dropdown -->
                    <div id="searchResults" class="absolute top-full left-0 right-0 mt-3 bg-white rounded-xl shadow-xl border border-slate-200 max-h-96 overflow-y-auto z-50 hidden opacity-0 translate-y-2 transition-all duration-200">
                        <div id="searchContent" class="p-2"></div>
                    </div>
                </div>

                <div class="flex items-center gap-4 md:gap-6">
                    <!-- Activity Menu -->
                    <div class="relative group/activity border-r border-gray-200 pr-4 md:pr-6 mr-1 md:mr-2">
                        <button id="activityToggle" class="flex items-center gap-2 p-2 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 rounded-lg transition-colors focus:outline-none">
                            <i data-lucide="activity" class="w-5 h-5"></i>
                            <span class="text-sm font-medium hidden sm:inline">Activity</span>
                        </button>
                        
                        <div id="activityDropdownContainer" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-50 hidden">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="font-bold text-slate-900 text-sm">System Activity</h3>
                            </div>
                            <div class="max-h-80 overflow-y-auto no-scrollbar">
                                @forelse($recentActivities ?? [] as $activity)
                                    <div class="px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                                                <span class="text-xs font-bold text-slate-600">{{ substr($activity->adminUser->name ?? 'S', 0, 1) }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs text-slate-900 leading-tight">
                                                    <span class="font-bold">{{ $activity->adminUser->name ?? 'System' }}</span>
                                                    <span class="text-slate-500">{{ strtolower($activity->action) }}</span>
                                                    @if($activity->target_name)
                                                    <span class="font-medium text-slate-700 truncate block">{{ $activity->target_name }}</span>
                                                    @endif
                                                </p>
                                                <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-wider">{{ $activity->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-6 text-center text-slate-500 text-xs">No recent activity.</div>
                                @endforelse
                            </div>
                            <div class="border-t border-gray-100 p-2 text-center bg-slate-50/50 rounded-b-xl mt-1">
                                <a href="{{ route('cms.activity') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 w-full block py-1 transition-colors">View All Activity &rarr;</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-all">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        <span class="text-sm font-medium hidden sm:inline">Visit</span>
                    </a>
                    <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                    <div class="relative">
                        <button id="avatarDropdown" class="flex items-center gap-3 pl-2 hover:bg-slate-50 rounded-lg p-2 transition-all">
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-bold leading-none">{{ Auth::guard('admin')->user()->name }}</p>
                                <p class="text-[11px] text-slate-500 font-medium mt-1 uppercase tracking-wider">{{ Auth::guard('admin')->user()->role }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-indigo-100 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                                </div>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                        </button>
                        <div id="avatarDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50 hidden">
                            <a href="{{ route('cms.profile') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <i data-lucide="user" class="w-4 h-4"></i>
                                Profile
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('cms.logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto flex flex-col">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mx-4 mt-4 rounded-r-lg shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mx-4 mt-4 rounded-r-lg shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="x-circle" class="w-5 h-5 text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mx-4 mt-4 rounded-r-lg shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-semibold text-red-800">There were validation errors with your submission:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="p-4 md:p-8 flex-1">
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 px-8 py-4 mt-auto">
                    <div class="flex items-center justify-between text-sm text-slate-500">
                        <p>&copy; {{ date('Y') }} Inaquired CMS. All rights reserved.</p>
                        <p>Version 1.0</p>
                    </div>
                </footer>
            </div>
        </main>
    </div>

    <script>
        // ─── Global Script Initialization ────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            const preloader = document.getElementById('cms-preloader');
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileOverlay = document.getElementById('mobile-overlay');
            const toggleIcon = document.getElementById('toggleIcon');
            const logoFull = document.querySelector('.logo-full');
            const logoIcon = document.querySelector('.logo-icon');
            const logoArea = document.getElementById('logoArea');
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const searchContent = document.getElementById('searchContent');
            const avatarDropdown = document.getElementById('avatarDropdown');
            const avatarDropdownMenu = document.getElementById('avatarDropdownMenu');
            const activityToggle = document.getElementById('activityToggle');
            const activityDropdownContainer = document.getElementById('activityDropdownContainer');
            
            const navTexts = document.querySelectorAll('.nav-text');
            const navItems = document.querySelectorAll('.nav-item');

            // --- Preloader Logic ---
            window.showCmsPreloader = () => {
                if (preloader) {
                    preloader.style.opacity = '1';
                    preloader.style.pointerEvents = 'auto';
                }
            };

            window.hideCmsPreloader = () => {
                if (preloader) {
                    preloader.style.opacity = '0';
                    preloader.style.pointerEvents = 'none';
                }
            };

            // Hide preloader initially
            if (preloader) {
                preloader.style.transition = 'opacity 0.3s ease';
                setTimeout(window.hideCmsPreloader, 300);
            }

            // Lucide icons initialization
            if (window.lucide) {
                window.lucide.createIcons();
            }

            // --- Sidebar Logic ---
            let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            function applySidebarState(state) {
                if (window.innerWidth < 1024) return;
                if (state) {
                    sidebar.classList.replace('w-64', 'w-20');
                    if(logoFull) logoFull.classList.add('hidden');
                    if(logoIcon) logoIcon.classList.remove('hidden');
                    logoArea.style.justifyContent = 'center';
                    logoArea.classList.replace('px-6', 'px-0');
                    navTexts.forEach(t => t.classList.add('hide-text'));
                    navItems.forEach(i => i.classList.add('collapsed-nav-item'));
                    if(toggleIcon) toggleIcon.setAttribute('data-lucide', 'menu');
                } else {
                    sidebar.classList.replace('w-20', 'w-64');
                    if(logoFull) logoFull.classList.remove('hidden');
                    if(logoIcon) logoIcon.classList.add('hidden');
                    logoArea.style.justifyContent = 'flex-start';
                    logoArea.classList.replace('px-0', 'px-6');
                    navTexts.forEach(t => t.classList.remove('hide-text'));
                    navItems.forEach(i => i.classList.remove('collapsed-nav-item'));
                    if(toggleIcon) toggleIcon.setAttribute('data-lucide', 'chevron-left');
                }
                if (window.lucide) window.lucide.createIcons();
            }

            applySidebarState(isCollapsed);

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    isCollapsed = !isCollapsed;
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                    applySidebarState(isCollapsed);
                });
            }

            // --- Mobile Logic ---
            function toggleMobileMenu() {
                const isOpen = sidebar.classList.toggle('mobile-open');
                mobileOverlay.classList.toggle('hidden', !isOpen);
                mobileOverlay.classList.toggle('visible', isOpen);
                document.body.classList.toggle('overflow-hidden', isOpen);
            }

            if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', toggleMobileMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', toggleMobileMenu);

            // --- Dropdown Logic ---
            document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
                trigger.addEventListener('click', () => {
                    if (isCollapsed && window.innerWidth >= 1024) return;
                    const targetId = trigger.getAttribute('data-target');
                    const target = document.getElementById(targetId);
                    target.classList.toggle('open');
                    trigger.classList.toggle('dropdown-active');
                });
            });

            // --- Search Logic ---
            let searchTimeout;
            const searchData = [
                { title: 'Dashboard', url: '{{ route("cms.dashboard") }}', type: 'page', icon: 'layout-dashboard' },
                { title: 'Jobs', url: '{{ route("cms.jobs") }}', type: 'page', icon: 'briefcase' },
                { title: 'Create Job', url: '{{ route("cms.jobs.create") }}', type: 'action', icon: 'plus' },
                { title: 'Internships', url: '{{ route("cms.internships") }}', type: 'page', icon: 'graduation-cap' },
                { title: 'Create Internship', url: '{{ route("cms.internships.create") }}', type: 'action', icon: 'plus' },
                { title: 'Blog Posts', url: '{{ route("cms.posts") }}', type: 'page', icon: 'file-text' },
                { title: 'Create Blog Post', url: '{{ route("cms.posts.create") }}', type: 'action', icon: 'plus' },
                { title: 'Companies', url: '{{ route("cms.companies") }}', type: 'page', icon: 'building' },
                { title: 'Create Company', url: '{{ route("cms.companies.create") }}', type: 'action', icon: 'plus' },
                { title: 'Categories', url: '{{ route("cms.categories") }}', type: 'page', icon: 'tag' },
                { title: 'Create Category', url: '{{ route("cms.categories.create") }}', type: 'action', icon: 'plus' },
                { title: 'Testimonials', url: '{{ route("cms.testimonials.index") }}', type: 'page', icon: 'message-square' },
                { title: 'SEO Settings', url: '{{ route("cms.seo.index") }}', type: 'settings', icon: 'search' },
                @if(auth('admin')->user()->role === 'superadmin')
                { title: 'Users', url: '{{ route("cms.users") }}', type: 'page', icon: 'users' },
                { title: 'Create User', url: '{{ route("cms.users.create") }}', type: 'action', icon: 'plus' },
                @endif
                { title: 'Profile', url: '{{ route("cms.profile") }}', type: 'settings', icon: 'user' },
            ];

            function performSearch(query) {
                if (!query.trim()) {
                    searchResults.classList.add('hidden', 'opacity-0', 'translate-y-2');
                    return;
                }
                const results = searchData.filter(item => item.title.toLowerCase().includes(query.toLowerCase()));
                if (results.length === 0) {
                    searchContent.innerHTML = '<div class="p-4 text-center text-slate-500 text-sm">No results found</div>';
                } else {
                    searchContent.innerHTML = results.map(item => `
                        <a href="${item.url}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <i data-lucide="${item.icon}" class="w-4 h-4 text-indigo-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-slate-900 text-sm">${item.title}</div>
                                <div class="text-xs text-slate-500 capitalize">${item.type}</div>
                            </div>
                        </a>
                    `).join('');
                    if (window.lucide) window.lucide.createIcons();
                }
                searchResults.classList.remove('hidden');
                requestAnimationFrame(() => searchResults.classList.remove('opacity-0', 'translate-y-2'));
            }

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => performSearch(e.target.value), 300);
                });
                searchInput.addEventListener('focus', () => searchInput.value.trim() && performSearch(searchInput.value));
            }

            document.addEventListener('click', (e) => {
                if (searchInput && !searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => searchResults.classList.add('hidden'), 200);
                }
                // Avatar Dropdown
                if (avatarDropdown && !avatarDropdown.contains(e.target) && !avatarDropdownMenu.contains(e.target)) {
                    avatarDropdownMenu.classList.add('hidden');
                }
                // Activity Dropdown
                if (activityToggle && !activityToggle.contains(e.target) && !activityDropdownContainer.contains(e.target)) {
                    activityDropdownContainer.classList.add('hidden');
                }
            });

            if (activityToggle && activityDropdownContainer) {
                activityToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    activityDropdownContainer.classList.toggle('hidden');
                });
            }

            if (avatarDropdown) {
                avatarDropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                    avatarDropdownMenu.classList.toggle('hidden');
                });
            }

            // Keyboard Shortcuts
            document.addEventListener('keydown', (e) => {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    if(searchInput) searchInput.focus();
                }
            });

            // --- Modular Unauthorized Modal Trigger ---
            @if(session('unauthorized_modal'))
                setTimeout(() => {
                    if (typeof window.showUnauthorizedModal === 'function') {
                        window.showUnauthorizedModal();
                    }
                }, 500);
            @endif
        });
    </script>

    @include('cms.partials.unauthorized-modal')
</body>
</html>