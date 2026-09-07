@extends('layouts.cms')

@section('title', 'Activity Logs - Inaquired')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Activity Logs</h1>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $activities->total() }} {{ \Illuminate\Support\Str::plural('record', $activities->total()) }}
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Audit trail of all administrative actions and security events.</p>
        </div>

        @if(Auth::guard('admin')->user()->role === 'superadmin' && $activities->total() > 0)
            <div>
                <form action="{{ route('cms.activity.clear') }}" method="POST" onsubmit="return confirm('⚠️ Are you sure you want to clear ALL activity logs?\n\nThis will permanently delete {{ $activities->total() }} log records and cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 hover:border-rose-300 rounded-xl text-sm font-semibold transition-all shadow-sm active:scale-95">
                        <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i>
                        <span>Clear All Logs</span>
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden flex flex-col min-h-[500px]">
        
        <!-- Table -->
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-xs uppercase text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 rounded-tl-lg">Admin User</th>
                        <th scope="col" class="px-6 py-4">Action Taken</th>
                        <th scope="col" class="px-6 py-4 hidden md:table-cell">Target Record</th>
                        <th scope="col" class="px-6 py-4 hidden lg:table-cell">IP Address</th>
                        <th scope="col" class="px-6 py-4 rounded-tr-lg">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0 text-indigo-600 font-bold text-xs">
                                        {{ substr($activity->adminUser->name ?? 'S', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-medium text-slate-900 truncate">{{ $activity->adminUser->name ?? 'System' }}</span>
                                        <span class="text-xs text-slate-500 truncate">{{ $activity->adminUser->role ?? '' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    @if(str_contains(strtolower($activity->action), 'created') || str_contains(strtolower($activity->action), 'in')) bg-emerald-100 text-emerald-800
                                    @elseif(str_contains(strtolower($activity->action), 'updated') || str_contains(strtolower($activity->action), 'modified')) bg-sky-100 text-sky-800
                                    @elseif(str_contains(strtolower($activity->action), 'deleted') || str_contains(strtolower($activity->action), 'out')) bg-rose-100 text-rose-800
                                    @else bg-slate-100 text-slate-800 @endif">
                                    {{ $activity->action }}
                                </span>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell">
                                @if($activity->target_name)
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-900">{{ \Illuminate\Support\Str::limit($activity->target_name, 35) }}</span>
                                        <span class="text-xs text-slate-400 capitalize">{{ str_replace('App\\Models\\', '', $activity->target_type) }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">N/A</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 hidden lg:table-cell">
                                <span class="text-xs font-mono text-slate-500 bg-slate-50 px-2 py-1 rounded">{{ $activity->ip_address ?? 'N/A' }}</span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-medium text-slate-700">{{ $activity->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ $activity->created_at->format('h:i A') }} ({{ $activity->created_at->diffForHumans() }})</span>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i data-lucide="activity" class="w-12 h-12 text-slate-300 mb-3"></i>
                                    <p class="text-lg font-medium text-slate-900">No activity recorded</p>
                                    <p class="text-sm mt-1">Actions performed by administrators will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($activities->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
