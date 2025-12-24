<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            // Drop old foreign key and column
            $table->dropForeign(['employer_id']);
            $table->dropColumn('employer_id');

            // Add new foreign key referencing companies
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
        });
    }
};
