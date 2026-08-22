<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add the demo account
        DB::table('admin_users')->insert([
            'name' => 'Demo Superadmin',
            'email' => 'demo@example.com',
            'password' => Hash::make('demo123'),
            'role' => 'superadmin',
            'email_verified_at' => Carbon::now(),
            'is_active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('admin_users')->where('email', 'demo@example.com')->delete();
    }
};
