@extends('layouts.cms')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-in"
    x-data="{ 
        showStats: true,
        init() {
            const stored = localStorage.getItem('cms_dashboard_stats');
            if (stored !== null) this.showStats = stored === 'true';
        },
        toggleStats() { 
            this.showStats = !this.showStats;
            localStorage.setItem('cms_dashboard_stats', this.showStats);
            setTimeout(() => { if(window.lucide) window.lucide.createIcons(); }, 100);
        },
        activeTab: 'all'
    }">
    
    <!-- Top Header Bar -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Dashboard Overview</h1>
            <p class="text-sm text-slate-500 mt-1">Platform metrics and recent activities</p>
        </div>
        
        <div class="flex items-center gap-3">
            <button @click="toggleStats()" 
                    class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors flex items-center shadow-sm">
                <i :data-lucide="showStats ? 'eye-off' : 'eye'" class="w-4 h-4 mr-2"></i>
                <span x-text="showStats ? 'Hide Stats' : 'Show Stats'"></span>
            </button>
            <a href="{{ route('cms.jobs.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center shadow-sm hover:shadow-md">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                New Job
            </a>
        </div>
    </div>

    <!-- Analytics Dashboard (Collapsible) -->
    <div x-show="showStats" 
         x-collapse.duration.400ms
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
        
        <!-- Total Jobs -->
        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 flex items-center rounded-full">+{{ rand(2, 8) }}%</span>
            </div>
            <div>
                <h3 class="text-sm font-medium text-slate-500 mb-1">Total Jobs</h3>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_jobs']) }}</p>
            </div>
        </div>

        <!-- Internships -->
        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-slate-500 mb-1">Internships</h3>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_internships']) }}</p>
            </div>
        </div>

        <!-- Active Listings -->
        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-slate-500 mb-1">Active Listings</h3>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['active_jobs']) }}</p>
            </div>
        </div>

        <!-- Companies -->
        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 flex items-center justify-center bg-violet-50 text-violet-600 rounded-lg">
                    <i data-lucide="building-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-slate-500 mb-1">Companies</h3>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_companies']) }}</p>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-slate-500 mb-1">Categories</h3>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_categories']) }}</p>
            </div>
        </div>

        <!-- Blog Posts -->
        <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-slate-500 mb-1">Blog Posts</h3>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_posts']) }}</p>
            </div>
        </div>
    </div>

    <!-- Content Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Activity Stream: Jobs & Internships -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Jobs Panel -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="briefcase" class="w-4 h-4 text-slate-500"></i>
                        <h3 class="font-semibold text-slate-900">Recent Jobs</h3>
                    </div>
                    <a href="{{ route('cms.jobs') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        View All
                    </a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($stats['recent_jobs'] as $job)
                        <div class="p-5 sm:p-6 hover:bg-slate-50 transition-colors flex flex-col sm:flex-row sm:items-center gap-4 relative group">
                            <div class="flex items-center flex-1 min-w-0">
                                @if($job->company && $job->company->logo_url)
                                    <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 shrink-0" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0 font-bold text-slate-700 uppercase text-sm" style="display:none;">
                                        {{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0 font-bold text-slate-700 uppercase text-sm">
                                        {{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div class="ml-4 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-sm font-semibold text-slate-900 truncate">{{ $job->title }}</h4>
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $job->is_active ? 'bg-green-500' : 'bg-red-500' }}" title="{{ $job->is_active ? 'Active' : 'Inactive' }}"></span>
                                        @if($job->is_featured)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-500 truncate flex items-center gap-1 mt-1">
                                        <span class="font-medium text-slate-700">{{ $job->company->name ?? 'Company' }}</span>
                                        <span>•</span>
                                        {{ $job->location }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 self-start sm:self-auto ml-14 sm:ml-0 opacity-0 sm:opacity-0 group-hover:opacity-100 transition-opacity absolute sm:static right-4 top-4 sm:right-auto sm:top-auto">
                                <a href="{{ route('cms.jobs.edit', $job) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('cms.jobs.destroy', $job) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this job?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto mb-3"></i>
                            <p class="text-sm font-medium text-slate-900">No recent jobs</p>
                            <p class="text-xs text-slate-500 mt-1">There are no jobs currently available in the system.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Internships Panel (Mirrors Recent Jobs Layout) -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="graduation-cap" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                        <h3 class="font-semibold text-slate-900">Recent Internships</h3>
                    </div>
                    <a href="{{ route('cms.internships') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        View All
                    </a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($stats['recent_internships'] as $internship)
                        <div class="p-5 sm:p-6 hover:bg-slate-50 transition-colors flex flex-col sm:flex-row sm:items-center gap-4 relative group">
                            <div class="flex items-center flex-1 min-w-0">
                                @if($internship->company && $internship->company->logo_url)
                                    <img src="{{ $internship->company->logo_url }}" alt="{{ $internship->company->name }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 shrink-0" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0 font-bold text-slate-700 uppercase text-sm" style="display:none;">
                                        {{ strtoupper(substr($internship->company->name ?? 'C', 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center shrink-0 font-bold text-slate-700 uppercase text-sm">
                                        {{ strtoupper(substr($internship->company->name ?? 'C', 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div class="ml-4 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-sm font-semibold text-slate-900 truncate">{{ $internship->title }}</h4>
                                        @if($internship->is_featured)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-500 truncate mt-1">
                                        <span class="font-medium text-slate-700">{{ $internship->company->name }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 self-start sm:self-auto ml-14 sm:ml-0 opacity-0 sm:opacity-0 group-hover:opacity-100 transition-opacity absolute sm:static right-4 top-4 sm:right-auto sm:top-auto">
                                <a href="{{ route('cms.internships.edit', $internship) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('cms.internships.destroy', $internship) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this internship?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto mb-3"></i>
                            <p class="text-sm font-medium text-slate-900">No recent internships</p>
                            <p class="text-xs text-slate-500 mt-1">There are no internships currently active.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Matrix -->
        <div class="space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4 flex-shrink-0 text-slate-500"></i>
                    <h3 class="font-semibold text-slate-900">Quick Actions</h3>
                </div>
                <div class="p-4 space-y-1">
                    <a href="{{ route('cms.jobs.create') }}" class="flex items-center p-3 hover:bg-slate-50 rounded-lg transition-colors group outline-none">
                        <div class="w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-500 rounded-lg mr-3 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                            <i data-lucide="briefcase" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900 group-hover:text-blue-700 transition-colors">Create New Job</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors"></i>
                    </a>
                    <a href="{{ route('cms.posts.create') }}" class="flex items-center p-3 hover:bg-slate-50 rounded-lg transition-colors group outline-none">
                        <div class="w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-500 rounded-lg mr-3 group-hover:bg-amber-100 group-hover:text-amber-700 transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900 group-hover:text-amber-700 transition-colors">Write Blog Post</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:text-amber-500 transition-colors"></i>
                    </a>
                    <a href="{{ route('cms.companies.create') }}" class="flex items-center p-3 hover:bg-slate-50 rounded-lg transition-colors group outline-none">
                        <div class="w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-500 rounded-lg mr-3 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">
                            <i data-lucide="building" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900 group-hover:text-emerald-700 transition-colors">Add Company</p>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Blog Posts: Tabbed UI -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="layout" class="w-4 h-4 text-slate-500 flex-shrink-0"></i>
                        <h3 class="font-semibold text-slate-900">Latest Content</h3>
                    </div>
                    
                    <!-- Tab Headers -->
                    <div class="flex gap-2 border-b border-slate-200 pb-0">
                        <button @click="activeTab = 'all'" 
                                :class="{'text-blue-600 border-b-2 border-blue-600': activeTab === 'all', 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent': activeTab !== 'all'}"
                                class="px-3 py-2 text-xs font-bold uppercase tracking-wider transition-all">
                            All Posts
                        </button>
                        <button @click="activeTab = 'published'" 
                                :class="{'text-blue-600 border-b-2 border-blue-600': activeTab === 'published', 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent': activeTab !== 'published'}"
                                class="px-3 py-2 text-xs font-bold uppercase tracking-wider transition-all">
                            Published
                        </button>
                        <button @click="activeTab = 'drafts'" 
                                :class="{'text-blue-600 border-b-2 border-blue-600': activeTab === 'drafts', 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent': activeTab !== 'drafts'}"
                                class="px-3 py-2 text-xs font-bold uppercase tracking-wider transition-all">
                            Drafts
                        </button>
                    </div>
                </div>
                
                <div class="divide-y divide-slate-100 max-h-[400px] overflow-y-auto no-scrollbar">
                    @forelse($stats['recent_posts'] as $post)
                        <a href="{{ route('cms.posts.edit', $post) }}" 
                           x-show="activeTab === 'all' || (activeTab === 'published' && {{ $post->is_published ? 'true' : 'false' }}) || (activeTab === 'drafts' && {{ !$post->is_published ? 'true' : 'false' }})"
                           class="block p-5 hover:bg-slate-50 transition-colors group">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] flex items-center font-bold text-slate-500 uppercase tracking-wider"><i data-lucide="clock" class="w-3 h-3 mr-1 inline-block"></i> {{ $post->created_at->format('M j, Y') }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            <h4 class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 transition-colors mb-2 line-clamp-2">{{ $post->title }}</h4>
                            <div class="flex items-center gap-2.5 text-xs text-slate-500">
                                <div class="w-5 h-5 rounded bg-slate-200 flex items-center justify-center font-bold text-[10px] text-slate-600 border border-slate-300">
                                    {{ substr($post->adminUser->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="font-medium">{{ $post->adminUser->name ?? 'Admin' }}</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-auto opacity-0 group-hover:opacity-100 text-blue-600 transition-opacity"></i>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-sm text-slate-500">
                            No content strategy active.
                        </div>
                    @endforelse
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50 text-center">
                    <a href="{{ route('cms.posts') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                        Manage All Posts
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>

<style>
    [x-cloak] { display: none !important; }
    .animate-in {
        animation: animate-in 0.3s ease-out;
    }
    @keyframes animate-in {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
