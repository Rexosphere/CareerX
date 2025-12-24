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
        Schema::create('research_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('type'); // e.g., "Msc Thesis", "Research Paper", "Undergraduate Project", "Conference Paper"
            $table->text('description');
            $table->string('status'); // e.g., "Ongoing", "Completed", "Published"
            $table->json('authors')->nullable(); // Collaborators/Co-authors
            $table->string('supervisor')->nullable();
            $table->string('department')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('tags')->nullable(); // Research areas/keywords
            $table->string('publication_link')->nullable(); // Link to published paper
            $table->string('doi')->nullable(); // Digital Object Identifier
            $table->string('conference')->nullable(); // Conference name if applicable
            $table->string('journal')->nullable(); // Journal name if applicable
            $table->text('abstract')->nullable(); // Research abstract
            $table->string('file_path')->nullable(); // PDF upload
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_projects');
    }
};
