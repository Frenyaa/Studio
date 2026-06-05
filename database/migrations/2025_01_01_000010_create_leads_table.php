<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Khách đăng ký tư vấn từ Form liên hệ
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');                           // Họ và tên
            $table->string('phone');                          // Số điện thoại
            $table->string('email')->nullable();
            $table->string('need')->nullable();               // Nhu cầu: Thiết kế / Thi công trọn gói / Cải tạo
            $table->text('message')->nullable();              // Lời nhắn

            // Trạng thái xử lý: new (Mới), contacting (Đang liên hệ), won (Đã chốt), lost (Không thành công)
            $table->string('status')->default('new');
            $table->text('admin_note')->nullable();

            // Truy vết nguồn
            $table->string('source')->default('homepage_form');
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
