<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingsTableSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks (if needed)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Ensure the table is empty
        DB::table('general_settings')->truncate();

        // Insert the default settings
        GeneralSetting::create([
            'id' => 1,
            'company_name' => 'Your Company Name',
            'company_email' => 'info@yourcompany.com',
            'company_phone' => '+1 (123) 456-7890',
            'company_address' => "123 Business Ave\nCity, State 10001",
            'company_tagline' => 'Quality Services Since 2023',
            'company_types' => 'IT Services',
            'subscription_type' => 'Premium',
            'subscription_price' => 99.99,
            'company_com_holiday_emp1' => 'Christmas Day',
            'company_com_holiday_emp2' => 'New Year Day',
            'company_logo' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('General settings seeded successfully!');
    }
}