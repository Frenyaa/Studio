<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Quy trình làm việc: Khảo sát -> Thiết kế 3D -> Sản xuất -> Thi công
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();             // 01, 02, 03 (điểm nhấn số lớn)
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0); // Hỗ trợ kéo thả sắp xếp
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_steps');
    }
};
