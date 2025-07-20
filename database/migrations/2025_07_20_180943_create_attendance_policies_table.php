<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained();
            $table->time('work_start_time'); // e.g. 09:00:00
            $table->time('work_end_time');   // e.g. 17:00:00
            $table->integer('late_tolerance_minutes')->default(10);
            $table->integer('half_day_threshold_minutes')->default(120);
            $table->integer('absent_threshold_minutes')->default(240);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_policies');
    }
};
