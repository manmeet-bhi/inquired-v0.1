<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsAdminActivity
{
    /**
     * Boot the trait to attach event listeners.
     */
    protected static function bootLogsAdminActivity()
    {
        static::created(function ($model) {
            self::logActivity('Created', $model);
        });

        static::updated(function ($model) {
            self::logActivity('Updated', $model);
        });

        static::deleted(function ($model) {
            self::logActivity('Deleted', $model);
        });
    }

    /**
     * Write the activity to the database.
     */
    protected static function logActivity($action, $model)
    {
        if (Auth::guard('admin')->check()) {
            $type = class_basename($model);
            
            // Specifically define Internship if it inherently rests on Job model
            if ($type === 'Job' && isset($model->type) && $model->type === 'internship') {
                $type = 'Internship';
            }

            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action'        => "{$action} {$type}",
                'target_name'   => $model->title ?? $model->name ?? 'Record #' . $model->id,
                'target_type'   => get_class($model),
                'target_id'     => $model->id,
                'ip_address'    => request()->ip()
            ]);
        }
    }
}
