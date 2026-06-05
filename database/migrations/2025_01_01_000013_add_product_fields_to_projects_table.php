<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Trường dành cho sản phẩm nội thất
        Schema::table('projects', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('slug');           // Mã SP
            $table->string('dimensions')->nullable()->after('sku');     // Kích thước: D2800 x R1600 mm
            $table->text('material')->nullable()->after('dimensions');  // Chất liệu
            $table->text('colors')->nullable()->after('material');      // Màu sắc / tuỳ chọn vải da
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['sku', 'dimensions', 'material', 'colors']);
        });
    }
};
