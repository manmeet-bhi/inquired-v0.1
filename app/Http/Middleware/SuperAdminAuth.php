<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('cms.login');
        }

        $admin = Auth::guard('admin')->user();
        
        if (!$admin->isSuperAdmin()) {
            throw new \App\Exceptions\PermissionDeniedException('Super Admin access required.');
        }

        return $next($request);
    }
}