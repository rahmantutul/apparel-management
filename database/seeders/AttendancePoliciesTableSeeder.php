<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttendancePolicy;

class AttendancePoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendancePolicy::create([
            'company_id' => 1, // Assuming company with ID 1 exists
            'work_start_time' => '09:00:00',
            'work_end_time' => '17:00:00',
            'late_tolerance_minutes' => 10,
            'half_day_threshold_minutes' => 120,
            'absent_threshold_minutes' => 240,
        ]);
    }
}
