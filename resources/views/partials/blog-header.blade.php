<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="brand-font text-xl font-bold tracking-tighter text-blue-600 uppercase flex items-center gap-2">
                    {{-- Logo Image Option --}}
                    @if(file_exists(public_path('assets/logos/logo.png')))
                        <img src="{{ asset('assets/logos/logo.png') }}" alt="Inaquired Logo" class="h-8 w-auto">

                    @elseif(file_exists(public_path('assets/logos/logo.svg')))
                        <img src="{{ asset('assets/logos/logo.svg') }}" alt="Inaquired Logo" class="h-8 w-auto">
                        inaquired
                    @else
                        {{-- Fallback to text with dot --}}
                        <span class="w-2.5 h-2.5 bg-blue-600 rounded-full"></span>
                        inaquired
                    @endif
                </a>
            </div>

            <div class="hidden lg:flex space-x-1 items-center">
                <div class="relative">
                    <button onclick="toggleDropdown('explore-dropdown')" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 px-4 py-2 text-base font-semibold transition-colors">
                        Explore <span class="chevron"></span>
                    </button>
                    <div id="explore-dropdown" class="dropdown-menu absolute left-0 bg-white border border-gray-100 shadow-xl rounded-xl py-3 w-52 mt-1 z-50">
                        <a href="{{ route('remote-jobs') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Remote Jobs
                        </a>
                        <a href="{{ route('onsite-jobs') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Onsite Jobs
                        </a>
                        <a href="{{ route('hybrid-jobs') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Hybrid Jobs
                        </a>
                        <a href="{{ route('internships') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Internships
                        </a>
                        <a href="{{ route('companies') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Companies
                        </a>
                        <a href="{{ route('categories') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Categories
                        </a>
                    </div>
                </div>

                <a href="{{ route('blog') }}" class="text-gray-600 hover:text-blue-600 px-4 py-2 text-base font-semibold transition-colors">
                    Blog
                </a>

                <div class="relative">
                    <button onclick="toggleDropdown('about-dropdown')" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 px-4 py-2 text-base font-semibold transition-colors">
                        About <span class="chevron"></span>
                    </button>
                    <div id="about-dropdown" class="dropdown-menu absolute right-0 bg-white border border-gray-100 shadow-xl rounded-xl py-3 w-52 mt-1 z-50">
                        <a href="{{ route('about') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            About
                        </a>
                        <a href="{{ route('contact') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Contact
                        </a>
                        <a href="{{ route('testimonials') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            Testimonials
                        </a>
                        <div class="border-t border-gray-100 my-2"></div>
                        <div class="px-4 py-2">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Follow Channels</p>
                            <div class="flex gap-3">
                                <a href="https://whatsapp.com/channel/0029Vb8XpiRAYlUJPEZqek2s" target="_blank" class="flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors" title="WhatsApp">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                </a>
                                <a href="https://t.me/inaquiredtelegram" target="_blank" class="flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Telegram">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                    </svg>
                                </a>
                                <a href="https://discord.gg/bZDamu2tT" target="_blank" class="flex items-center justify-center w-8 h-8 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors" title="Discord">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.211.375-.445.864-.608 1.25a18.27 18.27 0 00-5.487 0c-.163-.386-.397-.875-.609-1.25a.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.08.08 0 00.087-.027c.461-.63.873-1.295 1.226-1.994a.076.076 0 00-.042-.106 13.107 13.107 0 01-1.872-.892.077.077 0 00-.008-.128 10.713 10.713 0 00.372-.294.075.075 0 00.03-.066c.001-.009.001-.018 0-.027 3.928 1.793 8.18 1.793 12.062 0a.077.077 0 00.032.054.076.076 0 00.031.02c.12.098.246.198.373.294a.077.077 0 00-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.699.772 1.364 1.225 1.994a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.030.077.077 0 00.032-.057c.5-4.761-.838-8.895-3.549-12.55a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-.965-2.157-2.156 0-1.193.964-2.157 2.157-2.157 1.193 0 2.156.964 2.157 2.157 0 1.191-.964 2.156-2.157 2.156zm7.975 0c-1.183 0-2.157-.965-2.157-2.156 0-1.193.965-2.157 2.157-2.157 1.192 0 2.157.964 2.157 2.157 0 1.191-.965 2.156-2.157 2.156z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('jobs.index') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-sm hover:shadow-md">
                    Find a job
                </a>

                <button onclick="toggleMenu()" class="lg:hidden p-2.5 text-gray-600 hover:bg-gray-100 rounded-full transition-colors" aria-label="Toggle Navigation">
                    <div id="burger-icon" class="w-6 h-5 flex flex-col justify-between items-end">
                        <span class="w-full h-0.5 bg-current rounded-full transition-all"></span>
                        <span class="w-4/5 h-0.5 bg-current rounded-full transition-all"></span>
                        <span class="w-full h-0.5 bg-current rounded-full transition-all"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div id="mobileMenu" class="hidden lg:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md overflow-y-auto max-h-[85vh] shadow-xl transition-all duration-300">
        <div class="px-5 py-6 space-y-2">
            <!-- Explore Accordion Item -->
            <div class="rounded-xl overflow-hidden">
                <button onclick="toggleAccordion('acc-explore', this)" class="flex justify-between items-center w-full px-4 py-3.5 text-lg font-bold text-gray-900 hover:text-blue-600 hover:bg-gray-50 rounded-xl transition-all group">
                    <span>Explore</span>
                    <span class="chevron opacity-60 group-hover:opacity-100 transition-transform duration-200"></span>
                </button>
                <div id="acc-explore" class="mobile-accordion">
                    <div class="pt-2 pb-3 pl-4 pr-2 space-y-1 bg-gray-50/50 rounded-xl mt-1 border border-gray-100/80">
                        <a href="{{ route('remote-jobs') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Remote Jobs
                        </a>
                        <a href="{{ route('onsite-jobs') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Onsite Jobs
                        </a>
                        <a href="{{ route('hybrid-jobs') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Hybrid Jobs
                        </a>
                        <a href="{{ route('internships') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Internships
                        </a>
                        <a href="{{ route('companies') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Companies
                        </a>
                        <a href="{{ route('categories') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Categories
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Direct Link -->
            <div class="rounded-xl">
                <a href="{{ route('blog') }}" class="flex justify-between items-center w-full px-4 py-3.5 text-lg font-bold text-gray-900 hover:text-blue-600 hover:bg-gray-50 rounded-xl transition-all group">
                    <span>Blog</span>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- About Accordion Item -->
            <div class="rounded-xl overflow-hidden">
                <button onclick="toggleAccordion('acc-about', this)" class="flex justify-between items-center w-full px-4 py-3.5 text-lg font-bold text-gray-900 hover:text-blue-600 hover:bg-gray-50 rounded-xl transition-all group">
                    <span>About</span>
                    <span class="chevron opacity-60 group-hover:opacity-100 transition-transform duration-200"></span>
                </button>
                <div id="acc-about" class="mobile-accordion">
                    <div class="pt-2 pb-3 pl-4 pr-2 space-y-1 bg-gray-50/50 rounded-xl mt-1 border border-gray-100/80">
                        <a href="{{ route('about') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            About Us
                        </a>
                        <a href="{{ route('contact') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Contact
                        </a>
                        <a href="{{ route('testimonials') }}" class="block px-3 py-2.5 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50/70 rounded-lg transition-colors">
                            Testimonials
                        </a>

                        <!-- Follow Channels Section in Menu -->
                        <div class="pt-3 mt-2 border-t border-gray-200/60 px-3">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2.5">Follow Channels</p>
                            <div class="flex gap-2.5 items-center">
                                <a href="https://whatsapp.com/channel/0029Vb8XpiRAYlUJPEZqek2s" target="_blank" class="flex items-center justify-center w-9 h-9 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 hover:scale-105 transition-all shadow-xs" title="WhatsApp">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                </a>
                                <a href="https://t.me/inaquiredtelegram" target="_blank" class="flex items-center justify-center w-9 h-9 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 hover:scale-105 transition-all shadow-xs" title="Telegram">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                    </svg>
                                </a>
                                <a href="https://discord.gg/bZDamu2tT" target="_blank" class="flex items-center justify-center w-9 h-9 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 hover:scale-105 transition-all shadow-xs" title="Discord">
                                    <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.211.375-.445.864-.608 1.25a18.27 18.27 0 00-5.487 0c-.163-.386-.397-.875-.609-1.25a.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.08.08 0 00.087-.027c.461-.63.873-1.295 1.226-1.994a.076.076 0 00-.042-.106 13.107 13.107 0 01-1.872-.892.077.077 0 00-.008-.128 10.713 10.713 0 00.372-.294.075.075 0 00.03-.066c.001-.009.001-.018 0-.027 3.928 1.793 8.18 1.793 12.062 0a.077.077 0 00.032.054.076.076 0 00.031.02c.12.098.246.198.373.294a.077.077 0 00-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.699.772 1.364 1.225 1.994a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.030.077.077 0 00.032-.057c.5-4.761-.838-8.895-3.549-12.55a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-.965-2.157-2.156 0-1.193.964-2.157 2.157-2.157 1.193 0 2.156.964 2.157 2.157 0 1.191-.964 2.156-2.157 2.156zm7.975 0c-1.183 0-2.157-.965-2.157-2.156 0-1.193.965-2.157 2.157-2.157 1.192 0 2.157.964 2.157 2.157 0 1.191-.965 2.156-2.157 2.156z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action: Find Jobs CTA Button -->
            <div class="pt-2 px-1">
                <a href="{{ route('jobs.index') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-base shadow-sm hover:shadow-md transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Find Jobs</span>
                </a>
            </div>
        </div>
    </div>
</nav>
