@extends('layouts.cms')

@section('title', 'Manage Testimonials - Inaquired')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manage Testimonials</h1>
            <p class="mt-1 text-sm text-slate-500">Manage and publish testimonials from professionals and community members.</p>
        </div>
        <a href="{{ route('cms.testimonials.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-xl font-medium hover:bg-blue-700 transition-all flex items-center justify-center shadow-lg shadow-blue-500/20 active:scale-95">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Add Testimonial
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-lg flex items-center shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5 mr-3 shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <form method="GET" action="{{ route('cms.testimonials.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search testimonials by author, role, or message..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <button type="submit" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors flex items-center justify-center text-sm font-medium">
                <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                Filter
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('cms.testimonials.index') }}" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors flex items-center justify-center text-sm font-medium">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Testimonial</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date Added</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($testimonials as $testimonial)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center shrink-0 mr-3 shadow-sm">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">{{ $testimonial->name }}</div>
                                    @if($testimonial->role_company)
                                    <div class="text-xs text-blue-600 font-medium">{{ $testimonial->role_company }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-700 max-w-lg line-clamp-2" title="{{ $testimonial->message }}">
                                "{{ $testimonial->message }}"
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-xs text-slate-500">{{ $testimonial->created_at ? $testimonial->created_at->format('M d, Y') : '—' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('cms.testimonials.edit', $testimonial) }}" class="text-blue-600 hover:text-blue-800 transition-colors p-1" title="Edit">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('cms.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Delete this testimonial permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors p-1" title="Delete">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <i data-lucide="message-square" class="w-12 h-12 text-slate-300 mb-3"></i>
                                @if(request()->filled('search'))
                                <p class="text-base font-medium text-slate-700">No testimonials found matching "{{ request('search') }}"</p>
                                <p class="text-sm text-slate-500 mt-1">Try searching with a different term or clear the filter.</p>
                                <a href="{{ route('cms.testimonials.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                                    Clear search
                                </a>
                                @else
                                <p class="text-base font-medium text-slate-700">No testimonials yet.</p>
                                <p class="text-sm text-slate-500 mt-1">Get started by creating the first testimonial.</p>
                                <a href="{{ route('cms.testimonials.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                                    <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                                    Add Testimonial
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($testimonials->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $testimonials->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
