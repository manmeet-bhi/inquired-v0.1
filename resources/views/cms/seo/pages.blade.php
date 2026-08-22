@extends('layouts.cms')

@section('title', 'Page SEO Management - CMS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Page SEO Management</h1>
        </div>
        <a href="{{ route('cms.seo.pages.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center whitespace-nowrap">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Add Page SEO
        </a>
    </div>

    <!-- Search and Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pages by slug, title or description..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors flex items-center justify-center whitespace-nowrap">
                <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                Filter
            </button>
            @if(request()->has('search'))
                <a href="{{ route('cms.seo.pages') }}" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors flex items-center justify-center whitespace-nowrap">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- SEO Pages Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Page Details</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Meta Info</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($pages as $page)
                    <tr class="hover:bg-slate-50 group">
                        <td class="px-4 py-3">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3 border border-slate-200 shrink-0">
                                    <i data-lucide="{{ $page->page_type === 'job' ? 'briefcase' : ($page->page_type === 'post' ? 'file-text' : ($page->page_type === 'company' ? 'building' : ($page->page_type === 'category' ? 'tag' : 'layout'))) }}" class="w-5 h-5 text-slate-400"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <div class="text-sm font-semibold text-slate-900 truncate" title="{{ $page->slug }}">{{ $page->slug }}</div>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium 
                                            {{ $page->page_type === 'job' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $page->page_type === 'category' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $page->page_type === 'company' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $page->page_type === 'post' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $page->page_type === 'static' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst($page->page_type) }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-slate-500 truncate" title="{{ $page->meta_title }}">
                                        {{ $page->meta_title }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs text-slate-600">Title: <span class="font-medium {{ \Illuminate\Support\Str::length($page->meta_title) > 60 ? 'text-red-500' : 'text-slate-900' }}">{{ \Illuminate\Support\Str::length($page->meta_title) }}</span> / 60</span>
                                <span class="text-xs text-slate-600">Desc: <span class="font-medium {{ \Illuminate\Support\Str::length($page->meta_description) > 160 ? 'text-red-500' : 'text-slate-900' }}">{{ \Illuminate\Support\Str::length($page->meta_description) }}</span> / 160</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                @if($page->noindex)
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded border border-red-200">NoIndex</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded border border-green-200">Indexed</span>
                                @endif
                                @if($page->nofollow)
                                    <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded border border-orange-200">NoFollow</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                <a href="{{ url($page->slug) }}" target="_blank" class="p-1 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded transition-colors" title="View Public Page">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('cms.seo.pages.edit', $page) }}" class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('cms.seo.pages.destroy', $page) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this SEO page?')">
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
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i data-lucide="search" class="w-6 h-6 text-slate-400"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900 mb-1">No SEO pages found</h3>
                                <p class="text-sm text-slate-500 mb-4">
                                    @if(request()->has('search'))
                                        Try adjusting your search query.
                                    @else
                                        Start by adding SEO settings for your pages.
                                    @endif
                                </p>
                                <a href="{{ route('cms.seo.pages.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors whitespace-nowrap">
                                    Add First Page SEO
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pages->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $pages->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    <!-- SEO Tips -->
    <div class="mt-8 bg-blue-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
            <i data-lucide="lightbulb" class="w-5 h-5 mr-2"></i>
            SEO Best Practices
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
            <div>
                <h4 class="font-medium mb-2">Meta Title Guidelines:</h4>
                <ul class="space-y-1 text-blue-700">
                    <li>- Keep between 30-60 characters</li>
                    <li>- Include primary keyword</li>
                    <li>- Make it compelling and unique</li>
                    <li>- Avoid keyword stuffing</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium mb-2">Meta Description Guidelines:</h4>
                <ul class="space-y-1 text-blue-700">
                    <li>- Keep between 120-160 characters</li>
                    <li>- Include call-to-action</li>
                    <li>- Summarize page content</li>
                    <li>- Use natural language</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
