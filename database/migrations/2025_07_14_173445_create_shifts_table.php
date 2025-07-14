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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name')->nullable();
            $table->string('shift_start_time')->nullable();
            $table->string('shift_end_time')->nullable();
            $table->string('punch_start_time')->nullable();
            $table->string('punch_end_time')->nullable();
            $table->string('entry_time_close')->nullable();
            $table->string('exit_time_start')->nullable();
            $table->string('late_consideration_minutes')->nullable();
            $table->string('shift_active_status')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
