@props(['title' => null, 'description' => null, 'keywords' => null, 'canonical' => null, 'ogTitle' => null, 'ogDescription' => null, 'ogImage' => null, 'noindex' => false, 'nofollow' => false, 'favicon' => null])

@php
    use App\Traits\HasSeo;
    
    // If no specific SEO data provided, try to get it from the current route
    if (!$title && !$description) {
        $currentSlug = request()->path();
        if ($currentSlug === '/') {
            $currentSlug = 'home';
        }
        $seoData = HasSeo::getSeoData($currentSlug);
        
        $title = $title ?: $seoData['title'];
        $description = $description ?: $seoData['description'];
        $keywords = $keywords ?: $seoData['keywords'];
        $canonical = $canonical ?: $seoData['canonical'];
        $ogTitle = $ogTitle ?: $seoData['og_title'];
        $ogDescription = $ogDescription ?: $seoData['og_description'];
        $ogImage = $ogImage ?: $seoData['og_image'];
        $noindex = $noindex ?: $seoData['noindex'];
        $nofollow = $nofollow ?: $seoData['nofollow'];
        $favicon = $favicon ?: $seoData['favicon'];
    }
@endphp

<title>{{ $title ?: 'Inaquired - Find Your Dream Job' }}</title>
<meta name="description" content="{{ $description ?: 'Find your dream job with top companies. Explore remote, onsite, and internship opportunities.' }}">
@if($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif
@if($canonical)
<link rel="canonical" href="{{ $canonical }}">
@endif
@if($noindex || $nofollow)
<meta name="robots" content="{{ $noindex ? 'noindex' : 'index' }}{{ $noindex && $nofollow ? ',' : '' }}{{ $nofollow ? 'nofollow' : ($noindex ? '' : ',follow') }}">
@endif

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $ogTitle ?: $title }}">
<meta property="og:description" content="{{ $ogDescription ?: $description }}">
@if($ogImage)
<meta property="og:image" content="{{ $ogImage }}">
@endif
<meta property="og:site_name" content="Inaquired">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $ogTitle ?: $title }}">
<meta property="twitter:description" content="{{ $ogDescription ?: $description }}">
@if($ogImage)
<meta property="twitter:image" content="{{ $ogImage }}">
@endif

<!-- Favicon -->
@include('partials.favicons')