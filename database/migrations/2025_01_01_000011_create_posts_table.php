<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bài viết Cảm hứng / Góc tư vấn (blog)
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->text('excerpt')->nullable();          // Mô tả ngắn hiển thị ở lưới
            $table->longText('content')->nullable();        // Nội dung chi tiết (rich text)
            $table->string('category')->nullable();         // Chủ đề: Xu hướng, Mẹo, Vật liệu...
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();

            $table->timestamps();

            $table->index(['is_published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
