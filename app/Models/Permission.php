<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'category',
        'description'
    ];

    public function adminUsers()
    {
        return $this->belongsToMany(AdminUser::class, 'admin_user_permissions');
    }
}