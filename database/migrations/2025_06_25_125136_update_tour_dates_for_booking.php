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
        // Обновляем даты туров, чтобы они были доступны для бронирования
        // Начинаем с 25 июня 2025 года (сегодняшней даты)
        
        $tours = [
            // Туры которые уже доступны (начинаются сегодня или в ближайшие дни)
            1 => ['start' => '2025-06-25', 'end' => '2025-07-01'], // 7 дней
            2 => ['start' => '2025-06-25', 'end' => '2025-07-01'], // 7 дней  
            3 => ['start' => '2025-06-26', 'end' => '2025-07-03'], // 8 дней
            4 => ['start' => '2025-06-27', 'end' => '2025-07-05'], // 9 дней
            5 => ['start' => '2025-06-28', 'end' => '2025-07-09'], // 12 дней
            
            // Туры которые начинаются в ближайшем будущем
            6 => ['start' => '2025-07-01', 'end' => '2025-07-06'], // 6 дней
            7 => ['start' => '2025-07-03', 'end' => '2025-07-11'], // 9 дней
            8 => ['start' => '2025-07-05', 'end' => '2025-07-10'], // 5 дней
            9 => ['start' => '2025-07-07', 'end' => '2025-07-20'], // 14 дней
            10 => ['start' => '2025-07-10', 'end' => '2025-07-16'], // 7 дней
        ];
        
        foreach ($tours as $id => $dates) {
            DB::table('tours')
                ->where('id', $id)
                ->update([
                    'start_date' => $dates['start'],
                    'end_date' => $dates['end'],
                    'data' => $dates['start'] . ' 00:00:00',
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Возвращаем оригинальные даты (опционально)
        $originalDates = [
            1 => ['start' => '2025-06-05', 'end' => '2025-06-15'],
            2 => ['start' => '2025-09-02', 'end' => '2025-09-09'],
            3 => ['start' => '2025-12-25', 'end' => '2026-01-02'],
            4 => ['start' => '2025-05-20', 'end' => '2025-05-29'],
            5 => ['start' => '2025-09-23', 'end' => '2025-10-05'],
            6 => ['start' => '2025-06-12', 'end' => '2025-06-18'],
            7 => ['start' => '2025-08-19', 'end' => '2025-08-27'],
            8 => ['start' => '2025-07-03', 'end' => '2025-07-08'],
            9 => ['start' => '2025-06-09', 'end' => '2025-06-23'],
            10 => ['start' => '2025-09-05', 'end' => '2025-09-12'],
        ];
        
        foreach ($originalDates as $id => $dates) {
            DB::table('tours')
                ->where('id', $id)
                ->update([
                    'start_date' => $dates['start'],
                    'end_date' => $dates['end'],
                    'data' => $dates['start'] . ' 00:00:00',
                    'updated_at' => now(),
                ]);
        }
    }
};
