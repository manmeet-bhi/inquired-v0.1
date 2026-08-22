<div class="otp-wrapper" id="{{ $id ?? '2fa-otp-container' }}">
    @for($i = 0; $i < 6; $i++)
        <input type="text" 
               maxlength="1" 
               data-index="{{ $i }}"
               class="otp-digit"
               inputmode="numeric"
               pattern="[0-9]*"
               autocomplete="one-time-code">
    @endfor
</div>

<style>
.otp-wrapper {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-bottom: 1.25rem;
    width: 100%;
    max-width: 280px;
    margin-left: auto;
    margin-right: auto;
}
.otp-digit {
    width: 42px !important;
    height: 52px !important;
    text-align: center !important;
    font-size: 22px !important;
    font-weight: 700 !important;
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    background-color: #f8fafc !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    padding: 0 !important;
    line-height: 52px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
.otp-digit:focus {
    border-color: #1877f2 !important;
    background-color: #fff !important;
    box-shadow: 0 0 0 4px rgba(24, 119, 242, 0.1) !important;
    outline: none !important;
    transform: none !important; /* Disable global translateY */
}
@keyframes otp-shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
.otp-wrapper.animate-shake {
    animation: otp-shake 0.2s ease-in-out 0s 2;
}
</style>

<script>
if (typeof initOtpField !== 'function') {
    window.initOtpField = function(containerId, onComplete) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        const inputs = container.querySelectorAll('.otp-digit');
        
        inputs.forEach((input, index) => {
            // Handle typing
            input.addEventListener('input', (e) => {
                const val = e.target.value;
                // Allow only numbers
                if (/[^0-9]/.test(val)) {
                    e.target.value = val.replace(/[^0-9]/g, '');
                }
                
                if (e.target.value.length > 0) {
                    if (index < inputs.length - 1) {
                        // Use requestAnimationFrame for smoother focus transition on Firefox
                        requestAnimationFrame(() => {
                            inputs[index + 1].focus();
                        });
                    }
                }
                checkComplete();
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    requestAnimationFrame(() => {
                        inputs[index - 1].focus();
                    });
                }
            });

            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6).split('');
                
                inputs.forEach((input, i) => {
                    input.value = pasteData[i] || '';
                });

                if (pasteData.length > 0) {
                    const lastFilledIndex = Math.min(pasteData.length - 1, inputs.length - 1);
                    const focusIndex = lastFilledIndex < inputs.length - 1 ? lastFilledIndex + 1 : lastFilledIndex;
                    requestAnimationFrame(() => {
                        inputs[focusIndex].focus();
                    });
                }
                checkComplete();
            });
        });

        function checkComplete() {
            const val = Array.from(inputs).map(i => i.value).join('');
            if (val.length === 6 && typeof onComplete === 'function') {
                onComplete(val);
            }
        }

        return {
            getValue: () => Array.from(inputs).map(i => i.value).join(''),
            clear: () => inputs.forEach(i => i.value = ''),
            focus: () => inputs[0].focus()
        };
    };
}
</script>
