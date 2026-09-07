@extends('layouts.app')

@section('title', 'About - Inaquired')

@section('content')
<div class="bg-white">


    <main class="max-w-7xl mx-auto px-6">
        <!-- Top Section: Mission & Offer -->
        <div class="py-24 border-b border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                <!-- Left Column: Mission -->
                <section class="bg-white rounded-2xl border border-gray-100 p-8 h-full shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Our Mission</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-lg mb-4">
                        At Inaquired, our goal is to make job discovery simple, transparent, and accessible for everyone. We collect and share job opportunities from various trusted sources so that job seekers can easily explore openings in one place.
                    </p>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Our mission is to help bridge the gap between job seekers and opportunities by providing a clean, easy-to-use platform where users can find the latest job listings quickly and efficiently.
                    </p>
                </section>

                <!-- Right Column: What We Offer -->
                <section class="bg-white rounded-2xl border border-gray-100 p-8 h-full shadow-sm hover:shadow-md transition-shadow">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">What We Offer</h2>
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">For Job Seekers</h3>
                                    <p class="text-gray-600 leading-relaxed text-sm">
                                        Browse thousands of opportunities from remote work to on-site positions. Save your favorite jobs, 
                                        get personalized recommendations, and apply with confidence.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">For Employers</h3>
                                    <p class="text-gray-600 leading-relaxed text-sm">
                                        Connect with top talent across various industries. Post jobs, manage applications, 
                                        and find the perfect candidates for your team.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

                <!-- How Our Platform Works -->
                <section class="max-w-7xl mx-auto px-6 py-16 border-b border-gray-100">
                    <div class="max-w-4xl mx-auto">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">How Our Platform Works</h2>
                        <p class="text-gray-600 mb-4">
                            Inaquired is a third-party job listing platform. We gather job information from publicly available sources, company career pages, and other job portals, and share them on our website to help users stay updated with new opportunities.
                        </p>
                        <div class="bg-white border border-gray-100 rounded-xl p-6">
                            <ul class="list-disc pl-5 text-gray-600 space-y-2">
                                <li>We do not have any direct partnership, contract, or affiliation with the companies listed on our website unless explicitly stated.</li>
                                <li>We do not act as a recruitment agency.</li>
                                <li>All applications are processed through the official company websites or original job sources.</li>
                                <li>Our goal is only to simplify the process of finding job opportunities by bringing them together in one place.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Values Section (Centered) -->
        <section class="max-w-6xl mx-auto px-6 py-24 border-b border-gray-100">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Us</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">We are committed to providing the best experience for both job seekers and employers.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: Transparency -->
                <div class="bg-white border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-1 text-gray-900">Transparency</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Clear job descriptions, honest company reviews, and transparent hiring processes so you know exactly what to expect.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Daily Updates -->
                <div class="bg-white border border-green-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-100 flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-1 text-gray-900">Daily Updates</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Stay ahead of the competition with timely job and internship postings updated daily by our dedicated team.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Trust -->
                <div class="bg-white border border-purple-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-purple-100 flex-shrink-0">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-1 text-gray-900">Trust</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Our team carefully researches and verifies every job opening to ensure accuracy and legitimacy.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="max-w-3xl mx-auto px-6 py-24 border-b border-gray-100">
            <div class="space-y-4">
                <!-- Q1 -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-6 list-none bg-gray-50/50 hover:bg-gray-50 transition-colors">
                            <span class="text-lg font-semibold text-gray-900">From where are jobs collected?</span>
                            <span class="transition-transform duration-300 group-open:rotate-180">
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="px-6 py-4 text-gray-600 leading-relaxed border-t border-gray-100">
                            We aggregate job listings directly from verified company career pages, official recruitment portals, and trusted partner networks to ensure you have access to the most current and legitimate opportunities.
                        </div>
                    </details>
                </div>

                <!-- Q2 -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-6 list-none bg-gray-50/50 hover:bg-gray-50 transition-colors">
                            <span class="text-lg font-semibold text-gray-900">Is it authentic?</span>
                            <span class="transition-transform duration-300 group-open:rotate-180">
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="px-6 py-4 text-gray-600 leading-relaxed border-t border-gray-100">
                            Yes, absolutely. We employ a rigorous 2-step manual verification process involving expert human review to validate every job posting before it goes live on our platform.
                        </div>
                    </details>
                </div>

                <!-- Q3 -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-6 list-none bg-gray-50/50 hover:bg-gray-50 transition-colors">
                            <span class="text-lg font-semibold text-gray-900">Who are we?</span>
                            <span class="transition-transform duration-300 group-open:rotate-180">
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="px-6 py-4 text-gray-600 leading-relaxed border-t border-gray-100">
                            Inaquired is a dedicated platform committed to bridging the gap between talented professionals and global opportunities. We are a team of passionate individuals working to make job searching simple, transparent, and accessible for everyone.
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <!-- Contact Section (Centered) -->
        <section class="max-w-4xl mx-auto py-24 text-center">
            <div class="bg-blue-50 rounded-3xl p-10 md:p-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Ready to Get Started?</h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-10 max-w-2xl mx-auto">
                    Join thousands of professionals who have found their dream jobs through Inaquired. Your next opportunity awaits.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('jobs.index') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-700 transition-all transform hover:scale-105 shadow-lg shadow-blue-600/20">
                        Browse Jobs
                    </a>
                    <a href="{{ route('companies') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all transform hover:scale-105 border border-blue-200 shadow-sm">
                        View Companies
                    </a>
                    <a href="https://t.me/inaquiredtelegram" target="_blank" class="bg-[#0088cc] text-white px-8 py-4 rounded-xl font-bold hover:bg-[#0077b3] transition-all transform hover:scale-105 shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        Join Telegram
                    </a>
                </div>
            </div>
        </section>
</div>
@endsection
