@props([
    'type' => 'filter',
    'active' => 'all'
])

<aside {{ $attributes->merge(['class' => 'w-full lg:w-80 flex-shrink-0']) }}>
    <div id="filters-panel" class="bg-white p-6 rounded-2xl border border-gray-100 space-y-8 lg:block sticky top-32 {{ $type === 'filter' ? 'hidden' : '' }}">
        
        @if($type === 'filter')
            {{-- Filter Mode --}}
            {{-- Filter Mode Empty --}}


            <form id="filter-form" method="GET">
                <div class="space-y-6">

                </div>
            </form>
            


        @else
            {{-- Navigation Mode --}}
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400 mb-6">Explore More</h2>
                <div class="space-y-3">
                    <a href="{{ route('unicorn-companies') }}" class="flex items-center justify-between p-4 rounded-xl border {{ $active === 'unicorn' ? 'border-blue-100 bg-blue-50' : 'border-gray-50 hover:border-blue-100 hover:bg-blue-50' }} transition-all group">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $active === 'unicorn' ? 'text-blue-600' : 'text-gray-500' }} group-hover:text-blue-600">Unicorns</span>
                        <svg class="w-4 h-4 {{ $active === 'unicorn' ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('startup-companies') }}" class="flex items-center justify-between p-4 rounded-xl border {{ $active === 'startup' ? 'border-blue-100 bg-blue-50' : 'border-gray-50 hover:border-blue-100 hover:bg-blue-50' }} transition-all group">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $active === 'startup' ? 'text-blue-600' : 'text-gray-500' }} group-hover:text-blue-600">Startups</span>
                        <svg class="w-4 h-4 {{ $active === 'startup' ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('mnc-companies') }}" class="flex items-center justify-between p-4 rounded-xl border {{ $active === 'mnc' ? 'border-blue-100 bg-blue-50' : 'border-gray-50 hover:border-blue-100 hover:bg-blue-50' }} transition-all group">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $active === 'mnc' ? 'text-blue-600' : 'text-gray-500' }} group-hover:text-blue-600">MNCs</span>
                        <svg class="w-4 h-4 {{ $active === 'mnc' ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('companies') }}" class="flex items-center justify-between p-4 rounded-xl border {{ $active === 'all' ? 'border-blue-100 bg-blue-50' : 'border-gray-50 hover:border-blue-100 hover:bg-blue-50' }} transition-all group">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $active === 'all' ? 'text-blue-600' : 'text-gray-500' }} group-hover:text-blue-600">All Directory</span>
                        <svg class="w-4 h-4 {{ $active === 'all' ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>


        @endif
    </div>
</aside>
