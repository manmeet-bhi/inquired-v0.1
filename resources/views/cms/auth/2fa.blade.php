<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify its you - Inaquired CMS</title>
    @include('partials.favicons')
    <link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/tailwind-full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/cms-stylesheet.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/lucide.min.js') }}"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: radial-gradient(circle at top right, #f8fafc, #f1f5f9);
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .login-box { 
            background: white; 
            padding: 40px;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            width: 100%; 
            max-width: 450px; 
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        
        .loading .btn-text { display: none; }

        /* Success Animation */
        .success-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: white;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            z-index: 20;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .success-overlay.show { display: flex; opacity: 1; }

        .checkmark-circle {
            width: 80px; height: 80px;
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin-bottom: 20px;
        }
        .checkmark-circle .background {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: #22c55e;
            position: absolute;
        }
        .checkmark-circle .checkmark {
            border-radius: 5px;
        }
        .checkmark-circle .checkmark.draw:after {
            animation-duration: 800ms;
            animation-timing-function: ease;
            animation-name: checkmark;
            transform: scaleX(-1) rotate(135deg);
        }
        .checkmark-circle .checkmark:after {
            opacity: 1;
            height: 40px;
            width: 20px;
            transform-origin: left top;
            border-right: 5px solid white;
            border-top: 5px solid white;
            content: '';
            left: 20px;
            top: 40px;
            position: absolute;
        }
        @keyframes checkmark {
            0% { height: 0; width: 0; opacity: 1; }
            20% { height: 0; width: 20px; opacity: 1; }
            40% { height: 40px; width: 20px; opacity: 1; }
            100% { height: 40px; width: 20px; opacity: 1; }
        }

        .input-code:focus { border-color: #1877f2; box-shadow: 0 0 0 4px rgba(24, 119, 242, 0.1); }
    </style>
</head>
<body>
    <div class="login-box" id="main-box">
        <!-- Success Overlay -->
        <div class="success-overlay" id="success-overlay">
            <div class="checkmark-circle">
                <div class="background"></div>
                <div class="checkmark draw"></div>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Verified Successfully</h3>
            <p class="text-slate-500 text-sm mt-2">Redirecting to dashboard...</p>
        </div>

        <div class="text-center mb-6">
            <div class="mx-auto h-24 w-24 text-indigo-600 flex items-center justify-center bg-indigo-50 rounded-full mb-6 ring-8 ring-indigo-50/50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="m16 19 2 2 4-4"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Verify its you</h2>
            <p class="text-slate-600 text-xs" id="verify-text">
                @if(session('2fa_type') === 'google')
                    Enter the 6-digit code from your Authenticator app.
                @else
                    Check your email for the 6-digit verification code.
                @endif
            </p>
        </div>

        <form id="verify-form" data-ajax="true" action="{{ route('cms.verify.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div class="mb-4">
                <div id="otp-mode">
                    @include('cms.partials.tfa-input', ['id' => 'otp-container'])
                </div>
                <div id="recovery-mode" class="hidden">
                    <input type="text" name="recovery_code" id="recovery-input" 
                           class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-center font-mono text-xl tracking-widest focus:border-blue-500 focus:outline-none uppercase"
                           placeholder="Enter backup code" maxlength="10">
                </div>
                
                <input type="hidden" name="code" id="code-input">
                @if($errors->any())
                    <p class="mt-3 text-sm text-red-500 text-center font-medium" id="error-msg">{{ $errors->first() }}</p>
                @endif
                
                <!-- Loading Indicator -->
                <div id="loading-indicator" class="hidden flex flex-col items-center justify-center py-4">
                    <div class="w-10 h-10 border-4 border-indigo-100 border-t-indigo-600 rounded-full animate-spin"></div>
                    <p class="text-xs text-indigo-600 font-bold mt-3 uppercase tracking-wider animate-pulse">Verifying code...</p>
                </div>
            </div>

            <div class="text-center pt-2" id="resend-container">
                <button type="button" id="resend-btn" disabled class="text-xs font-bold uppercase tracking-wider text-blue-600 hover:text-blue-800 disabled:text-slate-400 disabled:cursor-not-allowed transition-colors">
                    Resend Code <span id="countdown">(60s)</span>
                </button>
            </div>

            <div class="text-center pt-4 space-y-4">
                <button type="button" id="toggle-recovery-btn" class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-blue-600 transition-colors">
                    Use a backup recovery code
                </button>
                <div class="border-t border-slate-100 pt-4">
                    <a href="{{ route('cms.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-[10px] font-bold uppercase tracking-wider text-slate-400 hover:text-slate-600 transition-colors">
                        Cancel & Return to Login
                    </a>
                </div>
            </div>
        </form>

        <form id="logout-form" action="{{ route('cms.logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        const form = document.getElementById('verify-form');
        const loadingIndicator = document.getElementById('loading-indicator');
        const overlay = document.getElementById('success-overlay');
        const errorMsg = document.getElementById('error-msg');
        
        // Resend logic
        const resendBtn = document.getElementById('resend-btn');
        const countdownEl = document.getElementById('countdown');
        let timeLeft = 60;
        let timerId = null;

        function startTimer() {
            resendBtn.disabled = true;
            timeLeft = 60;
            countdownEl.textContent = `(${timeLeft}s)`;
            
            if (timerId) clearInterval(timerId);
            
            timerId = setInterval(() => {
                timeLeft--;
                if (timeLeft <= 0) {
                    clearInterval(timerId);
                    resendBtn.disabled = false;
                    countdownEl.textContent = '';
                } else {
                    countdownEl.textContent = `(${timeLeft}s)`;
                }
            }, 1000);
        }

        resendBtn.addEventListener('click', async () => {
            resendBtn.disabled = true;
            const originalText = resendBtn.innerHTML;
            resendBtn.textContent = 'Sending...';

            try {
                const response = await fetch("{{ route('cms.verify.resend') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    // Start timer again
                    startTimer();
                } else {
                    resendBtn.innerHTML = originalText;
                    resendBtn.disabled = false;
                    alert('Failed to resend code. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                resendBtn.innerHTML = originalText;
                resendBtn.disabled = false;
            }
        });

        let otpField = null;

        function initFields() {
            otpField = window.initOtpField('otp-container', (val) => {
                document.getElementById('code-input').value = val;
                form.dispatchEvent(new Event('submit'));
            });
            setTimeout(() => {
                if (otpField) otpField.focus();
            }, 100);
        }

        // Initialize timer and fields on load
        startTimer();
        setTimeout(initFields, 0);

        // Recovery mode toggle
        const toggleRecoveryBtn = document.getElementById('toggle-recovery-btn');
        const otpMode = document.getElementById('otp-mode');
        const recoveryMode = document.getElementById('recovery-mode');
        const resendContainer = document.getElementById('resend-container');
        const verifyText = document.getElementById('verify-text');
        const recoveryInput = document.getElementById('recovery-input');
        let isRecoveryMode = false;

        toggleRecoveryBtn.addEventListener('click', () => {
            isRecoveryMode = !isRecoveryMode;
            if (isRecoveryMode) {
                otpMode.classList.add('hidden');
                recoveryMode.classList.remove('hidden');
                resendContainer.classList.add('hidden');
                verifyText.textContent = 'Enter one of your 8-character recovery codes.';
                toggleRecoveryBtn.textContent = 'Use authentication code instead';
                recoveryInput.focus();
            } else {
                otpMode.classList.remove('hidden');
                recoveryMode.classList.add('hidden');
                resendContainer.classList.remove('hidden');
                verifyText.textContent = "{{ session('2fa_type') === 'google' ? 'Enter the 6-digit code from your Authenticator app.' : 'Check your email for the 6-digit verification code.' }}";
                toggleRecoveryBtn.textContent = 'Use a backup recovery code';
                if (otpField) otpField.focus();
            }
        });

        // Auto-submit recovery code when 10 characters entered
        recoveryInput.addEventListener('input', () => {
            if (recoveryInput.value.trim().length === 10) {
                form.dispatchEvent(new Event('submit'));
            }
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Update code-input based on mode
            if (isRecoveryMode) {
                document.getElementById('code-input').value = recoveryInput.value;
            } else if (otpField) {
                document.getElementById('code-input').value = otpField.getValue();
            }

            const codeValue = document.getElementById('code-input').value;
            if (!codeValue) return;

            // Clear previous errors
            if (errorMsg) errorMsg.style.display = 'none';
            
            // Hide normal UI and show loader
            otpMode.style.opacity = '0.3';
            recoveryMode.style.opacity = '0.3';
            otpMode.style.pointerEvents = 'none';
            recoveryMode.style.pointerEvents = 'none';
            loadingIndicator.classList.remove('hidden');

            const formData = new FormData(form);
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    loadingIndicator.classList.add('hidden');
                    // Show success animation
                    overlay.classList.add('show');
                    
                    // Small delay to admire the animation then redirect
                    setTimeout(() => {
                        window.location.href = "{{ route('cms.dashboard') }}";
                    }, 1200);
                } else {
                    const data = await response.json();
                    loadingIndicator.classList.add('hidden');
                    otpMode.style.opacity = '1';
                    recoveryMode.style.opacity = '1';
                    otpMode.style.pointerEvents = 'auto';
                    recoveryMode.style.pointerEvents = 'auto';
                    
                    // Create or update error message
                    let msg = data.errors?.code?.[0] || data.message || 'Verification failed. Please try again.';
                    if (errorMsg) {
                        errorMsg.textContent = msg;
                        errorMsg.style.display = 'block';
                    } else {
                        const newError = document.createElement('p');
                        newError.id = 'error-msg';
                        newError.className = 'mt-3 text-sm text-red-500 text-center font-medium';
                        newError.textContent = msg;
                        form.querySelector('div').appendChild(newError);
                    }

                    // Clear OTP if failed
                    if (!isRecoveryMode && otpField) {
                        otpField.clear();
                        otpField.focus();
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                loadingIndicator.classList.add('hidden');
                otpMode.style.opacity = '1';
                recoveryMode.style.opacity = '1';
            }
        });

        // Auto-focus the input
        document.getElementById('code-input').focus();
    </script>
</body>
</html>
