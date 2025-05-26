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
            // Добавляем недостающие поля, если их нет
            if (!Schema::hasColumn('tours', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('tours', 'type')) {
                $table->string('type')->default('Пляжный');
            }
            if (!Schema::hasColumn('tours', 'season')) {
                $table->string('season')->default('Лето');
            }
            if (!Schema::hasColumn('tours', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('tours', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('tours', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            if (!Schema::hasColumn('tours', 'end_date')) {
                $table->date('end_date')->nullable();
            }
            if (!Schema::hasColumn('tours', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('tours', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('tours', 'duration')) {
                $table->integer('duration')->default(7);
            }
            if (!Schema::hasColumn('tours', 'features')) {
                $table->json('features')->nullable();
            }
            if (!Schema::hasColumn('tours', 'available_seats')) {
                $table->integer('available_seats')->default(20);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // Можно удалить поля при откате миграции,
            // но лучше этого не делать для сохранности данных
        });
    }
};
