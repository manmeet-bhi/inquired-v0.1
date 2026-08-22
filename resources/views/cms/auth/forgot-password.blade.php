<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Anywhereroles Desk</title>
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
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Anywhereroles Logo" class="auth-logo">
            
            <div class="auth-header">
                <h1 class="auth-title">Find Your Account</h1>
                <p class="auth-subtitle">Enter your email address to search for your account and reset your password.</p>
            </div>
            
            <form action="{{ route('cms.password.email') }}" method="POST">
                @csrf
                
                @if(session('status'))
                    <div class="success-alert">
                        {{ session('status') }}
                    </div>
                @endif

                @error('email')
                    <div class="error-alert">
                        {{ $message }}
                    </div>
                @enderror

                <div class="cms-form-group">
                    <label class="cms-label">Email Address</label>
                    <input type="email" name="email" class="cms-input" placeholder="example@example.com" value="{{ old('email') }}" required autofocus>
                </div>

                <button type="submit" class="cms-btn cms-btn-primary w-full" id="submit-btn">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Send Reset Link</span>
                </button>

                <div class="text-center mt-6">
                    <a href="{{ route('cms.login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-colors flex items-center justify-center gap-1">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>