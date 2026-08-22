{{-- Dynamic Icon Loading Helper --}}
@php
    $offlineMode = config('offline.offline_mode', false);
@endphp

@if($offlineMode)
    {{-- Offline Mode: Use Local Lucide Icons --}}
    <script src="{{ asset(config('offline.local.lucide')) }}"></script>
    <script>lucide.createIcons();</script>
@else
    {{-- Online Mode: Use CDN --}}
    <script src="{{ config('offline.cdn.lucide') }}"></script>
    <script>lucide.createIcons();</script>
@endif