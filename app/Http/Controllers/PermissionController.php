<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index()
    {
        $this->checkPermission('users.permissions');
        
        $adminUsers = AdminUser::with('permissions')->where('role', '!=', 'superadmin')->get();
        $permissions = Permission::all()->groupBy('category');
        
        return view('cms.permissions.index', compact('adminUsers', 'permissions'));
    }

    public function edit(AdminUser $adminUser)
    {
        $this->checkPermission('users.permissions');
        
        if ($adminUser->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Cannot edit super admin permissions');
        }
        
        $permissions = Permission::all()->groupBy('category');
        $userPermissions = $adminUser->permissions()->pluck('name')->toArray();
        
        return view('cms.permissions.edit', compact('adminUser', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, AdminUser $adminUser)
    {
        $this->checkPermission('users.permissions');
        
        if ($adminUser->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Cannot edit super admin permissions');
        }
        
        $permissions = $request->input('permissions', []);
        $adminUser->syncPermissions($permissions);
        
        return redirect()->route('cms.permissions.index')
            ->with('success', 'Permissions updated successfully');
    }
}