<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Excursion;
use Carbon\Carbon;

class ToursAndExcursionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Очистка существующих данных
        Tour::truncate();
        Excursion::truncate();
        
        // Создаем тестовые туры
        $this->createTours();
        
        // Создаем тестовые экскурсии
        $this->createExcursions();
    }
    
    /**
     * Создать тестовые туры
     */
    private function createTours(): void
    {
        // Тестовые туры по России
        Tour::create([
            'name' => 'Отдых в Сочи',
            'type' => 'Пляжный',
            'season' => 'Лето',
            'description' => 'Незабываемый отдых на Черноморском побережье. Вас ждет теплое море, комфортабельный отель, развлекательная программа и экскурсии по достопримечательностям Сочи и его окрестностей.',
            'image' => 'tours/plyazh.jpg',
            'start_date' => Carbon::now()->addDays(10),
            'end_date' => Carbon::now()->addDays(20),
            'data' => Carbon::now()->addDays(10),
            'price' => 45000,
            'location' => 'Россия, Сочи',
            'duration' => 7,
            'features' => ['Проживание в отеле 4*', 'Питание "все включено"', 'Трансфер из аэропорта', 'Пляжный отдых', 'Экскурсии'],
            'available_seats' => 20
        ]);
        
        Tour::create([
            'name' => 'Зимний отдых в Красной Поляне',
            'type' => 'Горнолыжный',
            'season' => 'Зима',
            'description' => 'Идеальный зимний отдых в горах Красной Поляны. Современные горнолыжные курорты, трассы разной степени сложности, подходящие как для новичков, так и для профессионалов.',
            'image' => 'tours/winter.jpg',
            'start_date' => Carbon::now()->addDays(60),
            'end_date' => Carbon::now()->addDays(67),
            'data' => Carbon::now()->addDays(60),
            'price' => 55000,
            'location' => 'Россия, Сочи, Красная Поляна',
            'duration' => 7,
            'features' => ['Проживание в отеле 4*', 'Завтраки', 'Ски-пасс на 6 дней', 'Трансфер из аэропорта', 'Прокат оборудования'],
            'available_seats' => 15
        ]);
        
        // Тестовые туры по Турции
        Tour::create([
            'name' => 'Отдых в Анталии',
            'type' => 'Пляжный',
            'season' => 'Лето',
            'description' => 'Роскошный отдых на турецком побережье в отеле 5* с системой "ультра все включено". Белоснежные пляжи, бирюзовое море и безупречный сервис.',
            'image' => 'tours/more.jpg',
            'start_date' => Carbon::now()->addDays(15),
            'end_date' => Carbon::now()->addDays(25),
            'data' => Carbon::now()->addDays(15),
            'price' => 65000,
            'location' => 'Турция, Анталия',
            'duration' => 10,
            'features' => ['Проживание в отеле 5*', 'Ultra All Inclusive', 'Перелет', 'Трансфер', 'Страховка'],
            'available_seats' => 25
        ]);
        
        Tour::create([
            'name' => 'Исторический тур по Стамбулу',
            'type' => 'Экскурсионный',
            'season' => 'Весна',
            'description' => 'Увлекательное путешествие по историческим местам Стамбула. Вы посетите Айя-Софию, Голубую мечеть, дворец Топкапы, Гранд Базар и другие достопримечательности.',
            'image' => 'tours/kazan.jpg',
            'start_date' => Carbon::now()->addDays(30),
            'end_date' => Carbon::now()->addDays(35),
            'data' => Carbon::now()->addDays(30),
            'price' => 58000,
            'location' => 'Турция, Стамбул',
            'duration' => 5,
            'features' => ['Проживание в отеле 4*', 'Завтраки', 'Экскурсионная программа', 'Русскоязычный гид', 'Входные билеты'],
            'available_seats' => 18
        ]);
        
        // Тестовые туры по другим странам
        Tour::create([
            'name' => 'Отдых в Шарм-эль-Шейхе',
            'type' => 'Пляжный',
            'season' => 'Осень',
            'description' => 'Великолепный отдых на побережье Красного моря. Потрясающий подводный мир, коралловые рифы и экзотические рыбы.',
            'image' => 'tours/more.jpg',
            'start_date' => Carbon::now()->addDays(40),
            'end_date' => Carbon::now()->addDays(49),
            'data' => Carbon::now()->addDays(40),
            'price' => 70000,
            'location' => 'Египет, Шарм-эль-Шейх',
            'duration' => 9,
            'features' => ['Проживание в отеле 5*', 'All Inclusive', 'Перелет', 'Трансфер', 'Страховка'],
            'available_seats' => 22
        ]);
    }
    
    /**
     * Создать тестовые экскурсии
     */
    private function createExcursions(): void
    {
        // Экскурсии в Сочи
        Excursion::create([
            'name' => 'Красная Поляна и Олимпийские объекты',
            'description' => 'Обзорная экскурсия по Олимпийскому парку и Красной Поляне. Вы увидите главные спортивные объекты Зимних Олимпийских игр 2014 года и подниметесь на канатной дороге на высоту более 2000 м над уровнем моря.',
            'location' => 'Сочи, Адлерский район',
            'region' => 'Россия',
            'duration' => 1,
            'price' => 2500,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 0,
            'max_age' => 99,
            'available_seats' => 30,
            'features' => ['Транспортное обслуживание', 'Услуги гида', 'Билет на канатную дорогу', 'Фотографии']
        ]);
        
        Excursion::create([
            'name' => '33 водопада и Долина легенд',
            'description' => 'Увлекательное путешествие в ущелье Джегош, где расположен уникальный природный комплекс из 33 водопадов. По пути вы посетите этнографический центр и попробуете блюда местной кухни.',
            'location' => 'Сочи, Лазаревский район',
            'region' => 'Россия',
            'duration' => 1,
            'price' => 2200,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'all',
            'min_age' => 6,
            'max_age' => 99,
            'available_seats' => 25,
            'features' => ['Транспортное обслуживание', 'Услуги гида', 'Входные билеты', 'Обед с дегустацией']
        ]);
        
        
        Excursion::create([
            'name' => 'Яхтинг по Средиземному морю',
            'description' => 'Морская прогулка вдоль побережья на комфортабельной яхте. Остановки для купания в живописных бухтах, обед на борту и возможность увидеть дельфинов.',
            'location' => 'Анталия',
            'region' => 'Турция',
            'duration' => 1,
            'price' => 4000,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 3,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Трансфер из отеля', 'Услуги капитана и команды', 'Обед и напитки', 'Снаряжение для снорклинга']
        ]);
        
        // Экскурсии в Египте
        Excursion::create([
            'name' => 'Каир и пирамиды Гизы',
            'description' => 'Экскурсия в столицу Египта и к великим пирамидам. Вы увидите пирамиды Хеопса, Хефрена и Микерина, Сфинкса, посетите Египетский музей и познакомитесь с древними сокровищами.',
            'location' => 'Каир, Гиза',
            'region' => 'Египет',
            'duration' => 1,
            'price' => 6000,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'all',
            'min_age' => 6,
            'max_age' => 99,
            'available_seats' => 15,
            'features' => ['Перелет Шарм-эль-Шейх - Каир - Шарм-эль-Шейх', 'Русскоговорящий гид', 'Входные билеты', 'Обед в ресторане', 'Поездка на верблюде']
        ]);
    }
}
