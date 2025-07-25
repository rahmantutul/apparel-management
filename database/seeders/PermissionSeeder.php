<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create all possible permissions your app will use
        $permissions = [
            // User permissions
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Role permissions
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            
            // Post permissions
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            
            // Category permissions
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            
            // Settings permissions
            'view_settings',
            'edit_settings',

            // Attendance Log permissions
            'view_attendance_logs',
            'create_attendance_logs',
            'edit_attendance_logs',
            'delete_attendance_logs'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
    }
}