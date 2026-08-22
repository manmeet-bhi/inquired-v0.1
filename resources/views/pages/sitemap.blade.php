@extends('layouts.app')

@section('title', 'Sitemap - Anywhereroles')

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-7xl mx-auto px-6">
        <!-- Header Section -->
        <div class="py-24 border-b border-gray-100 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl mb-8">
                <i data-lucide="map" class="w-8 h-8 text-blue-600"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 brand-font mb-6 tracking-tight">Sitemap</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Explore all sections and resources of Anywhereroles. Find your way to your next career opportunity effortlessly.
            </p>
        </div>

        <!-- Accordion Container -->
        <div class="py-16 space-y-6">
            <!-- 1. Main Pages -->
            <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 overflow-hidden" open>
                <summary class="flex items-center justify-between p-8 cursor-pointer hover:bg-gray-50/50 transition-colors list-none">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="home" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Main Pages</h2>
                    </div>
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                        <i data-lucide="chevron-down" class="w-5 h-5 group-open:rotate-180 transition-transform duration-300"></i>
                    </div>
                </summary>
                <div class="px-8 pb-8 pt-2 border-t border-gray-50">
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <li><a href="{{ route('home') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-blue-600 border border-transparent hover:border-blue-100 transition-all card-hover group/item">
                            <span class="font-bold">Home</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('jobs.index') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-blue-600 border border-transparent hover:border-blue-100 transition-all card-hover group/item">
                            <span class="font-bold">All Jobs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('companies') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-blue-600 border border-transparent hover:border-blue-100 transition-all card-hover group/item">
                            <span class="font-bold">All Companies</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('categories') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-blue-600 border border-transparent hover:border-blue-100 transition-all card-hover group/item">
                            <span class="font-bold">All Categories</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('blog') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-blue-600 border border-transparent hover:border-blue-100 transition-all card-hover group/item">
                            <span class="font-bold">Blog / Articles</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('search') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-blue-600 border border-transparent hover:border-blue-100 transition-all card-hover group/item">
                            <span class="font-bold">Search Jobs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                    </ul>
                </div>
            </details>

            <!-- 2. Job Types -->
            <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 overflow-hidden">
                <summary class="flex items-center justify-between p-8 cursor-pointer hover:bg-gray-50/50 transition-colors list-none">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="briefcase" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Job Types</h2>
                    </div>
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-400 group-hover:bg-green-50 group-hover:text-green-600 transition-colors">
                        <i data-lucide="chevron-down" class="w-5 h-5 group-open:rotate-180 transition-transform duration-300"></i>
                    </div>
                </summary>
                <div class="px-8 pb-8 pt-2 border-t border-gray-50">
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <li><a href="{{ route('remote-jobs') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-green-600 border border-transparent hover:border-green-100 transition-all card-hover group/item">
                            <span class="font-bold">Remote Jobs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('onsite-jobs') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-green-600 border border-transparent hover:border-green-100 transition-all card-hover group/item">
                            <span class="font-bold">On-site Jobs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('hybrid-jobs') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-green-600 border border-transparent hover:border-green-100 transition-all card-hover group/item">
                            <span class="font-bold">Hybrid Jobs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('internships') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-green-600 border border-transparent hover:border-green-100 transition-all card-hover group/item">
                            <span class="font-bold">Internships</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('freshers-jobs') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-green-600 border border-transparent hover:border-green-100 transition-all card-hover group/item">
                            <span class="font-bold">Freshers Jobs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('part-time-jobs') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-green-600 border border-transparent hover:border-green-100 transition-all card-hover group/item">
                            <span class="font-bold">Part Time Jobs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                    </ul>
                </div>
            </details>

            <!-- 3. Companies -->
            <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 overflow-hidden">
                <summary class="flex items-center justify-between p-8 cursor-pointer hover:bg-gray-50/50 transition-colors list-none">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="building-2" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Companies</h2>
                    </div>
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-400 group-hover:bg-purple-50 group-hover:text-purple-600 transition-colors">
                        <i data-lucide="chevron-down" class="w-5 h-5 group-open:rotate-180 transition-transform duration-300"></i>
                    </div>
                </summary>
                <div class="px-8 pb-8 pt-2 border-t border-gray-50">
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <li><a href="{{ route('startup-companies') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-purple-600 border border-transparent hover:border-purple-100 transition-all card-hover group/item">
                            <span class="font-bold">Startup Companies</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('mnc-companies') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-purple-600 border border-transparent hover:border-purple-100 transition-all card-hover group/item">
                            <span class="font-bold">MNCs</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        @php
                            $topCompanies = \App\Models\Company::latest()->take(6)->get();
                        @endphp
                        @foreach($topCompanies as $company)
                            <li><a href="{{ route('company.show', $company->slug) }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-purple-600 border border-transparent hover:border-purple-100 transition-all card-hover group/item">
                                <span class="font-bold">{{ $company->name }}</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                            </a></li>
                        @endforeach
                    </ul>
                </div>
            </details>

            <!-- 4. Support & Social -->
            <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 overflow-hidden">
                <summary class="flex items-center justify-between p-8 cursor-pointer hover:bg-gray-50/50 transition-colors list-none">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="heart" class="w-6 h-6 text-orange-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Support & Social</h2>
                    </div>
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-400 group-hover:bg-orange-50 group-hover:text-orange-600 transition-colors">
                        <i data-lucide="chevron-down" class="w-5 h-5 group-open:rotate-180 transition-transform duration-300"></i>
                    </div>
                </summary>
                <div class="px-8 pb-8 pt-2 border-t border-gray-50">
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <li><a href="{{ route('about') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-orange-600 border border-transparent hover:border-orange-100 transition-all card-hover group/item">
                            <span class="font-bold">About Us</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('contact') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-orange-600 border border-transparent hover:border-orange-100 transition-all card-hover group/item">
                            <span class="font-bold">Contact Us</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('support') }}" class="flex items-center gap-3 p-4 rounded-xl bg-orange-50 hover:bg-orange-100 text-orange-700 border border-orange-200 shadow-sm transition-all card-hover group/item">
                            <span class="font-bold flex items-center gap-2"><i data-lucide="heart" class="w-5 h-5 text-orange-600"></i> Support Us</span>
                        </a></li>
                        <li><a href="{{ route('contact') }}?subject=Share%20Your%20Thought" class="flex items-center gap-3 p-4 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 shadow-sm transition-all card-hover group/item italic">
                            <span class="font-bold flex items-center gap-2"><i data-lucide="message-square" class="w-5 h-5 text-blue-600"></i> Share Your Thought</span>
                        </a></li>
                    </ul>
                </div>
            </details>

            <!-- 5. Legal & Transparency -->
            <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 overflow-hidden">
                <summary class="flex items-center justify-between p-8 cursor-pointer hover:bg-gray-50/50 transition-colors list-none">
                    <div class="flex items-center gap-6">
                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="scale" class="w-6 h-6 text-indigo-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Legal & Transparency</h2>
                    </div>
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                        <i data-lucide="chevron-down" class="w-5 h-5 group-open:rotate-180 transition-transform duration-300"></i>
                    </div>
                </summary>
                <div class="px-8 pb-8 pt-2 border-t border-gray-50">
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <li><a href="{{ route('privacy') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-indigo-600 border border-transparent hover:border-indigo-100 transition-all card-hover group/item">
                            <span class="font-bold">Privacy Policy</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('terms') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-indigo-600 border border-transparent hover:border-indigo-100 transition-all card-hover group/item">
                            <span class="font-bold">Terms of Service</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('cookies') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-indigo-600 border border-transparent hover:border-indigo-100 transition-all card-hover group/item">
                            <span class="font-bold">Cookie Policy</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="{{ route('testimonials') }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-white text-gray-800 hover:text-indigo-600 border border-transparent hover:border-indigo-100 transition-all card-hover group/item">
                            <span class="font-bold">Testimonials</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-1 transition-all ml-auto"></i>
                        </a></li>
                        <li><a href="https://t.me/anywhereroles" target="_blank" class="flex items-center gap-3 p-4 rounded-xl bg-[#0088cc]/10 hover:bg-[#0088cc]/20 text-[#0088cc] border border-[#0088cc]/20 transition-all card-hover group/item font-bold">
                            <span>Join Telegram</span>
                            <i data-lucide="send" class="w-4 h-4 ml-auto"></i>
                        </a></li>
                    </ul>
                </div>
            </details>
        </div>

        <!-- Footer Call to Action -->
        <div class="mt-12 mb-24 hero-gradient rounded-2xl p-12 md:p-16 text-center shadow-sm border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-900 brand-font mb-6">Still have questions?</h2>
            <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Contact our support team directly. We are here to help you find your dream role.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-md flex items-center justify-center gap-2">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                    Contact Support
                </a>
                <a href="{{ route('jobs.index') }}" class="bg-white text-gray-700 px-8 py-4 rounded-xl font-bold border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-5 h-5"></i>
                    Browse Jobs
                </a>
            </div>
        </div>
    </main>
</div>

<style>
    /* Hide the default marker for <details> */
    details > summary::-webkit-details-marker {
        display: none;
    }
    details > summary {
        list-style: none;
    }
    /* Smooth transition for details expansion */
    details[open] summary ~ * {
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
        0% { opacity: 0; transform: translateY(-5px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
