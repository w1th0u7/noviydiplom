<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tour;
use Illuminate\Support\Carbon;

class ToursTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tours')->truncate();

        DB::table('tours')->insert([
            'name' => 'Новый летний тур',
            'season' => 'летние',
            'description' => 'Это новый летний тур, который вы не захотите пропустить.',
            'image' => '/img/image 5.jpg',
            'data' => now()->addDays(1),
            'price' => 25000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        Tour::create([
            'name' => 'Ближайший осенний тур',
            'season' => 'осенние',
            'description' => 'Не пропустите наш ближайший осенний тур!',
            'image' => '/img/image 6.jpg',
            'data' => Carbon::createFromFormat('d.m.Y', '15.09.2023'), // Преобразуйте строку в дату
            'price' => 30000,
        ]);

        Tour::create([
            'name' => 'Популярный зимний тур', //  <<<--- Использовать 'name'
            'season' => 'зимние',
            'description' => 'Этот зимний тур пользуется огромной популярностью.',
            'image' => '/img/image 8.jpg',
            'data' => '10.12.2023',
            'price' => 40000,
        ]);

        Tour::create([
            'name' => 'Новый летний тур',
            'season' => 'летние',
            'description' => 'Это новый летний тур, который вы не захотите пропустить.',
            'image' => '/img/image 5.jpg',
            'data' => now()->addDays(1),
            'price' => 25000,
        ]);

        Tour::create([
            'name' => 'Летний пляжный отдых', //  <<<--- Использовать 'name'
            'season' => 'летние',
            'description' => 'Отличный летний отдых на пляже.',
            'image' => '/img/image 8.jpg',
            'data' => '20.08.2023',
            'price' => 22000,
        ]);

        Tour::create([
            'name' => 'Летний пляжный отдых', //  <<<--- Использовать 'name'
            'season' => 'летние',
            'description' => 'Отличный летний отдых на пляже.',
            'image' => '/img/image 8.jpg',
            'data' => '20.06.2023',
            'price' => 23000,
        ]);

    }
}