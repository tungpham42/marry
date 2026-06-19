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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->foreignId('package_id')->constrained('packages');
            $table->date('shoot_date');
            $table->string('shoot_location')->nullable();
            // Trạng thái: pending (chờ), confirmed (đã chốt), processing (đang chụp), completed (xong), cancelled (hủy)
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
