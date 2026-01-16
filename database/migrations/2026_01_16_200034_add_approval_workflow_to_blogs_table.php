<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite compatibility, we need to recreate the table with the new status enum
        // First, store the old data
        $blogs = DB::table('blogs')->get();

        // Drop the old table
        Schema::dropIfExists('blogs');

        // Recreate with new schema
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->boolean('is_approved')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('tags')->nullable();
            $table->string('category');
            $table->enum('status', ['draft', 'pending', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });

        // Restore the old data
        foreach ($blogs as $blog) {
            DB::table('blogs')->insert((array) $blog);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Store existing data
        $blogs = DB::table('blogs')->get();

        // Drop the modified table
        Schema::dropIfExists('blogs');

        // Recreate original schema
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('tags')->nullable();
            $table->string('category');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });

        // Restore data (excluding new columns)
        foreach ($blogs as $blog) {
            $oldBlog = [
                'id' => $blog->id,
                'author_id' => $blog->author_id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'excerpt' => $blog->excerpt,
                'content' => $blog->content,
                'featured_image' => $blog->featured_image,
                'tags' => $blog->tags,
                'category' => $blog->category,
                'status' => in_array($blog->status, ['draft', 'published', 'archived']) ? $blog->status : 'draft',
                'published_at' => $blog->published_at,
                'views' => $blog->views,
                'created_at' => $blog->created_at,
                'updated_at' => $blog->updated_at,
            ];
            DB::table('blogs')->insert($oldBlog);
        }
    }
};
