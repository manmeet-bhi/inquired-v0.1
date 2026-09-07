@extends('layouts.app')

@section('title', 'Employer Listing Policy - Inaquired')
@section('meta_description', 'Review the rules, quality standards, and listing criteria for job openings and featured placements on Inaquired.')

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-4xl mx-auto px-6 py-12 sm:py-16">
        
        <!-- Header -->
        <div class="mb-10 pb-8 border-b border-gray-100 text-center sm:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wider mb-3">
                <span>Employer & Recruiter Guidelines</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-3">
                Employer Listing Policy
            </h1>
            <p class="text-gray-600 text-base sm:text-lg leading-relaxed">
                Our standards, review rules, and transparency commitments for job postings and featured listings on Inaquired.
            </p>
            <div class="text-xs text-gray-400 mt-4">
                Effective Date: September 2026 &bull; Status: Featured Listing Beta (No-Charge)
            </div>
        </div>

        <!-- Policy Content Container -->
        <div class="bg-white rounded-2xl border border-gray-100 p-8 sm:p-10 space-y-10 shadow-sm leading-relaxed text-gray-700">
            
            <!-- Section 1: Overview & Beta Program -->
            <section>
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">1. Overview & Featured Listing Beta</h2>
                </div>
                <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                    Inaquired is currently operating a curated, no-charge featured listing beta for employers and recruiters. We do not sell paid placements or charge fees to list openings at this time. This policy outlines the quality benchmarks that govern all submissions today, as well as the non-negotiable principles that will apply to any future sponsored listings.
                </p>
            </section>

            <!-- Section 2: Eligibility & What Can Be Featured -->
            <section>
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">2. Eligibility & Listing Criteria</h2>
                </div>
                <p class="text-gray-600 mb-4 text-sm sm:text-base">
                    To be eligible for publication or featured placement on Inaquired, every job opening must satisfy the following criteria:
                </p>
                
                <div class="space-y-3 bg-gray-50/70 rounded-xl p-5 border border-gray-100 text-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span><strong>Direct Application Destination:</strong> The post URL must lead directly to a live, official employer-controlled careers website or verified Applicant Tracking System (e.g., Greenhouse, Lever, Workday, Ashby, BambooHR).</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span><strong>Location & Work Arrangement:</strong> The role must clearly specify remote eligibility, regional/time-zone constraints, or physical office location (Onsite / Hybrid).</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span><strong>Accurate Job Information:</strong> All submissions must include verifiable company identity, genuine job title, clear responsibilities, and legitimate employment status (Full-time, Part-time, Internship, Contract).</span>
                    </div>
                </div>

                <div class="mt-4 p-4 rounded-xl bg-red-50/60 border border-red-100 text-sm text-red-900">
                    <p class="font-semibold mb-1">Strict Rejection & Non-Eligibility:</p>
                    <p class="text-xs sm:text-sm text-red-800">
                        We immediately reject expired listings, duplicate entries, ambiguous role descriptions, commission-only/multi-level schemes, fee-based application setups, or any misleading postings. Submitting a role never guarantees publication or featured placement.
                    </p>
                </div>
            </section>

            <!-- Section 3: Labels & Ranking -->
            <section>
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">3. Labels, Attribution & Search Integrity</h2>
                </div>
                <p class="text-gray-600 text-sm sm:text-base mb-3 leading-relaxed">
                    Transparency is paramount. All active beta featured listings are clearly designated with a <strong>Featured</strong> label. Any future commercial placement will be prominently and unequivocally labeled as <strong>Sponsored</strong> before a job seeker views or applies.
                </p>
                <div class="bg-blue-50/40 rounded-xl p-5 border border-blue-100 text-sm text-slate-800 space-y-2">
                    <p class="font-semibold text-blue-950">Search Neutrality Commitment:</p>
                    <p>Featured or sponsored status may enhance visibility on relevant pages, but will <strong>never</strong>:</p>
                    <ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm text-slate-700">
                        <li>Bypass user search filters or query parameters.</li>
                        <li>Conceal original company attribution or source details.</li>
                        <li>Alter or redirect the employer's genuine application destination link.</li>
                        <li>Force an ineligible or irrelevant vacancy into unrelated searches.</li>
                    </ul>
                </div>
            </section>

            <!-- Section 4: Duration, Review, and Removal -->
            <section>
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">4. Duration, Quality Audits & Removal</h2>
                </div>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-3">
                    Each featured placement has a defined visibility window. Our curation team conducts periodic audits to ensure that destination links remain live and active.
                </p>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    We reserve the right to refuse, suspend, or remove any listing immediately without prior notice if the role expires, changes materially, becomes misleading, or receives a credible report of inaccuracies. This ensures the highest standard of trust for our job-seeking community.
                </p>
            </section>

            <!-- Section 5: Candidate Privacy & Metrics -->
            <section id="privacy">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">5. Candidate Privacy & Performance Reporting</h2>
                </div>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-3">
                    Inaquired upholds strict privacy standards. We <strong>do not</strong> sell, rent, or disclose job-seeker identities, resumes, application contents, or private personal data to employers or third-party advertisers.
                </p>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Any analytics shared with employers are restricted strictly to aggregated, non-personally identifiable metrics, such as total listing views and application link clicks.
                </p>
            </section>

            <!-- Section 6: Future Paid Listings Framework -->
            <section>
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">6. Future Commercial Placements</h2>
                </div>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    A paid listing program will only commence after our featured beta demonstrates sustained employer demand and verified candidate value. Transparent pricing terms, billing guidelines, and any material policy revisions will be publicly announced and documented on this page before any commercial agreements are initiated.
                </p>
            </section>

            <!-- Contact / Inquiries Box -->
            <section class="bg-blue-50 rounded-xl p-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Questions About This Policy?</h2>
                <p class="text-gray-600 leading-relaxed mb-4 text-sm sm:text-base">
                    If you have any questions, suggestions, or reports regarding our Employer Listing Policy or a specific listing, please reach out to our team:
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:items-center justify-between text-sm text-gray-700">
                    <p>Email: <a href="mailto:inaquired@gmail.com" class="text-blue-600 font-medium hover:underline">inaquired@gmail.com</a></p>
                    <a href="{{ route('contact') }}?subject=Employer%20Listing%20Policy%20Inquiry" class="inline-flex items-center gap-1.5 text-blue-600 font-semibold hover:text-blue-700 hover:underline">
                        <span>Contact Policy Team</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </section>
        </div>

        <!-- Back to Employer Submission -->
        <div class="mt-8 text-center">
            <a href="{{ route('for-employers') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Job Submission Form</span>
            </a>
        </div>

    </main>
</div>
@endsection
