<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the users table first
        DB::table('users')->truncate();

        // Create admin user
        DB::table('users')->insert([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@apparel.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Admin@123'), // Strong default password
            'phone' => '1234567890',
            'address' => '123 Main St, Pharmacy City',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Successfully seeded users table with admin, manager, and staff accounts!');
    }
}