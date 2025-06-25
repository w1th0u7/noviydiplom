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
        // Обновляем названия регионов для корректной работы фильтра
        $regionMapping = [
            'Россия, Центральный федеральный округ' => 'Центральный',
            'Россия, Северо-Западный федеральный округ' => 'Северо-Западный',
            'Россия, Южный федеральный округ' => 'Южный',
            'Россия, Северо-Кавказский федеральный округ' => 'Северо-Кавказский',
            'Россия, Приволжский федеральный округ' => 'Приволжский',
            'Россия, Уральский федеральный округ' => 'Уральский',
            'Россия, Сибирский федеральный округ' => 'Сибирский',
            'Россия, Дальневосточный федеральный округ' => 'Дальневосточный',
        ];

        foreach ($regionMapping as $oldRegion => $newRegion) {
            DB::table('excursions')
                ->where('region', $oldRegion)
                ->update(['region' => $newRegion]);
        }

        // Обновляем пути к изображениям
        $excursions = DB::table('excursions')->get();
        
        $imageMapping = [
            'excursions/1.jpg' => 'img/excursions/1.jpg',
            'excursions/excursion1.jpg' => 'img/excursions/excursion1.jpg',
            'excursions/excursion2.jpg' => 'img/excursions/excursion2.jpg',
            'excursions/excursion3.jpg' => 'img/excursions/excursion3.jpg',
            'excursions/placeholder.jpg' => 'img/excursions/placeholder.jpg',
            'excursions/adult-1.jpg' => 'img/excursions/adult-1.jpg',
            'excursions/all-1.jpg' => 'img/excursions/all-1.jpg',
            'excursions/all-2.jpg' => 'img/excursions/all-2.jpg',
            'excursions/preschool-1.jpg' => 'img/excursions/preschool-1.jpg',
            'excursions/preschool-2.jpg' => 'img/excursions/preschool-2.jpg',
            'excursions/school-1.jpg' => 'img/excursions/school-1.jpg',
            'excursions/excursion-deti.jpg' => 'img/excursions/excursion-deti.jpg',
        ];

        foreach ($excursions as $excursion) {
            $currentImage = $excursion->image;
            
            // Если изображение уже содержит правильный путь, пропускаем
            if (str_starts_with($currentImage, 'img/')) {
                continue;
            }
            
            // Ищем соответствующий путь в маппинге
            $newImage = $imageMapping[$currentImage] ?? null;
            
            if ($newImage) {
                DB::table('excursions')
                    ->where('id', $excursion->id)
                    ->update(['image' => $newImage]);
            } else {
                // Если нет соответствия, добавляем img/ к текущему пути
                $newImage = 'img/' . $currentImage;
                DB::table('excursions')
                    ->where('id', $excursion->id)
                    ->update(['image' => $newImage]);
            }
        }

        // Добавляем недостающие экскурсии для каждого региона, чтобы в каждом было минимум по одной
        $allRegions = ['Центральный', 'Северо-Западный', 'Южный', 'Северо-Кавказский', 'Приволжский', 'Уральский', 'Сибирский', 'Дальневосточный'];
        
        $existingRegions = DB::table('excursions')->pluck('region')->unique()->toArray();
        
        $missingRegions = array_diff($allRegions, $existingRegions);
        
        // Добавляем экскурсии для отсутствующих регионов
        foreach ($missingRegions as $index => $region) {
            $images = ['img/excursions/all-1.jpg', 'img/excursions/all-2.jpg', 'img/excursions/excursion1.jpg'];
            $randomImage = $images[$index % count($images)];
            
            DB::table('excursions')->insert([
                'name' => "Обзорная экскурсия по {$region} региону",
                'description' => "Познавательная экскурсия по достопримечательностям {$region} региона России.",
                'location' => "{$region} регион",
                'region' => $region,
                'duration' => rand(1, 3),
                'price' => rand(1500, 4000),
                'image' => $randomImage,
                'audience_type' => 'all',
                'min_age' => 0,
                'max_age' => 99,
                'available_seats' => rand(15, 30),
                'start_date' => '2025-06-29',
                'end_date' => '2025-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Возвращаем обратно названия регионов
        $regionMapping = [
            'Центральный' => 'Россия, Центральный федеральный округ',
            'Северо-Западный' => 'Россия, Северо-Западный федеральный округ',
            'Южный' => 'Россия, Южный федеральный округ',
            'Северо-Кавказский' => 'Россия, Северо-Кавказский федеральный округ',
            'Приволжский' => 'Россия, Приволжский федеральный округ',
            'Уральский' => 'Россия, Уральский федеральный округ',
            'Сибирский' => 'Россия, Сибирский федеральный округ',
            'Дальневосточный' => 'Россия, Дальневосточный федеральный округ',
        ];

        foreach ($regionMapping as $oldRegion => $newRegion) {
            DB::table('excursions')
                ->where('region', $oldRegion)
                ->update(['region' => $newRegion]);
        }
    }
};
