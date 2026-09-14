@extends('layouts.cms')

@section('title', 'Activity Logs - Inaquired')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Activity Logs</h1>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                    {{ number_format($activities->total()) }} {{ \Illuminate\Support\Str::plural('record', $activities->total()) }}
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Audit trail of all administrative actions and security events.</p>
        </div>

        <div class="flex items-center gap-3">
            @if($activities->total() > 0)
                <button type="button" onclick="openExportModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 hover:border-indigo-300 rounded-xl text-sm font-semibold transition-all shadow-sm active:scale-95">
                    <i data-lucide="download" class="w-4 h-4 text-indigo-600"></i>
                    <span>Export CSV</span>
                </button>
            @endif

            @if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->isSuperAdmin() && $activities->total() > 0)
                <form action="{{ route('cms.activity.clear') }}" method="POST" onsubmit="return confirm('⚠️ Are you sure you want to clear ALL activity logs?\n\nThis will permanently delete {{ number_format($activities->total()) }} log records and cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 hover:border-rose-300 rounded-xl text-sm font-semibold transition-all shadow-sm active:scale-95">
                        <i data-lucide="trash-2" class="w-4 h-4 text-rose-600"></i>
                        <span>Clear All Logs</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col min-h-[500px]">
        
        <!-- Table -->
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/90 text-xs uppercase text-slate-500 font-semibold border-b border-slate-200 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Admin User</th>
                        <th scope="col" class="px-6 py-4">Action Taken</th>
                        <th scope="col" class="px-6 py-4 hidden md:table-cell">Target Record</th>
                        <th scope="col" class="px-6 py-4 hidden lg:table-cell">IP Address</th>
                        <th scope="col" class="px-6 py-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0 text-indigo-600 font-bold text-xs shadow-xs">
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
                                    @if(str_contains(strtolower($activity->action), 'created') || str_contains(strtolower($activity->action), 'in')) bg-emerald-100 text-emerald-800 border border-emerald-200
                                    @elseif(str_contains(strtolower($activity->action), 'updated') || str_contains(strtolower($activity->action), 'modified')) bg-sky-100 text-sky-800 border border-sky-200
                                    @elseif(str_contains(strtolower($activity->action), 'deleted') || str_contains(strtolower($activity->action), 'out')) bg-rose-100 text-rose-800 border border-rose-200
                                    @else bg-slate-100 text-slate-800 border border-slate-200 @endif">
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
                                <span class="text-xs font-mono text-slate-600 bg-slate-100 px-2 py-1 rounded border border-slate-200">{{ $activity->ip_address ?? 'N/A' }}</span>
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
                            <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-3 border border-slate-200">
                                        <i data-lucide="activity" class="w-7 h-7"></i>
                                    </div>
                                    <p class="text-base font-semibold text-slate-800">No activity recorded</p>
                                    <p class="text-sm text-slate-500 mt-1">Actions performed by administrators will appear here automatically.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($activities->hasPages())
            <div class="border-t border-slate-200 bg-slate-50/70 px-6 py-4">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Progressive Export Progress Modal -->
