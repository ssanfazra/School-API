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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->foreignId('current_academic_year_id')->constrained('academic_years');
            $table->foreignId('current_major_id')->constrained('majors');
            $table->foreignId('current_grade_id')->constrained('grades');
            $table->foreignId('current_classroom_id')->constrained('classrooms');
            $table->foreignId('guardian_id')->constrained('guardians')->nullable();
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('religion', ['islam', 'kristen', 'hindu', 'buddha', 'konghucu', 'other'])->nullable();
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
