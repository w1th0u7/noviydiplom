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
            // Делаем поля bookable_type и bookable_id nullable для бронирований из калькулятора
            $table->string('bookable_type')->nullable()->change();
            $table->unsignedBigInteger('bookable_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Возвращаем обратно NOT NULL
            $table->string('bookable_type')->nullable(false)->change();
            $table->unsignedBigInteger('bookable_id')->nullable(false)->change();
        });
    }
};
