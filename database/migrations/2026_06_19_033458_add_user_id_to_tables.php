<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
        Schema::table('deductions', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
        Schema::table('packages', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
        Schema::table('package_role_wages', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
        Schema::table('payrolls', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('deductions', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('package_role_wages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
