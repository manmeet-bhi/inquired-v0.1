@extends('layouts.app')

@section('title', 'Startup Companies - Browse Jobs by Company')

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-7xl mx-auto px-6 py-12">
        <!-- Header Section REMOVED -->

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-16">
            <!-- Sidebar -->
            <x-company-sidebar type="nav" active="startup" />

            <!-- Main Content Area -->
            <div class="flex-grow">
                <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">
                            {{ $companies->total() }} {{ $companies->total() === 1 ? 'Startup' : 'Startups' }}
                        </h2>
                        @if(request()->filled('search'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold border border-blue-100">
                                <span>Results for "{{ request('search') }}"</span>
                                <a href="{{ route('startup-companies') }}" class="hover:text-blue-900 ml-1 font-bold" title="Clear search">✕</a>
                            </span>
                        @endif
                    </div>
                </div>

                @if($companies->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                    @foreach($companies as $company)
                        <x-company-card :company="$company" />
                    @endforeach
                </div>

                @if($companies->hasPages())
                    <div class="flex justify-center mt-12">
                        {{ $companies->links() }}
                    </div>
                @endif
                @else
                <div class="py-20 text-center">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No startup companies found</h3>
                    <p class="text-gray-500 text-sm font-medium mt-1">
                        @if(request()->filled('search'))
                            No startup companies matching "<strong class="text-gray-700">{{ request('search') }}</strong>".
                        @else
                            New startups are being added regularly. Check back soon!
                        @endif
                    </p>
                    @if(request()->filled('search'))
                        <div class="mt-6">
                            <a href="{{ route('startup-companies') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-600/20 transition-all">
                                <span>Clear Search</span>
                            </a>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </main>
@include('partials.trademark-disclaimer')
</div>
@endsection