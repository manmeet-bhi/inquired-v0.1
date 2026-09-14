<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Inaquired Desk</title>
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
            margin: 0;
            padding: 16px;
        }
        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 0;
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

        .user-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
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
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/logos/logo.png') }}" alt="Inaquired Logo" class="auth-logo">
            </a>
            
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

            @if(Auth::guard('admin')->check())
                <!-- Case 1: User is Logged In (from Profile Settings > Change Password) -->
                <div class="user-preview flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0 flex-1 mr-2">
                        <div class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center font-bold text-indigo-600 text-xs shrink-0">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="user-preview-email" title="{{ Auth::guard('admin')->user()->email }}">{{ Auth::guard('admin')->user()->email }}</div>
                            <div class="text-[11px] text-slate-500 truncate">{{ Auth::guard('admin')->user()->name }} · Active Session</div>
                        </div>
                    </div>
                    <form action="{{ route('cms.logout') }}" method="POST" class="inline m-0 shrink-0">
                        @csrf
                        <button type="submit" class="p-1.5 sm:px-2.5 sm:py-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all flex items-center gap-1 text-xs font-semibold" title="Log Out / Switch Account">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>

                <form action="{{ route('cms.password.email') }}" method="POST" id="auth-form">
                    @csrf
                    <input type="hidden" name="email" value="{{ Auth::guard('admin')->user()->email }}">

                    <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                        Click below to send a password reset verification link to your registered email address.
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('cms.profile') }}#password" class="cms-btn cms-btn-secondary flex-1 text-center flex items-center justify-center text-sm font-semibold">
                            <span class="btn-text">Back</span>
                        </a>
                        <button type="submit" class="cms-btn cms-btn-primary flex-[2]" id="submit-btn">
                            <span class="btn-spinner"></span>
                            <span class="btn-text">Send Reset Link</span>
                        </button>
                    </div>
                </form>

            @else
                <!-- Case 2: User is Logged Out (Guest) -->
                <form action="{{ route('cms.password.email') }}" method="POST" id="auth-form">
                    @csrf

                    <div class="cms-form-group">
                        <label class="cms-label">Email Address</label>
                        <input type="email" name="email" id="email-input" class="cms-input" placeholder="example@example.com" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('cms.login') }}" class="cms-btn cms-btn-secondary flex-1 text-center flex items-center justify-center text-sm font-semibold">
                            <span class="btn-text">Back</span>
                        </a>
                        <button type="submit" class="cms-btn cms-btn-primary flex-[2]" id="submit-btn">
                            <span class="btn-spinner"></span>
                            <span class="btn-text">Send Reset Link</span>
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>

    <script>
        document.getElementById('auth-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            if (btn) {
                btn.classList.add('loading');
                btn.disabled = true;
            }
        });
    </script>
</body>
</html>