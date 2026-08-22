@extends('layouts.cms')

@section('title', 'Profile - CMS')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">Profile Settings</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Information -->
        <div class="bg-white shadow-md rounded-2xl px-4 sm:px-8 pt-6 pb-8 mb-6 border border-slate-200/60">
            <h2 class="text-lg font-semibold mb-4">Profile Information</h2>
            <form action="{{ route('cms.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Full Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" 
                           id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email Address
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" 
                           id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                            type="submit">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white shadow-md rounded-2xl px-4 sm:px-8 pt-6 pb-8 mb-6 border border-slate-200/60">
            <h2 class="text-lg font-semibold mb-4">Change Password</h2>
            <form action="{{ route('cms.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">
                        Current Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-red-500 @enderror" 
                           id="current_password" name="current_password" type="password" required>
                    @error('current_password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        New Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" 
                           id="password" name="password" type="password" required>
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                        Confirm New Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="password_confirmation" name="password_confirmation" type="password" required>
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                            type="submit">
                        Change Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Two-Factor Authentication -->
        <div class="bg-white shadow-md rounded-2xl px-4 sm:px-8 pt-6 pb-8 border border-slate-200/60" id="2fa-settings-section">
            <h2 class="text-lg font-semibold mb-4">Two-Factor Authentication</h2>
            
            <div id="2fa-status-banner">
                @if(auth()->user()->two_factor_enabled)
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700">
                        <p class="font-bold">2FA is currently ENABLED</p>
                        <p class="text-sm">Your account is protected with Two-Factor Authentication via {{ ucfirst(auth()->user()->two_factor_type) }}.</p>
                    </div>
                @else
                    <div class="mb-6 p-4 bg-gray-50 border-l-4 border-gray-400 text-gray-700">
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
                    .toggle-input:checked + .toggle-slider { background-color: #2563eb; }
                    .toggle-input:checked + .toggle-slider:before { transform: translateX(1.75rem); }
                    .toggle-input:focus + .toggle-slider { box-shadow: 0 0 1px #2563eb; }
                    .tfa-spinner { display: inline-block; width: 1rem; height: 1rem; border: 2px solid #93c5fd; border-top-color: #2563eb; border-radius: 50%; animation: tfa-spin 0.7s linear infinite; vertical-align: middle; margin-left: 0.5rem; }
                    .tfa-spinner.hidden { display: none; }
                    @keyframes tfa-spin { to { transform: rotate(360deg); } }
                    /* Circle Spinner */
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
                    <span class="block text-gray-700 text-sm font-bold mb-2">Preferred Method</span>
                    <div class="flex space-x-6 items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="two_factor_type" value="email" class="form-radio h-4 w-4 text-blue-600"
                                   {{ auth()->user()->two_factor_type === 'email' ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Email Code</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="two_factor_type" value="google" class="form-radio h-4 w-4 text-blue-600"
                                   {{ auth()->user()->two_factor_type === 'google' ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Authenticator</span>
                        </label>
                        <span id="method-spinner" class="tfa-spinner hidden"></span>
                    </div>
                </div>

                <div id="qr-code-container">
                    @if(auth()->user()->two_factor_enabled && auth()->user()->two_factor_type === 'google')
                        <div class="mb-6 p-6 border border-slate-200 rounded-2xl text-center bg-slate-50/50">
                            <div class="flex items-center justify-center gap-2 mb-4 text-green-600">
                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                <span class="font-bold">Authenticator is linked</span>
                            </div>
                            
                            <div id="qr-content" class="hidden">
                                <p class="text-sm font-medium text-gray-700 mb-4">Scan this QR code with your Authenticator app</p>
                                <div class="inline-block p-4 bg-white rounded-lg shadow-sm mb-4">
                                    {!! $qrCodeInline !!}
                                </div>
                                <p class="text-xs text-gray-500 mb-2">Or enter this key manually:</p>
                                <code class="px-3 py-1 bg-white border rounded text-blue-600 font-mono font-bold">{{ $secret }}</code>
                            </div>

                            <button type="button" id="toggle-qr-btn" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Show QR Code
                            </button>
                        </div>
                    @elseif(auth()->user()->two_factor_enabled && auth()->user()->two_factor_type === 'email')
                        <div class="mb-6 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                            <p class="text-sm text-blue-700">
                                <i data-lucide="mail" class="w-4 h-4 inline-block mr-1"></i>
                                <strong>Verification codes</strong> will be sent to your linked email: 
                                <span class="font-bold">{{ auth()->user()->email }}</span>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Backup Codes Section -->
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i data-lucide="key" class="w-5 h-5 text-slate-500"></i>
                        Backup Recovery Codes
                    </h3>
                    <p class="text-sm text-slate-500 mb-6">
                        Recovery codes can be used to access your account if you lose your two-factor authentication device. 
                        Keep these in a safe, offline place.
                    </p>

                    <div id="recovery-codes-area">
                        @if(auth()->user()->two_factor_recovery_codes)
                            <div class="flex flex-wrap gap-4 mb-6">
                                <button type="button" id="show-recovery-codes-btn" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 px-4 rounded-xl transition-all flex items-center gap-2">
                                    <span class="btn-spinner"></span>
                                    <span class="btn-text">Show Backup Codes</span>
                                </button>
                                <a href="{{ route('cms.profile.2fa.recovery-codes.download') }}" data-no-preloader="true" id="download-recovery-codes-link" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2 px-4 rounded-xl transition-all inline-flex items-center gap-2">
                                    <span class="btn-spinner"></span>
                                    <i data-lucide="download" class="w-4 h-4"></i>
                                    <span class="btn-text">Download Codes</span>
                                </a>
                                <button type="button" id="email-recovery-codes-btn" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2 px-4 rounded-xl transition-all flex items-center gap-2">
                                    <span class="btn-spinner"></span>
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                    <span class="btn-text">Send to Email</span>
                                </button>
                            </div>
                        @else
                            <div class="mb-6">
                                <button type="button" id="generate-recovery-codes-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl transition-all flex items-center gap-2">
                                    <span class="btn-spinner"></span>
                                    <span class="btn-text">Generate Backup Codes</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div id="recovery-codes-display" class="hidden bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-6">
                        <div class="grid grid-cols-2 gap-4 mb-6 font-mono text-center" id="codes-grid">
                            <!-- Codes will be injected here -->
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-rose-500 font-medium">Important: These codes are only shown once!</p>
                            <button type="button" id="hide-codes-btn" class="text-sm text-slate-500 hover:text-slate-700">Hide</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- 2FA Verification Modal -->
            <div id="2fa-verify-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-3">

                <!-- WIDE card: 2-col layout when QR is visible (max-w-2xl), narrow single-col otherwise (max-w-xs) -->
                <div id="2fa-modal-card" class="bg-white rounded-2xl shadow-2xl w-full max-w-xs transition-all duration-200">

                    <!-- ===== SINGLE-COLUMN (email / no QR) – always visible ===== -->
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
                            
                            <button type="button" id="submit-2fa-email" class="w-full bg-[#1877f2] hover:bg-[#166fe5] text-white font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed">
                                <span class="spinner hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                                <span class="label">Verify Code</span>
                            </button>
                            <button id="cancel-2fa-verify" class="w-full py-2 text-slate-400 text-xs font-medium hover:text-slate-600 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>

                    <!-- ===== TWO-COLUMN section (Google QR) – toggled by JS ===== -->
                    <div id="modal-qr-section" class="hidden">
                        <!-- Two-col grid inside the wide card -->
                        <div class="grid grid-cols-1 sm:grid-cols-2">

                            <!-- LEFT: QR code -->
                            <div class="p-5 flex flex-col items-center justify-center border-b sm:border-b-0 sm:border-r border-slate-100 bg-indigo-50 rounded-t-2xl sm:rounded-tr-none sm:rounded-l-2xl">
                                <p class="text-[10px] font-bold text-indigo-700 uppercase tracking-widest mb-3">Step 1 — Scan QR</p>
                                <div id="modal-qr-code" class="p-2 bg-white rounded-lg shadow-sm mb-3"></div>
                                <p class="text-[10px] text-slate-500 mb-1">Or enter key manually:</p>
                                <code id="modal-qr-secret" class="px-2 py-0.5 bg-white border rounded text-indigo-600 font-mono text-[10px] font-bold break-all text-center max-w-[160px]"></code>
                            </div>

                            <!-- RIGHT: header + input + cancel -->
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
                                    
                                    <button type="button" id="submit-2fa-google" class="w-full bg-[#1877f2] hover:bg-[#166fe5] text-white font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed">
                                        <span class="spinner hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                                        <span class="label">Verify Code</span>
                                    </button>
                                </div>
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
document.addEventListener('DOMContentLoaded', function() {
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

    let isQrMode = false;  // tracks whether two-col QR layout is active
    let otpFieldEmail = null;
    let otpFieldGoogle = null;
    const emailSubmitBtn = document.getElementById('submit-2fa-email');
    const googleSubmitBtn = document.getElementById('submit-2fa-google');

    // Initialize OTP fields
    function initFields() {
        otpFieldEmail = window.initOtpField('otp-container-email', (val) => update2fa(val));
        otpFieldGoogle = window.initOtpField('otp-container-google', (val) => update2fa(val));
        
        // Manual button listeners
        emailSubmitBtn.addEventListener('click', () => {
            const val = otpFieldEmail.getValue();
            if (val.length === 6) update2fa(val);
            else showModalError('Please enter a 6-digit code');
        });
        
        googleSubmitBtn.addEventListener('click', () => {
            const val = otpFieldGoogle.getValue();
            if (val.length === 6) update2fa(val);
            else showModalError('Please enter a 6-digit code');
        });
    }
    
    // Call init after DOM and Partial scripts are ready
    setTimeout(initFields, 0);

    let pendingSettings   = null;   // { enabled, type, verifyVia }
    let activeSpinner     = null;

    function showSpinner(spinner) {
        if (activeSpinner) activeSpinner.classList.add('hidden');
        activeSpinner = spinner;
        if (spinner) spinner.classList.remove('hidden');
        
        // Handle button spinners
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
        
        // Reset buttons
        [emailSubmitBtn, googleSubmitBtn].forEach(btn => {
            if (btn) {
                btn.disabled = false;
                btn.querySelector('.spinner').classList.add('hidden');
                btn.querySelector('.label').textContent = 'Verify Code';
            }
        });
    }

    function setControlsDisabled(disabled) {
        twoFactorEnabledInput.disabled = disabled;
        twoFactorTypeRadios.forEach(r => r.disabled = disabled);
    }

    async function update2fa(verificationCode = null, triggerSpinner = toggleSpinner) {
        const enabled = verificationCode ? pendingSettings.enabled : twoFactorEnabledInput.checked;
        const typeInput = document.querySelector('input[name="two_factor_type"]:checked');
        const type = verificationCode ? pendingSettings.type : (typeInput ? typeInput.value : 'email');
        // verifyVia is determined server-side; use stored value on second call (with code)
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
            // Only include 'code' when actually submitting a verification code.
            // NEVER send code:null — PHP's $request->has('code') is true even for null,
            // which would cause the controller to enter the verification branch prematurely.
            if (verificationCode !== null && verificationCode !== undefined && verificationCode !== '') {
                body.code = verificationCode;
            }
            // Pass verify_via back so backend chooses correct verification path
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
                    // Show the verification modal and stop here — do NOT throw,
                    // as that would trigger the catch block which reverts the toggle.
                    // Save verify_via so second request uses the correct validation path.
                    if (pendingSettings) pendingSettings.verifyVia = data.verify_via || null;
                    hideSpinner();
                    setControlsDisabled(false);
                    showVerificationModal(data.type, data.qrCodeInline || null, data.secret || null);
                    return;
                }
                // For genuine errors (not verification prompts), revert toggle & show error
                hideSpinner();
                setControlsDisabled(false);
                if (!verificationCode) {
                    twoFactorEnabledInput.checked = !pendingSettings.enabled;
                }
                if (data.message) showModalError(data.message);
                return;
            }

            // Success
            closeModal();
            updateUI(data);

        } catch (error) {
            // Network-level error (fetch failed entirely)
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

        // Update status banner
        if (data.enabled) {
            statusBanner.innerHTML = `
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700">
                    <p class="font-bold">2FA is currently ENABLED</p>
                    <p class="text-sm">Your account is protected via ${data.type.charAt(0).toUpperCase() + data.type.slice(1)}.</p>
                </div>`;
            methodContainer.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            statusBanner.innerHTML = `
                <div class="mb-6 p-4 bg-gray-50 border-l-4 border-gray-400 text-gray-700">
                    <p class="font-bold">2FA is currently DISABLED</p>
                    <p class="text-sm">Enable Two-Factor Authentication to add an extra layer of security.</p>
                </div>`;
            // Only dim visually — never block pointer events (user can pre-select method)
            methodContainer.classList.add('opacity-50');
            methodContainer.classList.remove('pointer-events-none');
        }

        // Update QR code / info area
        if (data.enabled && data.type === 'google' && data.qrCodeInline) {
            qrCodeContainer.innerHTML = `
                <div class="mb-6 p-6 border-2 border-dashed border-gray-200 rounded-lg text-center bg-gray-50">
                    <p class="text-sm font-medium text-gray-700 mb-4">Scan this QR code with your Authenticator app</p>
                    <div class="inline-block p-4 bg-white rounded-lg shadow-sm mb-4">${data.qrCodeInline}</div>
                    <p class="text-xs text-gray-500 mb-2">Or enter this key manually:</p>
                    <code class="px-3 py-1 bg-white border rounded text-blue-600 font-mono font-bold">${data.secret}</code>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-1">Authenticator is now linked</p>
                        <p class="text-xs text-gray-500">You will be asked for a code next time you login.</p>
                    </div>
                </div>`;
        } else if (data.enabled && data.type === 'email') {
            qrCodeContainer.innerHTML = `
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-blue-700">
                        <strong>Verification codes</strong> will be sent to your email address.
                    </p>
                </div>`;
        } else {
            qrCodeContainer.innerHTML = '';
        }

        twoFactorEnabledInput.checked = !!data.enabled;
        twoFactorTypeRadios.forEach(r => { r.checked = (r.value === data.type); });
    }

    async function showVerificationModal(type, qrCodeInline = null, secret = null) {
        // Reset both inputs and error state
        if (otpFieldEmail) otpFieldEmail.clear();
        if (otpFieldGoogle) otpFieldGoogle.clear();
        
        modalError.classList.add('hidden');
        modalQrCode.innerHTML    = '';
        modalQrSecret.textContent = '';

        if (type === 'google' && qrCodeInline) {
            // ── TWO-COLUMN MODE ────────────────────────────────────
            isQrMode = true;
            modalQrCode.innerHTML    = qrCodeInline;
            modalQrSecret.textContent = secret || '';

            // Show QR section, hide single-col panel, widen card
            modalQrSection.classList.remove('hidden');
            modalSingleCol.classList.add('hidden');
            modalCard.classList.remove('max-w-xs');
            modalCard.classList.add('max-w-2xl');
        } else {
            // ── SINGLE-COLUMN MODE ────────────────────────────────
            isQrMode = false;
            modalQrSection.classList.add('hidden');
            modalSingleCol.classList.remove('hidden');
            modalCard.classList.remove('max-w-2xl');
            modalCard.classList.add('max-w-xs');

            if (type === 'google') {
                // Google but no QR (already set up)
                modalText.innerText = 'Enter the 6-digit code from your Authenticator app.';
            } else {
                // Email OTP
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
        
        // Re-render Lucide icons in the modal
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Focus the correct input
        setTimeout(() => {
            if (isQrMode && otpFieldGoogle) otpFieldGoogle.focus();
            else if (!isQrMode && otpFieldEmail) otpFieldEmail.focus();
        }, 100);
    }

    function closeModal() {
        verifyModal.classList.add('hidden');
        verifyModal.classList.remove('flex');
        // Reset to single-col / narrow card for next open
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

    // Cancel buttons (both single-col and QR-col)
    [cancelBtn, cancelBtnQr].forEach(btn => btn.addEventListener('click', () => {
        closeModal();
        location.reload(); // Revert to actual server state
    }));

    twoFactorEnabledInput.addEventListener('change', () => update2fa(null, toggleSpinner));

    twoFactorTypeRadios.forEach(radio => radio.addEventListener('change', () => {
        if (twoFactorEnabledInput.checked) {
            update2fa(null, methodSpinner);
        }
    }));

    // QR Toggle
    const toggleQrBtn = document.getElementById('toggle-qr-btn');
    const qrContent = document.getElementById('qr-content');
    if (toggleQrBtn) {
        toggleQrBtn.addEventListener('click', function() {
            qrContent.classList.toggle('hidden');
            this.textContent = qrContent.classList.contains('hidden') ? 'Show QR Code' : 'Hide QR Code';
        });
    }

    // Recovery Codes
    const generateBtn = document.getElementById('generate-recovery-codes-btn');
    const showBtn = document.getElementById('show-recovery-codes-btn');
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
                        
                        // Update UI area to show "Show/Download" instead of "Generate" if needed
                        if (btn.id === 'generate-recovery-codes-btn') {
                            recoveryCodesArea.innerHTML = `
                                <div class="flex flex-wrap gap-4 mb-6">
                                    <button type="button" id="show-recovery-codes-btn" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 px-4 rounded-xl transition-all flex items-center gap-2">
                                        <span class="btn-spinner"></span>
                                        <span class="btn-text">Show Backup Codes</span>
                                    </button>
                                    <a href="{{ route('cms.profile.2fa.recovery-codes.download') }}" data-no-preloader="true" id="download-recovery-codes-link" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2 px-4 rounded-xl transition-all inline-flex items-center gap-2">
                                        <span class="btn-spinner"></span>
                                        <i data-lucide="download" class="w-4 h-4"></i>
                                        <span class="btn-text">Download Codes</span>
                                    </a>
                                    <button type="button" id="email-recovery-codes-btn" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-2 px-4 rounded-xl transition-all flex items-center gap-2">
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

    if (hideBtn) {
        hideBtn.addEventListener('click', () => codesDisplay.classList.add('hidden'));
    }

    function renderCodes(codes) {
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