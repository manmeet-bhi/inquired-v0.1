<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $admin = Auth::guard('admin')->user();
        
        if (!$admin) {
            return redirect()->route('cms.login');
        }

        if (!$admin->hasPermission($permission)) {
            throw new \App\Exceptions\PermissionDeniedException('You do not have permission to access this resource.');
        }

        return $next($request);
    }
}