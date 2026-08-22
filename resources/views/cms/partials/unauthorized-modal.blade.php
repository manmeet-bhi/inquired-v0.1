<!-- Permission Denied Modular Modal (Solid Premium Style) -->
<div id="unauthorized-modal" 
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300 bg-slate-900/60"
     onclick="hideUnauthorizedModal()">
    
    <div class="max-w-md w-full animate-in fade-in zoom-in duration-300" onclick="event.stopPropagation()">
        <div class="bg-white rounded-2xl p-8 border-2 border-rose-500 shadow-[0_20px_50px_rgba(225,29,72,0.15)] relative overflow-hidden">
            <!-- Decorative Sidebar Accent -->
            <div class="absolute inset-y-0 left-0 w-1.5 bg-rose-500"></div>
            
            <div class="flex items-start gap-5">
                <!-- Icon -->
                <div class="shrink-0 w-14 h-14 bg-rose-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-rose-200">
                    <i data-lucide="shield-alert" class="w-7 h-7"></i>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2 mt-1 tracking-tight">Access Denied</h3>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        You do not have the permissions to access this page or action. 
                        <span class="block mt-4 p-4 bg-rose-50 rounded-xl border border-rose-100 text-rose-900 font-bold">
                            Please connect to the administrator to update your role.
                        </span>
                    </p>
                </div>
            </div>

            <!-- Dismiss Hint -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-center">
                <p class="text-[11px] uppercase tracking-[0.2em] font-bold text-slate-400">Click anywhere to dismiss</p>
            </div>
        </div>
    </div>
</div>

<script>
    function showUnauthorizedModal() {
        const modal = document.getElementById('unauthorized-modal');
        if (modal) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            // Re-render lucide icons if needed
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    }

    function hideUnauthorizedModal() {
        const modal = document.getElementById('unauthorized-modal');
        if (modal) {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }
    }
</script>
