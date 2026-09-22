@props([
    'type' => 'filter',
    'active' => 'all'
])

<aside {{ $attributes->merge(['class' => 'w-full lg:w-80 flex-shrink-0']) }}>
    <div id="filters-panel" class="bg-white p-6 rounded-2xl border border-gray-100 space-y-6 lg:block sticky top-28 shadow-xs">
        
        {{-- Search Company Section with Live Autocomplete Suggestions (>= 3 chars) --}}
        <div>
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400 mb-3 flex items-center justify-between">
                <span>Search Companies</span>
                @if(request()->filled('search'))
                    <a href="{{ route('companies') }}" class="text-[10px] font-bold text-blue-600 hover:underline normal-case">Clear filter</a>
                @endif
            </h2>
            
            <div class="relative" id="company-search-container">
                <form action="{{ route('companies') }}" method="GET" class="relative" id="company-search-form">
                    <div class="relative flex items-center">
                        <input type="text" 
                               name="search" 
                               id="company-search-input"
                               value="{{ request('search') }}"
                               placeholder="Type company name..." 
                               autocomplete="off"
                               maxlength="50"
                               class="w-full pl-10 pr-9 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        
                        <div class="absolute left-3.5 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        {{-- Clear Button if search query exists --}}
                        <button type="button" 
                                id="company-search-clear-btn" 
                                onclick="clearCompanySearch()" 
                                class="{{ request()->filled('search') ? '' : 'hidden' }} absolute right-3 text-slate-400 hover:text-slate-600 transition-colors p-1" 
                                title="Clear search">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </form>

                {{-- Autocomplete Suggestions Dropdown --}}
                <div id="company-suggestions-dropdown" 
                     class="hidden absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 max-h-80 overflow-y-auto divide-y divide-slate-50">
                    <div id="company-suggestions-list" class="space-y-0.5"></div>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-1.5 flex items-center gap-1">
                <span>Type 3+ characters for instant suggestions</span>
            </p>
        </div>

        {{-- Navigation Mode --}}
        <div>
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400 mb-3">Explore Companies</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-1 gap-2.5 sm:gap-3">
                <a href="{{ route('unicorn-companies') }}" class="flex items-center justify-between p-3.5 sm:p-4 rounded-xl border {{ $active === 'unicorn' ? 'border-blue-200 bg-blue-50/80 text-blue-700 shadow-xs' : 'border-gray-100 bg-white hover:border-blue-100 hover:bg-blue-50/50 text-gray-700' }} transition-all group">
                    <span class="text-xs font-bold uppercase tracking-wider group-hover:text-blue-600">Unicorns</span>
                    <svg class="w-4 h-4 {{ $active === 'unicorn' ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('startup-companies') }}" class="flex items-center justify-between p-3.5 sm:p-4 rounded-xl border {{ $active === 'startup' ? 'border-blue-200 bg-blue-50/80 text-blue-700 shadow-xs' : 'border-gray-100 bg-white hover:border-blue-100 hover:bg-blue-50/50 text-gray-700' }} transition-all group">
                    <span class="text-xs font-bold uppercase tracking-wider group-hover:text-blue-600">Startups</span>
                    <svg class="w-4 h-4 {{ $active === 'startup' ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('mnc-companies') }}" class="flex items-center justify-between p-3.5 sm:p-4 rounded-xl border {{ $active === 'mnc' ? 'border-blue-200 bg-blue-50/80 text-blue-700 shadow-xs' : 'border-gray-100 bg-white hover:border-blue-100 hover:bg-blue-50/50 text-gray-700' }} transition-all group">
                    <span class="text-xs font-bold uppercase tracking-wider group-hover:text-blue-600">MNCs</span>
                    <svg class="w-4 h-4 {{ $active === 'mnc' ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('companies') }}" class="flex items-center justify-between p-3.5 sm:p-4 rounded-xl border {{ $active === 'all' && !request()->filled('search') ? 'border-blue-200 bg-blue-50/80 text-blue-700 shadow-xs' : 'border-gray-100 bg-white hover:border-blue-100 hover:bg-blue-50/50 text-gray-700' }} transition-all group">
                    <span class="text-xs font-bold uppercase tracking-wider group-hover:text-blue-600">All Directory</span>
                    <svg class="w-4 h-4 {{ $active === 'all' && !request()->filled('search') ? 'text-blue-600' : 'text-gray-300' }} group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('company-search-input');
    const clearBtn = document.getElementById('company-search-clear-btn');
    const dropdown = document.getElementById('company-suggestions-dropdown');
    const listContainer = document.getElementById('company-suggestions-list');
    
    if (!searchInput || !dropdown || !listContainer) return;

    let debounceTimer = null;
    let abortController = null;

    // Helper: Escape HTML to prevent XSS
    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Helper: Highlight matched substring securely
    function highlightMatch(text, query) {
        if (!text || !query) return escapeHtml(text);
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escapedQuery})`, 'gi');
        const parts = text.split(regex);
        return parts.map(part => {
            if (part.toLowerCase() === query.toLowerCase()) {
                return `<span class="font-bold text-blue-600 underline decoration-blue-300 decoration-2">${escapeHtml(part)}</span>`;
            }
            return escapeHtml(part);
        }).join('');
    }

    function showDropdown() {
        dropdown.classList.remove('hidden');
    }

    function hideDropdown() {
        dropdown.classList.add('hidden');
    }

    window.clearCompanySearch = function () {
        searchInput.value = '';
        if (clearBtn) clearBtn.classList.add('hidden');
        hideDropdown();
        if (window.location.search.includes('search=')) {
            window.location.href = "{{ route('companies') }}";
        }
    };

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();

        if (clearBtn) {
            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        clearTimeout(debounceTimer);

        // Require at least 3 characters before fetching suggestions
        if (query.length < 3) {
            hideDropdown();
            return;
        }

        debounceTimer = setTimeout(() => {
            if (abortController) {
                abortController.abort();
            }
            abortController = new AbortController();

            // Display loading state
            listContainer.innerHTML = `
                <div class="px-4 py-3 text-xs text-slate-400 flex items-center justify-center gap-2">
                    <svg class="animate-spin w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Searching companies...</span>
                </div>
            `;
            showDropdown();

            fetch(`{{ route('companies.autocomplete') }}?q=${encodeURIComponent(query)}`, {
                signal: abortController.signal,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    listContainer.innerHTML = `
                        <div class="px-4 py-3 text-xs text-slate-500 text-center">
                            No companies found matching "<strong class="text-slate-700">${escapeHtml(query)}</strong>"
                        </div>
                    `;
                    showDropdown();
                    return;
                }

                let html = '';
                data.forEach(item => {
                    const highlightedName = highlightMatch(item.name, query);
                    const typeBadge = item.type 
                        ? `<span class="text-[9px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">${escapeHtml(item.type)}</span>` 
                        : '';
                    const jobsBadge = item.jobs_count > 0 
                        ? `<span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded ml-auto flex-shrink-0">${item.jobs_count} ${item.jobs_count === 1 ? 'Job' : 'Jobs'}</span>` 
                        : '';
                    const industryText = item.industry ? `<p class="text-[11px] text-slate-400 truncate mt-0.5">${escapeHtml(item.industry)}</p>` : '';

                    html += `
                        <a href="${escapeHtml(item.url)}" 
                           class="block px-4 py-2.5 hover:bg-blue-50/60 transition-colors group/item">
                            <div class="flex items-center justify-between gap-2">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover/item:text-blue-600 transition-colors truncate">
                                            ${highlightedName}
                                        </h4>
                                        ${typeBadge}
                                    </div>
                                    ${industryText}
                                </div>
                                ${jobsBadge}
                            </div>
                        </a>
                    `;
                });

                // Footer link to full search results
                html += `
                    <div class="p-2 bg-slate-50 border-t border-slate-100 text-center">
                        <button type="submit" form="company-search-form" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">
                            View all results for "${escapeHtml(query)}" →
                        </button>
                    </div>
                `;

                listContainer.innerHTML = html;
                showDropdown();
            })
            .catch(err => {
                if (err.name !== 'AbortError') {
                    console.error('Autocomplete error:', err);
                    hideDropdown();
                }
            });
        }, 220);
    });

    // Close on click outside
    document.addEventListener('click', function (e) {
        const container = document.getElementById('company-search-container');
        if (container && !container.contains(e.target)) {
            hideDropdown();
        }
    });

    // Keyboard support (Escape closes dropdown)
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            hideDropdown();
        }
    });
});
</script>
