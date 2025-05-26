<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Excursion;
use Illuminate\Support\Carbon;

class ExcursionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excursion::truncate();
        
        $excursions = [
            [
                'name' => 'Исторический тур "Кремль изнутри"',
                'description' => 'Увлекательная экскурсия по территории Кремля с посещением соборов и Оружейной палаты для всей семьи.',
                'location' => 'Москва',
                'region' => 'Центральный',
                'duration' => 3,
                'price' => 1500,
                'image' => 'excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'audience_type' => 'all',
                'min_age' => 6,
                'max_age' => null,
                'available_seats' => 20,
                'features' => json_encode(['Профессиональный гид', 'Входные билеты', 'Экскурсия на русском языке', 'Встреча у метро']),
            ],
            [
                'name' => 'Образовательный тур "Старый город"',
                'description' => 'Погружение в историю древнего города. Экскурсия специально разработана для школьников с учетом школьной программы по истории.',
                'location' => 'Суздаль',
                'region' => 'Центральный',
                'duration' => 4,
                'price' => 2000,
                'image' => 'excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'audience_type' => 'school',
                'min_age' => 7,
                'max_age' => 17,
                'available_seats' => 25,
                'features' => json_encode(['Адаптированная под школьную программу', 'Посещение 3-х музеев', 'Интерактивные задания', 'Обед в кафе']),
            ],
            [
                'name' => 'Художественный тур "Третьяковская галерея"',
                'description' => 'Экскурсия по Третьяковской галерее с акцентом на русскую живопись для взрослых любителей искусства.',
                'location' => 'Москва',
                'region' => 'Центральный',
                'duration' => 2,
                'price' => 1200,
                'image' => 'excursions/4aWc5ilxL9V5cYYbJsdhZgKH.jpg',
                'audience_type' => 'adult',
                'min_age' => 18,
                'max_age' => null,
                'available_seats' => 15,
                'features' => json_encode(['Профессиональный искусствовед', 'Входные билеты', 'Аудиогид', 'Буклет о галерее']),
            ],
            [
                'name' => 'Интерактивная экскурсия "В мире животных"',
                'description' => 'Познавательная экскурсия для дошкольников в зоопарке с элементами игры и обучения.',
                'location' => 'Москва',
                'region' => 'Центральный',
                'duration' => 2,
                'price' => 1000,
                'image' => 'excursions/4aWc5ilxL9V5cYYbJsdhZgKH.jpg',
                'audience_type' => 'preschool',
                'min_age' => 3,
                'max_age' => 6,
                'available_seats' => 10,
                'features' => json_encode(['Игровая форма', 'Кормление животных', 'Фотосессия', 'Подарок каждому ребенку']),
            ],
            [
                'name' => 'Природный тур "Заповедные места"',
                'description' => 'Экологическая экскурсия по заповеднику с изучением флоры и фауны. Подходит для всех возрастов.',
                'location' => 'Национальный парк Мещёра',
                'region' => 'Центральный',
                'duration' => 5,
                'price' => 2500,
                'image' => 'excursions/4aWc5ilxL9V5cYYbJsdhZgKH.jpg',
                'audience_type' => 'all',
                'min_age' => 5,
                'max_age' => null,
                'available_seats' => 20,
                'features' => json_encode(['Наблюдение за дикой природой', 'Пикник на природе', 'Фотосессия', 'Сувениры из природных материалов']),
            ],
            [
                'name' => 'Музыкальное путешествие "Звуки природы"',
                'description' => 'Интерактивная экскурсия для дошкольников, знакомящая с музыкальными инструментами и звуками природы.',
                'location' => 'Детский музей',
                'region' => 'Центральный',
                'duration' => 1,
                'price' => 800,
                'image' => 'excursions/4aWc5ilxL9V5cYYbJsdhZgKH.jpg',
                'audience_type' => 'preschool',
                'min_age' => 3,
                'max_age' => 6,
                'available_seats' => 15,
                'features' => json_encode(['Игра на музыкальных инструментах', 'Мастер-класс по изготовлению шумелок', 'Музыкальная сказка', 'Небольшой концерт']),
            ],
        ];
        
        foreach ($excursions as $excursionData) {
            Excursion::create($excursionData);
        }
    }
} 