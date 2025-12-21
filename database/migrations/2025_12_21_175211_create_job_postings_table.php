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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->text('description');
            $table->string('location');
            $table->enum('type', ['Full-time', 'Part-time', 'Internship', 'Contract']);
            $table->string('category');
            $table->string('salary_range')->nullable();
            $table->json('requirements')->nullable(); // Skills, qualifications
            $table->boolean('is_active')->default(true);
            $table->date('application_deadline')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
