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
            $table->string('emp_id')->nullable();
            $table->string('emp_name')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->string('emp_gender')->nullable();
            $table->date('emp_date_of_birth')->nullable();
            $table->string('emp_religion')->nullable();
            $table->string('emp_contact_number')->nullable();
            $table->string('emp_emergency_contact')->nullable();
            $table->string('emp_present_address')->nullable();
            $table->string('emp_permanent_address')->nullable();
            $table->date('emp_joining_date')->nullable();
            $table->decimal('emp_starting_salary', 10, 2)->nullable();
            $table->string('emp_salary_payment_method')->nullable();
            $table->string('emp_status')->default('active');
            $table->text('emp_short_bio')->nullable();
            $table->string('emp_image')->nullable();
            $table->string('emp_file')->nullable();
            $table->string('emp_email')->nullable()->unique();
            $table->string('emp_national_id')->nullable();
            $table->string('emp_marital_status')->nullable();
            $table->string('emp_blood_group')->nullable();
            $table->string('emp_father_name')->nullable();
            $table->string('emp_mother_name')->nullable();
            $table->string('emp_qualification')->nullable();
            $table->string('emp_experience')->nullable();
            $table->string('emp_bank_account')->nullable();
            $table->boolean('emp_is_resigned')->default(false);
            $table->date('emp_resignation_date')->nullable();
            $table->int('user_id')->nullable();
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
