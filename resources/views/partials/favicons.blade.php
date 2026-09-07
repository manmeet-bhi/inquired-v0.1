@php
    $dynamicFavicon = !empty($seoSettings['favicon'])
        ? media_url($seoSettings['favicon'])
        : null;
    $favIcoPath = public_path('assets/favicon/favicon.ico');
    $favVersion = file_exists($favIcoPath) ? filemtime($favIcoPath) : time();
@endphp

@if($dynamicFavicon)
<link rel="icon" type="image/x-icon" href="{{ $dynamicFavicon }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ $dynamicFavicon }}">
<link rel="apple-touch-icon" href="{{ $dynamicFavicon }}">
@else
<link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon/favicon.ico') }}?v={{ $favVersion }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/favicon/favicon.ico') }}?v={{ $favVersion }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}?v={{ $favVersion }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}?v={{ $favVersion }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}?v={{ $favVersion }}">
<link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}?v={{ $favVersion }}">
@endif
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">
