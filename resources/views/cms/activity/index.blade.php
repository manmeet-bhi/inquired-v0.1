@extends('layouts.cms')

@section('title', 'Activity Logs - Inaquired')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Activity Logs</h1>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                    {{ number_format($activities->total()) }} {{ \Illuminate\Support\Str::plural('record', $activities->total()) }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($activities->total() > 0)
                <a href="{{ route('cms.activity.export') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Export CSV</span>
                </a>
            @endif

            @if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->isSuperAdmin() && $activities->total() > 0)
                <form action="{{ route('cms.activity.clear') }}" method="POST" onsubmit="return confirm('⚠️ Are you sure you want to clear ALL activity logs?\n\nThis will permanently delete {{ number_format($activities->total()) }} log records and cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-sm font-medium transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i>
                        <span>Clear All Logs</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <form method="GET" action="{{ route('cms.activity') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search activity logs..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div>
                <select name="action" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                    <option value="">All Actions</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login / Session</option>
                </select>
            </div>
            <button type="submit" class="bg-slate-600 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition-colors flex items-center justify-center text-sm font-medium">
                <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                Filter
            </button>
            @if(request()->filled('search') || request()->filled('action'))
                <a href="{{ route('cms.activity') }}" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors flex items-center justify-center text-sm font-medium">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Main Card & Data Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden flex flex-col min-h-[480px]">
        <div class="overflow-x-auto flex-1">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-600">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Admin User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Target Record</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">IP Address</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($activities as $activity)
                        @php
                            $actionLower = strtolower($activity->action);
                            $badgeStyle = 'bg-slate-100 text-slate-800 border-slate-200';

                            if (str_contains($actionLower, 'created') || str_contains($actionLower, 'in') || str_contains($actionLower, 'added')) {
                                $badgeStyle = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                            } elseif (str_contains($actionLower, 'updated') || str_contains($actionLower, 'modified') || str_contains($actionLower, 'edit')) {
                                $badgeStyle = 'bg-sky-100 text-sky-800 border-sky-200';
                            } elseif (str_contains($actionLower, 'deleted') || str_contains($actionLower, 'out') || str_contains($actionLower, 'remove')) {
                                $badgeStyle = 'bg-rose-100 text-rose-800 border-rose-200';
                            } elseif (str_contains($actionLower, 'login') || str_contains($actionLower, 'auth')) {
                                $badgeStyle = 'bg-amber-100 text-amber-800 border-amber-200';
                            }

                            $targetModelClean = $activity->target_type ? str_replace('App\\Models\\', '', $activity->target_type) : null;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            
                            <!-- Admin User -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0 text-indigo-600 font-bold text-xs shadow-xs">
                                        {{ strtoupper(substr($activity->adminUser->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-medium text-slate-900 truncate" title="{{ $activity->adminUser->name ?? 'System' }}">
                                            {{ $activity->adminUser->name ?? 'System' }}
                                        </span>
                                        <span class="text-xs text-slate-500 truncate">
                                            {{ $activity->adminUser->role ?? '' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeStyle }}">
                                    {{ $activity->action }}
                                </span>
                            </td>

                            <!-- Target Record -->
                            <td class="px-6 py-4 hidden md:table-cell">
                                @if($activity->target_name)
                                    <div class="flex flex-col min-w-0 max-w-sm">
                                        <span class="font-medium text-slate-900 break-words" title="{{ $activity->target_name }}">
                                            {{ \Illuminate\Support\Str::limit($activity->target_name, 45) }}
                                        </span>
                                        <span class="text-xs text-slate-400 capitalize">
                                            {{ $targetModelClean }} @if($activity->target_id)<span class="font-mono text-slate-400">#{{ $activity->target_id }}</span>@endif
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-xs">N/A</span>
                                @endif
                            </td>

                            <!-- IP Address -->
                            <td class="px-6 py-4 hidden lg:table-cell whitespace-nowrap">
                                <span class="text-xs font-mono text-slate-600 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                    {{ $activity->ip_address ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Timestamp -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium text-slate-700 text-xs">{{ $activity->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ $activity->created_at->format('h:i A') }} ({{ $activity->created_at->diffForHumans() }})</span>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-3 border border-slate-200">
                                        <i data-lucide="activity" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-base font-semibold text-slate-800">No activity recorded</p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        @if(request('search') || request('action'))
                                            No logs match your filter criteria. Try clearing filters.
                                        @else
                                            Actions performed by administrators will appear here automatically.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if($activities->hasPages())
            <div class="border-t border-slate-200 bg-slate-50/70 px-6 py-4">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
