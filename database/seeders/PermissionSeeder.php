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
            ['name' => 'jobs.create', 'display_name' => 'Create Jobs', 'category' => 'Jobs'],
            ['name' => 'jobs.edit', 'display_name' => 'Edit Jobs', 'category' => 'Jobs'],
            ['name' => 'jobs.delete', 'display_name' => 'Delete Jobs', 'category' => 'Jobs'],
            ['name' => 'jobs.view', 'display_name' => 'View Jobs', 'category' => 'Jobs'],
            
            // Blog Management
            ['name' => 'blog.create', 'display_name' => 'Create Blog Posts', 'category' => 'Blog'],
            ['name' => 'blog.edit', 'display_name' => 'Edit Blog Posts', 'category' => 'Blog'],
            ['name' => 'blog.delete', 'display_name' => 'Delete Blog Posts', 'category' => 'Blog'],
            ['name' => 'blog.view', 'display_name' => 'View Blog Posts', 'category' => 'Blog'],
            
            // SEO Management
            ['name' => 'seo.manage', 'display_name' => 'Manage SEO Settings', 'category' => 'SEO'],
            ['name' => 'seo.view', 'display_name' => 'View SEO Settings', 'category' => 'SEO'],
            
            // Category Management
            ['name' => 'categories.create', 'display_name' => 'Create Categories', 'category' => 'Categories'],
            ['name' => 'categories.edit', 'display_name' => 'Edit Categories', 'category' => 'Categories'],
            ['name' => 'categories.delete', 'display_name' => 'Delete Categories', 'category' => 'Categories'],
            ['name' => 'categories.view', 'display_name' => 'View Categories', 'category' => 'Categories'],
            
            // Company Management
            ['name' => 'companies.create', 'display_name' => 'Create Companies', 'category' => 'Companies'],
            ['name' => 'companies.edit', 'display_name' => 'Edit Companies', 'category' => 'Companies'],
            ['name' => 'companies.delete', 'display_name' => 'Delete Companies', 'category' => 'Companies'],
            ['name' => 'companies.view', 'display_name' => 'View Companies', 'category' => 'Companies'],
            
            // User Management
            ['name' => 'users.create', 'display_name' => 'Create Admin Users', 'category' => 'Users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Admin Users', 'category' => 'Users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Admin Users', 'category' => 'Users'],
            ['name' => 'users.view', 'display_name' => 'View Admin Users', 'category' => 'Users'],
            ['name' => 'users.permissions', 'display_name' => 'Manage User Permissions', 'category' => 'Users'],
            
            // Analytics & Reports
            ['name' => 'analytics.view', 'display_name' => 'View Analytics', 'category' => 'Analytics'],
            ['name' => 'reports.view', 'display_name' => 'View Reports', 'category' => 'Analytics'],

            // Testimonials Management
            ['name' => 'testimonials.manage', 'display_name' => 'Manage Testimonials', 'category' => 'Testimonials'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}