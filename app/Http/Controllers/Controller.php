<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Check if the authenticated admin has the required permission.
     * Throws a PermissionDeniedException if unauthorized, which is 
     * caught by the global handler to show the modular modal.
     */
    public function checkPermission($permission)
    {
        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        if (!$admin || !$admin->hasPermission($permission)) {
            throw new \App\Exceptions\PermissionDeniedException('Unauthorized Access');
        }
    }
}
