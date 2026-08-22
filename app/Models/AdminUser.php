<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class AdminUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin_users';


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'email_verified_at',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'two_factor_enabled',
        'two_factor_type',
        'two_factor_secret',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_recovery_codes'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'permissions' => 'array',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'locked_until' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'two_factor_expires_at' => 'datetime',
        'two_factor_recovery_codes' => 'array'
    ];

    // Security methods
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function incrementFailedAttempts(): void
    {
        $this->increment('failed_login_attempts');
        
        if ($this->failed_login_attempts >= 5) {
            $this->update(['locked_until' => Carbon::now()->addMinutes(30)]);
        }
    }

    public function resetFailedAttempts(): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    public function updateLastLogin(string $ip): void
    {
        $this->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $ip,
        ]);
    }

    // Role methods
    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    // Permission methods
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admin_user_permissions');
    }

    // Load active permissions once per request for massive performance gains
    protected $cachedPermissions = null;

    public function getActivePermissions()
    {
        if ($this->cachedPermissions === null) {
            $this->cachedPermissions = $this->permissions()->get();
        }
        return $this->cachedPermissions;
    }

    public function hasPermission($permission)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        
        return $this->getActivePermissions()->contains('name', $permission);
    }

    public function hasAnyPermission($permissions)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        
        return $this->getActivePermissions()->whereIn('name', $permissions)->isNotEmpty();
    }

    public function givePermission($permission)
    {
        $permissionModel = Permission::where('name', $permission)->first();
        if ($permissionModel && !$this->hasPermission($permission)) {
            $this->permissions()->attach($permissionModel->id);
        }
    }

    public function revokePermission($permission)
    {
        $permissionModel = Permission::where('name', $permission)->first();
        if ($permissionModel) {
            $this->permissions()->detach($permissionModel->id);
        }
    }

    public function syncPermissions($permissions)
    {
        $permissionIds = Permission::whereIn('name', $permissions)->pluck('id');
        $this->permissions()->sync($permissionIds);
    }

    // Relationships
    public function posts()
    {
        return $this->hasMany(Post::class, 'admin_user_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'admin_created_by');
    }
}