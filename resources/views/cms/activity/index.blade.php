@extends('layouts.cms')

@section('title', 'Activity Logs - Inaquired')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <!-- Header & Action Bar -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Activity Logs</h1>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-2xs">
                    {{ number_format($activities->total()) }} {{ \Illuminate\Support\Str::plural('event', $activities->total()) }}
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Real-time audit trail of administrative modifications, authentications, and system actions.</p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            @if($activities->total() > 0)
                <button type="button" onclick="openExportModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 hover:border-slate-300 rounded-xl text-sm font-semibold transition-all shadow-xs active:scale-95">
                    <i data-lucide="download" class="w-4 h-4 text-indigo-600"></i>
                    <span>Export CSV</span>
                </button>
            @endif

            @if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->isSuperAdmin() && $activities->total() > 0)
                <button type="button" onclick="openClearLogsModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 hover:border-rose-300 rounded-xl text-sm font-semibold transition-all shadow-xs active:scale-95">
                    <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i>
                    <span>Clear Logs</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-4">
        <form action="{{ route('cms.activity') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user, action, target record, or IP..." 
                    class="w-full pl-10 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <select name="action" onchange="this.form.submit()" class="px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    <option value="">All Action Types</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login / Session</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition-all shadow-xs active:scale-95">
                    Filter
                </button>

                @if(request('search') || request('action'))
                    <a href="{{ route('cms.activity') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Card & Data Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden flex flex-col min-h-[480px]">
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/90 text-xs uppercase text-slate-500 font-semibold border-b border-slate-200 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Admin User</th>
                        <th scope="col" class="px-6 py-4">Action</th>
                        <th scope="col" class="px-6 py-4 hidden md:table-cell">Target Record</th>
                        <th scope="col" class="px-6 py-4 hidden lg:table-cell">IP Address</th>
                        <th scope="col" class="px-6 py-4">Timestamp</th>
                        <th scope="col" class="px-6 py-4 text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($activities as $activity)
                        @php
                            $actionLower = strtolower($activity->action);
                            $badgeStyle = 'bg-slate-100 text-slate-800 border-slate-200';
                            $actionIcon = 'activity';

                            if (str_contains($actionLower, 'created') || str_contains($actionLower, 'in') || str_contains($actionLower, 'added')) {
                                $badgeStyle = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                $actionIcon = 'plus-circle';
                            } elseif (str_contains($actionLower, 'updated') || str_contains($actionLower, 'modified') || str_contains($actionLower, 'edit')) {
                                $badgeStyle = 'bg-sky-50 text-sky-700 border-sky-200';
                                $actionIcon = 'edit-3';
                            } elseif (str_contains($actionLower, 'deleted') || str_contains($actionLower, 'out') || str_contains($actionLower, 'remove')) {
                                $badgeStyle = 'bg-rose-50 text-rose-700 border-rose-200';
                                $actionIcon = 'trash';
                            } elseif (str_contains($actionLower, 'login') || str_contains($actionLower, 'auth')) {
                                $badgeStyle = 'bg-amber-50 text-amber-700 border-amber-200';
                                $actionIcon = 'shield';
                            }

                            $targetModelClean = $activity->target_type ? str_replace('App\\Models\\', '', $activity->target_type) : null;
                            $activityPayload = [
                                'id' => $activity->id,
                                'admin_name' => $activity->adminUser->name ?? 'System',
                                'admin_email' => $activity->adminUser->email ?? 'system@internal',
                                'admin_role' => $activity->adminUser->role ?? 'System Process',
                                'action' => $activity->action,
                                'action_badge' => $badgeStyle,
                                'action_icon' => $actionIcon,
                                'target_name' => $activity->target_name ?? 'N/A',
                                'target_type' => $targetModelClean ?? 'General',
                                'target_id' => $activity->target_id ?? 'N/A',
                                'ip_address' => $activity->ip_address ?? '127.0.0.1',
                                'created_at_formatted' => $activity->created_at->format('M d, Y · h:i:s A'),
                                'created_at_human' => $activity->created_at->diffForHumans(),
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors group cursor-pointer" onclick='openLogDetailsModal(@json($activityPayload))'>
                            
                            <!-- Admin User -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-100 to-indigo-50 border border-indigo-200/80 flex items-center justify-center shrink-0 text-indigo-700 font-bold text-xs shadow-2xs">
                                        {{ strtoupper(substr($activity->adminUser->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-medium text-slate-900 truncate max-w-[150px] sm:max-w-[200px]" title="{{ $activity->adminUser->name ?? 'System' }}">
                                            {{ $activity->adminUser->name ?? 'System' }}
                                        </span>
                                        <span class="text-xs text-slate-500 truncate max-w-[150px] sm:max-w-[200px]">
                                            {{ $activity->adminUser->email ?? ($activity->adminUser->role ?? 'Automated') }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeStyle }}">
                                    <i data-lucide="{{ $actionIcon }}" class="w-3.5 h-3.5"></i>
                                    <span>{{ $activity->action }}</span>
                                </span>
                            </td>

                            <!-- Target Record -->
                            <td class="px-6 py-4 hidden md:table-cell">
                                @if($activity->target_name)
                                    <div class="flex flex-col min-w-0 max-w-xs">
                                        <span class="font-medium text-slate-900 truncate" title="{{ $activity->target_name }}">
                                            {{ $activity->target_name }}
                                        </span>
                                        <span class="text-xs text-slate-400">
                                            {{ $targetModelClean }} @if($activity->target_id)<span class="font-mono text-slate-400">#{{ $activity->target_id }}</span>@endif
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-xs">System / Global</span>
                                @endif
                            </td>

                            <!-- IP Address -->
                            <td class="px-6 py-4 hidden lg:table-cell whitespace-nowrap">
                                <span class="text-xs font-mono text-slate-600 bg-slate-100 px-2 py-1 rounded-md border border-slate-200/80">
                                    {{ $activity->ip_address ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Timestamp -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium text-slate-700 text-xs">{{ $activity->created_at->format('M d, Y · h:i A') }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </td>

                            <!-- View Inspector Action -->
                            <td class="px-6 py-4 text-right whitespace-nowrap" onclick="event.stopPropagation()">
                                <button type="button" onclick='openLogDetailsModal(@json($activityPayload))' 
                                    class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="View Log Details">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-3 border border-slate-200">
                                        <i data-lucide="activity" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-base font-semibold text-slate-800">No activity events found</p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        @if(request('search') || request('action'))
                                            No logs match your filter criteria. Try clearing search filters.
                                        @else
                                            Actions performed by administrators and background tasks will appear here automatically.
                                        @endif
                                    </p>
                                    @if(request('search') || request('action'))
                                        <a href="{{ route('cms.activity') }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                            <span>Clear all filters</span>
                                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                        </a>
                                    @endif
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

<!-- ========================================================= -->
<!-- Modal 1: Clean & Overflow-Proof Export Progress Modal     -->
<!-- ========================================================= -->
<div id="exportModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden transition-opacity opacity-0 duration-200" aria-modal="true" role="dialog">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full max-h-[90vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-200" id="exportModalContent">
        
        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 via-indigo-50/30 to-slate-50 shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 shadow-2xs">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-slate-900 truncate">Export Activity Logs</h3>
                    <p class="text-xs text-slate-500 truncate">CSV format · UTF-8 formatted archive</p>
                </div>
            </div>
            <button type="button" onclick="closeExportModal()" id="exportCloseBtn" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors shrink-0">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Body (Scrollable if screen is very short) -->
        <div class="p-6 space-y-5 overflow-y-auto flex-1">
            
            <!-- Progress Tracker -->
            <div id="progressState" class="space-y-3">
                <div class="flex items-center justify-between gap-3 text-sm min-w-0">
                    <div id="progressStatusText" class="font-medium text-slate-700 flex items-center gap-2 min-w-0 truncate">
                        <i data-lucide="loader-2" class="w-4 h-4 text-indigo-600 animate-spin shrink-0"></i>
                        <span class="truncate">Initializing exporter...</span>
                    </div>
                    <span id="progressPercent" class="font-bold font-mono text-indigo-600 shrink-0">0%</span>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-3 p-0.5 overflow-hidden border border-slate-200/80 shadow-inner">
                    <div id="progressBarFill" class="bg-gradient-to-r from-indigo-500 via-blue-500 to-indigo-600 h-full rounded-full transition-all duration-300 ease-out shadow-xs" style="width: 0%"></div>
                </div>

                <div class="flex justify-between items-center text-xs text-slate-400 pt-0.5">
                    <span class="truncate">Task: Query & Stream logs</span>
                    <span class="shrink-0 font-mono">{{ number_format($activities->total()) }} total records</span>
                </div>
            </div>

            <!-- Task Metadata Details Card (Overflow-safe flex layout) -->
            <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 text-xs space-y-2.5">
                <div class="flex items-center justify-between gap-3 min-w-0">
                    <span class="font-medium text-slate-500 shrink-0">Export Task:</span>
                    <span class="font-semibold text-slate-800 truncate text-right">Audit Trail CSV Dataset</span>
                </div>
                <div class="flex items-center justify-between gap-3 min-w-0">
                    <span class="font-medium text-slate-500 shrink-0">Total Records:</span>
                    <span class="font-semibold text-slate-800 font-mono text-right">{{ number_format($activities->total()) }} entries</span>
                </div>
                <div class="flex items-center justify-between gap-3 min-w-0">
                    <span class="font-medium text-slate-500 shrink-0">File Encoding:</span>
                    <span class="font-semibold text-slate-800 font-mono text-right">CSV (.csv) UTF-8 BOM</span>
                </div>
                <div class="flex items-center justify-between gap-3 min-w-0">
                    <span class="font-medium text-slate-500 shrink-0">Operator:</span>
                    <span class="font-semibold text-slate-800 truncate max-w-[220px] text-right" title="{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}">
                        {{ Auth::guard('admin')->user()->name ?? 'Administrator' }}
                    </span>
                </div>
                <div class="flex items-center justify-between gap-3 min-w-0">
                    <span class="font-medium text-slate-500 shrink-0">Generated At:</span>
                    <span class="font-semibold text-slate-800 font-mono text-right">{{ now()->format('M d, Y h:i A') }}</span>
                </div>
                <div class="flex items-center justify-between gap-3 min-w-0 pt-2 border-t border-slate-200/60">
                    <span class="font-medium text-slate-500 shrink-0">Task Status:</span>
                    <span id="taskStatusBadge" class="inline-flex items-center gap-1 font-semibold text-amber-600 truncate text-right">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse shrink-0"></span>
                        <span class="truncate">Processing stream</span>
                    </span>
                </div>
            </div>

            <!-- Completed Actions (Revealed at 100%) -->
            <div id="completedState" class="hidden space-y-3 pt-1">
                <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start sm:items-center gap-3 text-emerald-800 text-xs sm:text-sm font-medium">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5 sm:mt-0"></i>
                    <span>Export completed! Your CSV file has been compiled and is ready for download.</span>
                </div>

                <div class="flex flex-col sm:flex-row gap-2.5 pt-1">
                    <a id="downloadCsvBtn" href="{{ route('cms.activity.export') }}" download class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-indigo-500/20 active:scale-95 transition-all">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        <span>Download CSV File</span>
                    </a>
                    <button type="button" onclick="closeExportModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition-colors">
                        Done
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- ========================================================= -->
<!-- Modal 2: Activity Details Inspector Modal (New & Clean)   -->
<!-- ========================================================= -->
<div id="logDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden transition-opacity opacity-0 duration-200" aria-modal="true" role="dialog">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full max-h-[90vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-200" id="logDetailsModalContent">
        
        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span>Activity Event</span>
                        <span id="detailLogId" class="text-xs font-mono text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">#0</span>
                    </h3>
                    <p id="detailTimestampHuman" class="text-xs text-slate-500 truncate">Just now</p>
                </div>
            </div>
            <button type="button" onclick="closeLogDetailsModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors shrink-0">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4 overflow-y-auto flex-1 text-sm">
            
            <!-- Action Badge & Type -->
            <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <span id="detailActionBadge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border">
                        <i id="detailActionIcon" data-lucide="activity" class="w-3.5 h-3.5"></i>
                        <span id="detailActionText">Action</span>
                    </span>
                </div>
                <span id="detailTimestampFormatted" class="text-xs font-mono text-slate-500 shrink-0">Date</span>
            </div>

            <!-- Actor Section -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-500"></i>
                    <span>Actor Information</span>
                </h4>
                <div class="flex items-center gap-3 pt-1">
                    <div id="detailAdminAvatar" class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-sm border border-indigo-200 shrink-0">
                        A
                    </div>
                    <div class="min-w-0 flex-1">
                        <p id="detailAdminName" class="font-semibold text-slate-900 truncate">Admin Name</p>
                        <p id="detailAdminEmail" class="text-xs text-slate-500 truncate">admin@example.com</p>
                    </div>
                    <span id="detailAdminRole" class="px-2 py-0.5 text-xs font-medium bg-slate-100 text-slate-600 rounded-md border border-slate-200 shrink-0">
                        Admin
                    </span>
                </div>
            </div>

            <!-- Target Record Section -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <i data-lucide="database" class="w-3.5 h-3.5 text-blue-500"></i>
                    <span>Target Record</span>
                </h4>
                <div class="space-y-2 text-xs">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-slate-500 font-medium shrink-0">Target Name:</span>
                        <span id="detailTargetName" class="font-semibold text-slate-900 text-right break-words max-w-[280px]">N/A</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500 font-medium shrink-0">Model Type:</span>
                        <span id="detailTargetType" class="font-semibold text-slate-700 font-mono text-right">Job</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500 font-medium shrink-0">Record ID:</span>
                        <span id="detailTargetId" class="font-mono text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded text-right">#0</span>
                    </div>
                </div>
            </div>

            <!-- Network & Security Section -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-emerald-500"></i>
                    <span>Network & Security</span>
                </h4>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500 font-medium shrink-0">IP Address:</span>
                        <span id="detailIpAddress" class="font-mono text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 text-right">127.0.0.1</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between gap-3 shrink-0">
            <button type="button" onclick="copyLogSummary()" id="copySummaryBtn" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <i data-lucide="copy" class="w-3.5 h-3.5 text-slate-500"></i>
                <span id="copySummaryBtnText">Copy Details</span>
            </button>
            <button type="button" onclick="closeLogDetailsModal()" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                Close
            </button>
        </div>

    </div>
</div>

<!-- ========================================================= -->
<!-- Modal 3: Clear All Logs Confirmation Modal                -->
<!-- ========================================================= -->
<div id="clearLogsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden transition-opacity opacity-0 duration-200" aria-modal="true" role="dialog">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-md w-full overflow-hidden transform scale-95 transition-transform duration-200" id="clearLogsModalContent">
        <div class="p-6 text-center space-y-4">
            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mx-auto shadow-xs border border-rose-200">
                <i data-lucide="alert-triangle" class="w-7 h-7"></i>
            </div>
            <div class="space-y-1.5">
                <h3 class="text-lg font-bold text-slate-900">Clear All Activity Logs?</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    This action will permanently delete all <strong class="text-slate-800">{{ number_format($activities->total()) }} log records</strong>. This cannot be undone.
                </p>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="button" onclick="closeClearLogsModal()" class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition-colors">
                    Cancel
                </button>
                <form action="{{ route('cms.activity.clear') }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-sm rounded-xl transition-all shadow-md hover:shadow-rose-500/20 active:scale-95">
                        Yes, Delete All
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let exportTimer = null;
    let currentLogData = null;

    // --- Export Modal Handlers ---
    function openExportModal() {
        const modal = document.getElementById('exportModal');
        const content = document.getElementById('exportModalContent');
        const progressBarFill = document.getElementById('progressBarFill');
        const progressPercent = document.getElementById('progressPercent');
        const progressStatusText = document.getElementById('progressStatusText');
        const taskStatusBadge = document.getElementById('taskStatusBadge');
        const completedState = document.getElementById('completedState');

        // Reset progress UI
        progressBarFill.style.width = '0%';
        progressPercent.innerText = '0%';
        progressStatusText.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 text-indigo-600 animate-spin shrink-0"></i><span class="truncate">Connecting to audit database...</span>';
        taskStatusBadge.innerHTML = '<span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse shrink-0"></span><span class="truncate">Processing stream</span>';
        taskStatusBadge.className = 'inline-flex items-center gap-1 font-semibold text-amber-600 truncate text-right';
        completedState.classList.add('hidden');

        // Show modal
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
            if (window.lucide) lucide.createIcons();
        }, 10);

        // Run progressive progress bar
        let currentProgress = 0;
        if (exportTimer) clearInterval(exportTimer);

        const steps = [
            { threshold: 25, text: 'Querying activity log events...' },
            { threshold: 55, text: 'Processing audit trail & user metadata...' },
            { threshold: 85, text: 'Compiling CSV dataset stream...' },
            { threshold: 100, text: 'Export finalized and packaged!' }
        ];

        exportTimer = setInterval(() => {
            const increment = Math.floor(Math.random() * 9) + 5;
            currentProgress = Math.min(100, currentProgress + increment);

            progressBarFill.style.width = currentProgress + '%';
            progressPercent.innerText = currentProgress + '%';

            for (let i = 0; i < steps.length; i++) {
                if (currentProgress <= steps[i].threshold || i === steps.length - 1) {
                    if (currentProgress < 100) {
                        progressStatusText.innerHTML = `<i data-lucide="loader-2" class="w-4 h-4 text-indigo-600 animate-spin shrink-0"></i><span class="truncate">${steps[i].text}</span>`;
                    } else {
                        progressStatusText.innerHTML = `<i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0"></i><span class="text-emerald-700 font-semibold truncate">${steps[i].text}</span>`;
                    }
                    if (window.lucide) lucide.createIcons();
                    break;
                }
            }

            if (currentProgress >= 100) {
                clearInterval(exportTimer);
                taskStatusBadge.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span><span class="truncate">Ready for Download</span>';
                taskStatusBadge.className = 'inline-flex items-center gap-1 font-semibold text-emerald-600 truncate text-right';
                
                setTimeout(() => {
                    completedState.classList.remove('hidden');
                    if (window.lucide) lucide.createIcons();
                }, 200);
            }
        }, 110);
    }

    function closeExportModal() {
        if (exportTimer) clearInterval(exportTimer);
        const modal = document.getElementById('exportModal');
        const content = document.getElementById('exportModalContent');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    // --- Log Details Inspector Modal Handlers ---
    function openLogDetailsModal(data) {
        currentLogData = data;
        document.getElementById('detailLogId').innerText = '#' + data.id;
        document.getElementById('detailTimestampHuman').innerText = data.created_at_human;
        document.getElementById('detailTimestampFormatted').innerText = data.created_at_formatted;

        // Action badge
        const badgeElem = document.getElementById('detailActionBadge');
        badgeElem.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ' + data.action_badge;
        document.getElementById('detailActionText').innerText = data.action;

        // Admin info
        document.getElementById('detailAdminName').innerText = data.admin_name;
        document.getElementById('detailAdminEmail').innerText = data.admin_email;
        document.getElementById('detailAdminRole').innerText = data.admin_role;
        document.getElementById('detailAdminAvatar').innerText = data.admin_name.charAt(0).toUpperCase();

        // Target info
        document.getElementById('detailTargetName').innerText = data.target_name;
        document.getElementById('detailTargetType').innerText = data.target_type;
        document.getElementById('detailTargetId').innerText = '#' + data.target_id;

        // Network
        document.getElementById('detailIpAddress').innerText = data.ip_address;

        // Reset copy button state
        document.getElementById('copySummaryBtnText').innerText = 'Copy Details';

        // Show modal
        const modal = document.getElementById('logDetailsModal');
        const content = document.getElementById('logDetailsModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
            if (window.lucide) lucide.createIcons();
        }, 10);
    }

    function closeLogDetailsModal() {
        const modal = document.getElementById('logDetailsModal');
        const content = document.getElementById('logDetailsModalContent');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    function copyLogSummary() {
        if (!currentLogData) return;
        const summary = `Activity Log #${currentLogData.id}
Action: ${currentLogData.action}
Actor: ${currentLogData.admin_name} (${currentLogData.admin_email} - ${currentLogData.admin_role})
Target: [${currentLogData.target_type}] ${currentLogData.target_name} (ID: ${currentLogData.target_id})
IP Address: ${currentLogData.ip_address}
Timestamp: ${currentLogData.created_at_formatted} (${currentLogData.created_at_human})`;

        navigator.clipboard.writeText(summary).then(() => {
            const btnText = document.getElementById('copySummaryBtnText');
            btnText.innerText = 'Copied!';
            setTimeout(() => {
                btnText.innerText = 'Copy Details';
            }, 2000);
        });
    }

    // --- Clear Logs Confirmation Modal Handlers ---
    function openClearLogsModal() {
        const modal = document.getElementById('clearLogsModal');
        const content = document.getElementById('clearLogsModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
            if (window.lucide) lucide.createIcons();
        }, 10);
    }

    function closeClearLogsModal() {
        const modal = document.getElementById('clearLogsModal');
        const content = document.getElementById('clearLogsModalContent');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    // Global Keydown & Backdrop Listeners
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExportModal();
            closeLogDetailsModal();
            closeClearLogsModal();
        }
    });

    ['exportModal', 'logDetailsModal', 'clearLogsModal'].forEach(id => {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    if (id === 'exportModal') closeExportModal();
                    if (id === 'logDetailsModal') closeLogDetailsModal();
                    if (id === 'clearLogsModal') closeClearLogsModal();
                }
            });
        }
    });
</script>
@endsection
