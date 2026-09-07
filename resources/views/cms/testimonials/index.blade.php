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
        <form method="GET" action="{{ route('cms.testimonials.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search testimonials by author, role, or message..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div>
                <select name="filter" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                    <option value="">All Status</option>
                    <option value="featured" {{ request('filter') === 'featured' ? 'selected' : '' }}>Featured Only</option>
                    <option value="standard" {{ request('filter') === 'standard' ? 'selected' : '' }}>Standard Only</option>
                </select>
            </div>
            <button type="submit" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors flex items-center justify-center text-sm font-medium">
                <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                Filter
            </button>
            @if(request()->filled('search') || request()->filled('filter'))
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
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Featured</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date Added</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($testimonials as $testimonial)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center shrink-0 mr-3 shadow-sm font-bold text-xs">
                                    {{ strtoupper(substr($testimonial->name, 0, 2)) }}
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
                        <!-- Featured Toggle Star Icon Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <form action="{{ route('cms.testimonials.toggle-featured', $testimonial) }}" method="POST" class="inline-block" onsubmit="handleFeaturedToggle(event, this)">
                                @csrf
                                <button type="submit" 
                                        class="toggle-featured-btn inline-flex items-center justify-center w-8 h-8 rounded-full transition-all {{ $testimonial->is_featured ? 'bg-amber-50 text-amber-500 border border-amber-300 hover:bg-amber-100 shadow-sm' : 'bg-slate-100 text-slate-400 border border-slate-200 hover:bg-slate-200' }}"
                                        title="{{ $testimonial->is_featured ? 'Featured on Top (Click to remove)' : 'Standard (Click to feature on top)' }}">
                                    <i data-lucide="star" class="w-4 h-4 {{ $testimonial->is_featured ? 'fill-amber-400 text-amber-500' : 'text-slate-300 hover:text-slate-400' }}"></i>
                                </button>
                            </form>
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <i data-lucide="message-square" class="w-12 h-12 text-slate-300 mb-3"></i>
                                @if(request()->filled('search') || request()->filled('filter'))
                                <p class="text-base font-medium text-slate-700">No testimonials found matching your filters</p>
                                <p class="text-sm text-slate-500 mt-1">Try clearing your filters or search term.</p>
                                <a href="{{ route('cms.testimonials.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                                    Clear filters
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

<script>
async function handleFeaturedToggle(event, form) {
    event.preventDefault();
    const btn = form.querySelector('.toggle-featured-btn');
    if (!btn) return form.submit();

    btn.disabled = true;
    btn.style.opacity = '0.6';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        if (data.success) {
            if (data.is_featured) {
                btn.className = 'toggle-featured-btn inline-flex items-center justify-center w-8 h-8 rounded-full transition-all bg-amber-50 text-amber-500 border border-amber-300 hover:bg-amber-100 shadow-sm';
                btn.innerHTML = `<i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-500"></i>`;
                btn.title = 'Featured on Top (Click to remove)';
            } else {
                btn.className = 'toggle-featured-btn inline-flex items-center justify-center w-8 h-8 rounded-full transition-all bg-slate-100 text-slate-400 border border-slate-200 hover:bg-slate-200';
                btn.innerHTML = `<i data-lucide="star" class="w-4 h-4 text-slate-300 hover:text-slate-400"></i>`;
                btn.title = 'Standard (Click to feature on top)';
            }
            if (window.lucide) {
                lucide.createIcons();
            }
        } else {
            form.submit();
        }
    } catch (err) {
        form.submit();
    } finally {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
}
</script>
@endsection
