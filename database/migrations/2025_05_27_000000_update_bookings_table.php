<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Если таблица bookings существует, проверяем и обновляем ее структуру
        if (Schema::hasTable('bookings')) {
            // Проверяем, существуют ли поля для полиморфной связи
            $hasBookableType = Schema::hasColumn('bookings', 'bookable_type');
            $hasBookableId = Schema::hasColumn('bookings', 'bookable_id');
            
            // Если какого-то из полей нет, добавляем его
            if (!$hasBookableType || !$hasBookableId) {
                Schema::table('bookings', function (Blueprint $table) use ($hasBookableType, $hasBookableId) {
                    if (!$hasBookableType) {
                        $table->string('bookable_type')->nullable();
                    }
                    
                    if (!$hasBookableId) {
                        $table->unsignedBigInteger('bookable_id')->nullable();
                    }
                    
                    if (!$hasBookableType || !$hasBookableId) {
                        $table->index(['bookable_type', 'bookable_id']);
                    }
                });
                
                // Добавляем запись в лог
                DB::statement("INSERT INTO migrations (migration, batch) VALUES ('2025_05_27_000000_update_bookings_table', (SELECT MAX(batch) + 1 FROM migrations))");
            }
            
            // Проверяем тип поля status
            $statusType = DB::selectOne("SHOW COLUMNS FROM bookings WHERE Field = 'status'")->Type;
            if ($statusType !== "enum('pending','confirmed','cancelled','completed')") {
                // Изменяем тип поля status на enum
                DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'confirmed', 'cancelled', 'completed') NOT NULL DEFAULT 'pending'");
            }
        } else {
            // Если таблицы нет, создаем ее с правильной структурой
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('guest_name');
                $table->string('guest_email');
                $table->string('guest_phone');
                $table->date('booking_date');
                $table->integer('persons')->default(1);
                $table->decimal('total_price', 10, 2);
                $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
                $table->text('notes')->nullable();
                
                // Полиморфные связи для туров и экскурсий
                $table->string('bookable_type');
                $table->unsignedBigInteger('bookable_id');
                $table->index(['bookable_type', 'bookable_id']);
                
                $table->timestamps();
            });
            
            // Добавляем запись в лог
            DB::statement("INSERT INTO migrations (migration, batch) VALUES ('2025_05_27_000000_update_bookings_table', (SELECT MAX(batch) + 1 FROM migrations))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ничего не делаем при откате, чтобы избежать потери данных
    }
}; 