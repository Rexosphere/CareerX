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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('student_id')->unique(); // UoM registration number
            $table->string('course'); // e.g., "Computer Science & Engineering"
            $table->integer('year'); // 1-4
            $table->text('bio')->nullable();
            $table->json('skills')->nullable(); // Array of skills
            $table->json('experience')->nullable(); // Work experience
            $table->json('projects')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('portfolio')->nullable();
            $table->float('gpa')->nullable();
            $table->boolean('available_for_hire')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
