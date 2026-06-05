<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Quản lý video nền + slogan của Hero Section trang chủ
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('video_file')->nullable();         // File video upload (mp4)
            $table->string('video_url')->nullable();          // Hoặc link video ngoài (CDN/Youtube...)
            $table->string('poster_image')->nullable();       // Ảnh poster hiển thị khi video chưa load (lazy)

            $table->string('slogan')->default('THIẾT KẾ THI CÔNG TOÀN DIỆN CHO NGÔI NHÀ CỦA BẠN');
            $table->string('sub_slogan')->nullable();
            $table->string('cta_label')->default('XEM DỰ ÁN');
            $table->string('cta_anchor')->default('#portfolio'); // Cuộn mượt tới section

            $table->boolean('show_logo_overlay')->default(true); // Logo phóng to mờ dần khi cuộn
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
