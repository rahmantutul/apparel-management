<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
        // Don't truncate here - let migrate:refresh handle table clearing
        // DB::table('users')->truncate(); // Remove this line
        
        // Get the admin role (assuming RoleSeeder runs first)
        $adminRole = Role::where('name', 'admin')->first();
        
        if (!$adminRole) {
            $this->command->error('Admin role not found! Run RoleSeeder first.');
            return;
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@apparel.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Admin@123'),
            'phone' => '1234567890',
            'remember_token' => Str::random(10),
        ]);

        // Assign role
        $admin->assignRole($adminRole);

        $this->command->info('Successfully created admin user with admin role!');
    }
}