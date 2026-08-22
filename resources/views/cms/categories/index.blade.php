@extends('layouts.cms')

@section('title', 'Manage Categories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Manage Categories</h1>
        </div>
        <a href="{{ route('cms.categories.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center">
            <i data-lucide="tag" class="w-5 h-5 mr-2"></i>
            Add New Category
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div id="bulk-actions" class="hidden bg-slate-50 border-b border-slate-200 px-6 py-3">
            <div class="flex items-center justify-between">
                <span id="selected-count" class="text-sm font-medium text-slate-700">0 items selected</span>
                <form id="bulk-delete-form" action="{{ route('cms.categories.bulk-delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected categories? Categories with associated jobs will be skipped.')">
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Category Details</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status & Stats</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50 group">
                        <td class="px-4 py-3">
                            <input type="checkbox" class="category-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500" value="{{ $category->id }}">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-start">
                                @if($category->icon_file)
                                <div class="w-10 h-10 mr-3 flex items-center justify-center shrink-0">
                                    <img src="{{ asset('assets/icons/categories/' . $category->icon_file) }}" alt="{{ $category->name }}" class="w-8 h-8">
                                </div>
                                @elseif($category->icon)
                                <div class="w-10 h-10 mr-3 flex items-center justify-center text-xl shrink-0">
                                    {!! $category->icon !!}
                                </div>
                                @else
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3 shrink-0">
                                    <i data-lucide="tag" class="w-5 h-5 text-slate-400"></i>
                                </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm font-semibold text-slate-900 truncate max-w-[200px]" title="{{ $category->name }}">{{ $category->name }}</div>
                                        <span class="text-xs text-slate-400 font-mono">{{ $category->slug }}</span>
                                    </div>
                                    @if($category->description)
                                        <div class="text-xs text-slate-500 truncate max-w-[300px]">{{ Str::limit($category->description, 60) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm text-slate-700">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded textxs font-medium {{ $category->is_active ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="text-slate-300 mx-1.5">•</span>
                                <span class="text-xs text-slate-600">{{ $category->jobs_count }} Jobs</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('cms.categories.edit', $category) }}" class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('cms.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            No categories found. <a href="{{ route('cms.categories.create') }}" class="text-blue-600 hover:underline">Create your first category</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.category-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    const selectedIdsContainer = document.getElementById('selected-ids-container');

    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.category-checkbox:checked').length;
        
        if (checkedCount > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = `${checkedCount} items selected`;
            
            // Update hidden inputs
            selectedIdsContainer.innerHTML = '';
            document.querySelectorAll('.category-checkbox:checked').forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'category_ids[]';
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