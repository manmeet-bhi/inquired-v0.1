<div id="terms-acceptance-banner" class="hidden fixed bottom-0 left-0 right-0 z-[100] p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-slate-900/95 backdrop-blur-md border border-slate-700/50 rounded-3xl shadow-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5 w-full md:w-auto text-left">

                <div class="flex-1 min-w-0">
                    <h3 class="text-white font-bold text-lg mb-1">Terms & Privacy</h3>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-2xl text-wrap break-words">
                        By using this website, you agree to our <a href="{{ route('terms') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors underline decoration-blue-400/30 underline-offset-4">Terms of Service</a> and our commitment to privacy. We do not collect personal data.
                        <a href="{{ route('cookies') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold transition-colors ml-1 group whitespace-nowrap">
                            Learn more
                            <i data-lucide="arrow-right" class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button id="accept-terms-btn" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-2xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 whitespace-nowrap">
                    Got it, thanks!
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.getElementById('terms-acceptance-banner');
        const acceptBtn = document.getElementById('accept-terms-btn');
        
        // Check if already accepted
        if (!localStorage.getItem('terms-accepted')) {
            // Show with a small delay for better UX
            setTimeout(() => {
                banner.classList.remove('hidden');
                // Re-initialize icons for the banner
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons({
                        attrs: {
                            class: 'lucide'
                        },
                        nameAttr: 'data-lucide'
                    });
                }
            }, 1000);
        }
        
        if (acceptBtn && banner) {
            acceptBtn.addEventListener('click', function() {
                localStorage.setItem('terms-accepted', 'true');
                banner.classList.add('translate-y-full');
                banner.style.transition = 'all 0.5s ease-in';
                setTimeout(() => {
                    banner.classList.add('hidden');
                }, 500);
            });
        }
    });
</script>
