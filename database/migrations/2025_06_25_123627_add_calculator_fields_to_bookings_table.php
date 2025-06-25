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
            // Добавляем поля для сохранения данных калькулятора
            $table->text('calculator_data')->nullable()->after('notes'); // JSON с полными данными калькулятора
            $table->string('calculator_country')->nullable()->after('calculator_data');
            $table->string('calculator_resort')->nullable()->after('calculator_country');
            $table->string('calculator_tour_type')->nullable()->after('calculator_resort');
            $table->string('calculator_hotel_class')->nullable()->after('calculator_tour_type');
            $table->string('calculator_meal')->nullable()->after('calculator_hotel_class');
            $table->integer('calculator_nights')->nullable()->after('calculator_meal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'calculator_data',
                'calculator_country',
                'calculator_resort',
                'calculator_tour_type',
                'calculator_hotel_class',
                'calculator_meal',
                'calculator_nights'
            ]);
        });
    }
};
