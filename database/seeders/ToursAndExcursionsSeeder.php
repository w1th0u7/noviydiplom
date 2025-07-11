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
        

        // Создаем туры по сезонам и регионам
        $this->createSeasonalTours();
        
        // Создаем туры для разных возрастных групп
        $this->createAgeCategoryTours();

        
        // Создаем тестовые экскурсии
        $this->createExcursions();
    }
    
    /**

     * Создать туры по сезонам и регионам
     */
    private function createSeasonalTours(): void
    {
        // Летний тур (Июнь-Август)
        $summerStartDate = Carbon::create(null, rand(6, 8), rand(1, 28));
        Tour::create([
            'name' => 'Летний отдых в Сочи',
            'type' => 'Пляжный',
            'season' => 'Лето',
            'description' => 'Незабываемый отдых на Черноморском побережье. Вас ждет теплое море, комфортабельный отель, развлекательная программа и экскурсии по достопримечательностям Сочи и его окрестностей.',
            'image' => 'img/tours/plyazh.jpg',
            'start_date' => $summerStartDate,
            'end_date' => $summerStartDate->copy()->addDays(10),
            'data' => $summerStartDate,
            'price' => 45000,
            'location' => 'Россия, Южный федеральный округ, Краснодарский край, Сочи',
            'duration' => 7,
            'features' => ['Проживание в отеле 4*', 'Питание "все включено"', 'Трансфер из аэропорта', 'Пляжный отдых', 'Экскурсии'],
            'available_seats' => 20
        ]);
        
        // Осенний тур (Сентябрь-Ноябрь)
        $autumnStartDate = Carbon::create(null, rand(9, 11), rand(1, 28));
        Tour::create([
            'name' => 'Осенний тур по Золотому кольцу',
            'type' => 'Экскурсионный',
            'season' => 'Осень',
            'description' => 'Удивительное путешествие по древним городам России. Вы увидите уникальные памятники архитектуры, красочные осенние пейзажи и познакомитесь с богатой историей русских городов.',
            'image' => 'img/tours/kazan.jpg',
            'start_date' => $autumnStartDate,
            'end_date' => $autumnStartDate->copy()->addDays(7),
            'data' => $autumnStartDate,
            'price' => 38000,
            'location' => 'Россия, Центральный федеральный округ, Владимир, Суздаль, Ярославль',
            'duration' => 7,
            'features' => ['Проживание в отелях 3-4*', 'Завтраки', 'Экскурсионное обслуживание', 'Комфортабельный автобус', 'Входные билеты в музеи'],
            'available_seats' => 25
        ]);
        
        // Зимний тур (Декабрь-Февраль)
        $winterStartDate = Carbon::create(null, rand(12, 12), rand(1, 28));
        if ($winterStartDate->month == 12) {
            $winterStartDate->year = Carbon::now()->year;
        } else {
            $winterStartDate->year = Carbon::now()->year + 1;
        }
        Tour::create([
            'name' => 'Зимнее путешествие на Байкал',
            'type' => 'Горнолыжный',
            'season' => 'Зима',
            'description' => 'Удивительное зимнее приключение на озере Байкал. Катание на собачьих упряжках, подледная рыбалка, невероятные ледяные гроты и потрясающие пейзажи.',
            'image' => 'img/tours/winter.jpg',
            'start_date' => $winterStartDate,
            'end_date' => $winterStartDate->copy()->addDays(8),
            'data' => $winterStartDate,
            'price' => 65000,
            'location' => 'Россия, Сибирский федеральный округ, Иркутская область, Байкал',
            'duration' => 8,
            'features' => ['Проживание в гостинице', 'Трехразовое питание', 'Экскурсии по льду Байкала', 'Фотосессия на прозрачном льду', 'Баня'],
            'available_seats' => 15
        ]);
        
        // Весенний тур (Март-Май)
        $springStartDate = Carbon::create(null, rand(3, 5), rand(1, 28));
        Tour::create([
            'name' => 'Весенний Алтай',
            'type' => 'Экологический',
            'season' => 'Весна',
            'description' => 'Путешествие по цветущему Алтаю. Вы увидите пробуждение природы, живописные долины, горные реки и водопады. Идеальное место для активного отдыха и фотографии.',
            'image' => 'img/tours/more.jpg',
            'start_date' => $springStartDate,
            'end_date' => $springStartDate->copy()->addDays(9),
            'data' => $springStartDate,
            'price' => 42000,
            'location' => 'Россия, Сибирский федеральный округ, Республика Алтай',
            'duration' => 9,
            'features' => ['Проживание в экоотеле', 'Питание', 'Походы к водопадам', 'Экскурсии к горным озерам', 'Посещение пасек'],
            'available_seats' => 18
        ]);
        
        // Тур по Дальнему Востоку
        $farEastStartDate = Carbon::create(null, rand(7, 9), rand(1, 28));
        Tour::create([
            'name' => 'Открывая Камчатку',
            'type' => 'Приключенческий',
            'season' => 'Лето',
            'description' => 'Уникальное путешествие по одному из самых загадочных регионов России. Вулканы, гейзеры, горячие источники и дикая природа Камчатки.',
            'image' => 'img/tours/plyazh.jpg',
            'start_date' => $farEastStartDate,
            'end_date' => $farEastStartDate->copy()->addDays(12),
            'data' => $farEastStartDate,
            'price' => 95000,
            'location' => 'Россия, Дальневосточный федеральный округ, Камчатский край',
            'duration' => 12,
            'features' => ['Проживание в гостинице и палаточных лагерях', 'Питание', 'Вертолетная экскурсия', 'Восхождение на вулкан', 'Купание в термальных источниках'],
            'available_seats' => 12
        ]);
        
        // Тур по Уралу
        $uralStartDate = Carbon::create(null, rand(6, 8), rand(1, 28));
        Tour::create([
            'name' => 'Сокровища Урала',
            'type' => 'Познавательный',
            'season' => 'Лето',
            'description' => 'Увлекательное путешествие по Уральским горам. Вы посетите знаменитые минералогические музеи, увидите живописные горные пейзажи и познакомитесь с самобытной культурой региона.',
            'image' => 'img/tours/more.jpg',
            'start_date' => $uralStartDate,
            'end_date' => $uralStartDate->copy()->addDays(6),
            'data' => $uralStartDate,
            'price' => 35000,
            'location' => 'Россия, Уральский федеральный округ, Свердловская область',
            'duration' => 6,
            'features' => ['Проживание в отелях 3*', 'Завтраки и обеды', 'Экскурсии по музеям', 'Посещение природных парков', 'Мастер-классы по камнеобработке'],
            'available_seats' => 22
        ]);
        
        // Тур по Северному Кавказу
        $caucasusStartDate = Carbon::create(null, rand(5, 9), rand(1, 28));
        Tour::create([
            'name' => 'Величественный Кавказ',
            'type' => 'Горный',
            'season' => 'Лето',
            'description' => 'Путешествие по живописным горным маршрутам Кавказа. Завораживающие виды Эльбруса, минеральные источники Пятигорска и самобытная культура горных народов.',
            'image' => 'img/tours/winter.jpg',
            'start_date' => $caucasusStartDate,
            'end_date' => $caucasusStartDate->copy()->addDays(8),
            'data' => $caucasusStartDate,
            'price' => 48000,
            'location' => 'Россия, Северо-Кавказский федеральный округ, Кабардино-Балкария, Карачаево-Черкесия',
            'duration' => 8,
            'features' => ['Проживание в гостиницах', 'Трехразовое питание', 'Подъем на канатной дороге', 'Дегустация национальных блюд', 'Фольклорная программа'],
            'available_seats' => 20
        ]);
    }

    /**
     * Создать туры для разных возрастных групп
     */
    private function createAgeCategoryTours(): void
    {
        // Тур для дошкольников (3-6 лет)
        $preschoolStartDate = Carbon::create(null, 7, rand(1, 28));
        Tour::create([
            'name' => 'Детская сказочная деревня',
            'type' => 'Детский',
            'season' => 'Лето',
            'description' => 'Увлекательный тур для самых маленьких путешественников. Анимационные программы с любимыми сказочными героями, творческие мастер-классы, игры на свежем воздухе и много веселья!',
            'image' => 'img/tours/plyazh.jpg',
            'start_date' => $preschoolStartDate,
            'end_date' => $preschoolStartDate->copy()->addDays(5),
            'data' => $preschoolStartDate,
            'price' => 30000,
            'location' => 'Россия, Московская область, Детский развлекательный комплекс',
            'duration' => 5,
            'features' => ['Проживание с родителями', 'Питание 5 раз в день', 'Анимационная программа', 'Развивающие занятия', 'Детская игровая площадка'],
            'available_seats' => 30,
            'min_age' => 3,
            'max_age' => 6,
            'audience_type' => 'preschool'
        ]);
        
        // Тур для школьников (7-17 лет)
        $schoolStartDate = Carbon::create(null, 6, rand(1, 28));
        Tour::create([
            'name' => 'Летний образовательный лагерь',
            'type' => 'Образовательный',
            'season' => 'Лето',
            'description' => 'Познавательный тур для школьников, сочетающий отдых и образовательные программы. Занятия по робототехнике, английскому языку, спортивные мероприятия и экскурсии.',
            'image' => 'img/tours/kazan.jpg',
            'start_date' => $schoolStartDate,
            'end_date' => $schoolStartDate->copy()->addDays(14),
            'data' => $schoolStartDate,
            'price' => 45000,
            'location' => 'Россия, Крым, Детский лагерь',
            'duration' => 14,
            'features' => ['Проживание в комфортабельных корпусах', 'Пятиразовое питание', 'Образовательные программы', 'Спортивные мероприятия', 'Экскурсии'],
            'available_seats' => 40,
            'min_age' => 7,
            'max_age' => 17,
            'audience_type' => 'school'
        ]);
        
        // Тур для взрослых (18+)
        $adultStartDate = Carbon::create(null, 9, rand(1, 28));
        Tour::create([
            'name' => 'Винный тур по Краснодарскому краю',
            'type' => 'Гастрономический',
            'season' => 'Осень',
            'description' => 'Эксклюзивный тур для ценителей вина. Посещение лучших винодельческих хозяйств Краснодарского края, дегустации, мастер-классы по сочетанию вин и блюд.',
            'image' => 'img/tours/more.jpg',
            'start_date' => $adultStartDate,
            'end_date' => $adultStartDate->copy()->addDays(7),
            'data' => $adultStartDate,
            'price' => 58000,
            'location' => 'Россия, Краснодарский край, Анапа, Геленджик',
            'duration' => 7,
            'features' => ['Проживание в винодельческих хозяйствах', 'Трехразовое питание', 'Дегустации вин', 'Мастер-классы', 'Экскурсии по виноградникам'],
            'available_seats' => 20,
            'min_age' => 18,
            'max_age' => 99,
            'audience_type' => 'adult'
        ]);
    }
    
    /**
     * Создать тестовые экскурсии
     */
    private function createExcursions(): void
    {
        // Экскурсии в Центральной России
        Excursion::create([
            'name' => 'Московский Кремль и Красная площадь',
            'description' => 'Обзорная экскурсия по историческому центру Москвы. Вы увидите главные достопримечательности столицы, посетите территорию Кремля и узнаете много интересного об истории России.',
            'location' => 'Москва, Красная площадь',
            'region' => 'Россия, Центральный федеральный округ',
            'duration' => 1,
            'price' => 2500,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 0,
            'max_age' => 99,
            'available_seats' => 30,
            'features' => ['Услуги гида', 'Входные билеты в Кремль', 'Аудиогид', 'Фотографии'],
            'start_date' => '2025-06-29',
            'end_date' => '2025-12-31',
        ]);
        
        // Экскурсия на Дальнем Востоке
        Excursion::create([
            'name' => 'Долина гейзеров на Камчатке',
            'description' => 'Уникальная экскурсия в одно из самых удивительных мест России — Долину гейзеров. Вы увидите множество гейзеров, горячих источников и грязевых котлов в окружении потрясающих ландшафтов.',
            'location' => 'Камчатский край, Долина гейзеров',
            'region' => 'Россия, Дальневосточный федеральный округ',
            'duration' => 1,
            'price' => 15000,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'adults',
            'min_age' => 12,
            'max_age' => 99,
            'available_seats' => 15,
            'features' => ['Вертолетная экскурсия', 'Услуги гида-инструктора', 'Обед', 'Экологический сбор'],
            'start_date' => '2025-07-15',
            'end_date' => '2025-09-15',
        ]);
        
        // Экскурсия в Сибири
        Excursion::create([
            'name' => 'Круиз по Байкалу',
            'description' => 'Морская прогулка по самому глубокому озеру мира. Вы посетите остров Ольхон, мыс Бурхан, увидите знаменитые байкальские пейзажи и познакомитесь с уникальной экосистемой Байкала.',
            'location' => 'Иркутская область, озеро Байкал',
            'region' => 'Россия, Сибирский федеральный округ',
            'duration' => 1,
            'price' => 5000,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 6,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Круиз на комфортабельном судне', 'Услуги гида', 'Обед на борту', 'Посещение смотровых площадок'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-10-15',
        ]);
        
        // Экскурсия для дошкольников
        Excursion::create([
            'name' => 'В гостях у сказки',
            'description' => 'Интерактивная экскурсия для самых маленьких туристов. Путешествие по мотивам любимых сказок с участием аниматоров, игры, конкурсы и сладкие подарки.',
            'location' => 'Москва, Детский парк развлечений',
            'region' => 'Россия, Центральный федеральный округ',
            'duration' => 0.5,
            'price' => 1500,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'preschool',
            'min_age' => 3,
            'max_age' => 6,
            'available_seats' => 25,
            'features' => ['Аниматоры в костюмах', 'Развлекательная программа', 'Мастер-класс', 'Сладкий подарок', 'Фотографии'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-12-31',
        ]);
        
        // Экскурсия для школьников
        Excursion::create([
            'name' => 'Космический музей',
            'description' => 'Познавательная экскурсия в музей космонавтики. Школьники узнают об истории покорения космоса, увидят настоящие космические аппараты и смогут почувствовать себя космонавтами.',
            'location' => 'Москва, Музей космонавтики',
            'region' => 'Россия, Центральный федеральный округ',
            'duration' => 1,
            'price' => 1200,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'school',
            'min_age' => 7,
            'max_age' => 17,
            'available_seats' => 30,
            'features' => ['Экскурсионное обслуживание', 'Входные билеты', 'Интерактивная программа', 'Образовательные материалы'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-12-31',
        ]);
        
        // Экскурсия для взрослых
        Excursion::create([
            'name' => 'Вечерний Санкт-Петербург с разводом мостов',
            'description' => 'Романтическая экскурсия по ночному Санкт-Петербургу. Вы увидите главные достопримечательности города в красивой подсветке и знаменитое зрелище — развод мостов над Невой.',
            'location' => 'Санкт-Петербург, Нева',
            'region' => 'Россия, Северо-Западный федеральный округ',
            'duration' => 1,
            'price' => 3000,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'adult',
            'min_age' => 18,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Прогулка на теплоходе', 'Экскурсионное обслуживание', 'Бокал шампанского', 'Фотографии на фоне разведенных мостов'],
            'start_date' => '2025-06-28',
            'end_date' => '2025-08-31',
        ]);
        
        // НОВЫЕ ЭКСКУРСИИ (Добавлены дополнительные регионы и продолжительности)
        
        // Южный федеральный округ - 2 дня
        Excursion::create([
            'name' => 'Винные долины Краснодарского края',
            'description' => 'Двухдневный тур по лучшим винодельням Краснодарского края. Вы посетите знаменитые виноградники, продегустируете премиальные вина и узнаете все о процессе виноделия.',
            'location' => 'Краснодарский край, Абрау-Дюрсо',
            'region' => 'Россия, Южный федеральный округ',
            'duration' => 2,
            'price' => 8500,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'adult',
            'min_age' => 18,
            'max_age' => 99,
            'available_seats' => 18,
            'features' => ['Проживание в отеле 4*', 'Дегустация вин', 'Экскурсия по винодельням', 'Гастрономический ужин', 'Трансфер'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Южный федеральный округ - 3 дня
        Excursion::create([
            'name' => 'Побережье Чёрного моря',
            'description' => 'Трехдневная экскурсия по живописному побережью Черного моря от Анапы до Сочи. Вы увидите лучшие пляжи, природные достопримечательности и курортные города.',
            'location' => 'Краснодарский край, Сочи, Анапа, Геленджик',
            'region' => 'Россия, Южный федеральный округ',
            'duration' => 3,
            'price' => 12000,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'all',
            'min_age' => 0,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Проживание в отелях', 'Экскурсионное обслуживание', 'Посещение пляжей', 'Морская прогулка', 'Дегустация местных деликатесов'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Северо-Западный федеральный округ - 2 дня
        Excursion::create([
            'name' => 'Петергоф и Кронштадт',
            'description' => 'Двухдневная экскурсия по пригородам Санкт-Петербурга. Вы посетите знаменитый дворцово-парковый ансамбль Петергофа с фонтанами и морскую крепость Кронштадт.',
            'location' => 'Санкт-Петербург, Петергоф, Кронштадт',
            'region' => 'Россия, Северо-Западный федеральный округ',
            'duration' => 2,
            'price' => 7500,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'all',
            'min_age' => 5,
            'max_age' => 99,
            'available_seats' => 25,
            'features' => ['Входные билеты', 'Экскурсионное обслуживание', 'Проживание', 'Трансфер', 'Фотографии'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Северо-Западный федеральный округ - 3 дня
        Excursion::create([
            'name' => 'Карельские красоты',
            'description' => 'Трехдневный тур по живописной Карелии. Вы посетите водопад Кивач, мраморный каньон Рускеала, старинные деревни и познакомитесь с культурой края.',
            'location' => 'Республика Карелия, Петрозаводск, Рускеала',
            'region' => 'Россия, Северо-Западный федеральный округ',
            'duration' => 3,
            'price' => 13500,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 6,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Проживание в коттеджах', 'Экскурсионное обслуживание', 'Дегустация карельской кухни', 'Посещение водопадов и каньонов', 'Мастер-класс по выпечке калиток'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Уральский федеральный округ - 1 день
        Excursion::create([
            'name' => 'Граница Европы и Азии',
            'description' => 'Однодневная экскурсия к знаменитому обелиску, обозначающему границу между Европой и Азией. Вы узнаете об истории Урала и сможете сделать уникальные фотографии.',
            'location' => 'Свердловская область, Екатеринбург',
            'region' => 'Россия, Уральский федеральный округ',
            'duration' => 1,
            'price' => 2000,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'all',
            'min_age' => 0,
            'max_age' => 99,
            'available_seats' => 30,
            'features' => ['Транспортное обслуживание', 'Экскурсовод', 'Сертификат о посещении', 'Обед', 'Фотосессия'],
            'start_date' => '2025-06-29',
            'end_date' => '2025-12-31',
        ]);
        
        // Уральский федеральный округ - 2 дня
        Excursion::create([
            'name' => 'Горнозаводской Урал',
            'description' => 'Двухдневная экскурсия по историческим горным заводам Урала. Вы посетите старинные предприятия, узнаете о промышленной истории региона и увидите красивейшие пейзажи.',
            'location' => 'Свердловская область, Нижний Тагил, Невьянск',
            'region' => 'Россия, Уральский федеральный округ',
            'duration' => 2,
            'price' => 6500,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'all',
            'min_age' => 7,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Проживание', 'Экскурсии по заводам', 'Мастер-классы по обработке камня', 'Музей горнозаводской техники', 'Дегустация уральской кухни'],
            'start_date' => '2025-07-15',
            'end_date' => '2025-10-31',
        ]);
        
        // Северо-Кавказский федеральный округ - 1 день
        Excursion::create([
            'name' => 'Загадки Эльбруса',
            'description' => 'Однодневная экскурсия на Эльбрус с подъёмом на канатной дороге. Вы увидите высочайшую гору Европы, познакомитесь с природой и культурой кавказских народов.',
            'location' => 'Кабардино-Балкария, Приэльбрусье',
            'region' => 'Россия, Северо-Кавказский федеральный округ',
            'duration' => 1,
            'price' => 4000,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 5,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Билеты на канатную дорогу', 'Экскурсионное обслуживание', 'Обед в горном ресторане', 'Фотосессия', 'Сертификат о посещении Эльбруса'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Северо-Кавказский федеральный округ - 3 дня
        Excursion::create([
            'name' => 'Легенды Северного Кавказа',
            'description' => 'Трехдневное путешествие по горным аулам Кавказа. Вы посетите древние поселения, познакомитесь с традициями и обычаями местных жителей, попробуете национальную кухню.',
            'location' => 'Дагестан, Карачаево-Черкесия, Кабардино-Балкария',
            'region' => 'Россия, Северо-Кавказский федеральный округ',
            'duration' => 3,
            'price' => 15000,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'all',
            'min_age' => 7,
            'max_age' => 99,
            'available_seats' => 15,
            'features' => ['Проживание в гостевых домах', 'Национальная кухня', 'Фольклорные программы', 'Посещение мастерских ремесленников', 'Дегустация местных блюд'],
            'start_date' => '2025-06-29',
            'end_date' => '2025-09-30',
        ]);
        
        // Приволжский федеральный округ - 1 день
        Excursion::create([
            'name' => 'Казанский Кремль',
            'description' => 'Однодневная экскурсия по Казанскому Кремлю — объекту Всемирного наследия ЮНЕСКО. Вы увидите мечеть Кул-Шариф, башню Сююмбике и узнаете о многовековой истории Казани.',
            'location' => 'Республика Татарстан, Казань',
            'region' => 'Россия, Приволжский федеральный округ',
            'duration' => 1,
            'price' => 2000,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'all',
            'min_age' => 0,
            'max_age' => 99,
            'available_seats' => 30,
            'features' => ['Экскурсионное обслуживание', 'Входные билеты', 'Дегустация национальной кухни', 'Фотосессия', 'Сувениры'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-12-31',
        ]);
        
        // Приволжский федеральный округ - 2 дня
        Excursion::create([
            'name' => 'Нижегородские просторы',
            'description' => 'Двухдневная экскурсия по историческому центру Нижнего Новгорода и окрестностям. Вы посетите Кремль, увидите место слияния Волги и Оки, прогуляетесь по старинным улочкам.',
            'location' => 'Нижегородская область, Нижний Новгород',
            'region' => 'Россия, Приволжский федеральный округ',
            'duration' => 2,
            'price' => 7000,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 5,
            'max_age' => 99,
            'available_seats' => 25,
            'features' => ['Проживание в отеле', 'Экскурсии по городу', 'Посещение музея народных промыслов', 'Круиз по Волге', 'Мастер-класс по хохломской росписи'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Дальневосточный федеральный округ - 2 дня
        Excursion::create([
            'name' => 'Загадочный Сахалин',
            'description' => 'Двухдневная экскурсия по острову Сахалин. Вы увидите живописные бухты, познакомитесь с историей освоения острова и жизнью коренных народов.',
            'location' => 'Сахалинская область, Южно-Сахалинск',
            'region' => 'Россия, Дальневосточный федеральный округ',
            'duration' => 2,
            'price' => 18000,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'all',
            'min_age' => 7,
            'max_age' => 99,
            'available_seats' => 15,
            'features' => ['Проживание в гостинице', 'Экскурсионное обслуживание', 'Дегустация дальневосточной кухни', 'Посещение маяка Анива', 'Фотосессия в живописных местах'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Дальневосточный федеральный округ - 3 дня
        Excursion::create([
            'name' => 'Владивосток - восточная столица',
            'description' => 'Трехдневная экскурсия по главному городу Дальнего Востока и его окрестностям. Вы посетите знаменитые мосты, форты, маяки и морские бухты Владивостока.',
            'location' => 'Приморский край, Владивосток',
            'region' => 'Россия, Дальневосточный федеральный округ',
            'duration' => 3,
            'price' => 22000,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'all',
            'min_age' => 6,
            'max_age' => 99,
            'available_seats' => 20,
            'features' => ['Проживание в отеле 4*', 'Экскурсии по городу', 'Морская прогулка', 'Дегустация морепродуктов', 'Посещение острова Русский'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Сибирский федеральный округ - 2 дня
        Excursion::create([
            'name' => 'Красноярские Столбы',
            'description' => 'Двухдневная экскурсия в национальный парк "Красноярские столбы". Вы увидите знаменитые скалы с причудливыми формами и насладитесь красотами сибирской природы.',
            'location' => 'Красноярский край, Красноярск',
            'region' => 'Россия, Сибирский федеральный округ',
            'duration' => 2,
            'price' => 8500,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 7,
            'max_age' => 99,
            'available_seats' => 15,
            'features' => ['Проживание на турбазе', 'Экологические тропы', 'Услуги гида-инструктора', 'Фотосессия', 'Посещение смотровых площадок'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Сибирский федеральный округ - 3 дня
        Excursion::create([
            'name' => 'Алтайская сказка',
            'description' => 'Трехдневное путешествие по живописным местам Алтая. Вы посетите Телецкое озеро, долину реки Чулышман, водопады и древние курганы.',
            'location' => 'Республика Алтай, Телецкое озеро',
            'region' => 'Россия, Сибирский федеральный округ',
            'duration' => 3,
            'price' => 16000,
            'image' => 'excursions/excursion3.jpg',
            'audience_type' => 'all',
            'min_age' => 7,
            'max_age' => 99,
            'available_seats' => 15,
            'features' => ['Проживание в гостевых домах', 'Экскурсии по природным достопримечательностям', 'Круиз по Телецкому озеру', 'Посещение водопадов', 'Мастер-класс по алтайской кухне'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Центральный федеральный округ - 2 дня
        Excursion::create([
            'name' => 'Усадьбы Подмосковья',
            'description' => 'Двухдневная экскурсия по старинным усадьбам Подмосковья. Вы посетите Архангельское, Абрамцево и Мураново, познакомитесь с историей дворянских гнезд.',
            'location' => 'Московская область, Архангельское, Абрамцево',
            'region' => 'Россия, Центральный федеральный округ',
            'duration' => 2,
            'price' => 6500,
            'image' => 'excursions/1.jpg',
            'audience_type' => 'all',
            'min_age' => 6,
            'max_age' => 99,
            'available_seats' => 25,
            'features' => ['Проживание в гостинице', 'Входные билеты в усадьбы', 'Экскурсионное обслуживание', 'Мастер-класс по живописи', 'Чаепитие в дворянском стиле'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
        
        // Центральный федеральный округ - 3 дня
        Excursion::create([
            'name' => 'Золотое кольцо России',
            'description' => 'Трехдневная экскурсия по древним городам Золотого кольца: Суздаль, Владимир, Ярославль. Вы увидите уникальные памятники архитектуры и узнаете о истории Древней Руси.',
            'location' => 'Владимирская область, Ярославская область',
            'region' => 'Россия, Центральный федеральный округ',
            'duration' => 3,
            'price' => 14000,
            'image' => 'excursions/excursion2.jpg',
            'audience_type' => 'all',
            'min_age' => 5,
            'max_age' => 99,
            'available_seats' => 30,
            'features' => ['Проживание в отелях', 'Экскурсии по городам', 'Посещение монастырей и кремлей', 'Мастер-классы народных промыслов', 'Дегустация медовухи'],
            'start_date' => '2025-07-01',
            'end_date' => '2025-09-30',
        ]);
    }
}
