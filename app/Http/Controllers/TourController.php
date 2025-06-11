<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TourController extends Controller
   
   {  public function index()
    {
        
        $newTours = Tour::orderBy('created_at', 'desc')->get();
        $upcomingTours = Tour::orderBy('start_date', 'asc')->where('start_date', '>', now())->get();
        $popularTours = Tour::orderBy('price', 'desc')->get();
        $summerTours = Tour::where('season', 'like', 'Лето%')->orWhere('season', 'like', 'лето%')->orWhere('season', 'like', '%летние%')->get();
        $winterTours = Tour::where('season', 'like', 'Зима%')->orWhere('season', 'like', 'зима%')->orWhere('season', 'like', '%зимние%')->get();
        $autumnTours = Tour::where('season', 'like', 'Осень%')->orWhere('season', 'like', 'осень%')->orWhere('season', 'like', '%осенние%')->get();
        $springTours = Tour::where('season', 'like', 'Весна%')->orWhere('season', 'like', 'весна%')->orWhere('season', 'like', '%весенние%')->get();

        // Если данных нет, используем демо-данные
        if ($newTours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            $newTours = $demoTours->sortByDesc('created_at');
        }
        
        if ($upcomingTours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            $upcomingTours = $demoTours->filter(function ($tour) {
                return Carbon::parse($tour->start_date)->isAfter(now());
            });
        }
        
        if ($popularTours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            $popularTours = $demoTours->sortByDesc('price');
        }
        
        if ($summerTours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            $summerTours = $demoTours->filter(function ($tour) {
                return $tour->season === 'Лето';
            });
        }
        
        if ($winterTours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            $winterTours = $demoTours->filter(function ($tour) {
                return $tour->season === 'Зима';
            });
        }
        
        if ($autumnTours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            $autumnTours = $demoTours->filter(function ($tour) {
                return $tour->season === 'Осень';
            });
        }
        
        if ($springTours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            $springTours = $demoTours->filter(function ($tour) {
                return $tour->season === 'Весна';
            });
        }

        return view('index', compact(
            'newTours',
            'upcomingTours',
            'popularTours',
            'summerTours',
            'winterTours',
            'autumnTours',
            'springTours'
        ));
    }

    /**
     * Отображает все туры с пагинацией.
     */
    public function showAll()
    {
        $tours = Tour::paginate(6); // Пагинация
        
        // Если данных нет, используем демо-данные
        if ($tours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            
            // Создаем пагинацию вручную
            $currentPage = request()->get('page', 1);
            $perPage = 6;
            $total = $demoTours->count();
            $items = $demoTours->forPage($currentPage, $perPage);
            
            // Создаем кастомный пагинатор
            $tours = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $currentPage,
                ['path' => request()->url()]
            );
        }
        
        return view('tours.all', compact('tours')); // Отдельное представление для списка всех туров
    }

    /**
     * Отображает детали одного тура.
     */
    public function show($id)
    {
        $tour = Tour::find($id);
        
        // Если тур не найден в базе, ищем в демо-данных
        if (!$tour) {
            $demoTours = collect($this->getDemoTours());
            $tour = $demoTours->firstWhere('id', (int)$id);
            
            if (!$tour) {
                abort(404);
            }
        }
        
        // Передаем модель напрямую в представление
        return view('tours.show', compact('tour'));
    }

    /**
     * Обрабатывает поисковый запрос.
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');
        $tours = Tour::where('name', 'like', '%' . $searchTerm . '%')->paginate(6);
        
        // Если данных нет, используем демо-данные
        if ($tours->isEmpty()) {
            $demoTours = collect($this->getDemoTours());
            
            $filteredTours = $demoTours->filter(function ($tour) use ($searchTerm) {
                return stripos($tour->name, $searchTerm) !== false;
            });
            
            // Создаем пагинацию вручную
            $currentPage = request()->get('page', 1);
            $perPage = 6;
            $total = $filteredTours->count();
            $items = $filteredTours->forPage($currentPage, $perPage);
            
            // Создаем кастомный пагинатор
            $tours = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $currentPage,
                ['path' => request()->url()]
            );
        }
        
        return view('tours.all', compact('tours')); //  Используем tours.all для результатов поиска
    }

    /**
     * Отображает форму для создания нового тура.
     */
    public function create()
    {
        return view('tours.create'); //  Отдельное представление для формы
    }

    /**
     * Сохраняет новый тур в базу данных.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'season' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'data' => 'required|date',
            'price' => 'required|integer',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('img/tours', $imageName, 'public');
        }

        $tour = Tour::create([
            'name' => $request->name,
            'season' => $request->season,
            'description' => $request->description,
            'image' => $imagePath,
            'data' => $request->data,
            'price' => $request->price,
        ]);

        if ($tour) {
            return redirect()->route('tours.show', $tour->id)->with('success', 'Тур успешно создан!'); // Перенаправляем на страницу тура
        } else {
            return back()->with('error', 'Ошибка при создании тура.');
        }
    }

    /**
     * Отображает форму (предположительно, для отправки запроса, а не для создания тура).
     */
    public function showForm()
    {
        return view('form');
    }

    /**
     * Отображает страницу с преимуществами.
     */
    public function showAdvantages()
    {
        return view('advantages');
    }

    /**
     * Получить демо-данные туров, когда БД пуста
     */
    private function getDemoTours()
    {
        $tours = [];
        
        // Создаем демо-туры
        $locations = [
            'Россия, Сочи',
            'Россия, Крым',
            'Россия, Байкал',
            'Россия, Алтай',
            'Турция, Анталия',
            'Турция, Стамбул',
            'Египет, Шарм-эль-Шейх',
            'Египет, Хургада',
            'Таиланд, Пхукет',
            'Кипр, Айя-Напа'
        ];
        
        $types = ['Пляжный', 'Экскурсионный', 'Горнолыжный', 'Оздоровительный', 'Круиз'];
        $seasons = ['Лето', 'Зима', 'Осень', 'Весна'];
        
        for ($i = 1; $i <= 20; $i++) {
            $locationIndex = array_rand($locations);
            $typeIndex = array_rand($types);
            $seasonIndex = array_rand($seasons);
            $location = $locations[$locationIndex];
            $type = $types[$typeIndex];
            $season = $seasons[$seasonIndex];
            
            // Генерируем описание в зависимости от типа тура
            $description = '';
            $features = [];
            
            switch ($type) {
                case 'Пляжный':
                    $description = "Великолепный пляжный отдых в {$location}. Вас ждут белоснежные пляжи, теплое море и комфортабельный отель.";
                    $features = ['Проживание в отеле 4*', 'Питание "все включено"', 'Трансфер из аэропорта', 'Пляжный отдых', 'Экскурсии'];
                    break;
                case 'Экскурсионный':
                    $description = "Увлекательный экскурсионный тур по достопримечательностям {$location}. Вы посетите самые интересные места и узнаете историю региона.";
                    $features = ['Проживание в отеле 4*', 'Завтраки', 'Экскурсионная программа', 'Русскоязычный гид', 'Входные билеты'];
                    break;
                case 'Горнолыжный':
                    $description = "Отличный горнолыжный отдых в {$location}. Великолепные склоны, современные подъемники и комфортабельный отель.";
                    $features = ['Проживание в отеле 4*', 'Завтраки', 'Ски-пасс на 6 дней', 'Трансфер из аэропорта', 'Прокат оборудования'];
                    break;
                case 'Оздоровительный':
                    $description = "Полезный для здоровья отдых в {$location}. Термальные источники, SPA-процедуры и оздоровительные программы.";
                    $features = ['Проживание в отеле 4*', 'Питание "полный пансион"', 'SPA-процедуры', 'Оздоровительная программа', 'Консультация врача'];
                    break;
                case 'Круиз':
                    $description = "Увлекательный круиз по самым красивым местам {$location}. Вас ждут комфортабельные каюты, развлекательная программа и экскурсии в портах захода.";
                    $features = ['Проживание в каюте', 'Полный пансион', 'Развлекательная программа', 'Экскурсии в портах', 'Бассейны и спортивные площадки'];
                    break;
            }
            
            // Определяем цену в зависимости от типа и сезона
            $basePrice = 30000;
            
            // Модификаторы цены в зависимости от типа тура
            $priceModifiers = [
                'Пляжный' => 1.0,
                'Экскурсионный' => 1.1,
                'Горнолыжный' => 1.3,
                'Оздоровительный' => 1.4,
                'Круиз' => 1.5
            ];
            
            // Модификаторы цены в зависимости от сезона
            $seasonModifiers = [
                'Лето' => 1.2,
                'Зима' => 1.0,
                'Осень' => 0.9,
                'Весна' => 1.0
            ];
            
            $price = $basePrice * $priceModifiers[$type] * $seasonModifiers[$season];
            
            // Создаем даты для туров
            $startOffset = rand(10, 60);
            $duration = rand(7, 14);
            
            // Создаем объект тура
            $tour = new \stdClass();
            $tour->id = $i;
            $tour->name = "{$type} тур в " . explode(',', $location)[1];
            $tour->type = $type;
            $tour->season = $season;
            $tour->description = $description;
            // Используем изображения из storage, с разными вариантами для разнообразия
            $imageNames = ['beach.jpg', 'mountain.jpg', 'city.jpg', 'resort.jpg', 'hotel.jpg'];
            $imagePath = 'img/tours/' . $imageNames[array_rand($imageNames)];
            $tour->image = $imagePath;
            $tour->start_date = Carbon::now()->addDays($startOffset)->format('Y-m-d');
            $tour->end_date = Carbon::now()->addDays($startOffset + $duration)->format('Y-m-d');
            $tour->data = Carbon::now()->addDays($startOffset);
            $tour->price = round($price);
            $tour->location = $location;
            $tour->duration = $duration;
            $tour->features = $features;
            $tour->available_seats = rand(10, 30);
            $tour->created_at = Carbon::now()->subDays(rand(1, 90));
            
            $tours[] = $tour;
        }
        
        return $tours;
    }
}
