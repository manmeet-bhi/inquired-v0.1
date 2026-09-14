@extends('layouts.cms')

@section('title', 'Edit Permissions - CMS')

@section('content')
<style>
    /* Modern Pure CSS Toggle Switch Implementation */
    .cms-toggle { position: relative; display: inline-block; width: 2.75rem; height: 1.5rem; flex-shrink: 0; }
    .cms-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
    .cms-toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #e2e8f0; transition: .3s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 9999px; border: 1px solid #cbd5e1; }
    .cms-toggle-slider:before { position: absolute; content: ""; height: 1.125rem; width: 1.125rem; left: 2px; bottom: 2px; background-color: white; transition: .3s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    .cms-toggle input:checked + .cms-toggle-slider { background-color: #4f46e5; border-color: #4f46e5; }
    .cms-toggle input:focus-visible + .cms-toggle-slider { box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2); }
    .cms-toggle input:checked + .cms-toggle-slider:before { transform: translateX(1.25rem); }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Edit Permissions: <span class="text-indigo-600">{{ $adminUser->name }}</span>
                </h1>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $adminUser->isSuperAdmin() ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                    {{ strtoupper($adminUser->role) }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('cms.permissions.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-xs font-semibold text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                <span>Back to Permissions</span>
            </a>
        </div>
    </div>

    @if($adminUser->isSuperAdmin())
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3 text-amber-900 text-sm">
            <i data-lucide="shield-alert" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
            <div>
                <p class="font-bold">Super Administrator Account</p>
                <p class="text-xs text-amber-700 mt-0.5">Super Admins bypass granular checks and inherently have unrestricted access to all system functions, CMS settings, and database management.</p>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-xs flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-emerald-500 shrink-0"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl shadow-xs flex items-center">
            <i data-lucide="info" class="w-5 h-5 mr-3 text-blue-500 shrink-0"></i>
            <span class="text-sm font-medium">{{ session('info') }}</span>
        </div>
    @endif

    <!-- Search and Filters (Matching other CMS pages) -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" id="permissionSearchInput" oninput="filterPermissions()" placeholder="Search permissions by name or module..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div>
                <select id="permissionCategoryFilter" onchange="filterPermissions()" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                    <option value="">All Categories</option>
                    @foreach($permissions as $category => $catPermissions)
                        <option value="{{ \Illuminate\Support\Str::slug($category) }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" onclick="filterPermissions()" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors flex items-center justify-center text-sm font-medium">
                <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                Search
            </button>
            <button type="button" id="clearSearchBtn" onclick="clearPermissionSearch()" class="hidden bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors flex items-center justify-center text-sm font-medium">
                <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                Clear
            </button>
        </div>
    </div>

    <!-- Preset Controls Bar -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-xs">
        <div class="flex items-center gap-2 text-sm text-slate-600">
            <i data-lucide="sliders" class="w-4 h-4 text-indigo-600"></i>
            <span class="font-medium">Active Permissions:</span>
            <span id="activeCountBadge" class="font-bold font-mono text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                0
            </span>
        </div>

        @if(!$adminUser->isSuperAdmin())
            <div class="flex items-center gap-2">
                <button type="button" onclick="setAllPermissions(true)" class="px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 rounded-lg text-xs font-semibold transition-colors">
                    Grant All
                </button>
                <button type="button" onclick="setAllPermissions(false)" class="px-3 py-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-700 rounded-lg text-xs font-semibold transition-colors">
                    Revoke All
                </button>
            </div>
        @endif
    </div>

    <!-- Permissions Form -->
    <form method="POST" action="{{ route('cms.permissions.update', $adminUser) }}" class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 lg:p-8 space-y-8">
        @csrf
        @method('PUT')

        @php
            $categoryIcons = [
                'Jobs' => 'briefcase',
                'Blog' => 'file-text',
                'SEO' => 'search',
                'Categories' => 'folder',
                'Companies' => 'building',
                'Users' => 'users',
                'Analytics' => 'bar-chart-2',
                'Testimonials' => 'message-square',
                'Activity Logs' => 'activity',
                'Settings' => 'settings',
            ];
        @endphp
        
        <div id="permissionsCategoriesContainer" class="space-y-6">
            @foreach($permissions as $category => $categoryPermissions)
                @php
                    $catIcon = $categoryIcons[$category] ?? 'shield';
                    $catSlug = \Illuminate\Support\Str::slug($category);
                @endphp
                <div class="permission-category-card bg-slate-50/60 rounded-xl p-5 sm:p-6 border border-slate-200/80 space-y-4" data-category="{{ $catSlug }}">
                    
                    <!-- Category Header -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 gap-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 shadow-2xs">
                                <i data-lucide="{{ $catIcon }}" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">{{ $category }} Management</h3>
                                <p class="text-xs text-slate-500">{{ count($categoryPermissions) }} permission {{ \Illuminate\Support\Str::plural('rule', count($categoryPermissions)) }}</p>
                            </div>
                        </div>

                        @if(!$adminUser->isSuperAdmin())
                            <button type="button" onclick="toggleCategory('{{ $catSlug }}')" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">
                                Toggle Group
                            </button>
                        @endif
                    </div>

                    <!-- Category Permission Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                        @foreach($categoryPermissions as $permission)
                            @php
                                $isChecked = $adminUser->isSuperAdmin() || in_array($permission->name, $userPermissions);
                            @endphp
                            <label class="permission-item-label flex items-center justify-between p-3.5 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 hover:ring-2 hover:ring-indigo-50 transition-all cursor-pointer group shadow-2xs"
                                   data-name="{{ strtolower($permission->display_name) }} {{ strtolower($permission->name) }}"
                                   data-category="{{ $catSlug }}">
                                <span class="text-xs sm:text-sm font-semibold text-slate-700 group-hover:text-indigo-700 transition-colors select-none tracking-tight">
                                    {{ $permission->display_name }}
                                </span>
                                <div class="ml-3 shrink-0 flex items-center">
                                    <span class="cms-toggle mb-0">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->name }}"
                                               id="perm_{{ $permission->id }}"
                                               data-category="{{ $catSlug }}"
                                               class="permission-checkbox"
                                               {{ $isChecked ? 'checked' : '' }}
                                               {{ $adminUser->isSuperAdmin() ? 'disabled' : '' }}
                                               onchange="updateCounter()">
                                        <span class="cms-toggle-slider"></span>
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty Search Results Message -->
        <div id="noPermissionMatches" class="hidden py-12 text-center">
            <div class="flex flex-col items-center justify-center text-slate-400">
                <i data-lucide="search-x" class="w-10 h-10 mb-3 text-slate-300"></i>
                <p class="text-base font-semibold text-slate-700">No permissions found</p>
                <p class="text-xs text-slate-400 mt-1">No permissions match your search filter.</p>
                <button type="button" onclick="clearPermissionSearch()" class="mt-4 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold hover:bg-indigo-100 transition-colors">
                    Clear Search Filter
                </button>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-slate-200">
            <a href="{{ route('cms.permissions.index') }}" class="w-full sm:w-auto px-5 py-2.5 text-center font-semibold text-sm text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Cancel
            </a>
            @if(!$adminUser->isSuperAdmin())
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all shadow-md hover:shadow-indigo-500/20 active:scale-95 flex items-center justify-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>Save Permissions</span>
                </button>
            @endif
        </div>
    </form>
</div>

<script>
    function updateCounter() {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const checked = document.querySelectorAll('.permission-checkbox:checked');
        const badge = document.getElementById('activeCountBadge');
        if (badge) {
            badge.innerText = `${checked.length} of ${checkboxes.length} enabled`;
        }
    }

    function setAllPermissions(grant) {
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            if (!cb.disabled) {
                cb.checked = grant;
            }
        });
        updateCounter();
    }

    function toggleCategory(catSlug) {
        const catCheckboxes = document.querySelectorAll(`.permission-checkbox[data-category="${catSlug}"]`);
        const anyUnchecked = Array.from(catCheckboxes).some(cb => !cb.checked);
        catCheckboxes.forEach(cb => {
            if (!cb.disabled) {
                cb.checked = anyUnchecked;
            }
        });
        updateCounter();
    }

    function filterPermissions() {
        const query = document.getElementById('permissionSearchInput').value.toLowerCase().trim();
        const selectedCat = document.getElementById('permissionCategoryFilter').value;
        const clearBtn = document.getElementById('clearSearchBtn');

        if (query || selectedCat) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }

        let totalVisibleCards = 0;
        const categoryCards = document.querySelectorAll('.permission-category-card');

        categoryCards.forEach(catCard => {
            const catSlug = catCard.getAttribute('data-category');
            const items = catCard.querySelectorAll('.permission-item-label');
            let visibleInCat = 0;

            const categoryMatches = !selectedCat || selectedCat === catSlug;

            items.forEach(item => {
                const itemName = item.getAttribute('data-name');
                const matchesSearch = !query || itemName.includes(query);

                if (categoryMatches && matchesSearch) {
                    item.classList.remove('hidden');
                    visibleInCat++;
                    totalVisibleCards++;
                } else {
                    item.classList.add('hidden');
                }
            });

            if (visibleInCat > 0) {
                catCard.classList.remove('hidden');
            } else {
                catCard.classList.add('hidden');
            }
        });

        const noMatchesMsg = document.getElementById('noPermissionMatches');
        if (totalVisibleCards === 0) {
            noMatchesMsg.classList.remove('hidden');
        } else {
            noMatchesMsg.classList.add('hidden');
        }

        if (window.lucide) lucide.createIcons();
    }

    function clearPermissionSearch() {
        document.getElementById('permissionSearchInput').value = '';
        document.getElementById('permissionCategoryFilter').value = '';
        filterPermissions();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateCounter();
        if (window.lucide) lucide.createIcons();
    });
</script>
@endsection