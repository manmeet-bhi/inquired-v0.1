<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $siteTitle = $seoSettings['site_title'] ?? 'Inaquired | The Remote Career Hub';
        $yieldedTitle = trim($__env->yieldContent('title'));
        $yieldedDescription = trim($__env->yieldContent('meta_description'));
        $yieldedKeywords = trim($__env->yieldContent('meta_keywords'));
        $yieldedCanonical = trim($__env->yieldContent('canonical'));
        $yieldedOgTitle = trim($__env->yieldContent('og_title'));
        $yieldedOgDescription = trim($__env->yieldContent('og_description'));
        $yieldedOgImage = trim($__env->yieldContent('og_image'));

        $title = !empty($pageSeo?->meta_title) ? $pageSeo->meta_title : ($yieldedTitle ?: $siteTitle);
        $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $description = !empty($pageSeo?->meta_description) ? $pageSeo->meta_description : ($yieldedDescription ?: ($seoSettings['meta_description'] ?? 'Find your dream job at top companies. Browse thousands of job opportunities from leading employers.'));
        $description = html_entity_decode($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $keywords = !empty($pageSeo?->meta_keywords) ? $pageSeo->meta_keywords : ($yieldedKeywords ?: ($seoSettings['meta_keywords'] ?? 'jobs, careers, employment, companies, hiring, job search'));
        $canonical = !empty($pageSeo?->canonical_url) ? $pageSeo->canonical_url : ($yieldedCanonical ?: url()->current());

        $ogTitle = !empty($pageSeo?->og_title)
            ? $pageSeo->og_title
            : (!empty($pageSeo?->meta_title)
                ? $pageSeo->meta_title
                : ($yieldedOgTitle ?: (!empty($seoSettings['og_title']) ? $seoSettings['og_title'] : $title)));
        $ogTitle = html_entity_decode($ogTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $ogDescription = !empty($pageSeo?->og_description)
            ? $pageSeo->og_description
            : (!empty($pageSeo?->meta_description)
                ? $pageSeo->meta_description
                : ($yieldedOgDescription ?: (!empty($seoSettings['og_description']) ? $seoSettings['og_description'] : $description)));
        $ogDescription = html_entity_decode($ogDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $ogImage = !empty($pageSeo?->og_image)
            ? media_url($pageSeo->og_image)
            : ($yieldedOgImage ?: (!empty($seoSettings['og_default_image']) ? media_url($seoSettings['og_default_image']) : null));

        $twitterTitle = !empty($pageSeo?->twitter_title)
            ? $pageSeo->twitter_title
            : ($ogTitle ?: (!empty($seoSettings['twitter_title']) ? $seoSettings['twitter_title'] : $title));
        $twitterTitle = html_entity_decode($twitterTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $twitterDescription = !empty($pageSeo?->twitter_description)
            ? $pageSeo->twitter_description
            : ($ogDescription ?: (!empty($seoSettings['twitter_description']) ? $seoSettings['twitter_description'] : $description));
        $twitterDescription = html_entity_decode($twitterDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $twitterImage = !empty($pageSeo?->twitter_image)
            ? media_url($pageSeo->twitter_image)
            : ($ogImage ?: null);

        $schemaJson = !empty($pageSeo?->schema_json) ? $pageSeo->schema_json : null;
        if (empty($schemaJson)) {
            if (isset($post) && is_object($post) && $post instanceof \App\Models\Post) {
                $schemaJson = json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    'headline' => $post->title,
                    'description' => $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160),
                    'image' => $post->featured_image_url ?: (!empty($seoSettings['og_default_image']) ? media_url($seoSettings['og_default_image']) : null),
                    'datePublished' => $post->published_at ? $post->published_at->format('Y-m-d\TH:i:sP') : ($post->created_at ? $post->created_at->format('Y-m-d\TH:i:sP') : date('c')),
                    'dateModified' => $post->updated_at ? $post->updated_at->format('Y-m-d\TH:i:sP') : date('c'),
                    'author' => [
                        '@type' => 'Person',
                        'name' => $post->author?->name ?? 'Inaquired Editorial Team'
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => $seoSettings['site_title'] ?? 'Inaquired',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => asset('assets/logos/logo.png')
                        ]
                    ],
                    'mainEntityOfPage' => [
                        '@type' => 'WebPage',
                        '@id' => url()->current()
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } elseif (!empty($seoSettings['schema_json'])) {
                $schemaJson = $seoSettings['schema_json'];
            }
        }

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

            // Mobile Menu Toggle
            window.toggleMenu = function() {
                const menu = document.getElementById('mobileMenu');
                const burgerIcon = document.getElementById('burger-icon');

                if (menu) {
                    menu.classList.toggle('hidden');
                }

                if (burgerIcon) {
                    burgerIcon.classList.toggle('open');
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
