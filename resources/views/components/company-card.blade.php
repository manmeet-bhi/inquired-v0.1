@props(['company'])
@php
    $firstAlphabet = strtoupper(substr($company->name ?? 'C', 0, 1));
    $slug = $company->slug ?? $company->id;
@endphp

<div onclick="window.location.href='{{ route('company.show', $slug) }}'" 
     class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 group flex flex-col h-full cursor-pointer relative">
    
    <div class="p-6">
        <div class="flex items-start justify-between mb-4">
            {{-- Logo --}}
            <div class="w-14 h-14 rounded-xl border border-gray-100 bg-gray-50 flex items-center justify-center overflow-hidden shadow-sm group-hover:scale-105 transition-transform duration-300">
                @if($company->logo_url)
                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" loading="lazy">
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xl uppercase" style="display:none;">
                        {{ $firstAlphabet }}
                    </div>
                @else
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 text-xl uppercase">
                        {{ $firstAlphabet }}
                    </div>
                @endif
            </div>

            {{-- Social Icons --}}
            <div class="flex items-center gap-2">
                @if($company->website)
                    <a href="{{ $company->website }}" target="_blank" onclick="event.stopPropagation();" 
                       class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all border border-gray-100 shadow-sm" title="Visit {{ $company->name }} Website">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m-9 9a9 9 0 019-9"></path></svg>
                    </a>
                @endif
                @if($company->linkedin_url)
                    <a href="{{ $company->linkedin_url }}" target="_blank" onclick="event.stopPropagation();" 
                       class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#0077b5] hover:bg-blue-50 transition-all border border-gray-100 shadow-sm" title="LinkedIn Profile">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Company Info --}}
        <div>
            <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 text-lg mb-2 truncate">{{ $company->name }}</h3>
            <div class="flex flex-wrap gap-2 items-center mb-4">
                <span class="text-[10px] font-black tracking-widest text-blue-600 bg-blue-50/50 px-2.5 py-1 rounded-lg">{{ $company->type }}</span>

                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ $company->industry }}</span>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                {{ $company->description ?? "Shaping the future of its industry through innovative solutions and excellence." }}
            </p>
        </div>
    </div>
    
    {{-- Card Footer decoration --}}
    <div class="mt-auto p-6 pt-0 flex flex-row-reverse items-center justify-between">
        <div class="w-8 h-8 rounded-full border border-gray-100 flex items-center justify-center opacity-0 group-hover:opacity-100 group-hover:translate-x-0 translate-x-2 transition-all duration-300">
             <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </div>
    </div>
</div>
