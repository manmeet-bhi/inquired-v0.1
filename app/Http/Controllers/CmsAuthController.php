<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class CmsAuthController extends Controller
{
    public function showLogin()
    {
        \Log::debug('CMS Login page visited');
        return view('cms.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        \Log::debug('CMS Login attempt', ['email' => $request->email, 'remember' => $remember]);

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $admin = Auth::guard('admin')->user();

            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Account is inactive.']);
            }

            // Update last login info
            $admin->updateLastLogin($request->ip());
            $admin->resetFailedAttempts();

            $request->session()->regenerate();

            // Check if 2FA is enabled
            if ($admin->two_factor_enabled) {
                // Log out but store intended admin ID in session
                $adminId = $admin->id;
                Auth::guard('admin')->logout();
                $request->session()->put('2fa_admin_id', $adminId);
                $request->session()->put('2fa_type', $admin->two_factor_type);
                // Persist the remember preference through the 2FA step
                $request->session()->put('2fa_remember', $remember);

                if ($admin->two_factor_type === 'email') {
                    // Generate and send code
                    $code = rand(100000, 999999);
                    $admin->update([
                        'two_factor_code'       => $code,
                        'two_factor_expires_at' => now()->addMinutes(10)
                    ]);
                    \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\TwoFactorCodeMail($admin, $code));
                }

                return redirect()->route('cms.verify.show');
            }

            return redirect()->route('cms.dashboard');
        }

        // Handle failed login attempt
        $admin = AdminUser::where('email', $request->email)->first();
        if ($admin) {
            $admin->incrementFailedAttempts();
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('cms.login');
    }

    public function showForgotPassword()
    {
        return view('cms.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if admin user exists
        $admin = AdminUser::where('email', $request->email)->first();
        if (!$admin) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Generate token and store in database
        $token = Str::random(64);
        
        \DB::table('admin_password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Send custom CMS reset email
        try {
            \Mail::send('emails.cms-password-reset', ['token' => $token, 'email' => $request->email], function($message) use($request) {
                $message->to($request->email);
                $message->subject('Reset Your CMS Password - Inaquired');
            });

            return back()->with('status', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            \Log::error('Failed to send CMS password reset email: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send password reset email: ' . $e->getMessage()]);
        }
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('cms.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Verify token
        $resetRecord = \DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Check if token is expired (60 minutes)
        if (\Carbon\Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Reset token has expired.']);
        }

        // Update admin password
        $admin = AdminUser::where('email', $request->email)->first();
        if (!$admin) {
            return back()->withErrors(['email' => 'Admin user not found.']);
        }

        $admin->update(['password' => Hash::make($request->password)]);

        // Delete used token
        \DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('cms.login')->with('status', 'Password reset successfully! Please login.');
    }

    public function verifyEmail(Request $request, $id)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired verification link.');
        }

        $user = AdminUser::findOrFail($id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->route('cms.login')->with('success', 'Email verified successfully! You can now login.');
    }

    public function showVerifyNotice()
    {
        $user = Auth::guard('admin')->user();
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('cms.dashboard');
        }
        return view('cms.auth.verify-email', compact('user'));
    }

    public function checkVerification()
    {
        return response()->json([
            'verified' => Auth::guard('admin')->user()->hasVerifiedEmail()
        ]);
    }

    public function resendVerification(Request $request)
    {
        $user = Auth::guard('admin')->user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('cms.dashboard');
        }

        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'cms.users.verify_email',
            now()->addDays(7),
            ['id' => $user->id]
        );

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AdminUserVerificationMail($user, $verificationUrl));

        return back()->with('success', 'Verification email has been resent.');
    }

    public function show2fa()
    {
        if (!session()->has('2fa_admin_id')) {
            return redirect()->route('cms.login');
        }
        return view('cms.auth.2fa');
    }

    public function verify2fa(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        
        if (!session()->has('2fa_admin_id')) {
            return redirect()->route('cms.login');
        }

        $adminId = session('2fa_admin_id');
        $throttleKey = '2fa_verify_' . $adminId;

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            $msg = 'Too many failed attempts. Please try again in ' . $seconds . ' seconds.';
            if ($request->ajax()) {
                return response()->json(['message' => $msg], 429);
            }
            return back()->withErrors(['code' => $msg]);
        }

        $admin = AdminUser::find($adminId);
        if (!$admin) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Session expired.'], 401);
            }
            return redirect()->route('cms.login');
        }

        $isValid = false;
        if ($admin->two_factor_type === 'google') {
            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            try {
                $isValid = $google2fa->verifyKey($admin->two_factor_secret, $request->code);
            } catch (\Exception $e) {
                $isValid = false;
            }
        } else {
            // Cast both sides to string to avoid NULL strict comparison failure
            $isValid = $admin->two_factor_code !== null
                    && (string)$admin->two_factor_code === (string)$request->code
                    && $admin->two_factor_expires_at
                    && $admin->two_factor_expires_at->isFuture();
        }

        // Check recovery codes if not yet valid
        if (!$isValid && $admin->two_factor_recovery_codes) {
            $recoveryCodes = $admin->two_factor_recovery_codes;
            foreach ($recoveryCodes as $index => $hashedCode) {
                if (Hash::check($request->code, $hashedCode)) {
                    $isValid = true;
                    // Remove the used recovery code
                    unset($recoveryCodes[$index]);
                    $admin->update([
                        'two_factor_recovery_codes' => array_values($recoveryCodes)
                    ]);
                    break;
                }
            }
        }

        if ($isValid) {
            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            
            // Retrieve the remember preference stored during login
            $remember = (bool) session('2fa_remember', false);
            
            \Log::debug('CMS 2FA Verification Success', ['admin_id' => $adminId, 'remember' => $remember]);

            // Log the user in, passing the remember flag so a persistent cookie is set
            Auth::guard('admin')->login($admin, $remember);
            
            // Clear 2FA data
            if ($admin->two_factor_type === 'email') {
                $admin->update([
                    'two_factor_code'       => null,
                    'two_factor_expires_at' => null
                ]);
            }
            
            session()->forget(['2fa_admin_id', '2fa_type', '2fa_remember']);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'redirect' => route('cms.dashboard')]);
            }
            return redirect()->route('cms.dashboard');
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);

        if ($request->ajax()) {
            return response()->json(['errors' => ['code' => ['Invalid or expired verification code.']]], 422);
        }
        return back()->withErrors(['code' => 'Invalid or expired verification code.']);
    }

    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admin_users,email,' . Auth::guard('admin')->id(),
        ]);

        $user = Auth::guard('admin')->user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('cms.dashboard');
        }

        $user->email = $request->email;
        $user->save();

        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'cms.users.verify_email',
            now()->addDays(7),
            ['id' => $user->id]
        );

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AdminUserVerificationMail($user, $verificationUrl));

        return back()->with('success', 'Email updated and verification link sent.');
    }

    public function resend2fa(Request $request)
    {
        if (!session()->has('2fa_admin_id')) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Session expired.'], 401);
            }
            return redirect()->route('cms.login');
        }

        $admin = AdminUser::find(session('2fa_admin_id'));
        if (!$admin) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Admin not found.'], 404);
            }
            return redirect()->route('cms.login');
        }

        if ($admin->two_factor_type === 'email') {
            $code = rand(100000, 999999);
            $admin->update([
                'two_factor_code'       => $code,
                'two_factor_expires_at' => now()->addMinutes(10)
            ]);
            \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\TwoFactorCodeMail($admin, $code));
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'New verification code has been sent.']);
        }

        return back()->with('success', 'New verification code has been sent.');
    }
}