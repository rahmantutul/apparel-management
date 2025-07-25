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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sn');
            $table->foreignId('user_id')->constrained();
            $table->date('attendance_date');
            $table->time('attendance_time');
            $table->string('extra')->nullable();
            $table->integer('punch_type');
            $table->string('status_1')->nullable();
            $table->string('status_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
