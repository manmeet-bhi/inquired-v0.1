<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Inaquired CMS</title>
    @include('partials.favicons')
    <link href="{{ asset('assets/fonts/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/tailwind-full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/cms-stylesheet.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('assets/js/lucide.min.js') }}"></script>
    <style>
        body { 
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .auth-split-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Left Side: Form Content */
        .auth-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            background-color: #ffffff;
            position: relative;
            z-index: 10;
        }

        .auth-form-card {
            width: 100%;
            max-width: 440px;
        }

        .mail-icon-badge {
            width: 76px;
            height: 76px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 2px solid #bfdbfe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.15);
            color: #2563eb;
        }

        .auth-main-title {
            font-size: 1.875rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .auth-sub-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .user-email-chip {
            display: inline-block;
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 600;
            padding: 0.25rem 0.625rem;
            border-radius: 0.375rem;
            border: 1px solid #e2e8f0;
            margin-top: 0.25rem;
            word-break: break-all;
        }

        .resend-btn {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff !important;
            font-weight: 600;
            padding: 0.875rem 1.5rem;
            border-radius: 0.625rem;
            width: 100%;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .resend-btn:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            transform: translateY(-1px);
        }

        .resend-btn:active {
            transform: translateY(0);
        }

        .update-email-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            color: #0f172a;
            background-color: #ffffff;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .update-email-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .update-email-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .update-email-btn:hover {
            background-color: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
        }

        /* Right Side: High-Contrast Brand Graphic */
        .auth-brand-panel {
            flex: 1;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 50%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            color: #ffffff !important;
        }

        .brand-orb-1 {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.45) 0%, rgba(99, 102, 241, 0) 70%);
            pointer-events: none;
            filter: blur(40px);
        }

        .brand-orb-2 {
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.4) 0%, rgba(59, 130, 246, 0) 70%);
            pointer-events: none;
            filter: blur(40px);
        }

        .brand-pattern-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.12) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.6;
            pointer-events: none;
        }

        .brand-content-wrapper {
            position: relative;
            z-index: 10;
            max-width: 500px;
            text-align: center;
        }

        .brand-logo-img {
            height: 54px;
            width: auto;
            margin: 0 auto 2rem;
            filter: brightness(0) invert(1);
            display: block;
        }

        .brand-hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff !important;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 1.25rem;
            text-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
        }

        .brand-hero-desc {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #e0e7ff !important;
            font-weight: 400;
            margin-bottom: 2.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .feature-pills-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .feature-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 0.625rem 1.25rem;
            border-radius: 9999px;
            color: #ffffff !important;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .feature-pill-icon {
            color: #60a5fa;
            width: 1.125rem;
            height: 1.125rem;
        }

        @media (max-width: 768px) {
            .auth-split-wrapper {
                flex-direction: column-reverse;
            }
            .auth-brand-panel {
                padding: 2.5rem 1.5rem;
            }
            .brand-hero-title {
                font-size: 1.875rem;
            }
            .brand-hero-desc {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="auth-split-wrapper">
        
        <!-- Left Side: Action Form -->
        <div class="auth-form-panel">
            <div class="auth-form-card">
                
                <div class="text-center">
                    <div class="mail-icon-badge">
                        <i data-lucide="mail" style="width: 38px; height: 38px;"></i>
                    </div>
                    <h2 class="auth-main-title">Check your inbox</h2>
                    <p class="auth-sub-desc">
                        We sent a verification link to <br>
                        <span class="user-email-chip">{{ $user->email ?? 'your email address' }}</span>
                    </p>
                </div>

                <!-- Notifications -->
                @if (session('success'))
                    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 1rem; border-radius: 0.625rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #22c55e; flex-shrink: 0; margin-top: 2px;"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.9rem;">Success</div>
                            <div style="font-size: 0.85rem; margin-top: 2px;">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: 0.625rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <i data-lucide="alert-circle" style="width: 20px; height: 20px; color: #ef4444; flex-shrink: 0; margin-top: 2px;"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.9rem;">Errors Encountered</div>
                            <ul style="margin: 4px 0 0 0; padding-left: 1rem; font-size: 0.85rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Resend Form -->
                <form method="POST" action="{{ route('cms.verification.resend') }}" id="resend-form">
                    @csrf
                    <button type="submit" class="resend-btn" id="resend-submit-btn">
                        <span class="btn-spinner"></span>
                        <span class="btn-text" style="display: flex; align-items: center; gap: 0.5rem;">
                            <i data-lucide="send" style="width: 18px; height: 18px;"></i>
                            Resend Verification Email
                        </span>
                    </button>
                </form>

                <div style="margin: 2rem 0; position: relative; text-align: center;">
                    <div style="border-top: 1px solid #e2e8f0; position: absolute; top: 50%; left: 0; right: 0;"></div>
                    <span style="position: relative; background: #ffffff; padding: 0 0.875rem; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">
                        Have a typo in your email?
                    </span>
                </div>

                <!-- Update Email Form -->
                <form method="POST" action="{{ route('cms.change_email') }}">
                    @csrf
                    <div>
                        <input id="email" name="email" type="email" autocomplete="email" required class="update-email-input" placeholder="Enter corrected email address">
                    </div>
                    <button type="submit" class="update-email-btn">
                        Update Email & Resend
                    </button>
                </form>

                <!-- Logout Form -->
                <div style="margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9; text-align: center; font-size: 0.875rem; color: #64748b;">
                    <span>Need to access another account?</span>
                    <form method="POST" action="{{ route('cms.logout') }}" style="display: inline; margin-left: 0.25rem;">
                        @csrf
                        <button type="submit" style="background: none; border: none; padding: 0; color: #2563eb; font-weight: 600; cursor: pointer; text-decoration: underline;">
                            Log out completely
                        </button>
                    </form>
                </div>

            </div>
        </div>
        
        <!-- Right Side: Brand Graphic with High-Contrast Crystal-Clear Colors -->
        <div class="auth-brand-panel">
            <div class="brand-pattern-grid"></div>
            <div class="brand-orb-1"></div>
            <div class="brand-orb-2"></div>
            
            <div class="brand-content-wrapper">
                <a href="{{ url('/') }}" style="display: inline-block;">
                    <img src="{{ asset('assets/logos/logo.png') }}" alt="Inaquired Logo" class="brand-logo-img">
                </a>
                <h1 class="brand-hero-title">
                    Secure Your Account
                </h1>
                <p class="brand-hero-desc">
                    You're just one step away from managing your content seamlessly. Please verify your email to continue exploring the Inaquired dashboard.
                </p>
                
                <div class="feature-pills-row">
                    <div class="feature-pill">
                        <i data-lucide="shield-check" class="feature-pill-icon"></i>
                        <span>Fast Validation</span>
                    </div>
                    <div class="feature-pill">
                        <i data-lucide="lock" class="feature-pill-icon"></i>
                        <span>Encrypted Data</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Initialize Lucide icons
        if (window.lucide) {
            lucide.createIcons();
        }

        // Check verification status every 3 seconds silently
        const checkInterval = setInterval(async () => {
            try {
                const response = await fetch('{{ route('cms.verification.check') }}');
                const data = await response.json();
                
                if (data && data.verified) {
                    clearInterval(checkInterval);
                    document.body.style.opacity = '0.7';
                    document.body.style.transition = 'opacity 0.4s';
                    window.location.href = '{{ route('cms.dashboard') }}';
                }
            } catch (error) {
                // Keep polling silently
            }
        }, 3000);

        const resendForm = document.getElementById('resend-form');
        if (resendForm) {
            resendForm.addEventListener('submit', function() {
                const btn = document.getElementById('resend-submit-btn');
                if (btn) {
                    btn.classList.add('loading');
                    btn.disabled = true;
                }
            });
        }
    </script>
</body>
</html>
