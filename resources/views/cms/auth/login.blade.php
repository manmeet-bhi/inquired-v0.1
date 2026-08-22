<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anywhereroles Desk Login</title>
    @include('partials.favicons')
    <link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/tailwind-full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/cms-stylesheet.css') }}" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top right, #f8fafc, #f1f5f9);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 24px;
        }
        .auth-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            position: relative;
            overflow: hidden;
        }
        .auth-logo {
            display: block;
            margin: 0 auto 32px;
            height: 48px;
            object-fit: contain;
        }

        .error-alert {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 24px;
            font-weight: 500;
        }
        .success-alert {
            background: #f0fdf4;
            border: 1px solid #bcf0da;
            color: #15803d;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        /* 2-Step Transitions */
        .steps-container {
            position: relative;
            display: flex;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            width: 200%; /* Two steps */
        }
        .auth-step {
            width: 50%;
            transition: opacity 0.4s ease, visibility 0.4s;
            padding: 2px; /* Prevent focus ring clipping */
        }
        .auth-step.hidden-step {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .step-2-active .steps-container {
            transform: translateX(-50%);
        }

        .user-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }

        .user-preview-email {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Anywhereroles Logo" class="auth-logo">
            
            <form action="{{ route('cms.login') }}" method="POST" id="auth-form" class="overflow-hidden">
                @csrf
                
                @if(session('status'))
                    <div class="success-alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="error-alert">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <div class="steps-container">
                    <!-- Step 1: Email -->
                    <div class="auth-step" id="step-1">
                        <div class="cms-form-group">
                            <label class="cms-label">Email Address</label>
                            <input type="email" name="email" id="email-input" class="cms-input" placeholder="example@example.com" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-6 text-right">
                            <a href="{{ route('cms.password.request') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>

                        <button type="button" class="cms-btn cms-btn-primary w-full" onclick="goToStep(2)">
                            <span class="btn-text">Continue</span>
                        </button>
                    </div>

                    <!-- Step 2: Password -->
                    <div class="auth-step hidden-step" id="step-2">
                        <div class="user-preview">
                            <div class="user-preview-email" id="email-display">user@example.com</div>
                            <button type="button" onclick="goToStep(1)" class="ml-auto text-xs font-bold text-indigo-600 hover:text-indigo-500 uppercase tracking-wider">Edit</button>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-label" for="password">Password</label>
                            <div class="relative flex items-center" style="position: relative; display: flex; align-items: center;">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="cms-input transition-all duration-200 focus:ring-2 focus:ring-indigo-500/20" 
                                       style="padding-right: 48px !important;"
                                       placeholder="••••••••" 
                                       autocomplete="current-password">
                                <button type="button" 
                                        id="toggle-password-btn"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: transparent; padding: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #94a3b8; border-radius: 6px; z-index: 10; line-height: 0;" 
                                        onmouseover="this.style.color='#4f46e5'"
                                        onmouseout="this.style.color='#94a3b8'"
                                        onclick="togglePassword()" 
                                        title="Toggle password visibility"
                                        aria-label="Toggle password visibility">
                                    <svg id="eye-icon" style="width: 20px; height: 20px; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-off-icon" style="width: 20px; height: 20px; display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center mb-6">
                            <input type="checkbox" name="remember" id="remember" value="1" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 text-sm text-slate-600 cursor-pointer select-none">Remember me</label>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" class="cms-btn cms-btn-secondary flex-1" onclick="goToStep(1)">
                                <span class="btn-text">Back</span>
                            </button>
                            <button type="submit" class="cms-btn cms-btn-primary flex-[2]" id="login-btn">
                                <span class="btn-spinner"></span>
                                <span class="btn-text">Sign In</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
            passwordInput.focus();
        }

        function goToStep(step) {
            const form = document.getElementById('auth-form');
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const emailInput = document.getElementById('email-input');
            const emailDisplay = document.getElementById('email-display');
            const passwordInput = document.getElementById('password');

            if (step === 2) {
                // Validate email before proceeding
                if (!emailInput.value || !emailInput.checkValidity()) {
                    emailInput.classList.add('error-shake');
                    setTimeout(() => emailInput.classList.remove('error-shake'), 500);
                    emailInput.focus();
                    return;
                }

                emailDisplay.textContent = emailInput.value;
                form.classList.add('step-2-active');
                step1.classList.add('hidden-step');
                step2.classList.remove('hidden-step');
                setTimeout(() => passwordInput.focus(), 400);
            } else {
                form.classList.remove('step-2-active');
                step2.classList.add('hidden-step');
                step1.classList.remove('hidden-step');
                setTimeout(() => emailInput.focus(), 400);
            }
        }

        // Handle ENTER key on email input
        document.getElementById('email-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                goToStep(2);
            }
        });

        // Form submission handling
        document.getElementById('auth-form').addEventListener('submit', function (event) {
            const btn = document.getElementById('login-btn');
            const passwordInput = document.getElementById('password');
            
            if (!passwordInput.value) {
                passwordInput.classList.add('error-shake');
                setTimeout(() => passwordInput.classList.remove('error-shake'), 500);
                passwordInput.focus();
                event.preventDefault();
                return;
            }

            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Auto-advance to step 2 if returning with validation errors / old email
        @if(old('email') || $errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email-input');
            if (emailInput && emailInput.value) {
                goToStep(2);
            }
        });
        @endif
    </script>
</body>
</html>