<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Job Management
            ['name' => 'jobs.view', 'display_name' => 'View Jobs', 'category' => 'Jobs'],
            ['name' => 'jobs.create', 'display_name' => 'Create Jobs', 'category' => 'Jobs'],
            ['name' => 'jobs.edit', 'display_name' => 'Edit Jobs', 'category' => 'Jobs'],
            ['name' => 'jobs.delete', 'display_name' => 'Delete Jobs', 'category' => 'Jobs'],
            
            // Blog Management
            ['name' => 'blog.view', 'display_name' => 'View Blog Posts', 'category' => 'Blog'],
            ['name' => 'blog.create', 'display_name' => 'Create Blog Posts', 'category' => 'Blog'],
            ['name' => 'blog.edit', 'display_name' => 'Edit Blog Posts', 'category' => 'Blog'],
            ['name' => 'blog.delete', 'display_name' => 'Delete Blog Posts', 'category' => 'Blog'],
            
            // SEO Management
            ['name' => 'seo.view', 'display_name' => 'View SEO Settings', 'category' => 'SEO'],
            ['name' => 'seo.manage', 'display_name' => 'Manage SEO Settings', 'category' => 'SEO'],
            
            // Category Management
            ['name' => 'categories.view', 'display_name' => 'View Categories', 'category' => 'Categories'],
            ['name' => 'categories.create', 'display_name' => 'Create Categories', 'category' => 'Categories'],
            ['name' => 'categories.edit', 'display_name' => 'Edit Categories', 'category' => 'Categories'],
            ['name' => 'categories.delete', 'display_name' => 'Delete Categories', 'category' => 'Categories'],
            
            // Company Management
            ['name' => 'companies.view', 'display_name' => 'View Companies', 'category' => 'Companies'],
            ['name' => 'companies.create', 'display_name' => 'Create Companies', 'category' => 'Companies'],
            ['name' => 'companies.edit', 'display_name' => 'Edit Companies', 'category' => 'Companies'],
            ['name' => 'companies.delete', 'display_name' => 'Delete Companies', 'category' => 'Companies'],
            
            // User Management
            ['name' => 'users.view', 'display_name' => 'View Admin Users', 'category' => 'Users'],
            ['name' => 'users.create', 'display_name' => 'Create Admin Users', 'category' => 'Users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Admin Users', 'category' => 'Users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Admin Users', 'category' => 'Users'],
            ['name' => 'users.permissions', 'display_name' => 'Manage User Permissions', 'category' => 'Users'],
            
            // Analytics & Reports
            ['name' => 'analytics.view', 'display_name' => 'View Analytics', 'category' => 'Analytics'],
            ['name' => 'reports.view', 'display_name' => 'View Reports', 'category' => 'Analytics'],

            // Testimonials Management
            ['name' => 'testimonials.view', 'display_name' => 'View Testimonials', 'category' => 'Testimonials'],
            ['name' => 'testimonials.manage', 'display_name' => 'Manage Testimonials', 'category' => 'Testimonials'],

            // Activity Logs
            ['name' => 'activity.view', 'display_name' => 'View Activity Logs', 'category' => 'Activity Logs'],
            ['name' => 'activity.export', 'display_name' => 'Export Activity CSV', 'category' => 'Activity Logs'],
            ['name' => 'activity.clear', 'display_name' => 'Clear Activity Logs', 'category' => 'Activity Logs'],

            // Settings & Security
            ['name' => 'settings.view', 'display_name' => 'View CMS Settings', 'category' => 'Settings'],
            ['name' => 'settings.manage', 'display_name' => 'Manage System Settings', 'category' => 'Settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}