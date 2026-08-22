@extends('layouts.cms')

@section('title', 'Access Denied - CMS')

@section('content')
<div class="flex-1 flex items-center justify-center p-4 min-h-[calc(100vh-80px)]">
    <div class="max-w-md w-full animate-in fade-in zoom-in duration-300">
        <!-- Error Modal Style Card -->
        <div class="bg-white rounded-xl shadow-2xl shadow-indigo-200/50 border border-slate-100 overflow-hidden relative">
            <!-- Top Gradient Bar -->
            <div class="h-2 bg-gradient-to-r from-rose-500 via-indigo-500 to-indigo-600"></div>
            
            <div class="p-8 sm:p-12 text-center">
                <!-- Icon Container -->
                <div class="mb-8 relative inline-flex">
                    <div class="absolute inset-0 bg-rose-100 rounded-full animate-ping opacity-20"></div>
                    <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center relative">
                        <i data-lucide="shield-alert" class="w-12 h-12 text-rose-500"></i>
                    </div>
                </div>

                <!-- Error Message -->
                <h1 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">403</h1>
                <h2 class="text-xl font-bold text-slate-800 mb-4">Access Denied</h2>
                
                <p class="text-slate-500 leading-relaxed mb-0">
                    You do not have the required permissions to access this section. 
                    <span class="block font-medium text-slate-700 mt-2 italic text-sm">Please connect to the administrator to request access.</span>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Ensure icons are rendered if the layout didn't catch them
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection
