<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourCalculatorController extends Controller
{
    /**
     * Отображает страницу калькулятора туров
     */
    public function index()
    {
        // Получаем данные для отображения на странице калькулятора
        $countries = $this->getCountries();
        
        return view('calculate', compact('countries'));
    }
    
    /**
     * Возвращает список курортов по выбранной стране
     */
    public function getResorts(Request $request)
    {
        $country = $request->input('country');
        
        if (!$country) {
            return response()->json(['error' => 'Требуется указать страну'], 400);
        }
        
        $resorts = $this->getResortsByCountry($country);
        
        return response()->json($resorts);
    }
    
    /**
     * Возвращает список отелей по выбранному курорту
     */
    public function getHotels(Request $request)
    {
        $data = $request->all();
        
        if (!isset($data['resort']) || empty($data['resort'])) {
            return response()->json(['error' => 'Требуется указать курорт'], 400);
        }
        
        $resort = $data['resort'];
        $hotelClass = $data['hotelClass'] ?? 'стандарт';
        $tourType = $data['tourType'] ?? 'beach';
        
        $hotels = $this->getHotelsByResort($resort, $hotelClass, $tourType);
        
        return response()->json($hotels);
    }
    
    /**
     * Расчет стоимости тура
     */
    public function calculate(Request $request)
    {
        // Получаем все необходимые данные из запроса
        $data = $request->all();
        
        // Рассчитываем стоимость тура
        $result = $this->calculateTourPrice($data);
        
        return response()->json($result);
    }
    
    /**
     * Список стран
     */
    private function getCountries()
    {
        return [
            'Россия' => 'Россия',
            'Турция' => 'Турция',
            'Египет' => 'Египет',
            'ОАЭ' => 'ОАЭ',
            'Таиланд' => 'Таиланд',
            'Кипр' => 'Кипр',
            'Греция' => 'Греция',
            'Тунис' => 'Тунис',
            'Мальдивы' => 'Мальдивы',
            'Испания' => 'Испания',
            'Италия' => 'Италия',
            'Черногория' => 'Черногория'
        ];
    }
    
    /**
     * Список курортов по стране
     */
    private function getResortsByCountry($country)
    {
        $resorts = [
            'Россия' => [
                'Сочи', 'Крым', 'Калининград', 'Геленджик', 
                'Анапа', 'Санкт-Петербург', 'Байкал', 'Алтай',
                'Домбай', 'Шерегеш', 'Красная Поляна', 'Кавказские Минеральные Воды'
            ],
            'Турция' => [
                'Анталия', 'Бодрум', 'Стамбул', 'Кемер', 
                'Алания', 'Мармарис', 'Фетхие', 'Сиде',
                'Белек', 'Измир', 'Кушадасы', 'Каппадокия'
            ],
            'Египет' => [
                'Шарм-эль-Шейх', 'Хургада', 'Дахаб', 'Марса-Алам',
                'Эль-Гуна', 'Таба', 'Луксор', 'Каир'
            ],
            'ОАЭ' => [
                'Дубай', 'Абу-Даби', 'Шарджа', 'Рас-эль-Хайма',
                'Фуджейра', 'Аджман', 'Умм-аль-Кувейн'
            ],
            'Таиланд' => [
                'Пхукет', 'Паттайя', 'Самуи', 'Бангкок',
                'Краби', 'Чианг-Май', 'Хуа-Хин', 'Ко Чанг'
            ],
            'Кипр' => [
                'Айя-Напа', 'Пафос', 'Ларнака', 'Лимассол',
                'Протарас', 'Никосия', 'Полис'
            ],
            'Греция' => [
                'Афины', 'Родос', 'Крит', 'Корфу',
                'Санторини', 'Закинф', 'Халкидики', 'Салоники'
            ],
            'Тунис' => [
                'Хаммамет', 'Сусс', 'Монастир', 'Джерба',
                'Махдия', 'Табарка', 'Тунис'
            ],
            'Мальдивы' => [
                'Мале', 'Атолл Ари', 'Атолл Баа', 'Атолл Адду'
            ],
            'Испания' => [
                'Барселона', 'Мадрид', 'Майорка', 'Ибица',
                'Тенерифе', 'Коста Брава', 'Коста Дорада', 'Гран-Канария'
            ],
            'Италия' => [
                'Рим', 'Венеция', 'Флоренция', 'Милан',
                'Сицилия', 'Сардиния', 'Неаполь', 'Римини'
            ],
            'Черногория' => [
                'Будва', 'Котор', 'Тиват', 'Герцег-Нови',
                'Бар', 'Ульцинь', 'Свети-Стефан', 'Петровац'
            ]
        ];
        
        return isset($resorts[$country]) ? $resorts[$country] : [];
    }
    
    /**
     * Список отелей по курорту с учетом класса и типа тура
     */
    private function getHotelsByResort($resort, $hotelClass, $tourType)
    {
        // Здесь мы генерируем отели в зависимости от курорта
        // В реальном приложении это должен быть запрос к базе данных
        
        $hotelsByResort = [
            'Сочи' => [
                [
                    'name' => 'Radisson Blu Resort & Congress Centre',
                    'location' => 'Адлер, Сочи',
                    'stars' => 5,
                    'price' => 15000,
                    'image' => '/img/image 5.jpg',
                    'reviews' => '8.9 Отлично (1240 отзывов)',
                    'filters' => 'all,pool,beach',
                    // Добавляем близость к морю
                    'seaProximity' => 'first-line',
                    // Добавляем детальную информацию для модального окна
                    'rating' => 8.9,
                    'reviewsCount' => 1240,
                    'description' => 'Роскошный пятизвездочный комплекс с прямым выходом к морю. Отель предлагает элегантные номера, спа-центр, несколько ресторанов, открытый и крытый бассейны.',
                    'images' => [
                        '/img/image 5.jpg',
                        '/img/62a08e6ba6c5ba488f30d07e.jpg',
                        '/img/59.jpg',
                        '/img/BKPQSJucT0c 1.jpg'
                    ],
                    'features' => [
                        'Проживание в номере выбранной категории',
                        'Питание "шведский стол"',
                        'Спа-центр и крытый бассейн',
                        'Тренажерный зал',
                        'Бесплатный Wi-Fi',
                        'Частный пляж'
                    ]
                ],
                [
                    'name' => 'Роза Хутор Отель',
                    'location' => 'Роза Хутор, Сочи',
                    'stars' => 4,
                    'price' => 12000,
                    'image' => '/img/62a08e6ba6c5ba488f30d07e.jpg',
                    'reviews' => '9.1 Превосходно (980 отзывов)',
                    'filters' => 'all,pool,family',
                    // Добавляем близость к морю
                    'seaProximity' => 'over-500',
                    // Добавляем детальную информацию для модального окна
                    'rating' => 9.1,
                    'reviewsCount' => 980,
                    'description' => 'Отель в горах с прекрасными видами на горные склоны. Идеальное место для активного отдыха и занятий горнолыжным спортом зимой или пеших походов летом.',
                    'images' => [
                        '/img/62a08e6ba6c5ba488f30d07e.jpg',
                        '/img/image 5.jpg',
                        '/img/59.jpg',
                        '/img/BKPQSJucT0c 1.jpg'
                    ],
                    'features' => [
                        'Проживание в отеле 4*',
                        'Питание "завтрак"',
                        'Бесплатный Wi-Fi',
                        'Трансфер до подъемников',
                        'Услуги хранения горнолыжного оборудования',
                        'Спа-центр'
                    ]
                ],
                [
                    'name' => 'Swissôtel Resort Sochi Kamelia',
                    'location' => 'Центральный район, Сочи',
                    'stars' => 5,
                    'price' => 18000,
                    'image' => '/img/59.jpg',
                    'reviews' => '9.3 Превосходно (760 отзывов)',
                    'filters' => 'all,beach,center,pool',
                    // Добавляем близость к морю
                    'seaProximity' => 'first-line',
                    // Добавляем детальную информацию для модального окна
                    'rating' => 9.3,
                    'reviewsCount' => 760,
                    'description' => 'Элегантный пятизвездочный курорт на побережье Черного моря. Отель расположен в живописном парке с вековыми деревьями и предлагает роскошные номера с видом на море.',
                    'images' => [
                        '/img/59.jpg',
                        '/img/image 5.jpg',
                        '/img/62a08e6ba6c5ba488f30d07e.jpg',
                        '/img/BKPQSJucT0c 1.jpg'
                    ],
                    'features' => [
                        'Проживание в роскошном отеле 5*',
                        'Питание "полупансион"',
                        'Открытый бассейн с подогревом',
                        'Спа-центр Pürovel',
                        'Частный пляж',
                        'Трансфер из/в аэропорт'
                    ]
                ],
                [
                    'name' => 'Hyatt Regency Sochi',
                    'location' => 'Центральный район, Сочи',
                    'stars' => 5,
                    'price' => 16500,
                    'image' => '/img/BKPQSJucT0c 1.jpg',
                    'reviews' => '9.0 Превосходно (1100 отзывов)',
                    'filters' => 'all,center,pool',
                    // Добавляем близость к морю
                    'seaProximity' => 'up-to-500',
                    // Добавляем детальную информацию для модального окна
                    'rating' => 9.0,
                    'reviewsCount' => 1100,
                    'description' => 'Современный отель с панорамным видом на море, расположенный в центре города. Отель предлагает просторные номера, открытый бассейн и несколько ресторанов.',
                    'images' => [
                        '/img/BKPQSJucT0c 1.jpg',
                        '/img/image 5.jpg',
                        '/img/62a08e6ba6c5ba488f30d07e.jpg',
                        '/img/59.jpg'
                    ],
                    'features' => [
                        'Проживание в номере выбранной категории',
                        'Питание "завтрак"',
                        'Открытый бассейн с морской водой',
                        'Фитнес-центр',
                        'Спа-центр Evania',
                        'Бесплатный Wi-Fi'
                    ]
                ],
                [
                    'name' => 'Отель Бархатные Сезоны',
                    'location' => 'Имеретинская низменность, Сочи',
                    'stars' => 3,
                    'price' => 5500,
                    'image' => '/img/sayMGFc-uGI 2.png',
                    'reviews' => '8.2 Очень хорошо (2300 отзывов)',
                    'filters' => 'all,beach,family',
                    // Добавляем близость к морю
                    'seaProximity' => 'up-to-500',
                    // Добавляем детальную информацию для модального окна
                    'rating' => 8.2,
                    'reviewsCount' => 2300,
                    'description' => 'Комфортабельный отель в Олимпийском парке, в нескольких минутах ходьбы от моря. Отель предлагает современные номера, кафе и рестораны, а также близость к основным достопримечательностям.',
                    'images' => [
                        '/img/sayMGFc-uGI 2.png',
                        '/img/image 5.jpg',
                        '/img/62a08e6ba6c5ba488f30d07e.jpg',
                        '/img/59.jpg'
                    ],
                    'features' => [
                        'Проживание в отеле 3*',
                        'Питание по выбору',
                        'Близость к пляжу (350м)',
                        'Трансфер до центра города',
                        'Бесплатная парковка',
                        'Бесплатный Wi-Fi'
                    ]
                ]
            ],
            'Анталия' => [
                [
                    'name' => 'Rixos Premium Belek',
                    'location' => 'Белек, Анталия',
                    'stars' => 5,
                    'price' => 25000,
                    'image' => '/img/image 6.jpg',
                    'reviews' => '9.4 Превосходно (1560 отзывов)',
                    'filters' => 'all,beach,pool,family'
                ],
                [
                    'name' => 'Titanic Beach Lara',
                    'location' => 'Лара, Анталия',
                    'stars' => 5,
                    'price' => 20000,
                    'image' => '/img/image 8.jpg',
                    'reviews' => '8.9 Отлично (2100 отзывов)',
                    'filters' => 'all,beach,pool,family'
                ],
                [
                    'name' => 'Calista Luxury Resort',
                    'location' => 'Белек, Анталия',
                    'stars' => 5,
                    'price' => 28000,
                    'image' => '/img/image 7.jpg',
                    'reviews' => '9.2 Превосходно (980 отзывов)',
                    'filters' => 'all,beach,pool'
                ],
                [
                    'name' => 'Barut Lara',
                    'location' => 'Лара, Анталия',
                    'stars' => 5,
                    'price' => 22000,
                    'image' => '/img/YiVpT7_kdsw 1.png',
                    'reviews' => '9.0 Превосходно (1300 отзывов)',
                    'filters' => 'all,beach,pool'
                ],
                [
                    'name' => 'IC Hotels Green Palace',
                    'location' => 'Кунду, Анталия',
                    'stars' => 5,
                    'price' => 19000,
                    'image' => '/img/7nlvLmnwPIo.png',
                    'reviews' => '8.7 Отлично (1850 отзывов)',
                    'filters' => 'all,beach,family'
                ]
            ]
        ];
        
        // Проверяем, есть ли отели для данного курорта
        $hotels = isset($hotelsByResort[$resort]) ? $hotelsByResort[$resort] : [];
        
        // Если отелей нет, генерируем случайные отели
        if (empty($hotels)) {
            $hotels = $this->generateRandomHotels($resort, $hotelClass, $tourType);
        }
        
        return $hotels;
    }
    
    /**
     * Генерирует случайные отели для курорта
     */
    private function generateRandomHotels($resort, $hotelClass, $tourType)
    {
        $hotels = [];
        $hotelNames = [
            'Royal Resort & Spa', 'Grand Hotel', 'Luxury Palace', 
            'Ocean View', 'Imperial Resort', 'Sun Paradise',
            'Golden Beach', 'Diamond Resort', 'Crystal Palace',
            'Azure Sky Hotel', 'Emerald Bay Resort'
        ];
        
        $hotelTypes = [
            'beach' => ['У моря', 'С видом на океан', 'Пляжный', 'С собственным пляжем'],
            'excursion' => ['В центре города', 'Рядом с достопримечательностями', 'Исторический', 'Бутик-отель'],
            'skiing' => ['У подъемника', 'С видом на горы', 'Лыжный курорт', 'Шале'],
            'health' => ['СПА-отель', 'Оздоровительный', 'С термальными источниками', 'Wellness Resort'],
            'cruise' => ['Морской курорт', 'С пристанью', 'Яхт-клуб', 'С видом на залив']
        ];
        
        $filters = [
            'beach' => 'beach',
            'excursion' => 'center',
            'skiing' => 'pool',
            'health' => 'pool',
            'cruise' => 'beach'
        ];
        
        $stars = [
            'эконом' => [2, 3],
            'стандарт' => [3, 4],
            'комфорт' => [4],
            'люкс' => [5]
        ];
        
        $prices = [
            'эконом' => [3000, 7000],
            'стандарт' => [7000, 15000],
            'комфорт' => [15000, 25000],
            'люкс' => [25000, 50000]
        ];
        
        // Доступные изображения для отелей
        $hotelImages = [
            '/img/image 5.jpg',
            '/img/image 6.jpg',
            '/img/image 7.jpg',
            '/img/image 8.jpg',
            '/img/BKPQSJucT0c 1.jpg',
            '/img/62a08e6ba6c5ba488f30d07e.jpg',
            '/img/59.jpg'
        ];
        
        // Генерируем 5 отелей
        for ($i = 0; $i < 5; $i++) {
            $name = $hotelNames[array_rand($hotelNames)] . ' ' . $resort;
            $type = $tourType;
            $typePrefix = isset($hotelTypes[$type]) ? $hotelTypes[$type][array_rand($hotelTypes[$type])] : '';
            $starsCount = $stars[$hotelClass][array_rand($stars[$hotelClass])];
            $priceRange = $prices[$hotelClass];
            $price = rand($priceRange[0], $priceRange[1]);
            $review = number_format(rand(70, 95) / 10, 1);
            $reviewCount = rand(100, 2000);
            $reviewText = $review >= 9 ? 'Превосходно' : ($review >= 8 ? 'Отлично' : 'Очень хорошо');
            
            $filterType = $filters[$type] ?? 'all';
            $allFilters = ['all'];
            $allFilters[] = $filterType;
            if (rand(0, 1)) $allFilters[] = 'family';
            if (rand(0, 1) && $filterType != 'pool') $allFilters[] = 'pool';
            
            $hotels[] = [
                'name' => $name,
                'location' => $typePrefix . ', ' . $resort,
                'stars' => $starsCount,
                'price' => $price,
                'image' => $hotelImages[array_rand($hotelImages)],
                'reviews' => $review . ' ' . $reviewText . ' (' . $reviewCount . ' отзывов)',
                'filters' => implode(',', $allFilters)
            ];
        }
        
        return $hotels;
    }
    
    /**
     * Расчет стоимости тура
     */
    private function calculateTourPrice($data)
    {
        // Базовые цены для стран
        $basePrice = [
            'Россия' => 10000,
            'Турция' => 30000,
            'Египет' => 40000,
            'ОАЭ' => 60000,
            'Таиланд' => 70000,
            'Кипр' => 50000,
            'Греция' => 55000,
            'Тунис' => 35000,
            'Мальдивы' => 120000,
            'Испания' => 65000,
            'Италия' => 70000,
            'Черногория' => 45000
        ];
        
        // Модификаторы для типов туров
        $tourTypeModifiers = [
            'beach' => 1.0,     // Пляжный - стандартная цена
            'excursion' => 1.1, // Экскурсионный - +10%
            'skiing' => 1.2,    // Горнолыжный - +20%
            'health' => 1.3,    // Оздоровительный - +30%
            'cruise' => 1.5     // Круиз - +50%
        ];
        
        // Получаем базовую цену для выбранной страны
        $price = $basePrice[$data['country']] ?? 40000;
        
        // Применяем модификатор типа тура
        $tourTypeModifier = $tourTypeModifiers[$data['tourType']] ?? 1.0;
        $price *= $tourTypeModifier;
        
        // Модификаторы для курортов (в процентах)
        $resortModifiers = [
            'Сочи' => 20,
            'Крым' => 10,
            'Анталия' => 15,
            'Бодрум' => 20,
            'Шарм-эль-Шейх' => 10,
            'Хургада' => 5,
            'Дубай' => 30,
            'Пхукет' => 20,
            // Заглушка для остальных курортов
            'default' => 10
        ];
        
        // Применяем модификатор курорта
        $resortModifier = $resortModifiers[$data['resort']] ?? $resortModifiers['default'];
        $price = $price * (1 + $resortModifier / 100);
        
        // Модификаторы для класса отеля
        $hotelClassModifiers = [
            'эконом' => 1,
            'стандарт' => 1.3,
            'комфорт' => 1.6,
            'люкс' => 2.2
        ];
        
        // Применяем модификатор класса отеля
        $hotelClassModifier = $hotelClassModifiers[$data['hotelClass']] ?? 1.3;
        $price = $price * $hotelClassModifier;
        
        // Модификаторы для близости к морю
        $seaProximityModifiers = [
            'any' => 1.0,        // Любая - стандартная цена
            'first-line' => 1.3, // Первая линия - +30%
            'up-to-500' => 1.1,  // До 500 метров - +10%
            'over-500' => 0.9    // Более 500 метров - -10%
        ];
        
        // Применяем модификатор близости к морю
        $seaProximityModifier = $seaProximityModifiers[$data['seaProximity']] ?? 1.0;
        $price = $price * $seaProximityModifier;
        
        // Базовая цена (без учета количества ночей и туристов)
        $basePrice = $price;
        
        // Учитываем количество ночей
        $accommodationPrice = $price * $data['nights'];
        
        // Модификаторы для типа питания
        $mealModifiers = [
            'без питания' => 0,
            'завтрак' => 1000,
            'полупансион' => 2000,
            'полный пансион' => 2800,
            'все включено' => 3500,
            'ультра всё включено' => 5000
        ];
        
        // Применяем модификатор питания
        $mealModifier = $mealModifiers[$data['meal']] ?? 0;
        $accommodationPrice += $mealModifier * $data['nights'];
        
        // Учитываем количество туристов
        $accommodationPrice *= $data['tourists'];
        
        // Дополнительные услуги
        $extrasPrice = 0;
        
        // Учитываем страховку
        if (isset($data['insurance']) && $data['insurance']) {
            $extrasPrice += 1500 * $data['tourists'];
        }
        
        // Учитываем трансфер
        if (isset($data['transfer']) && $data['transfer']) {
            $extrasPrice += 2000;
        }
        
        // Учитываем экскурсии
        if (isset($data['excursions']) && $data['excursions']) {
            $extrasPrice += 5000 * $data['tourists'];
        }
        
        // Учитываем VIP-обслуживание
        if (isset($data['vip']) && $data['vip']) {
            $extrasPrice += 15000;
        }
        
        // Учитываем сезонность (высокий/низкий сезон)
        $departureDate = new \DateTime($data['departureDate']);
        $month = (int)$departureDate->format('n');
        
        $seasonMultiplier = 1.0;
        
        // Высокий сезон для большинства направлений: июнь-август
        if ($month >= 6 && $month <= 8) {
            $seasonMultiplier = 1.2; // Повышение цены на 20% в высокий сезон
        } elseif ($month >= 11 || $month <= 2) {
            // Низкий сезон для большинства направлений: ноябрь-февраль
            $seasonMultiplier = 0.9; // Снижение цены на 10% в низкий сезон
        }
        
        // Применяем сезонный множитель ко всем ценам
        $accommodationPrice *= $seasonMultiplier;
        $extrasPrice *= $seasonMultiplier;
        
        // Скидка при раннем бронировании (за 90+ дней)
        $today = new \DateTime();
        $daysDiff = $today->diff($departureDate)->days;
        
        if ($daysDiff >= 90) {
            // Скидка 10% при раннем бронировании
            $accommodationPrice *= 0.9;
        } elseif ($daysDiff <= 7) {
            // Повышение цены на 5% при позднем бронировании
            $accommodationPrice *= 1.05;
        }
        
        // Общая стоимость тура
        $totalPrice = $accommodationPrice + $extrasPrice;
        
        // Округляем все цены до целых чисел
        $basePrice = round($basePrice);
        $accommodationPrice = round($accommodationPrice);
        $extrasPrice = round($extrasPrice);
        $totalPrice = round($totalPrice);
        
        return [
            'basePrice' => $basePrice,
            'accommodationPrice' => $accommodationPrice,
            'extrasPrice' => $extrasPrice,
            'totalPrice' => $totalPrice,
            'country' => $data['country'],
            'resort' => $data['resort'],
            'nights' => $data['nights'],
            'tourists' => $data['tourists'],
            'departureDate' => $data['departureDate'],
            'hotelClass' => $data['hotelClass'],
            'meal' => $data['meal'],
            'seaProximity' => $data['seaProximity'] ?? 'any'
        ];
    }
} 