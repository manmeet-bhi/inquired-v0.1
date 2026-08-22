@extends('layouts.cms')

@section('title', 'Manage Posts - CMS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Posts</h1>
        </div>
        <a href="{{ route('cms.posts.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-xl font-medium hover:bg-blue-700 transition-all flex items-center justify-center shadow-lg shadow-blue-500/20 active:scale-95">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Write New Post
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <button type="submit" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('cms.posts') }}" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div id="bulk-actions" class="hidden bg-slate-50 border-b border-slate-200 px-6 py-3">
            <div class="flex items-center justify-between">
                <span id="selected-count" class="text-sm font-medium text-slate-700">0 items selected</span>
                <form id="bulk-delete-form" action="{{ route('cms.posts.bulk-delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected posts?')">
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Post Details</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status & Date</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($posts as $post)
                    <tr class="hover:bg-slate-50 group">
                        <td class="px-4 py-3">
                            <input type="checkbox" class="post-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500" value="{{ $post->id }}">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-start">
                                @if($post->featured_image_url)
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-10 h-10 rounded-lg object-cover mr-3 border border-slate-200" loading="lazy">
                                @else
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3 border border-slate-200">
                                    <i data-lucide="file-text" class="w-5 h-5 text-slate-400"></i>
                                </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-slate-900 truncate max-w-[300px]" title="{{ $post->title }}">{{ $post->title }}</div>
                                    <div class="text-xs text-slate-500 truncate max-w-[300px]">
                                        {{ Str::limit($post->excerpt ?? strip_tags($post->content), 60) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm text-slate-700">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded textxs font-medium {{ $post->status === 'published' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-yellow-50 text-yellow-700 border border-yellow-100' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                                <span class="text-slate-300 mx-1.5">•</span>
                                <span class="text-xs text-slate-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('cms.posts.edit', $post) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('cms.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i data-lucide="file-text" class="w-6 h-6 text-slate-400"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900 mb-1">No posts found</h3>
                                <p class="text-sm text-slate-500 mb-4">
                                    @if(request()->hasAny(['search', 'status']))
                                        Try adjusting your search or filters.
                                    @else
                                        Write your first post to get started.
                                    @endif
                                </p>
                                @if(request()->hasAny(['search', 'status']))
                                    <a href="{{ route('cms.posts') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Clear filters</a>
                                @else
                                    <a href="{{ route('cms.posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                        Write New Post
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.post-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    const selectedIdsContainer = document.getElementById('selected-ids-container');

    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.post-checkbox:checked').length;
        
        if (checkedCount > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = `${checkedCount} items selected`;
            
            // Update hidden inputs
            selectedIdsContainer.innerHTML = '';
            document.querySelectorAll('.post-checkbox:checked').forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'post_ids[]';
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