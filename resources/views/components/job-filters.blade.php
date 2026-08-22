@props([
    'categories' => collect(),
    'showDate' => true,
    'showWorkType' => false,
    'showSalary' => true,
    'salaryLabel' => 'Salary Range',
    'showJobType' => true,
    'showCategories' => true
])

<div id="filters-panel" class="bg-white p-6 rounded-2xl border border-gray-100 space-y-8 hidden lg:block">
    <div class="flex items-center justify-between">
        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Filters</h2>
        <button onclick="resetFilters()" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-widest">Clear All</button>
    </div>

    <form id="filter-form" method="GET">
        <!-- Preserve other query params like sort if needed, but usually sort is separate form. 
             If we want to preserve sort when filtering, we should add hidden input for it if it exists in request -->
        @if(request()->has('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif

        <div class="space-y-6">
            <!-- Date Posted -->
            @if($showDate)
            <details open class="group">
                <summary class="flex items-center justify-between cursor-pointer list-none mb-4">
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Date Posted</span>
                    <span class="transition group-open:rotate-180 transform">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </summary>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="date" value="all" {{ request('date', 'all') == 'all' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> All Time
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="date" value="1" {{ request('date') == '1' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Last 24 hours
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="date" value="7" {{ request('date') == '7' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Last 7 days
                    </label>
                </div>
            </details>
            @endif

            <!-- Location Filter -->
            <details open class="group">
                <summary class="flex items-center justify-between cursor-pointer list-none mb-4">
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Location</span>
                    <span class="transition group-open:rotate-180 transform">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </summary>
                <div class="relative group">
                    <input type="text" name="location" placeholder="City name..." value="{{ request('location') }}" onchange="this.form.submit()" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>
            </details>

            <!-- Salary Range -->
            @if($showSalary)
            <details open class="group">
                <summary class="flex items-center justify-between cursor-pointer list-none mb-4">
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">{{ $salaryLabel }}</span>
                    <span class="transition group-open:rotate-180 transform">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </summary>
                <div class="px-1 pt-2 pb-4">
                    @php
                        // Default to 1-60 format.
                        // If current request has salary but in old format (e.g. 0-5), we might want to respect it or reset it.
                        // For now, let's assume we want to guide user to new slider unless they really want old value.
                        // But strictly speaking, if URL has ?salary=0-5, slider logic might break if we expect "min-60".
                        // Let's parse the min value.
                        $currentSalary = request('salary', '1-60');
                        // Handle potential old formats or just default to 1 if not parseable as "min-60"
                        if (strpos($currentSalary, '-') !== false) {
                            $parts = explode('-', $currentSalary);
                            $minSalary = is_numeric($parts[0]) && $parts[0] > 0 ? $parts[0] : 1;
                        } else {
                            $minSalary = 1;
                        }
                    @endphp
                    <div class="relative mb-4">
                        <input type="range" id="salary-slider" min="1" max="60" step="1" value="{{ $minSalary }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                        <div class="flex justify-between text-xs text-gray-500 mt-2 font-medium">
                            <span>1 {{ $salaryLabel === 'Stipend' ? 'k' : 'LPA' }}</span>
                            <span id="salary-value" class="text-blue-600 font-bold">
                                {{ $minSalary == 60 ? 'Any' : $minSalary . ' ' . ($salaryLabel === 'Stipend' ? 'k' : 'LPA') . '+' }}
                            </span>
                            <span>Any</span>
                        </div>
                    </div>
                    <!-- Hidden input to store the actual value sent to server -->
                    <!-- For Stipend, if logic expects 'k', we can adjust. Assuming consistent unit for now. -->
                    <input type="hidden" name="salary" id="salary-input" value="{{ $currentSalary }}">
                </div>
            </details>
            @endif

            <!-- Job Type -->
            @if($showJobType)
            <details open class="group">
                <summary class="flex items-center justify-between cursor-pointer list-none mb-4">
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Job Type</span>
                    <span class="transition group-open:rotate-180 transform">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </summary>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="type" value="all" {{ request('type', 'all') == 'all' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> All Types
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="type" value="full-time" {{ request('type') == 'full-time' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Full Time
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="type" value="part-time" {{ request('type') == 'part-time' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Part Time
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="type" value="contract" {{ request('type') == 'contract' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Contract
                    </label>
                </div>
            </details>
            @endif

            <!-- Work Type (Remote/Onsite/Hybrid) -->
            @if($showWorkType)
            <details open class="group">
                <summary class="flex items-center justify-between cursor-pointer list-none mb-4">
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Work Type</span>
                    <span class="transition group-open:rotate-180 transform">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </summary>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="mode" value="all" {{ request('mode', 'all') == 'all' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Any
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="mode" value="onsite" {{ request('mode') == 'onsite' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Work from Office
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="mode" value="remote" {{ request('mode') == 'remote' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Work from Home
                    </label>
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer">
                        <input type="radio" name="mode" value="hybrid" {{ request('mode') == 'hybrid' ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600"> Hybrid
                    </label>
                </div>
            </details>
            @endif

            <!-- Categories -->
            @if($showCategories && isset($categories) && $categories->count() > 0)
            <details open class="group">
                <summary class="flex items-center justify-between cursor-pointer list-none mb-4">
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Categories</span>
                    <span class="transition group-open:rotate-180 transform">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </summary>
                <div class="relative mb-3">
                    <input type="text" id="category-search" placeholder="Search categories..." class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-medium focus:outline-none focus:border-blue-500 transition-colors placeholder-gray-400">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar" id="categories-list">
                    @foreach($categories as $index => $category)
                    <label class="flex items-center gap-3 text-sm text-gray-600 hover:text-gray-900 cursor-pointer category-item {{ $index >= 7 ? 'hidden' : '' }}" style="{{ $index >= 7 ? 'display: none;' : '' }}">
                        <input type="checkbox" name="categories[]" value="{{ $category->slug }}" {{ in_array($category->slug, request('categories', [])) ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <span class="flex-1 truncate">{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
                @if($categories->count() > 7)
                <button type="button" id="show-more-categories" class="text-xs font-bold text-blue-600 hover:text-blue-700 mt-2 flex items-center gap-1">
                    + {{ $categories->count() - 7 }} More
                </button>
                @endif
            </details>
            @endif
        </div>
    </form>

    <!-- Filter Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Search & Show More
            const categorySearch = document.getElementById('category-search');
            const categoryItems = document.querySelectorAll('.category-item');
            const showMoreBtn = document.getElementById('show-more-categories');
            
            if(categorySearch) {
                categorySearch.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    
                    categoryItems.forEach(item => {
                        const label = item.querySelector('span').textContent.toLowerCase();
                        if(label.includes(searchTerm)) {
                            item.classList.remove('hidden-by-search');
                            item.style.display = 'flex';
                        } else {
                            item.classList.add('hidden-by-search');
                            item.style.display = 'none';
                        }
                    });

                    if(searchTerm.length > 0) {
                        if(showMoreBtn) showMoreBtn.style.display = 'none';
                    } else {
                        // Reset visibility logic
                        categoryItems.forEach((item, index) => {
                            item.classList.remove('hidden-by-search');
                            if(index < 7) {
                                item.style.display = 'flex';
                                item.classList.remove('hidden');
                            } else {
                                if(showMoreBtn && showMoreBtn.textContent.includes('Show More')) {
                                    item.style.display = 'none';
                                    item.classList.add('hidden');
                                } else {
                                    item.style.display = 'flex';
                                }
                            }
                        });
                        if(showMoreBtn) showMoreBtn.style.display = 'block';
                    }
                });
            }

            if(showMoreBtn) {
                showMoreBtn.addEventListener('click', function() {
                    const isShowingMore = this.textContent.includes('Show Less');
                    
                    if(!isShowingMore) {
                        categoryItems.forEach(item => {
                            item.classList.remove('hidden');
                            item.style.display = 'flex';
                        });
                        this.textContent = '- Show Less';
                    } else {
                        categoryItems.forEach((item, index) => {
                            if(index >= 7) {
                                item.classList.add('hidden');
                                item.style.display = 'none';
                            }
                        });
                        this.textContent = '+ {{ $categories->count() - 7 }} More';
                    }
                });
            }

            // Salary Slider Logic
            const slider = document.getElementById('salary-slider');
            const output = document.getElementById('salary-value');
            const input = document.getElementById('salary-input');
            const form = document.getElementById('filter-form');
            const salaryLabel = '{{ $salaryLabel }}';
            const unit = salaryLabel === 'Stipend' ? 'k' : 'LPA';

            if (slider && output && input) {
                slider.addEventListener('input', function() {
                    if (this.value == 60) {
                        output.textContent = 'Any';
                    } else {
                        output.textContent = this.value + ' ' + unit + '+';
                    }
                });

                slider.addEventListener('change', function() {
                    input.value = this.value + '-60';
                    form.submit();
                });
            }
        });

        // Global function for resetting filters, accessible from button outside component if needed
        function resetFilters() {
            // Reset Radios
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                if (radio.value === 'all' || radio.value === 'any') radio.checked = true;
                else radio.checked = false;
            });

            // Reset Checkboxes
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Reset Location
            const locationInput = document.querySelector('input[name="location"]');
            if (locationInput) locationInput.value = '';

            // Reset Slider
            const slider = document.getElementById('salary-slider');
            const input = document.getElementById('salary-input');
            const output = document.getElementById('salary-value');
             // We need to re-read blade prop here or rely on data-attribute if this was external.
             // Since script is inline, we can use PHP var, but be careful if component is used multiple times (unlikely for sidebar).
             // However, cleaner way:
            const unit = '{{ $salaryLabel === "Stipend" ? "k" : "LPA" }}';

            if (slider && input && output) {
                slider.value = 1;
                input.value = '1-60';
                output.textContent = '1 ' + unit + '+';
            }
            
            // Reset Sort if present outside form or inside
            const sortSelect = document.querySelector('select[name="sort"]');
            if(sortSelect) sortSelect.value = 'newest';

            document.getElementById('filter-form').submit();
        }
        
        // Expose toggleFilters if not present in parent
        if (typeof window.toggleFilters === 'undefined') {
            window.toggleFilters = function() {
                const panel = document.getElementById('filters-panel');
                const arrow = document.getElementById('filter-arrow');
                
                if (panel.classList.contains('hidden')) {
                    panel.classList.remove('hidden');
                    panel.classList.add('block');
                    if(arrow) arrow.style.transform = 'rotate(180deg)';
                } else {
                    panel.classList.add('hidden');
                    panel.classList.remove('block');
                    if(arrow) arrow.style.transform = 'rotate(0deg)';
                }
            }
        }
    </script>
</div>
