<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_category_id')
                ->nullable()
                ->constrained('project_categories')
                ->nullOnDelete();

            $table->string('title');                          // Brave House, Teasu House...
            $table->string('slug')->unique();
            $table->string('location')->nullable();           // Hà Nội, Hải Phòng...
            $table->string('area')->nullable();               // Diện tích: 120m2
            $table->year('year_completed')->nullable();
            $table->string('client_name')->nullable();
            $table->string('style')->nullable();              // Phong cách: Minimalism...

            $table->string('cover_image');                    // Ảnh đại diện khổ lớn
            $table->string('thumbnail')->nullable();          // Ảnh thumbnail tối ưu lưới

            $table->text('summary')->nullable();              // Mô tả ngắn hiển thị trên lưới
            $table->longText('description')->nullable();       // Nội dung chi tiết (rich text)

            $table->boolean('is_featured')->default(false);   // Nổi bật trang chủ
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();

            $table->timestamps();

            $table->index(['is_published', 'is_featured', 'sort_order']);
            $table->index('project_category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
