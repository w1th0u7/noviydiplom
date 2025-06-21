<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tour;
use Illuminate\Support\Carbon;

class ToursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        Tour::truncate();
        
        
        $tours = [
            [
                'name' => 'Золотое кольцо России',
                'type' => 'Экскурсионный',
                'season' => 'Лето 2025',
                'description' => 'Увлекательный тур по историческим городам Золотого кольца России, включающий посещение древних храмов, монастырей и музеев.',
                'image' => 'img/tours/Novgorod.jpg',
                'data' => Carbon::now(),
                'start_date' => Carbon::create(2025, 7, 26),
                'end_date' => Carbon::create(2025, 7, 31),
                'price' => 24500,
                'location' => 'Владимир, Суздаль, Ярославль, Кострома',
                'duration' => 6,
                'features' => json_encode(['Экскурсии по историческим местам', 'Проживание в отелях 3*', 'Завтраки', 'Трансфер']),
                'audience_type' => 'all',
                'available_seats' => 12,
            ],
            [
                'name' => 'Сочи - Черноморская жемчужина',
                'type' => 'Пляжный',
                'season' => 'Лето 2023',
                'description' => 'Отдых на побережье Черного моря в Сочи. Теплое море, пляжи, развлечения, экскурсии по окрестностям.',
                'image' => 'img/tours/plyazh 2.jpg',
                'data' => Carbon::now(),
                'start_date' => Carbon::create(2023, 8, 10),
                'end_date' => Carbon::create(2023, 8, 17),
                'price' => 35000,
                'location' => 'Сочи, Адлер',
                'duration' => 8,
                'features' => json_encode(['Проживание в отеле 4*', 'Питание полупансион', 'Экскурсия в Красную Поляну', 'Трансфер']),
                'audience_type' => 'all',
                'available_seats' => 8,
            ],
            [
                'name' => 'Зимний отдых в Шерегеше',
                'type' => 'Горнолыжный',
                'season' => 'Зима 2023-2024',
                'description' => 'Горнолыжный отдых на одном из лучших курортов России. Отличные трассы, современные подъемники, активный отдых.',
                'image' => 'img/tours/winter.jpg',
                'data' => Carbon::now(),
                'start_date' => Carbon::create(2023, 12, 20),
                'end_date' => Carbon::create(2023, 12, 27),
                'price' => 42000,
                'location' => 'Шерегеш, Кемеровская область',
                'duration' => 8,
                'features' => json_encode(['Проживание в отеле 3*', 'Завтраки', 'Ски-пасс на 6 дней', 'Трансфер']),
                'audience_type' => 'adult',
                'available_seats' => 15,
            ],
            [
                'name' => 'Круиз по Волге',
                'type' => 'Круиз',
                'season' => 'Лето 2025',
                'description' => 'Волгоград - Углич - Ярославль - Кострома - Нижний Новгород',
                'image' => 'img/tours/rechka.jpg',
                'data' => Carbon::now(),
                'start_date' => Carbon::create(2025, 6, 5),
                'end_date' => Carbon::create(2025, 6, 12),
                'price' => 38000,
                'location' => 'Москва, Углич, Ярославль, Кострома, Нижний Новгород',
                'duration' => 8,
                'features' => json_encode(['Проживание в каюте', 'Полный пансион', 'Экскурсии в портах', 'Развлекательная программа']),
                'audience_type' => 'all',
                'available_seats' => 5,
            ],
            [
                'name' => 'Отдых в Минеральных Водах',
                'type' => 'Оздоровительный',
                'season' => 'Осень 2025',
                'description' => 'Оздоровительный отдых на курорте Кавказских Минеральных Вод. Лечебные процедуры, минеральные источники, экскурсии.',
                'image' => 'img/tours/rassvet.jpg',
                'data' => Carbon::now(),
                'start_date' => Carbon::create(2025, 9, 15),
                'end_date' => Carbon::create(2025, 9, 25),
                'price' => 45000,
                'location' => 'Пятигорск, Кисловодск, Ессентуки',
                'duration' => 11,
                'features' => json_encode(['Проживание в санатории', 'Полный пансион', 'Лечебные процедуры', 'Трансфер']),
                'audience_type' => 'adult',
                'available_seats' => 10,
            ],
            [
                'name' => 'Бурятия и Байкал',
                'type' => 'Экскурсионный',
                'season' => 'Лето 2025',
                'description' => 'Экскурсионный тур по Бурятии с отдыхом на Байкале. Посещение буддийских храмов, знакомство с культурой региона.',
                'image' => 'img/tours/more.jpg',
                'data' => Carbon::now(),
                'start_date' => Carbon::create(2025, 7, 25),
                'end_date' => Carbon::create(2025, 8, 1),
                'price' => 50000,
                'location' => 'Улан-Удэ, Иволгинский дацан, озеро Байкал',
                'duration' => 8,
                'features' => json_encode(['Проживание в отелях 3*', 'Завтраки', 'Экскурсии', 'Трансфер']),
                'audience_type' => 'all',
                'available_seats' => 7,
            ],
        ];
        
        
        foreach ($tours as $tourData) {
            Tour::create($tourData);
        }
    }
}