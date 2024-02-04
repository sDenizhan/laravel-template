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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned()->nullable();

            $table->text('post_title');
            $table->text('post_excerpt')->nullable();
            $table->longText('post_content')->nullable();
            $table->text('featured_image')->nullable();
            $table->integer('status')->unsigned()->nullable();

            $table->text('slug');
            $table->json('seo')->nullable();
            $table->timestamps();
            $table->timestamp('publish_at')->nullable();
            $table->softDeletes();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
