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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');

            // Tổng hợp từ các bảng trên
            $table->decimal('total_work_days', 5, 2)->default(0); // Tổng ngày công tích lũy trong tháng
            $table->decimal('salary_by_days', 12, 2)->default(0); // Tiền công (Total Days * Base Salary Per Day)
            $table->decimal('total_allowance', 12, 2)->default(0); // Tổng phụ cấp đi show
            $table->decimal('total_deduction', 12, 2)->default(0); // Tổng tiền phạt
            $table->decimal('final_salary', 12, 2)->default(0); // Thực lĩnh = Tiền công + Phụ cấp - Phạt

            $table->string('status')->default('draft'); // draft (nháp), approved (đã duyệt), paid (đã chi trả)
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            // Đảm bảo mỗi nhân viên chỉ có 1 bản ghi lương duy nhất cho mỗi tháng/năm
            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
