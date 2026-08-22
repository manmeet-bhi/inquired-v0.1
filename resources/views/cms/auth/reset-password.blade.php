<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Anywhereroles Desk</title>
    @include('partials.favicons')
    <link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/tailwind-full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/cms-stylesheet.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/lucide.min.js') }}"></script>
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
        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.025em;
            margin-bottom: 8px;
        }
        .auth-subtitle {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
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
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Anywhereroles Logo" class="auth-logo">
            
            <div class="auth-header">
                <h1 class="auth-title">Reset Your Password</h1>
                <p class="auth-subtitle">Secure your account by choosing a strong new password.</p>
            </div>
            
            <form action="{{ route('cms.password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                @if($errors->any())
                    <div class="error-alert">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <div class="cms-form-group">
                    <label class="cms-label">Email Address</label>
                    <input type="email" name="email" class="cms-input" placeholder="e.g. name@company.com" value="{{ old('email', $email ?? request()->query('email')) }}" required autofocus>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">New Password</label>
                    <div class="relative group">
                        <input type="password" name="password" id="password" class="cms-input pr-12 transition-all duration-200 focus:ring-2 focus:ring-indigo-500/20" placeholder="••••••••" required>
                        <button type="button" 
                                class="absolute right-0 top-0 h-full px-4 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors z-10" 
                                onclick="togglePassword('password', this)" 
                                title="Toggle Password Visibility">
                            <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                            <i data-lucide="eye-off" class="w-5 h-5 eye-off-icon hidden"></i>
                        </button>
                    </div>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">Confirm New Password</label>
                    <div class="relative group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="cms-input pr-12 transition-all duration-200 focus:ring-2 focus:ring-indigo-500/20" placeholder="••••••••" required>
                        <button type="button" 
                                class="absolute right-0 top-0 h-full px-4 flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors z-10" 
                                onclick="togglePassword('password_confirmation', this)" 
                                title="Toggle Password Visibility">
                            <i data-lucide="eye" class="w-5 h-5 eye-icon"></i>
                            <i data-lucide="eye-off" class="w-5 h-5 eye-off-icon hidden"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="cms-btn cms-btn-primary w-full" id="submit-btn">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Reset Password</span>
                </button>

                <div class="text-center mt-6">
                    <a href="{{ route('cms.login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        function togglePassword(inputId, button) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = button.querySelector('.eye-icon');
            const eyeOffIcon = button.querySelector('.eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>