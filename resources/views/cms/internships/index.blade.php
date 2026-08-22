@extends('layouts.cms')

@section('title', 'Manage Internships - CMS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Manage Internships</h1>
        </div>
        <a href="{{ route('cms.internships.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Add New Internship
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search internships..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <select name="featured" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all" {{ request('featured') == 'all' ? 'selected' : '' }}>All Listings</option>
                    <option value="featured" {{ request('featured') == 'featured' ? 'selected' : '' }}>Featured Only</option>
                    <option value="standard" {{ request('featured') == 'standard' ? 'selected' : '' }}>Standard Only</option>
                </select>
            </div>
            <button type="submit" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status', 'featured']))
                <a href="{{ route('cms.internships') }}" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div id="bulk-actions" class="hidden bg-slate-50 border-b border-slate-200 px-6 py-3">
            <div class="flex items-center justify-between">
                <span id="selected-count" class="text-sm font-medium text-slate-700">0 items selected</span>
                <form id="bulk-delete-form" action="{{ route('cms.internships.bulk-delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected internships?')">
                    @csrf
                    @method('DELETE')
                    <div id="selected-ids-container"></div>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors flex items-center">
                        <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                        Delete Selected
                    </button>
                </form>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left w-10">
                            <input type="checkbox" id="select-all" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Internship Details</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type & Location</th>
                         <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                         <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($internships as $internship)
                    <tr class="hover:bg-slate-50 group">
                        <td class="px-4 py-3">
                            <input type="checkbox" class="internship-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500" value="{{ $internship->id }}">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-start">
                                @if($internship->company && $internship->company->logo_url)
                                <img src="{{ $internship->company->logo_url }}" alt="{{ $internship->company->name }}" class="w-10 h-10 rounded-lg object-cover mr-3 border border-slate-200 shrink-0" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3 border border-slate-200 shrink-0 font-bold text-slate-700 uppercase text-sm" style="display:none;">
                                    {{ strtoupper(substr($internship->company->name ?? 'C', 0, 1)) }}
                                </div>
                                @else
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3 border border-slate-200 shrink-0 font-bold text-slate-700 uppercase text-sm">
                                    {{ strtoupper(substr($internship->company->name ?? 'C', 0, 1)) }}
                                </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                        <div class="text-sm font-semibold text-slate-900 truncate max-w-[200px] sm:max-w-xs" title="{{ $internship->title }}">{{ $internship->title }}</div>
                                        @if($internship->is_featured)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 flex items-center flex-wrap gap-1">
                                        <span class="font-medium text-slate-700">{{ $internship->company->name }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span>{{ $internship->created_at->format('M d') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                           <div class="flex flex-col gap-1.5">
                                <div class="flex items-center text-sm text-slate-700">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1.5 text-slate-400"></i>
                                    {{ $internship->location }}
                                    <span class="text-slate-300 mx-1.5">•</span>
                                    Internship
                                    <span class="text-slate-300 mx-1.5">•</span>
                                    {{ ucfirst($internship->work_type) }}
                                </div>
                           </div>
                        </td>
                         <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $internship->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $internship->is_active ? 'bg-green-600' : 'bg-red-600' }}"></span>
                                {{ $internship->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('cms.internships.edit', $internship) }}" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('cms.internships.destroy', $internship) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i data-lucide="graduation-cap" class="w-6 h-6 text-slate-400"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900 mb-1">No internships found</h3>
                                <p class="text-sm text-slate-500 mb-4">
                                    @if(request()->hasAny(['search', 'status']))
                                        Try adjusting your search or filters.
                                    @else
                                        Get started by creating a new internship.
                                    @endif
                                </p>
                                @if(request()->hasAny(['search', 'status']))
                                    <a href="{{ route('cms.internships') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Clear filters</a>
                                @else
                                    <a href="{{ route('cms.internships.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                        Create New Internship
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($internships->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $internships->links() }}
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.internship-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    const selectedIdsContainer = document.getElementById('selected-ids-container');

    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.internship-checkbox:checked').length;
        
        if (checkedCount > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = `${checkedCount} items selected`;
            
            // Update hidden inputs
            selectedIdsContainer.innerHTML = '';
            document.querySelectorAll('.internship-checkbox:checked').forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'internship_ids[]';
                input.value = checkbox.value;
                selectedIdsContainer.appendChild(input);
            });
        } else {
            bulkActions.classList.add('hidden');
        }
        
        selectAll.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
    }

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
        updateBulkActions();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
});
</script>
@endsection