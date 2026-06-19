<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('booking_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('assigned_role'); // Vai trò được phân công trong show này (UC5)

            // Chấm công & Trạng thái (UC6, UC7)
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->string('status')->default('assigned'); // assigned, checked_in, completed

            // Dữ liệu tính công & tiền phát sinh thực tế
            $table->decimal('ot_hours', 4, 2)->default(0); // Số giờ làm lố (UC8)
            $table->decimal('allowance_amount', 12, 2)->default(0); // Tiền phụ cấp xăng xe/ăn uống/đi tỉnh (UC9)
            $table->string('allowance_note')->nullable();

            // Ngày công chốt cuối cùng sau khi cộng cả OT (Hệ thống tự động tính hoặc Quản lý chỉnh sửa)
            $table->decimal('credited_work_days', 4, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_employee');
    }
};
