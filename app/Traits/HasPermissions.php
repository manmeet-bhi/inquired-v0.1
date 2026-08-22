<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasPermissions
{
    protected function checkPermission($permission)
    {
        $admin = Auth::guard('admin')->user();
        
        if (!$admin || !$admin->hasPermission($permission)) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }

    protected function hasPermission($permission)
    {
        $admin = Auth::guard('admin')->user();
        return $admin && $admin->hasPermission($permission);
    }
}