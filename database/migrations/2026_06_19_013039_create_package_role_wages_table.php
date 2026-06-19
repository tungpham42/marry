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
        Schema::create('package_role_wages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->string('role'); // Thợ chính, Thợ phụ, Assistant...
            $table->decimal('default_work_days', 4, 2)->default(1.00); // Ví dụ: Thợ chính gói đi tỉnh tính 1.5 công
            $table->timestamps();

            // Tránh trùng lặp cấu hình cho cùng một vai trò trong một gói
            $table->unique(['package_id', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_role_wages');
    }
};
