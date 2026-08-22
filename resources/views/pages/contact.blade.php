@extends('layouts.app')

@section('title', 'Contact Us - Anywhereroles')

@section('content')
<div class="bg-white">


    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid md:grid-cols-2 gap-12 items-start">
            
            <!-- LEFT COLUMN: Contact Details & FAQ -->
            <div class="space-y-8">
                <!-- Contact Methods -->
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-md transition-shadow">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">WhatsApp</h3>
                                <p class="text-gray-600">Available for quick support and inquiries</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Telegram</h3>
                                <p class="text-gray-600">Join our community for updates and discussions</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">anywhereroles@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Why Reach Out? (Filling space) -->
                <div class="bg-blue-50/50 rounded-2xl border border-blue-100 p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Here to Help</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Whether you're a job seeker looking for your next opportunity or an employer seeking to hire top talent, we're here to help you navigate the process.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center text-blue-800 font-medium bg-white px-4 py-3 rounded-xl border border-blue-100 hover:border-blue-200 hover:bg-blue-50/50 transition-colors shadow-sm">
                            <svg class="w-5 h-5 mr-3 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span>Get in touch and let us know how we can help.</span>
                        </div>
                        <div class="flex items-center text-blue-800 font-medium bg-white px-4 py-3 rounded-xl border border-blue-100 hover:border-blue-200 hover:bg-blue-50/50 transition-colors shadow-sm">
                            <svg class="w-5 h-5 mr-3 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Response time: ~24 hours</span>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section (Moved to Left Column) -->

            </div>

            <!-- RIGHT COLUMN: Contact Form & Quick Links -->
            <div class="space-y-6">
                
                <!-- Google Form Query Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 font-unbounded">Submit a Query</h3>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                Have specific questions or need assistance? Fill out our detailed form and we'll get back to you.
                            </p>
                            <a href="https://docs.google.com/forms/d/12sXwCj2Shdm2HTRdx8s7VnCL6hCtF2LepqrRm8MLRNM/edit" target="_blank" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 hover:underline decoration-2 underline-offset-2 transition-all">
                                Open Form
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Support Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-100 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 font-unbounded">Support Us</h3>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                Anywhereroles is free for everyone. Check out six great ways to support us.
                            </p>
                            <a href="{{ route('support') }}" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 hover:underline decoration-2 underline-offset-2 transition-all">
                                Learn How
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>



                <!-- Socials Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-100 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 font-unbounded">Follow us</h3>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                Daily remote jobs and updates on WhatsApp & Telegram.
                            </p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-green-600 font-semibold hover:text-green-700 hover:underline decoration-2 underline-offset-2 transition-all">WhatsApp</a>
                                <span class="text-gray-300">|</span>
                                <a href="#" class="text-blue-500 font-semibold hover:text-blue-600 hover:underline decoration-2 underline-offset-2 transition-all">Telegram</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
@endsection
