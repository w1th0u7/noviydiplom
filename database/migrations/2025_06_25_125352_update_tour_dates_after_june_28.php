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
        // Обновляем даты туров, чтобы они начинались после 28 июня с рандомными интервалами
        
        $tours = [
            // Туры начинаются с 29 июня и далее с рандомными интервалами
            1 => ['start' => '2025-06-29', 'end' => '2025-07-05'], // 7 дней
            2 => ['start' => '2025-07-01', 'end' => '2025-07-07'], // 7 дней  
            3 => ['start' => '2025-07-03', 'end' => '2025-07-10'], // 8 дней
            4 => ['start' => '2025-06-30', 'end' => '2025-07-08'], // 9 дней
            5 => ['start' => '2025-07-05', 'end' => '2025-07-16'], // 12 дней
            6 => ['start' => '2025-07-02', 'end' => '2025-07-07'], // 6 дней
            7 => ['start' => '2025-07-08', 'end' => '2025-07-16'], // 9 дней
            8 => ['start' => '2025-07-04', 'end' => '2025-07-08'], // 5 дней
            9 => ['start' => '2025-07-10', 'end' => '2025-07-23'], // 14 дней
            10 => ['start' => '2025-07-06', 'end' => '2025-07-12'], // 7 дней
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
        // Возвращаем предыдущие даты
        $previousDates = [
            1 => ['start' => '2025-06-25', 'end' => '2025-07-01'],
            2 => ['start' => '2025-06-25', 'end' => '2025-07-01'],
            3 => ['start' => '2025-06-26', 'end' => '2025-07-03'],
            4 => ['start' => '2025-06-27', 'end' => '2025-07-05'],
            5 => ['start' => '2025-06-28', 'end' => '2025-07-09'],
            6 => ['start' => '2025-07-01', 'end' => '2025-07-06'],
            7 => ['start' => '2025-07-03', 'end' => '2025-07-11'],
            8 => ['start' => '2025-07-05', 'end' => '2025-07-10'],
            9 => ['start' => '2025-07-07', 'end' => '2025-07-20'],
            10 => ['start' => '2025-07-10', 'end' => '2025-07-16'],
        ];
        
        foreach ($previousDates as $id => $dates) {
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
