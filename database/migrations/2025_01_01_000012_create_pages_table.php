<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Trang nội dung tĩnh: chính sách, điều khoản... (quản lý trong Admin)
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('show_in_footer')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();

            $table->timestamps();

            $table->index(['is_published', 'show_in_footer', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
