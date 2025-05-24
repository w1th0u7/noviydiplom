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
        Schema::table('tours', function (Blueprint $table) {
            $table->string('type')->nullable()->after('name'); // Тип тура (Пляжный, Экскурсионный, Горнолыжный и т.д.)
            $table->date('start_date')->nullable()->after('data'); // Дата начала тура
            $table->date('end_date')->nullable()->after('start_date'); // Дата окончания тура
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['type', 'start_date', 'end_date']);
        });
    }
};