<div id="exportModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden transition-opacity opacity-0 duration-200">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full overflow-hidden transform scale-95 transition-transform duration-200" id="exportModalContent">
        
        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-indigo-50/30">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shadow-xs">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Export Activity Logs</h3>
                    <p class="text-xs text-slate-500">Generating CSV audit archive</p>
                </div>
            </div>
            <button type="button" onclick="closeExportModal()" id="exportCloseBtn" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="p-6 space-y-6">
            
            <!-- Progress Section (Active while running) -->
            <div id="progressState" class="space-y-4">
                <div class="flex items-center justify-between text-sm">
                    <span id="progressStatusText" class="font-medium text-slate-700 flex items-center gap-2">
                        <i data-lucide="loader-2" class="w-4 h-4 text-indigo-600 animate-spin"></i>
                        <span>Initializing exporter...</span>
                    </span>
                    <span id="progressPercent" class="font-bold font-mono text-indigo-600">0%</span>
                </div>

                <!-- Progress Bar Outer Container -->
                <div class="w-full bg-slate-100 rounded-full h-3.5 p-0.5 overflow-hidden border border-slate-200 shadow-inner">
                    <div id="progressBarFill" class="bg-gradient-to-r from-indigo-500 via-blue-500 to-indigo-600 h-full rounded-full transition-all duration-300 ease-out shadow-sm" style="width: 0%"></div>
                </div>

                <div class="flex justify-between items-center text-xs text-slate-400 pt-1">
                    <span>Task: Query & Stream logs</span>
                    <span>Total: {{ number_format($activities->total()) }} records</span>
                </div>
            </div>

            <!-- Task Details Information Card -->
            <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 text-xs space-y-2.5">
                <div class="flex items-center justify-between text-slate-600">
                    <span class="font-medium text-slate-500">Task Name:</span>
                    <span class="font-semibold text-slate-800">Admin Audit Trail Export</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span class="font-medium text-slate-500">Total Entries:</span>
                    <span class="font-semibold text-slate-800 font-mono">{{ number_format($activities->total()) }} records</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span class="font-medium text-slate-500">File Format:</span>
                    <span class="font-semibold text-slate-800 font-mono">CSV (.csv) UTF-8</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span class="font-medium text-slate-500">Operator:</span>
                    <span class="font-semibold text-slate-800">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span class="font-medium text-slate-500">Generated At:</span>
                    <span class="font-semibold text-slate-800 font-mono">{{ now()->format('M d, Y h:i A') }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600 pt-1 border-t border-slate-200/60">
                    <span class="font-medium text-slate-500">Task Status:</span>
                    <span id="taskStatusBadge" class="inline-flex items-center gap-1 font-semibold text-amber-600">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>Processing in progress</span>
                    </span>
                </div>
            </div>

            <!-- Completed Actions (Hidden until 100%) -->
            <div id="completedState" class="hidden space-y-3 pt-2">
                <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-emerald-800 text-sm font-medium">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                    <span>Export completed successfully! Your CSV file is ready for download.</span>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a id="downloadCsvBtn" href="{{ route('cms.activity.export') }}" download class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-indigo-500/20 active:scale-95 transition-all">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        <span>Download CSV File</span>
                    </a>
                    <button type="button" onclick="closeExportModal()" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition-colors">
                        Done
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    let exportTimer = null;

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
        progressStatusText.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 text-indigo-600 animate-spin"></i><span>Connecting to audit database...</span>';
        taskStatusBadge.innerHTML = '<span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span><span>Processing in progress</span>';
        taskStatusBadge.className = 'inline-flex items-center gap-1 font-semibold text-amber-600';
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
            // Increment progress with smooth random variations
            const increment = Math.floor(Math.random() * 8) + 4;
            currentProgress = Math.min(100, currentProgress + increment);

            progressBarFill.style.width = currentProgress + '%';
            progressPercent.innerText = currentProgress + '%';

            // Find matched step message
            for (let i = 0; i < steps.length; i++) {
                if (currentProgress <= steps[i].threshold || i === steps.length - 1) {
                    if (currentProgress < 100) {
                        progressStatusText.innerHTML = `<i data-lucide="loader-2" class="w-4 h-4 text-indigo-600 animate-spin"></i><span>${steps[i].text}</span>`;
                    } else {
                        progressStatusText.innerHTML = `<i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i><span class="text-emerald-700 font-semibold">${steps[i].text}</span>`;
                    }
                    if (window.lucide) lucide.createIcons();
                    break;
                }
            }

            if (currentProgress >= 100) {
                clearInterval(exportTimer);
                
                // Update badge to Completed
                taskStatusBadge.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-500"></span><span>Ready for Download</span>';
                taskStatusBadge.className = 'inline-flex items-center gap-1 font-semibold text-emerald-600';
                
                // Reveal completed state
                setTimeout(() => {
                    completedState.classList.remove('hidden');
                    if (window.lucide) lucide.createIcons();
                }, 200);
            }
        }, 120);
    }

    function closeExportModal() {
        if (exportTimer) clearInterval(exportTimer);
        const modal = document.getElementById('exportModal');
        const content = document.getElementById('exportModalContent');
        
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    // Close on backdrop click
    document.getElementById('exportModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeExportModal();
        }
    });
</script>
@endsection
