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
            // Добавляем поля для полиморфных связей
            $table->string('bookable_type')->after('notes')->nullable();
            $table->unsignedBigInteger('bookable_id')->after('bookable_type')->nullable();
            $table->index(['bookable_type', 'bookable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['bookable_type', 'bookable_id']);
            $table->dropColumn('bookable_type');
            $table->dropColumn('bookable_id');
        });
    }
};
