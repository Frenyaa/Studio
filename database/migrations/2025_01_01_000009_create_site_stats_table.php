<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Khối chỉ số chạy số: 10+ Năm, 30/63 Tỉnh thành, 80+ Công trình, 30+ Nhân sự
        Schema::create('site_stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');                          // "Năm kinh nghiệm"
            $table->string('value');                          // "10" hoặc "30/63"
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();             // "+", "/63"...
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_stats');
    }
};
