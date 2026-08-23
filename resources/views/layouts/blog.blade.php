<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $siteTitle = $seoSettings['site_title'] ?? 'Anywhereroles | The Remote Career Hub';
        $yieldedTitle = trim($__env->yieldContent('title'));
        $yieldedDescription = trim($__env->yieldContent('meta_description'));
        $yieldedKeywords = trim($__env->yieldContent('meta_keywords'));
        $yieldedCanonical = trim($__env->yieldContent('canonical'));
        $yieldedOgTitle = trim($__env->yieldContent('og_title'));
        $yieldedOgDescription = trim($__env->yieldContent('og_description'));
        $yieldedOgImage = trim($__env->yieldContent('og_image'));

        $title = $pageSeo?->meta_title ?? ($yieldedTitle ?: $siteTitle);
        $description = $pageSeo?->meta_description ?? ($yieldedDescription ?: ($seoSettings['meta_description'] ?? 'Find your dream job at top companies. Browse thousands of job opportunities from leading employers.'));
        $keywords = $pageSeo?->meta_keywords ?? ($yieldedKeywords ?: ($seoSettings['meta_keywords'] ?? 'jobs, careers, employment, companies, hiring, job search'));
        $canonical = $pageSeo?->canonical_url ?? ($yieldedCanonical ?: url()->current());
        $ogTitle = $pageSeo?->og_title ?? $pageSeo?->meta_title ?? ($yieldedOgTitle ?: (!empty($seoSettings['og_title']) ? $seoSettings['og_title'] : $title));
        $ogDescription = $pageSeo?->og_description ?? $pageSeo?->meta_description ?? ($yieldedOgDescription ?: (!empty($seoSettings['og_description']) ? $seoSettings['og_description'] : $description));
        $ogImage = !empty($pageSeo?->og_image)
            ? media_url($pageSeo->og_image)
            : ($yieldedOgImage ?: (!empty($seoSettings['og_default_image']) ? media_url($seoSettings['og_default_image']) : null));
        $twitterTitle = $pageSeo?->twitter_title ?? (!empty($seoSettings['twitter_title']) ? $seoSettings['twitter_title'] : $ogTitle);
        $twitterDescription = $pageSeo?->twitter_description ?? (!empty($seoSettings['twitter_description']) ? $seoSettings['twitter_description'] : $ogDescription);
        $twitterImage = !empty($pageSeo?->twitter_image)
            ? media_url($pageSeo->twitter_image)
            : $ogImage;
        $schemaJson = $pageSeo?->schema_json ?? ($seoSettings['schema_json'] ?? null);
        $robotsNoindex = (bool) ($pageSeo?->noindex ?? false) || !empty($seoSettings['global_noindex']);
        $robotsNofollow = (bool) ($pageSeo?->nofollow ?? false) || !empty($seoSettings['global_nofollow']);
    @endphp
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    
    @if($robotsNoindex || $robotsNofollow)
    <meta name="robots" content="{{ $robotsNoindex ? 'noindex' : 'index' }}, {{ $robotsNofollow ? 'nofollow' : 'follow' }}">
    @endif
    
    @if($canonical)
    <link rel="canonical" href="{{ $canonical }}">
    @endif
    
    @include('partials.favicons')
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($seoSettings['og_site_name']))
    <meta property="og:site_name" content="{{ $seoSettings['og_site_name'] }}">
    @endif
    @if(!empty($seoSettings['og_locale']))
    <meta property="og:locale" content="{{ $seoSettings['og_locale'] }}">
    @endif
    @if($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="{{ $seoSettings['twitter_card'] ?? 'summary_large_image' }}">
    @if(!empty($seoSettings['twitter_site']))
    <meta name="twitter:site" content="{{ $seoSettings['twitter_site'] }}">
    @endif
    @if(!empty($seoSettings['twitter_creator']))
    <meta name="twitter:creator" content="{{ $seoSettings['twitter_creator'] }}">
    @endif
    <meta name="twitter:title" content="{{ $twitterTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription }}">
    @if($twitterImage)
    <meta name="twitter:image" content="{{ $twitterImage }}">
    @endif

    @if(!empty($schemaJson))
    <script type="application/ld+json">
        {!! $schemaJson !!}
    </script>
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/unbounded.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-white">
    @include('partials.blog-header')
    <main>
        @yield('content')
        @include('partials.blog-cta')
    </main>
    @include('partials.footer')
    @include('partials.terms-banner')
    


    <script src="{{ asset('assets/js/lucide.min.js') }}"></script>
    <script>lucide.createIcons();</script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown Toggle
            window.toggleDropdown = function(dropdownId) {
                const dropdown = document.getElementById(dropdownId);
                const allDropdowns = document.querySelectorAll('.dropdown-menu');

                // Close all other dropdowns
                allDropdowns.forEach(d => {
                    if (d.id !== dropdownId) {
                        d.classList.remove('show');
                    }
                });

                // Toggle current dropdown
                if(dropdown) dropdown.classList.toggle('show');
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.relative')) {
                    document.querySelectorAll('.dropdown-menu').forEach(d => {
                        d.classList.remove('show');
                    });
                }
            });

            // Search Toggle Functionality
            window.toggleSearch = function() {
                const searchBar = document.getElementById('globalSearch');
                const searchInput = document.getElementById('global-search-keyword');
                const mobileMenu = document.getElementById('mobileMenu');

                if (!searchBar) return;

                const isHidden = searchBar.classList.contains('hidden');

                // Close mobile menu if open
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }

                // Toggle search
                if (isHidden) {
                    searchBar.classList.remove('hidden');
                    // Focus on the keyword input
                    setTimeout(() => searchInput && searchInput.focus(), 100);
                } else {
                    searchBar.classList.add('hidden');
                }
            }

            // Close search when clicking outside
            document.addEventListener('click', function (event) {
                const searchBar = document.getElementById('globalSearch');
                const searchTrigger = event.target.closest('.search-trigger');
                const searchContent = event.target.closest('#globalSearch');

                if (!searchTrigger && !searchContent && searchBar && !searchBar.classList.contains('hidden')) {
                    searchBar.classList.add('hidden');
                }
            });

            // Mobile Menu Toggle
            window.toggleMenu = function() {
                const menu = document.getElementById('mobileMenu');
                const searchBar = document.getElementById('globalSearch');
                const burgerIcon = document.getElementById('burger-icon');

                if (menu) {
                    menu.classList.toggle('hidden');
                }

                if (burgerIcon) {
                    burgerIcon.classList.toggle('open');
                }

                if (searchBar) {
                    searchBar.classList.add('hidden');
                }
            };

            // Accordion Toggle
            window.toggleAccordion = function(id, btn) {
                if (window.event) window.event.stopPropagation();

                const content = document.getElementById(id);
                const chevron = btn ? btn.querySelector('.chevron') : null;

                // Close other top level accordions
                document.querySelectorAll('#mobileMenu .mobile-accordion').forEach(acc => {
                    if (acc.id !== id && acc.classList.contains('active')) {
                        acc.classList.remove('active');
                        const parent = acc.closest('.rounded-xl') || acc.parentElement;
                        const siblingBtn = parent ? parent.querySelector('button') : null;
                        const siblingChevron = siblingBtn ? siblingBtn.querySelector('.chevron') : null;
                        if (siblingChevron) {
                            siblingChevron.style.transform = '';
                        }
                    }
                });

                if (content) {
                    const isActive = content.classList.toggle('active');
                    if (chevron) {
                        chevron.style.transform = isActive ? 'rotate(225deg) translateY(-1px)' : '';
                    }
                }
            };
        });
    </script>
    @yield('scripts')
</body>
</html>
