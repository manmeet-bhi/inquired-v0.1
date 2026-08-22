<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('cms.login');
        }

        $admin = Auth::guard('admin')->user();
        
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('cms.login')->withErrors(['email' => 'Account is inactive.']);
        }

        if (!$admin->hasVerifiedEmail() && 
            !$request->routeIs('cms.verification.notice') && 
            !$request->routeIs('cms.verification.resend') &&
            !$request->routeIs('cms.verification.check') &&
            !$request->routeIs('cms.change_email') &&
            !$request->routeIs('cms.logout')) {
            return redirect()->route('cms.verification.notice');
        }

        return $next($request);
    }
}