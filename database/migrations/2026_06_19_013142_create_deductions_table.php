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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null'); // Gắn với show bị phạt (nếu có)
            $table->decimal('amount', 12, 2)->default(0); // Số tiền phạt/khấu trừ
            $table->string('reason'); // Lý do phạt
            $table->date('date'); // Ngày ghi nhận lỗi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
