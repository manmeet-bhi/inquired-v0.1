<footer class="bg-slate-950 text-slate-300 font-sans border-t border-slate-800">
    <div class="mx-auto w-full max-w-7xl px-4 py-12 lg:py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-12">
            
            <!-- Column 1: Brand & About -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group">
                    {{-- Logo from top nav bar --}}
                    @if(file_exists(public_path('images/logos/logo.png')))
                        <img src="{{ asset('images/logos/logo.png') }}" alt="Anywhereroles Logo" class="h-8 w-auto group-hover:opacity-80 transition-opacity filter brightness-0 invert">
                    @elseif(file_exists(public_path('images/logos/logo.svg')))
                        <img src="{{ asset('images/logos/logo.svg') }}" alt="Anywhereroles Logo" class="h-8 w-auto group-hover:opacity-80 transition-opacity filter brightness-0 invert">
                    @else
                        <span class="w-2.5 h-2.5 bg-blue-400 rounded-full group-hover:bg-blue-300 transition-colors"></span>
                    @endif
                </a>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Discover opportunities across the globe. Find your perfect remote, onsite, or hybrid job with Anywhereroles.
                </p>
                <div class="pt-2">
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-3">Connect With Us</p>
                    <div class="flex items-center gap-4">
                        <a href="https://www.whatsapp.com/channel/0029Vb85DUa9xVJXVPb5Uw22" target="_blank" class="text-slate-400 hover:text-[#25D366] transition-colors transform hover:scale-110" aria-label="WhatsApp">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </a>
                        <a href="https://t.me/anywhereroles" target="_blank" class="text-slate-400 hover:text-[#0088cc] transition-colors transform hover:scale-110" aria-label="Telegram">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </a>
                        <a href="https://discord.gg/gzK7xQtE" target="_blank" class="text-slate-400 hover:text-[#5865F2] transition-colors transform hover:scale-110" aria-label="Discord">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.211.375-.445.864-.608 1.25a18.27 18.27 0 00-5.487 0c-.163-.386-.397-.875-.609-1.25a.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.08.08 0 00.087-.027c.461-.63.873-1.295 1.226-1.994a.076.076 0 00-.042-.106 13.107 13.107 0 01-1.872-.892.077.077 0 00-.008-.128 10.713 10.713 0 00.372-.294.075.075 0 00.03-.066c.001-.009.001-.018 0-.027 3.928 1.793 8.18 1.793 12.062 0a.077.077 0 00.032.054.076.076 0 00.031.02c.12.098.246.198.373.294a.077.077 0 00-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.699.772 1.364 1.225 1.994a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.030.077.077 0 00.032-.057c.5-4.761-.838-8.895-3.549-12.55a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-.965-2.157-2.156 0-1.193.964-2.157 2.157-2.157 1.193 0 2.156.964 2.157 2.157 0 1.191-.964 2.156-2.157 2.156zm7.975 0c-1.183 0-2.157-.965-2.157-2.156 0-1.193.965-2.157 2.157-2.157 1.192 0 2.157.964 2.157 2.157 0 1.191-.965 2.156-2.157 2.156z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2: Jobs -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-100">Explore Jobs</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('remote-jobs') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Remote Jobs</a></li>
                    <li><a href="{{ route('onsite-jobs') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Onsite Jobs</a></li>
                    <li><a href="{{ route('hybrid-jobs') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Hybrid Jobs</a></li>
                    <li><a href="{{ route('internships') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Internships</a></li>
                    <li><a href="{{ route('freshers-jobs') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Freshers Jobs</a></li>
                    <li><a href="{{ route('part-time-jobs') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Part Time Jobs</a></li>
                </ul>
            </div>

            <!-- Column 3: Companies & Resources -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-100">Companies</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('companies') }}" class="text-slate-400 hover:text-blue-400 transition-colors">All Companies</a></li>
                    <li><a href="{{ route('startup-companies') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Startups</a></li>
                    <li><a href="{{ route('mnc-companies') }}" class="text-slate-400 hover:text-blue-400 transition-colors">MNCs</a></li>
                    <li><a href="{{ route('unicorn-companies') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Unicorns</a></li>
                    <li><a href="{{ route('categories') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Categories</a></li>
                </ul>
            </div>

            <!-- Column 4: About & Resources -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-100">About</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('about') }}" class="text-slate-400 hover:text-blue-400 transition-colors">About Us</a></li>
                    <li><a href="{{ route('blog') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Blog</a></li>
                    <li><a href="{{ route('testimonials') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Testimonials</a></li>
                    <li><a href="{{ route('contact') }}" class="text-slate-400 hover:text-blue-400 transition-colors">Contact Us</a></li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-px bg-slate-800 mb-8"></div>

        <!-- Bottom Footer -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <!-- Left: Copyright -->
            <div class="text-xs text-slate-500 text-center md:text-left">
                &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="text-slate-400 hover:text-blue-400 transition-colors font-semibold">Anywhereroles</a>. All Rights Reserved.
            </div>

            <!-- Center: Legal Links -->
            <div class="flex flex-wrap justify-center gap-4 text-xs font-medium text-slate-500">
                <a href="{{ route('cookies') }}" class="hover:text-blue-400 transition-colors">Cookie Policy</a>
                <span class="text-slate-700">•</span>
                <a href="{{ route('privacy') }}" class="hover:text-blue-400 transition-colors">Privacy Policy</a>
                <span class="text-slate-700">•</span>
                <a href="{{ route('terms') }}" class="hover:text-blue-400 transition-colors">Terms of Service</a>
            </div>

            <!-- Right: Social Quick Links -->
            <div class="flex items-center gap-4">
                <span class="text-xs text-slate-600 hidden sm:inline">Follow us:</span>
                <div class="flex gap-3">
                    <a href="https://www.whatsapp.com/channel/0029Vb85DUa9xVJXVPb5Uw22" target="_blank" class="text-slate-500 hover:text-[#25D366] transition-colors" aria-label="WhatsApp">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                    </a>
                    <a href="https://t.me/anywhereroles" target="_blank" class="text-slate-500 hover:text-[#0088cc] transition-colors" aria-label="Telegram">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                    </a>
                    <a href="https://discord.gg/gzK7xQtE" target="_blank" class="text-slate-500 hover:text-[#5865F2] transition-colors" aria-label="Discord">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.211.375-.445.864-.608 1.25a18.27 18.27 0 00-5.487 0c-.163-.386-.397-.875-.609-1.25a.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.08.08 0 00.087-.027c.461-.63.873-1.295 1.226-1.994a.076.076 0 00-.042-.106 13.107 13.107 0 01-1.872-.892.077.077 0 00-.008-.128 10.713 10.713 0 00.372-.294.075.075 0 00.03-.066c.001-.009.001-.018 0-.027 3.928 1.793 8.18 1.793 12.062 0a.077.077 0 00.032.054.076.076 0 00.031.02c.12.098.246.198.373.294a.077.077 0 00-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.699.772 1.364 1.225 1.994a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.030.077.077 0 00.032-.057c.5-4.761-.838-8.895-3.549-12.55a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-.965-2.157-2.156 0-1.193.964-2.157 2.157-2.157 1.193 0 2.156.964 2.157 2.157 0 1.191-.964 2.156-2.157 2.156zm7.975 0c-1.183 0-2.157-.965-2.157-2.156 0-1.193.965-2.157 2.157-2.157 1.192 0 2.157.964 2.157 2.157 0 1.191-.965 2.156-2.157 2.156z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
