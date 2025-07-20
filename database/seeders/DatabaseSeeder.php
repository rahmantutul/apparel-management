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
            PermissionSeeder::class,
            RoleSeeder::class,
            UsersTableSeeder::class,
            GeneralSettingsTableSeeder::class,
        ]);
    }
}
