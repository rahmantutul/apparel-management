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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('religion')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('starting_salary', 10, 2)->nullable();
            $table->string('salary_payment_method')->nullable();
            $table->string('status')->default('active');
            $table->text('short_bio')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('national_id')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('qualification')->nullable();
            $table->string('experience')->nullable();
            $table->string('bank_account')->nullable();
            $table->boolean('is_resigned')->default(false);
            $table->date('resignation_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // fixed line
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
