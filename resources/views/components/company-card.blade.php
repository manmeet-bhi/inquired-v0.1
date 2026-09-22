@props(['company', 'showLogo' => false])
@php
    $firstAlphabet = strtoupper(substr($company->name ?? 'C', 0, 1));
    $slug = $company->slug ?? $company->id;

    // Parse industry tags cleanly
    $industries = [];
    if (!empty($company->industry)) {
        $industries = array_values(array_filter(array_map('trim', preg_split('/[,|\/]+/', $company->industry))));
    }
    
    // Show max 1 or 2 tags based on length to prevent layout cutoff
    $maxTags = 1;
    if (count($industries) >= 2 && strlen($industries[0]) <= 12 && strlen($industries[1]) <= 12) {
        $maxTags = 2;
    }
    $shownIndustries = array_slice($industries, 0, $maxTags);
    $remainingIndustriesCount = count($industries) - count($shownIndustries);
    $remainingIndustriesText = implode(', ', array_slice($industries, $maxTags));
@endphp

<div onclick="window.location.href='{{ route('company.show', $slug) }}'" 
     class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 group flex flex-col h-full cursor-pointer relative">
    
    <div class="p-6">
        <div class="flex items-start justify-between gap-3 mb-3">
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 text-base sm:text-lg mb-1.5 line-clamp-2 break-words leading-snug">{{ $company->name }}</h3>
                <div class="flex flex-wrap gap-1.5 items-center">
                    @if($company->type)
                        <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50/80 px-2 py-0.5 rounded-md">{{ ucfirst($company->type) }}</span>
                    @endif

                    @foreach($shownIndustries as $ind)
                        <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md max-w-[150px] truncate" title="{{ $company->industry }}">{{ $ind }}</span>
                    @endforeach

                    @if($remainingIndustriesCount > 0)
                        <span class="inline-flex items-center text-[10px] font-bold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded-md cursor-help hover:bg-slate-200 transition-colors" title="{{ $remainingIndustriesText }}">
                            +{{ $remainingIndustriesCount }}
                        </span>
                    @endif

                    @if(isset($company->jobs_count))
                        <span class="inline-flex items-center text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md ml-auto">{{ $company->jobs_count }} {{ $company->jobs_count === 1 ? 'Job' : 'Jobs' }}</span>
                    @endif
                </div>
            </div>

            {{-- Social Icons --}}
            <div class="flex items-center gap-1.5 flex-shrink-0">
                @if($company->website)
                    <a href="{{ $company->website }}" target="_blank" onclick="event.stopPropagation();" 
                       class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all border border-gray-100 shadow-xs" title="Visit {{ $company->name }} Website">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m-9 9a9 9 0 019-9"></path></svg>
                    </a>
                @endif
                @if($company->linkedin_url)
                    <a href="{{ $company->linkedin_url }}" target="_blank" onclick="event.stopPropagation();" 
                       class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#0077b5] hover:bg-blue-50 transition-all border border-gray-100 shadow-xs" title="LinkedIn Profile">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Company Description / Tagline Snippet --}}
        <div class="mt-2.5">
            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 break-words">
                {{ !empty($company->tagline) ? $company->tagline : ($company->description ?? "Shaping the future of its industry through innovative solutions and excellence.") }}
            </p>
        </div>
    </div>

    {{-- Card Footer: Visible only on hover --}}
    <div class="mt-auto p-6 pt-0 flex items-center justify-between opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-1 group-hover:translate-y-0">
        <span class="text-xs font-semibold text-blue-600 group-hover:text-blue-700 flex items-center gap-1 transition-colors">
            Explore Careers
            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </span>
        <div class="w-8 h-8 rounded-full bg-blue-50/80 border border-blue-100 flex items-center justify-center">
             <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </div>
    </div>
</div>
