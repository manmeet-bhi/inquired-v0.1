<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id',
        'action',
        'target_name',
        'target_type',
        'target_id',
        'ip_address'
    ];

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }
}
