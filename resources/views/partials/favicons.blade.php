@php
    $dynamicFavicon = !empty($seoSettings['favicon'])
        ? \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($seoSettings['favicon'])
        : null;
@endphp

@if($dynamicFavicon)
<link rel="icon" href="{{ $dynamicFavicon }}">
<link rel="shortcut icon" href="{{ $dynamicFavicon }}">
<link rel="apple-touch-icon" href="{{ $dynamicFavicon }}">
@else
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">
<link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">
@endif
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">
