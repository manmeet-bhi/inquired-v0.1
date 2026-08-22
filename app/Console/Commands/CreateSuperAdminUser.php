<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CreateSuperAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superadmin 
                            {--name= : The name of the superadmin}
                            {--email= : The email of the superadmin}
                            {--password= : The password for the superadmin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update a verified Super Admin user with full privileges';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name') ?: $this->ask('Enter Super Admin Name', 'Super Admin');
        $email = $this->option('email') ?: $this->ask('Enter Super Admin Email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email format provided.');
            return 1;
        }

        $password = $this->option('password');
        if (empty($password)) {
            $password = $this->secret('Enter Super Admin Password (min 8 characters)');
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return 1;
        }

        $admin = AdminUser::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'superadmin',
                'email_verified_at' => Carbon::now(),
                'is_active' => true,
                'two_factor_enabled' => false,
            ]
        );

        $this->info("--------------------------------------------------");
        $this->info("👑 Super Admin created and verified successfully!");
        $this->table(
            ['Name', 'Email', 'Role', 'Status', 'Email Verified'],
            [[
                $admin->name,
                $admin->email,
                $admin->role,
                $admin->is_active ? 'Active' : 'Inactive',
                'Yes (' . $admin->email_verified_at->toDateTimeString() . ')'
            ]]
        );
        $this->info("Login URL: " . url('/cms/login'));
        $this->info("--------------------------------------------------");

        return 0;
    }
}
