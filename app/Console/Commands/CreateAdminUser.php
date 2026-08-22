<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--name= : The name of the admin user}
                            {--email= : The email of the admin user}
                            {--password= : The password for the admin user}
                            {--role=superadmin : The role (superadmin or admin)}
                            {--unverified : Do not mark email as verified}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update a verified admin/superadmin user for CMS access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name') ?: $this->ask('Enter Admin Name', 'Super Admin');
        $email = $this->option('email') ?: $this->ask('Enter Admin Email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email format provided.');
            return 1;
        }

        $password = $this->option('password');
        if (empty($password)) {
            $password = $this->secret('Enter Admin Password (min 8 characters)');
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return 1;
        }

        $role = $this->option('role') ?: 'superadmin';
        if (!in_array($role, ['superadmin', 'admin'])) {
            $this->error('Role must be either "superadmin" or "admin".');
            return 1;
        }

        $isVerified = !$this->option('unverified');

        $admin = AdminUser::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => $role,
                'email_verified_at' => $isVerified ? Carbon::now() : null,
                'is_active' => true,
                'two_factor_enabled' => false,
            ]
        );

        $this->info("--------------------------------------------------");
        $this->info("✅ Admin user saved successfully!");
        $this->table(
            ['Name', 'Email', 'Role', 'Status', 'Email Verified'],
            [[
                $admin->name,
                $admin->email,
                $admin->role,
                $admin->is_active ? 'Active' : 'Inactive',
                $admin->email_verified_at ? 'Yes (' . $admin->email_verified_at->toDateTimeString() . ')' : 'No'
            ]]
        );
        $this->info("Login URL: " . url('/cms/login'));
        $this->info("--------------------------------------------------");

        return 0;
    }
}
