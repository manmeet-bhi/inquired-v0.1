<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = env('INITIAL_ADMIN_EMAIL', 'admin@inaquired.com');
        $adminPassword = env('INITIAL_ADMIN_PASSWORD', 'Admin@123456');
        $adminName = env('INITIAL_ADMIN_NAME', 'Super Admin');

        // Create or update default verified superadmin
        AdminUser::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'role' => 'superadmin',
                'email_verified_at' => Carbon::now(),
                'is_active' => true,
                'two_factor_enabled' => false,
            ]
        );

        // Also ensure backward-compatible dev account if needed
        if ($adminEmail !== 'superadmin@example.com') {
            AdminUser::updateOrCreate(
                ['email' => 'superadmin@example.com'],
                [
                    'name' => 'Super Admin (Dev)',
                    'password' => Hash::make('password'),
                    'role' => 'superadmin',
                    'email_verified_at' => Carbon::now(),
                    'is_active' => true,
                    'two_factor_enabled' => false,
                ]
            );
        }
    }
}
