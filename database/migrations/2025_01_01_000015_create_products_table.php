<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')
                ->nullable()
                ->constrained('product_categories')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('dimensions')->nullable();   // Kích thước
            $table->text('material')->nullable();        // Chất liệu
            $table->text('colors')->nullable();          // Màu sắc / tuỳ chọn

            $table->string('cover_image');
            $table->string('thumbnail')->nullable();

            $table->text('summary')->nullable();
            $table->longText('description')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();

            $table->timestamps();

            $table->index(['is_published', 'is_featured', 'sort_order']);
            $table->index('product_category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
