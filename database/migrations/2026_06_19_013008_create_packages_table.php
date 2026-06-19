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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ví dụ: Pre-wedding Ngoại cảnh Đà Lạt
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0); // Giá bán cho khách hàng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
