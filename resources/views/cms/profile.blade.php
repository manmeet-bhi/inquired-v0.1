@extends('layouts.cms')

@section('title', 'Profile - CMS')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Profile Settings</h1>
            <form action="{{ route('cms.logout') }}" method="POST" class="inline m-0">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-3 sm:px-3.5 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 hover:text-rose-700 border border-rose-200/80 rounded-xl transition-all shadow-xs active:scale-95" title="Log Out of CMS">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center shadow-xs text-sm">
                <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-emerald-600 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center shadow-xs text-sm">
                <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-rose-600 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm shadow-xs">
                <div class="flex items-center gap-2 mb-2 font-semibold text-rose-900">
                    <i data-lucide="alert-octagon" class="w-4 h-4 text-rose-600 shrink-0"></i>
                    <span>Please fix the following validation errors:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs text-rose-700 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-xl border border-slate-200 p-1.5 shadow-xs flex gap-1 sm:gap-2">
            <button type="button" onclick="switchProfileTab('info')" id="tab-btn-info" 
                class="profile-tab-btn flex-1 inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold rounded-lg transition-all text-indigo-700 bg-indigo-50/80 border border-indigo-200/80 shadow-xs">
                <i data-lucide="user" class="w-4 h-4"></i>
                <span>Profile Information</span>
            </button>

            <button type="button" onclick="switchProfileTab('password')" id="tab-btn-password" 
                class="profile-tab-btn flex-1 inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold rounded-lg transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-50 border border-transparent">
                <i data-lucide="lock" class="w-4 h-4"></i>
                <span>Password</span>
            </button>

            <button type="button" onclick="switchProfileTab('2fa')" id="tab-btn-2fa" 
                class="profile-tab-btn flex-1 inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold rounded-lg transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-50 border border-transparent">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>2FA</span>
                @if(auth()->user()->two_factor_enabled)
                    <span class="w-2 h-2 rounded-full bg-emerald-500" title="2FA Active"></span>
                @endif
            </button>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: Profile Information                 -->
        <!-- ========================================== -->
        <div id="tab-content-info" class="profile-tab-content bg-white shadow-md rounded-2xl p-6 sm:p-8 border border-slate-200/60">
            <h2 class="text-lg font-semibold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                <span>Profile Information</span>
            </h2>
            
            <form action="{{ route('cms.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="name">
                        Full Name
                    </label>
                    <input class="w-full px-4 py-2.5 border rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('name') border-rose-500 @else border-slate-300 @enderror" 
                           id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="email">
                        Email Address
                    </label>
                    <input class="w-full px-4 py-2.5 border rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('email') border-rose-500 @else border-slate-300 @enderror" 
                           id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-3 flex items-center justify-end">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl transition-all shadow-md hover:shadow-indigo-500/20 active:scale-95 text-sm" 
                            type="submit">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: Change Password                     -->
        <!-- ========================================== -->
        <div id="tab-content-password" class="profile-tab-content hidden bg-white shadow-md rounded-2xl p-6 sm:p-8 border border-slate-200/60">
            <h2 class="text-lg font-semibold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="lock" class="w-5 h-5 text-indigo-600"></i>
                <span>Change Password</span>
            </h2>

            <form action="{{ route('cms.profile.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-slate-700 text-sm font-bold" for="current_password">
                            Current Password
                        </label>
                        <a href="{{ route('cms.password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                            Forgot password?
                        </a>
                    </div>
                    <input class="w-full px-4 py-2.5 border rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('current_password') border-rose-500 @else border-slate-300 @enderror" 
                           id="current_password" name="current_password" type="password" required>
                    @error('current_password')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="password">
                        New Password
                    </label>
                    <input class="w-full px-4 py-2.5 border rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all @error('password') border-rose-500 @else border-slate-300 @enderror" 
                           id="password" name="password" type="password" required>
                    @error('password')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="password_confirmation">
                        Confirm New Password
                    </label>
                    <input class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" 
                           id="password_confirmation" name="password_confirmation" type="password" required>
                </div>

                <div class="pt-3 flex items-center justify-end">
                    <button class="bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 px-5 rounded-xl transition-all shadow-md hover:shadow-rose-500/20 active:scale-95 text-sm" 
                            type="submit">
                        Change Password
                    </button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 3: Two-Factor Authentication (2FA)     -->
        <!-- ========================================== -->
        <div id="tab-content-2fa" class="profile-tab-content hidden bg-white shadow-md rounded-2xl p-6 sm:p-8 border border-slate-200/60" id="2fa-settings-section">
            <h2 class="text-lg font-semibold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-indigo-600"></i>
                <span>Two-Factor Authentication</span>
            </h2>
            
            <div id="2fa-status-banner">
                @if(auth()->user()->two_factor_enabled)
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-r-xl">
                        <p class="font-bold">2FA is currently ENABLED</p>
                        <p class="text-sm">Your account is protected with Two-Factor Authentication via {{ ucfirst(auth()->user()->two_factor_type) }}.</p>
                    </div>
                @else
                    <div class="mb-6 p-4 bg-slate-50 border-l-4 border-slate-400 text-slate-700 rounded-r-xl">
                        <p class="font-bold">2FA is currently DISABLED</p>
                        <p class="text-sm">Enable Two-Factor Authentication to add an extra layer of security to your account.</p>
                    </div>
                @endif
            </div>

            <form id="2fa-form">
                @csrf
                @method('PUT')

                <style>
                    .toggle-wrapper { position: relative; width: 3.5rem; height: 1.75rem; }
                    .toggle-input { position: absolute; opacity: 0; width: 0; height: 0; }
                    .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #e2e8f0; transition: .4s; border-radius: 9999px; }
                    .toggle-slider:before { position: absolute; content: ""; height: 1.25rem; width: 1.25rem; left: 0.25rem; bottom: 0.25rem; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); }
                    .toggle-input:checked + .toggle-slider { background-color: #4f46e5; }
                    .toggle-input:checked + .toggle-slider:before { transform: translateX(1.75rem); }
                    .toggle-input:focus + .toggle-slider { box-shadow: 0 0 1px #4f46e5; }
                    .tfa-spinner { display: inline-block; width: 1rem; height: 1rem; border: 2px solid #c7d2fe; border-top-color: #4f46e5; border-radius: 50%; animation: tfa-spin 0.7s linear infinite; vertical-align: middle; margin-left: 0.5rem; }
                    .tfa-spinner.hidden { display: none; }
                    @keyframes tfa-spin { to { transform: rotate(360deg); } }
                    .btn-spinner {
                        display: none;
                        width: 18px;
                        height: 18px;
                        border: 2px solid rgba(0, 0, 0, 0.1);
                        border-top-color: currentColor;
                        border-radius: 50%;
                        animation: spin 0.8s linear infinite;
                        margin-right: 8px;
                    }
                    @keyframes spin { to { transform: rotate(360deg); } }
                    .loading .btn-spinner { display: inline-block; }
                    .loading .btn-text { display: none; }
                    .loading i { display: none; }
                </style>

                <!-- Enable/Disable Toggle -->
                <div class="mb-6">
                    <label class="flex items-center cursor-pointer group">
                        <div class="toggle-wrapper">
                            <input type="checkbox" name="two_factor_enabled" id="two_factor_enabled" class="toggle-input" 
                                   {{ auth()->user()->two_factor_enabled ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </div>
                        <div class="ml-4 text-slate-700 font-medium group-hover:text-slate-900 transition-colors flex items-center gap-2">
                            <span>Enable 2FA</span>
                            <span id="toggle-spinner" class="tfa-spinner hidden"></span>
                        </div>
                    </label>
                </div>

                <!-- Method Selection -->
                <div id="2fa-method-container" class="mb-6 {{ !auth()->user()->two_factor_enabled ? 'opacity-50' : '' }}">
                    <span class="block text-slate-700 text-sm font-bold mb-2">Preferred Method</span>
                    <div class="flex space-x-6 items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="two_factor_type" value="email" class="form-radio h-4 w-4 text-indigo-600"
                                   {{ auth()->user()->two_factor_type === 'email' ? 'checked' : '' }}>
                            <span class="ml-2 text-slate-700 text-sm">Email Code</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="two_factor_type" value="google" class="form-radio h-4 w-4 text-indigo-600"
                                   {{ auth()->user()->two_factor_type === 'google' ? 'checked' : '' }}>
                            <span class="ml-2 text-slate-700 text-sm">Authenticator</span>
                        </label>
                        <span id="method-spinner" class="tfa-spinner hidden"></span>
                    </div>
                </div>

                <div id="qr-code-container">
                    @if(auth()->user()->two_factor_enabled && auth()->user()->two_factor_type === 'google')
                        <div class="mb-6 p-6 border border-slate-200 rounded-2xl text-center bg-slate-50/50">
                            <div class="flex items-center justify-center gap-2 mb-4 text-emerald-600">
                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                <span class="font-bold">Authenticator is linked</span>
                            </div>
                            
                            <div id="qr-content" class="hidden">
                                <p class="text-sm font-medium text-slate-700 mb-4">Scan this QR code with your Authenticator app</p>
                                <div class="inline-block p-4 bg-white rounded-lg shadow-sm mb-4">
                                    {!! $qrCodeInline !!}
                                </div>
                                <p class="text-xs text-slate-500 mb-2">Or enter this key manually:</p>
                                <code class="px-3 py-1 bg-white border rounded text-indigo-600 font-mono font-bold">{{ $secret }}</code>
                            </div>

                            <button type="button" id="toggle-qr-btn" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                                Show QR Code
                            </button>
                        </div>
                    @elseif(auth()->user()->two_factor_enabled && auth()->user()->two_factor_type === 'email')
                        <div class="mb-6 p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                            <p class="text-sm text-indigo-700">
                                <i data-lucide="mail" class="w-4 h-4 inline-block mr-1"></i>
                                <strong>Verification codes</strong> will be sent to your linked email: 
                                <span class="font-bold">{{ auth()->user()->email }}</span>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Backup Codes Section -->
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-slate-900">
                        <i data-lucide="key" class="w-5 h-5 text-slate-500"></i>
                        <span>Backup Recovery Codes</span>
                    </h3>
                    <p class="text-sm text-slate-500 mb-6">
                        Recovery codes can be used to access your account if you lose your two-factor authentication device. 
                        Keep these in a safe, offline place.
                    </p>

                    <div id="recovery-codes-area">
                        @if(auth()->user()->two_factor_recovery_codes)
                            <div class="flex flex-wrap gap-3 mb-6">
                                <button type="button" id="show-recovery-codes-btn" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition-all flex items-center gap-2 text-sm">
                                    <span class="btn-spinner"></span>
                                    <span class="btn-text">Show Backup Codes</span>
                                </button>
                                <a href="{{ route('cms.profile.2fa.recovery-codes.download') }}" data-no-preloader="true" id="download-recovery-codes-link" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition-all inline-flex items-center gap-2 text-sm shadow-xs">
                                    <span class="btn-spinner"></span>
                                    <i data-lucide="download" class="w-4 h-4"></i>
                                    <span class="btn-text">Download Codes</span>
                                </a>
                                <button type="button" id="email-recovery-codes-btn" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition-all flex items-center gap-2 text-sm shadow-xs">
                                    <span class="btn-spinner"></span>
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                    <span class="btn-text">Send to Email</span>
                                </button>
                            </div>
                        @else
                            <div class="mb-6">
                                <button type="button" id="generate-recovery-codes-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl transition-all flex items-center gap-2 text-sm shadow-md hover:shadow-indigo-500/20 active:scale-95">
                                    <span class="btn-spinner"></span>
                                    <span class="btn-text">Generate Backup Codes</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div id="recovery-codes-display" class="hidden bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-6">
                        <div class="grid grid-cols-2 gap-3 mb-6 font-mono text-center text-sm" id="codes-grid">
                            <!-- Codes will be injected here -->
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-rose-500 font-medium">Important: These codes are only shown once!</p>
                            <button type="button" id="hide-codes-btn" class="text-sm text-slate-500 hover:text-slate-700 font-medium">Hide</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- 2FA Verification Modal -->
            <div id="2fa-verify-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-3">
                <div id="2fa-modal-card" class="bg-white rounded-2xl shadow-2xl w-full max-w-xs transition-all duration-200">
                    
                    <!-- Single Column Mode -->
                    <div id="modal-single-col" class="p-6">
                        <div class="flex flex-col items-center text-center mb-4">
                            <div class="h-11 w-11 flex items-center justify-center bg-indigo-50 rounded-full mb-3">
                                <i data-lucide="shield-check" class="w-6 h-6 text-indigo-600"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-900">Verify it's you</h3>
                            <p id="2fa-modal-text" class="text-slate-500 text-xs mt-1">Enter the verification code to confirm changes.</p>
                        </div>

                        <div class="space-y-4">
                            @include('cms.partials.tfa-input', ['id' => 'otp-container-email'])
                            <div id="2fa-modal-error" class="hidden text-center text-xs text-rose-500 font-medium"></div>
                            
                            <button type="button" id="submit-2fa-email" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed text-sm shadow-md">
                                <span class="spinner hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                                <span class="label">Verify Code</span>
                            </button>
                            <button id="cancel-2fa-verify" class="w-full py-2 text-slate-400 text-xs font-medium hover:text-slate-600 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>

                    <!-- Two Column Mode (QR Code) -->
                    <div id="modal-qr-section" class="hidden">
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            <!-- Left: QR Code -->
                            <div class="p-5 flex flex-col items-center justify-center border-b sm:border-b-0 sm:border-r border-slate-100 bg-indigo-50 rounded-t-2xl sm:rounded-tr-none sm:rounded-l-2xl">
                                <p class="text-[10px] font-bold text-indigo-700 uppercase tracking-widest mb-3">Step 1 — Scan QR</p>
                                <div id="modal-qr-code" class="p-2 bg-white rounded-lg shadow-sm mb-3"></div>
                                <p class="text-[10px] text-slate-500 mb-1">Or enter key manually:</p>
                                <code id="modal-qr-secret" class="px-2 py-0.5 bg-white border rounded text-indigo-600 font-mono text-[10px] font-bold break-all text-center max-w-[160px]"></code>
                            </div>

                            <!-- Right: Form -->
                            <div class="p-5 flex flex-col justify-between">
                                <div class="text-center mb-4">
                                    <div class="mx-auto h-10 w-10 flex items-center justify-center bg-indigo-50 rounded-full mb-2">
                                        <i data-lucide="shield-check" class="w-5 h-5 text-indigo-600"></i>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">Verify it's you</h3>
                                    <p class="text-slate-500 text-[11px] mt-1">Step 2 — Enter the 6-digit code from your Authenticator app.</p>
                                </div>
                                <div class="space-y-4">
                                    @include('cms.partials.tfa-input', ['id' => 'otp-container-google'])
                                    
                                    <button type="button" id="submit-2fa-google" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed text-sm shadow-md">
                                        <span class="spinner hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                                        <span class="label">Verify Code</span>
                                    </button>
                                    <button id="cancel-2fa-verify-qr" class="w-full py-1.5 text-slate-400 text-xs font-medium hover:text-slate-600 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
// --- Tab Switching Logic ---
function switchProfileTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.profile-tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Reset all tab button styles
    document.querySelectorAll('.profile-tab-btn').forEach(btn => {
        btn.className = 'profile-tab-btn flex-1 inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold rounded-lg transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-50 border border-transparent';
    });

    // Show target content
    const targetContent = document.getElementById('tab-content-' + tabId);
    if (targetContent) {
        targetContent.classList.remove('hidden');
    }

    // Set target button active style
    const targetBtn = document.getElementById('tab-btn-' + tabId);
    if (targetBtn) {
        targetBtn.className = 'profile-tab-btn flex-1 inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold rounded-lg transition-all text-indigo-700 bg-indigo-50/80 border border-indigo-200/80 shadow-xs';
    }

    // Update URL hash without scroll
    history.replaceState(null, null, '#' + tabId);

    if (window.lucide) lucide.createIcons();
}

document.addEventListener('DOMContentLoaded', function() {
    // Determine initial tab from hash or errors
    let initialTab = 'info';
    const hash = window.location.hash.replace('#', '');
    
    @if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
        initialTab = 'password';
    @elseif($errors->has('name') || $errors->has('email'))
        initialTab = 'info';
    @elseif(session('tab'))
        initialTab = "{{ session('tab') }}";
    @else
        if (['info', 'password', '2fa'].includes(hash)) {
            initialTab = hash;
        }
    @endif

    switchProfileTab(initialTab);

    // --- 2FA Logic ---
    const twoFactorEnabledInput = document.getElementById('two_factor_enabled');
    const twoFactorTypeRadios   = document.querySelectorAll('input[name="two_factor_type"]');
    const qrCodeContainer       = document.getElementById('qr-code-container');
    const statusBanner          = document.getElementById('2fa-status-banner');
    const methodContainer       = document.getElementById('2fa-method-container');
    const toggleSpinner         = document.getElementById('toggle-spinner');
    const methodSpinner         = document.getElementById('method-spinner');

    // Modal Elements
    const verifyModal    = document.getElementById('2fa-verify-modal');
    const modalCard      = document.getElementById('2fa-modal-card');
    const modalSingleCol = document.getElementById('modal-single-col');
    const modalText      = document.getElementById('2fa-modal-text');
    const modalQrSecret  = document.getElementById('modal-qr-secret');
    const modalError     = document.getElementById('2fa-modal-error');
    const modalQrSection = document.getElementById('modal-qr-section');
    const modalQrCode    = document.getElementById('modal-qr-code');
    const cancelBtn      = document.getElementById('cancel-2fa-verify');
    const cancelBtnQr    = document.getElementById('cancel-2fa-verify-qr');

    let isQrMode = false;
    let otpFieldEmail = null;
    let otpFieldGoogle = null;
    const emailSubmitBtn = document.getElementById('submit-2fa-email');
    const googleSubmitBtn = document.getElementById('submit-2fa-google');

    function initFields() {
        if (window.initOtpField) {
            otpFieldEmail = window.initOtpField('otp-container-email', (val) => update2fa(val));
            otpFieldGoogle = window.initOtpField('otp-container-google', (val) => update2fa(val));
        }
        
        if (emailSubmitBtn) {
            emailSubmitBtn.addEventListener('click', () => {
                const val = otpFieldEmail ? otpFieldEmail.getValue() : '';
                if (val.length === 6) update2fa(val);
                else showModalError('Please enter a 6-digit code');
            });
        }
        
        if (googleSubmitBtn) {
            googleSubmitBtn.addEventListener('click', () => {
                const val = otpFieldGoogle ? otpFieldGoogle.getValue() : '';
                if (val.length === 6) update2fa(val);
                else showModalError('Please enter a 6-digit code');
            });
        }
    }
    
    setTimeout(initFields, 0);

    let pendingSettings   = null;
    let activeSpinner     = null;

    function showSpinner(spinner) {
        if (activeSpinner) activeSpinner.classList.add('hidden');
        activeSpinner = spinner;
        if (spinner) spinner.classList.remove('hidden');
        
        const currentBtn = isQrMode ? googleSubmitBtn : emailSubmitBtn;
        if (currentBtn && verifyModal.offsetParent !== null) {
            currentBtn.disabled = true;
            currentBtn.querySelector('.spinner').classList.remove('hidden');
            currentBtn.querySelector('.label').textContent = 'Verifying...';
        }
    }

    function hideSpinner() {
        if (activeSpinner) activeSpinner.classList.add('hidden');
        activeSpinner = null;
        
        [emailSubmitBtn, googleSubmitBtn].forEach(btn => {
            if (btn) {
                btn.disabled = false;
                btn.querySelector('.spinner').classList.add('hidden');
                btn.querySelector('.label').textContent = 'Verify Code';
            }
        });
    }

    function setControlsDisabled(disabled) {
        if (twoFactorEnabledInput) twoFactorEnabledInput.disabled = disabled;
        twoFactorTypeRadios.forEach(r => r.disabled = disabled);
    }

    async function update2fa(verificationCode = null, triggerSpinner = toggleSpinner) {
        const enabled = verificationCode ? pendingSettings.enabled : twoFactorEnabledInput.checked;
        const typeInput = document.querySelector('input[name="two_factor_type"]:checked');
        const type = verificationCode ? pendingSettings.type : (typeInput ? typeInput.value : 'email');
        const verifyVia = verificationCode ? (pendingSettings.verifyVia || null) : null;

        if (!verificationCode) {
            pendingSettings = { enabled, type, verifyVia: null };
            showSpinner(triggerSpinner);
            setControlsDisabled(true);
        }

        try {
            const body = {
                two_factor_enabled: enabled ? 1 : 0,
                two_factor_type: type
            };
            if (verificationCode !== null && verificationCode !== undefined && verificationCode !== '') {
                body.code = verificationCode;
            }
            if (verifyVia) body.verify_via = verifyVia;

            const response = await fetch("{{ route('cms.profile.2fa') }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(body)
            });

            const data = await response.json();

            if (!response.ok) {
                if (data.requires_verification) {
                    if (pendingSettings) pendingSettings.verifyVia = data.verify_via || null;
                    hideSpinner();
                    setControlsDisabled(false);
                    showVerificationModal(data.type, data.qrCodeInline || null, data.secret || null);
                    return;
                }
                hideSpinner();
                setControlsDisabled(false);
                if (!verificationCode) {
                    twoFactorEnabledInput.checked = !pendingSettings.enabled;
                }
                if (data.message) showModalError(data.message);
                return;
            }

            closeModal();
            updateUI(data);

        } catch (error) {
            console.error('2FA Update Error:', error);
            hideSpinner();
            setControlsDisabled(false);
            if (!verificationCode && pendingSettings) {
                twoFactorEnabledInput.checked = !pendingSettings.enabled;
            }
        }
    }

    function updateUI(data) {
        hideSpinner();
        setControlsDisabled(false);

        if (data.enabled) {
            statusBanner.innerHTML = `
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-r-xl">
                    <p class="font-bold">2FA is currently ENABLED</p>
                    <p class="text-sm">Your account is protected via ${data.type.charAt(0).toUpperCase() + data.type.slice(1)}.</p>
                </div>`;
            methodContainer.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            statusBanner.innerHTML = `
                <div class="mb-6 p-4 bg-slate-50 border-l-4 border-slate-400 text-slate-700 rounded-r-xl">
                    <p class="font-bold">2FA is currently DISABLED</p>
                    <p class="text-sm">Enable Two-Factor Authentication to add an extra layer of security.</p>
                </div>`;
            methodContainer.classList.add('opacity-50');
            methodContainer.classList.remove('pointer-events-none');
        }

        if (data.enabled && data.type === 'google' && data.qrCodeInline) {
            qrCodeContainer.innerHTML = `
                <div class="mb-6 p-6 border-2 border-dashed border-slate-200 rounded-xl text-center bg-slate-50">
                    <p class="text-sm font-medium text-slate-700 mb-4">Scan this QR code with your Authenticator app</p>
                    <div class="inline-block p-4 bg-white rounded-lg shadow-sm mb-4">${data.qrCodeInline}</div>
                    <p class="text-xs text-slate-500 mb-2">Or enter this key manually:</p>
                    <code class="px-3 py-1 bg-white border rounded text-indigo-600 font-mono font-bold">${data.secret}</code>
                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <p class="text-sm font-medium text-slate-700 mb-1">Authenticator is now linked</p>
                        <p class="text-xs text-slate-500">You will be asked for a code next time you login.</p>
                    </div>
                </div>`;
        } else if (data.enabled && data.type === 'email') {
            qrCodeContainer.innerHTML = `
                <div class="mb-6 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                    <p class="text-sm text-indigo-700">
                        <strong>Verification codes</strong> will be sent to your email address.
                    </p>
                </div>`;
        } else {
            qrCodeContainer.innerHTML = '';
        }

        twoFactorEnabledInput.checked = !!data.enabled;
        twoFactorTypeRadios.forEach(r => { r.checked = (r.value === data.type); });
        
        if (window.lucide) lucide.createIcons();
    }

    async function showVerificationModal(type, qrCodeInline = null, secret = null) {
        if (otpFieldEmail) otpFieldEmail.clear();
        if (otpFieldGoogle) otpFieldGoogle.clear();
        
        modalError.classList.add('hidden');
        modalQrCode.innerHTML    = '';
        modalQrSecret.textContent = '';

        if (type === 'google' && qrCodeInline) {
            isQrMode = true;
            modalQrCode.innerHTML    = qrCodeInline;
            modalQrSecret.textContent = secret || '';

            modalQrSection.classList.remove('hidden');
            modalSingleCol.classList.add('hidden');
            modalCard.classList.remove('max-w-xs');
            modalCard.classList.add('max-w-2xl');
        } else {
            isQrMode = false;
            modalQrSection.classList.add('hidden');
            modalSingleCol.classList.remove('hidden');
            modalCard.classList.remove('max-w-2xl');
            modalCard.classList.add('max-w-xs');

            if (type === 'google') {
                modalText.innerText = 'Enter the 6-digit code from your Authenticator app.';
            } else {
                modalText.innerText = 'Sending a verification code to your email…';
                await fetch("{{ route('cms.profile.2fa.send-code') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                modalText.innerText = 'Enter the verification code sent to your email.';
            }
        }

        verifyModal.classList.remove('hidden');
        verifyModal.classList.add('flex');
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        setTimeout(() => {
            if (isQrMode && otpFieldGoogle) otpFieldGoogle.focus();
            else if (!isQrMode && otpFieldEmail) otpFieldEmail.focus();
        }, 100);
    }

    function closeModal() {
        verifyModal.classList.add('hidden');
        verifyModal.classList.remove('flex');
        modalQrSection.classList.add('hidden');
        modalSingleCol.classList.remove('hidden');
        modalCard.classList.remove('max-w-2xl');
        modalCard.classList.add('max-w-xs');
        isQrMode = false;
        hideSpinner();
        setControlsDisabled(false);
    }

    function showModalError(msg) {
        modalError.innerText = msg;
        modalError.classList.remove('hidden');
        
        const activeContainer = isQrMode ? document.getElementById('otp-container-google') : document.getElementById('otp-container-email');
        if (activeContainer) {
            activeContainer.classList.add('animate-shake'); 
            setTimeout(() => activeContainer.classList.remove('animate-shake'), 500);
        }
    }

    if (cancelBtn) cancelBtn.addEventListener('click', () => { closeModal(); location.reload(); });
    if (cancelBtnQr) cancelBtnQr.addEventListener('click', () => { closeModal(); location.reload(); });

    if (twoFactorEnabledInput) {
        twoFactorEnabledInput.addEventListener('change', () => update2fa(null, toggleSpinner));
    }

    twoFactorTypeRadios.forEach(radio => radio.addEventListener('change', () => {
        if (twoFactorEnabledInput && twoFactorEnabledInput.checked) {
            update2fa(null, methodSpinner);
        }
    }));

    const toggleQrBtn = document.getElementById('toggle-qr-btn');
    const qrContent = document.getElementById('qr-content');
    if (toggleQrBtn && qrContent) {
        toggleQrBtn.addEventListener('click', function() {
            qrContent.classList.toggle('hidden');
            this.textContent = qrContent.classList.contains('hidden') ? 'Show QR Code' : 'Hide QR Code';
        });
    }

    const hideBtn = document.getElementById('hide-codes-btn');
    const codesDisplay = document.getElementById('recovery-codes-display');
    const codesGrid = document.getElementById('codes-grid');
    const recoveryCodesArea = document.getElementById('recovery-codes-area');
    
    if (recoveryCodesArea) {
        recoveryCodesArea.addEventListener('click', async function(e) {
            const btn = e.target.closest('button, a');
            if (!btn) return;

            if (btn.id === 'generate-recovery-codes-btn' || (btn.id === 'show-recovery-codes-btn' && confirm('Viewing/Regenerating backup codes will invalidate any existing codes. Continue?'))) {
                btn.classList.add('loading');
                btn.disabled = true;
                
                try {
                    const response = await fetch("{{ route('cms.profile.2fa.recovery-codes') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        renderCodes(data.codes);
                        if (btn.id === 'generate-recovery-codes-btn') {
                            recoveryCodesArea.innerHTML = `
                                <div class="flex flex-wrap gap-3 mb-6">
                                    <button type="button" id="show-recovery-codes-btn" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition-all flex items-center gap-2 text-sm">
                                        <span class="btn-spinner"></span>
                                        <span class="btn-text">Show Backup Codes</span>
                                    </button>
                                    <a href="{{ route('cms.profile.2fa.recovery-codes.download') }}" data-no-preloader="true" id="download-recovery-codes-link" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition-all inline-flex items-center gap-2 text-sm shadow-xs">
                                        <span class="btn-spinner"></span>
                                        <i data-lucide="download" class="w-4 h-4"></i>
                                        <span class="btn-text">Download Codes</span>
                                    </a>
                                    <button type="button" id="email-recovery-codes-btn" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition-all flex items-center gap-2 text-sm shadow-xs">
                                        <span class="btn-spinner"></span>
                                        <i data-lucide="mail" class="w-4 h-4"></i>
                                        <span class="btn-text">Send to Email</span>
                                    </button>
                                </div>
                            `;
                            lucide.createIcons();
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    btn.classList.remove('loading');
                    btn.disabled = false;
                }
            } else if (btn.id === 'email-recovery-codes-btn') {
                if (confirm('Sending codes to email will invalidate any existing codes and generate new ones. Continue?')) {
                    btn.classList.add('loading');
                    btn.disabled = true;
                    try {
                        const response = await fetch("{{ route('cms.profile.2fa.recovery-codes.email') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            renderCodes(data.codes);
                            alert(data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    } finally {
                        btn.classList.remove('loading');
                        btn.disabled = false;
                    }
                }
            } else if (btn.id === 'download-recovery-codes-link') {
                btn.classList.add('loading');
                setTimeout(() => {
                    btn.classList.remove('loading');
                }, 2000);
            }
        });
    }

    if (hideBtn && codesDisplay) {
        hideBtn.addEventListener('click', () => codesDisplay.classList.add('hidden'));
    }

    function renderCodes(codes) {
        if (!codesGrid || !codesDisplay) return;
        codesGrid.innerHTML = '';
        codes.forEach(code => {
            const div = document.createElement('div');
            div.className = 'bg-white p-3 border border-slate-100 rounded-xl text-slate-800 font-bold';
            div.textContent = code;
            codesGrid.appendChild(div);
        });
        codesDisplay.classList.remove('hidden');
    }
});
</script>
@endsection