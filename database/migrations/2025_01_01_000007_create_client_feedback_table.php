<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');                    // Anh Kiên, Chị Mai...
            $table->string('client_location')->nullable();    // Hà Nội, Hải Phòng...
            $table->string('client_title')->nullable();       // Chức danh (tuỳ chọn)
            $table->string('avatar')->nullable();
            $table->text('content');                          // Nội dung đánh giá
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_feedback');
    }
};
