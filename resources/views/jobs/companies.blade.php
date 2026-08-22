@extends('layouts.app')

@section('title', 'Companies - Browse Jobs by Company')

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-7xl mx-auto px-6 py-12">
        
        <!-- Header Section REMOVED -->


        <div class="flex flex-col lg:flex-row gap-6 lg:gap-16">
            <!-- Sidebar Navigation -->
            <x-company-sidebar type="nav" active="all" />


            <!-- Main Content Area -->
            <div class="flex-grow">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">{{ $companies->total() }} Companies</h2>
                </div>

                @if($companies->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($companies as $company)
                        <x-company-card :company="$company" />
                    @endforeach
                </div>

                <!-- Pagination -->
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
                    <h3 class="text-xl font-bold text-gray-900">No companies found</h3>
                    <p class="text-gray-500">Try adjusting your filters to find more opportunities.</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>


@endsection