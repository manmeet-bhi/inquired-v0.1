@props(['job', 'type' => 'job', 'layout' => 'card'])
@php
    use Illuminate\Support\Str;
@endphp

@if($layout === 'row')
    {{-- Row Layout for Homepage --}}
    <a href="{{ route('jobs.show', [$job->id, Str::slug($job->title)]) }}" class="job-row block border border-gray-200 rounded-xl p-4 mb-3 sm:border-0 sm:border-b sm:border-gray-100 sm:rounded-none sm:p-0 sm:py-5 sm:px-4 sm:mb-0 group hover:bg-gray-50/50 transition-all duration-200">
        <div class="flex flex-row items-start gap-3 sm:gap-4">
            {{-- Company Logo --}}
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl border border-gray-200 flex items-center justify-center overflow-hidden bg-white shadow-sm flex-shrink-0">
                @if($job->company && $job->company->logo_url)
                    <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" loading="lazy">
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center" style="display:none;">
                        <span class="text-slate-700 font-bold text-lg sm:text-xl uppercase">{{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}</span>
                    </div>
                @else
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                        <span class="text-slate-700 font-bold text-lg sm:text-xl uppercase">{{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}</span>
                    </div>
                @endif
            </div>
            
            <div class="flex-1 min-w-0 w-full">
                {{-- Mobile: Title + Timestamp Row --}}
                <div class="flex justify-between items-start gap-2 mb-1">
                    <div class="flex items-center gap-2 flex-wrap min-w-0">
                        <h3 class="font-bold text-gray-900 text-base sm:text-lg group-hover:text-blue-600 transition-colors duration-200">
                            {{ $job->title }}
                        </h3>
                        @if($job->is_featured ?? false)
                            <span class="inline-flex items-center bg-amber-50 text-amber-700 border border-amber-200 text-xs px-2.5 py-0.5 rounded-full font-semibold">
                                Featured
                            </span>
                        @endif
                    </div>
                    
                    {{-- Timestamp (Mobile Only here, Desktop below) --}}
                    <div class="flex sm:hidden items-center gap-1 text-gray-400 text-xs whitespace-nowrap pt-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $job->created_at->diffForHumans(null, true, true) }}</span>
                    </div>
                </div>
                
                {{-- Company Name --}}
                <div class="flex items-center gap-2 mb-3 sm:mb-2">
                    <i data-lucide="building-2" class="w-3 h-3 text-gray-400"></i>
                    <p class="text-gray-600 font-medium text-sm">
                        {{ $job->company->name ?? 'Company' }}
                    </p>
                </div>
                
                {{-- Job Details --}}
                <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4 sm:mt-0">
                    {{-- Location --}}
                    <div class="flex items-center gap-2 text-gray-500 text-sm">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $job->location ?? 'Remote' }}</span>
                    </div>
                    
                    {{-- Category --}}
                    @if($job->category)
                    <div class="flex items-center gap-2 text-gray-500 text-sm">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span>{{ $job->category->name }}</span>
                    </div>
                    @endif
                    
                    {{-- Experience --}}
                    @if($job->experience)
                    <div class="flex items-center gap-2 text-gray-500 text-sm">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                        <span>{{ $job->experience }}</span>
                    </div>
                    @endif
                    
                    {{-- Salary --}}
                    @if($job->salary_min && $job->salary_max)
                    <div class="flex items-center gap-2 text-gray-500 text-sm">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        @if($job->type === 'internship')
                            <span>{{ $job->salary_min > 1000 ? number_format($job->salary_min/1000, 0) . 'k' : number_format($job->salary_min) }} - {{ $job->salary_max > 1000 ? number_format($job->salary_max/1000, 0) . 'k' : number_format($job->salary_max) }}</span>
                        @else
                            <span>{{ number_format($job->salary_min/100000, 1) }}-{{ number_format($job->salary_max/100000, 1) }}L</span>
                        @endif
                    </div>
                    @elseif($job->stipend)
                    <div class="flex items-center gap-2 text-gray-500 text-sm">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span>₹{{ number_format($job->stipend/1000, 0) }}K</span>
                    </div>
                    @endif
                    
                    {{-- Posted Time (Desktop) --}}
                    <div class="hidden sm:flex items-center gap-1.5 text-gray-500 text-sm">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"/><path d="M3 10h18"/><path d="m16 20 2 2 4-4"/></svg>
                        <span>{{ $job->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            
            <div class="hidden sm:flex flex-col items-center justify-center gap-2 flex-shrink-0 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Apply
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="m10 8 4 4-4 4"></path>
                    </svg>
                </span>
            </div>
        </div>
    </a>
@else
    {{-- Card Layout for Job Pages --}}
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group border border-slate-200 cursor-pointer" onclick="window.location.href='{{ route('jobs.show', [$job->id, Str::slug($job->title)]) }}'">
        <div class="p-4 sm:p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-start gap-3 sm:gap-4 flex-1 min-w-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border border-slate-100 flex items-center justify-center overflow-hidden bg-slate-50 flex-shrink-0">
                        @if($job->company && $job->company->logo_url)
                            <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" loading="lazy">
                            <span class="text-slate-700 font-bold text-sm sm:text-base uppercase" style="display:none;">{{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}</span>
                        @else
                            <span class="text-slate-700 font-bold text-sm sm:text-base uppercase">{{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-1 group-hover:text-blue-600 transition-colors">{{ $job->title }}</h3>
                        <div class="flex items-center gap-1 mb-1">
                            <i data-lucide="building-2" class="w-3 h-3 text-slate-400"></i>
                            <p class="text-slate-600 text-sm truncate">{{ $job->company->name ?? 'Company' }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    @if($job->is_featured ?? false)
                        <span class="bg-amber-50 text-amber-700 border border-amber-200 text-xs px-2.5 py-0.5 rounded-full font-semibold inline-flex items-center">
                            Featured
                        </span>
                    @endif
                    @if($type === 'internship')
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Internship
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="space-y-2 text-sm text-slate-600 mb-4">
                @if($job->location)
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                        <span>{{ $job->location }}</span>
                    </div>
                @endif
                @if($job->category)
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span>{{ $job->category->name }}</span>
                    </div>
                @endif
                
                @if($job->experience)
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                        <span>{{ $job->experience }}</span>
                    </div>
                @endif
                @if($job->salary_min && $job->salary_max)
                    <div class="flex items-center gap-2 text-blue-600 font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        @if($job->type === 'internship')
                            <span>₹{{ $job->salary_min > 1000 ? number_format($job->salary_min/1000, 0) . 'k' : number_format($job->salary_min) }} - {{ $job->salary_max > 1000 ? number_format($job->salary_max/1000, 0) . 'k' : number_format($job->salary_max) }}/month</span>
                        @else
                            <span>{{ number_format($job->salary_min/100000, 1) }}-{{ number_format($job->salary_max/100000, 1) }} LPA</span>
                        @endif
                    </div>
                @elseif($job->stipend)
                    <div class="flex items-center gap-2 text-blue-600 font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span>₹{{ number_format($job->stipend) }}/month</span>
                    </div>
                @endif

                @if($job->experience_level)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>{{ ucfirst($job->experience_level) }} Level</span>
                    </div>
                @endif
            </div>
            
            @if($job->overview)
                <p class="text-slate-600 text-sm line-clamp-2 mb-4">{{ Str::limit(strip_tags($job->overview), 100) }}</p>
            @endif
            
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"/><path d="M3 10h18"/><path d="m16 20 2 2 4-4"/></svg>
                    <span>{{ $job->created_at->diffForHumans() }}</span>
                </div>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-sm opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0">
                    <span>Apply</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="m10 8 4 4-4 4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif