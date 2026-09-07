@extends('layouts.app')

@section('title', 'Contact Us - Inaquired')
@section('meta_description', 'Get in touch with the Inaquired team. Send us your questions, feedback, or support inquiries.')

@push('styles')
<style>
    @keyframes checkmarkStroke {
        100% { stroke-dashoffset: 0; }
    }
    @keyframes checkmarkScale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.15, 1.15, 1); }
    }
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2.5;
        stroke: #10b981;
        fill: none;
        animation: checkmarkStroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke-width: 3.5;
        stroke: #10b981;
        animation: checkmarkStroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 0.45s forwards;
    }
    .checkmark-wrapper {
        animation: checkmarkScale 0.4s ease-in-out 0.75s both;
    }
</style>
@endpush

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold uppercase tracking-wider mb-4">
                <span>Support & Inquiries</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                Get in Touch With Us
            </h1>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Have questions, suggestions, or need help finding or posting opportunities? We'd love to hear from you. Send us a message below or connect with our community.
            </p>
        </div>

        <!-- Two Column Grid (Side by side on medium and large screens) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- LEFT COLUMN: Contact Methods & Direct Channels (5 cols on md & lg) -->
            <div class="md:col-span-5 lg:col-span-5 space-y-6">
                
                <!-- Fast Connect Channels Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Direct Channels</h2>
                    <div class="space-y-4">
                        
                        <!-- WhatsApp -->
                        <a href="https://whatsapp.com/channel/0029Vb8XpiRAYlUJPEZqek2s" target="_blank" rel="noopener noreferrer" class="flex items-start gap-4 p-4 rounded-xl bg-gray-50/70 border border-gray-100 hover:bg-emerald-50/40 hover:border-emerald-200 transition-all group">
                            <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition-colors">
                                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-0.5 group-hover:text-emerald-600 transition-colors">WhatsApp Channel</h3>
                                <p class="text-xs text-gray-600">Quick announcements, daily alerts & updates</p>
                            </div>
                        </a>

                        <!-- Telegram -->
                        <a href="https://t.me/inaquiredtelegram" target="_blank" rel="noopener noreferrer" class="flex items-start gap-4 p-4 rounded-xl bg-gray-50/70 border border-gray-100 hover:bg-blue-50/40 hover:border-blue-200 transition-all group">
                            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition-colors">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-0.5 group-hover:text-blue-600 transition-colors">Telegram Community</h3>
                                <p class="text-xs text-gray-600">Join discussions & instant notifications</p>
                            </div>
                        </a>

                        <!-- Discord -->
                        <a href="https://discord.gg/bZDamu2tT" target="_blank" rel="noopener noreferrer" class="flex items-start gap-4 p-4 rounded-xl bg-gray-50/70 border border-gray-100 hover:bg-indigo-50/40 hover:border-indigo-200 transition-all group">
                            <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-100 transition-colors">
                                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.211.375-.445.864-.608 1.25a18.27 18.27 0 00-5.487 0c-.163-.386-.397-.875-.609-1.25a.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.08.08 0 00.087-.027c.461-.63.873-1.295 1.226-1.994a.076.076 0 00-.042-.106 13.107 13.107 0 01-1.872-.892.077.077 0 00-.008-.128 10.713 10.713 0 00.372-.294.075.075 0 00.03-.066c.001-.009.001-.018 0-.027 3.928 1.793 8.18 1.793 12.062 0a.077.077 0 00.032.054.076.076 0 00.031.02c.12.098.246.198.373.294a.077.077 0 00-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.699.772 1.364 1.225 1.994a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.030.077.077 0 00.032-.057c.5-4.761-.838-8.895-3.549-12.55a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-.965-2.157-2.156 0-1.193.964-2.157 2.157-2.157 1.193 0 2.156.964 2.157 2.157 0 1.191-.964 2.156-2.157 2.156zm7.975 0c-1.183 0-2.157-.965-2.157-2.156 0-1.193.965-2.157 2.157-2.157 1.192 0 2.157.964 2.157 2.157 0 1.191-.965 2.156-2.157 2.156z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-0.5 group-hover:text-indigo-600 transition-colors">Discord Server</h3>
                                <p class="text-xs text-gray-600">Collaborate, network & ask questions</p>
                            </div>
                        </a>

                        <!-- Email -->
                        <a href="mailto:inaquired@gmail.com" class="flex items-start gap-4 p-4 rounded-xl bg-gray-50/70 border border-gray-100 hover:bg-purple-50/40 hover:border-purple-200 transition-all group">
                            <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-purple-100 transition-colors">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-0.5 group-hover:text-purple-600 transition-colors">Email Support</h3>
                                <p class="text-xs sm:text-sm text-blue-600 group-hover:text-purple-700 font-medium transition-colors">inaquired@gmail.com</p>
                            </div>
                        </a>

                    </div>
                </div>

                <!-- Response Commitment Card -->
                <div class="bg-blue-50/60 rounded-2xl border border-blue-100 p-6 sm:p-8 shadow-sm">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2">Here to Help</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Whether you are a job seeker looking for guidance or an employer sharing feedback, our team is committed to assisting you.
                    </p>
                    <div class="flex items-center text-xs font-semibold text-blue-800 bg-white px-4 py-3 rounded-xl border border-blue-100 shadow-sm">
                        <svg class="w-4 h-4 mr-2 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Typical response time: ~24 hours</span>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Contact Form (7 cols on md & lg) -->
            <div class="md:col-span-7 lg:col-span-7">
                
                @if(session('success'))
                    <!-- Animated Success Card with Right Tick & Send Another Button -->
                    <div class="bg-white rounded-2xl border border-emerald-100 p-8 sm:p-12 shadow-sm text-center">
                        <!-- Animated SVG Checkmark / Tick -->
                        <div class="checkmark-wrapper w-20 h-20 rounded-full bg-emerald-50 border border-emerald-200/80 flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <svg class="checkmark-svg w-12 h-12 text-emerald-500" viewBox="0 0 52 52">
                                <circle class="checkmark-circle" cx="26" cy="26" r="24" fill="none"/>
                                <path class="checkmark-check" fill="none" stroke-linecap="round" stroke-linejoin="round" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3 tracking-tight">
                            Message Sent!
                        </h2>
                        <p class="text-gray-600 max-w-md mx-auto text-sm sm:text-base mb-8 leading-relaxed">
                            {{ session('success') }}
                        </p>

                        <div class="flex justify-center">
                            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-600/20 transition-all transform hover:scale-[1.02] active:scale-[0.98] text-sm tracking-normal cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Send Another Message</span>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Error Summary (if any) -->
                    @if($errors->any())
                        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-900 shadow-sm">
                            <div class="flex items-center gap-2 font-bold mb-2 text-sm text-red-800">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Please fix the following:</span>
                            </div>
                            <ul class="list-disc pl-5 text-xs text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Contact Form Card -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-10 shadow-sm hover:shadow-md transition-shadow">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Send Us a Message</h2>
                            <p class="text-sm text-gray-600">Fill out the form below and we will respond as soon as possible.</p>
                        </div>

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Your Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    placeholder="e.g. John Doe"
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 ring-1 ring-red-300 bg-red-50/20' : 'border-gray-200 bg-white' }} focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                                >
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    placeholder="e.g. john@example.com"
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-300 ring-1 ring-red-300 bg-red-50/20' : 'border-gray-200 bg-white' }} focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-gray-900 placeholder:text-gray-400 text-sm font-normal transition-all"
                                >
                                @error('email')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Message <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    rows="5" 
                                    required
                                    placeholder="How can we help you? Provide as much detail as possible..."
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('message') ? 'border-red-300 ring-1 ring-red-300 bg-red-50/20' : 'border-gray-200 bg-white' }} focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-gray-900 placeholder:text-gray-400 text-sm font-normal leading-relaxed transition-all resize-y"
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Privacy Note -->
                            <p class="text-xs text-gray-500 leading-relaxed">
                                We respect your privacy. Your information is securely handled in accordance with our 
                                <a href="{{ route('privacy') }}" class="text-blue-600 font-medium hover:underline">Privacy Policy</a>.
                            </p>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button 
                                    type="submit" 
                                    class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 transition-all transform hover:scale-[1.01] active:scale-[0.99] text-base cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    <span>Send Message</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
