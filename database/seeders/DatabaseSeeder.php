<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::truncate();
        // Recommended order:
        $this->call([
            PermissionSeeder::class, // 1. Create permissions first
            RoleSeeder::class,       // 2. Create roles (needs permissions)
            UsersTableSeeder::class  // 3. Create users (needs roles)
        ]);
    }
}
