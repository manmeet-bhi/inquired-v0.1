{{-- Dynamic Asset Loading Helper --}}
@php
    $offlineMode = config('offline.offline_mode', false);
@endphp

@if($offlineMode)
    {{-- Offline Mode: Use Local Assets --}}
    <link href="{{ asset(config('offline.local.tailwind')) }}" rel="stylesheet">
    <link href="{{ asset(config('offline.local.fonts.inter')) }}" rel="stylesheet">
    <link href="{{ asset(config('offline.local.fonts.unbounded')) }}" rel="stylesheet">
@else
    {{-- Online Mode: Use CDN --}}
    <script src="{{ config('offline.cdn.tailwind') }}"></script>
    <link href="{{ config('offline.cdn.fonts.inter') }}" rel="stylesheet">
    <link href="{{ config('offline.cdn.fonts.unbounded') }}" rel="stylesheet">
@endif