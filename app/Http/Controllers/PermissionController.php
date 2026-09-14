<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    private function ensurePermissionsExist()
    {
        if (Permission::count() === 0) {
            (new \Database\Seeders\PermissionSeeder())->run();
        }
    }

    public function index()
    {
        $this->checkPermission('users.permissions');
        $this->ensurePermissionsExist();
        
        $adminUsers = AdminUser::with('permissions')->get();
        $permissions = Permission::all()->groupBy('category');
        
        return view('cms.permissions.index', compact('adminUsers', 'permissions'));
    }

    public function edit(AdminUser $adminUser)
    {
        $this->checkPermission('users.permissions');
        $this->ensurePermissionsExist();
        
        $permissions = Permission::all()->groupBy('category');
        $userPermissions = $adminUser->permissions()->pluck('name')->toArray();
        
        return view('cms.permissions.edit', compact('adminUser', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, AdminUser $adminUser)
    {
        $this->checkPermission('users.permissions');
        $this->ensurePermissionsExist();
        
        if ($adminUser->isSuperAdmin()) {
            return redirect()->route('cms.permissions.index')
                ->with('info', 'Super Admins have full access to all system permissions by default.');
        }
        
        $permissions = $request->input('permissions', []);
        $adminUser->syncPermissions($permissions);
        
        return redirect()->route('cms.permissions.index')
            ->with('success', 'Permissions updated successfully for ' . $adminUser->name);
    }
}