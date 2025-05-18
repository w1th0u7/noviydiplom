<?php

namespace App\Http\Controllers;

use App\Models\Tour; // Укажите модель Tour (предполагается, что она у вас есть)
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Отображает панель управления администратора.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Перенаправляем на dashboard для единообразия
        return redirect()->route('admin.dashboard');
    }

    /**
     * Отображает форму для создания нового тура.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tours.create'); // Создайте представление для создания тура
    }

    /**
     * Сохраняет новый тур в базе данных.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валидация входных данных
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            // Другие поля и правила валидации
        ]);

        // Создание нового тура
        $tour = new Tour();
        $tour->title = $validatedData['title'];
        $tour->description = $validatedData['description'];
        $tour->price = $validatedData['price'];
        // Заполните другие поля тура

        $tour->save();

        // Перенаправление на страницу со списком туров или на страницу просмотра созданного тура
        return redirect()->route('admin.tours.index')->with('success', 'Тур успешно создан!');
    }

    /**
     * Отображает форму для редактирования существующего тура.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tour = Tour::findOrFail($id); // Находим тур по ID или возвращаем 404
        return view('admin.tours.edit', compact('tour')); // Создайте представление для редактирования тура
    }

    /**
     * Обновляет существующий тур в базе данных.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Валидация входных данных
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            // Другие поля и правила валидации
        ]);

        $tour = Tour::findOrFail($id); // Находим тур по ID или возвращаем 404
        $tour->title = $validatedData['title'];
        $tour->description = $validatedData['description'];
        $tour->price = $validatedData['price'];
        // Обновите другие поля тура

        $tour->save();

        return redirect()->route('admin.tours.index')->with('success', 'Тур успешно обновлен!');
    }

    /**
     * Удаляет тур из базы данных.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id); // Находим тур по ID или возвращаем 404
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Тур успешно удален!');
    }

    /**
     * Отображает список туров.
     *
     * @return \Illuminate\View\View
     */
    public function tours()
    {
        $tours = Tour::orderBy('created_at', 'desc')->paginate(10); // Используем пагинацию вместо всех записей
        return view('admin.tours.index', compact('tours')); // Создайте представление для отображения списка туров
    }

    /**
     * Показывает основную панель со статистикой
     */
    public function dashboard()
    {
        $tourCount = Tour::count();
        $userCount = User::count();
        $adminCount = User::where('role', 'admin')->count();
        
        // Здесь можно добавить дополнительную статистику
        
        return view('admin.dashboard', compact('tourCount', 'userCount', 'adminCount'));
    }

    /**
     * Показывает список всех пользователей
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Показывает страницу заказов
     */
    public function orders()
    {
        return view('admin.orders.index');
    }

    /**
     * Показывает страницу настроек
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Отображает форму для создания нового тура
     */
    public function createTour()
    {
        return view('admin.tours.create');
    }

    /**
     * Сохраняет новый тур в базе данных
     */
    public function storeTour(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'season' => 'required|string|max:50',
            'data' => 'required|date',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Сохранение изображения
        $imagePath = $request->file('image')->store('tours', 'public');

        Tour::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'season' => $validatedData['season'],
            'data' => $validatedData['data'],
            'price' => $validatedData['price'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.tours')->with('success', 'Тур успешно создан!');
    }

    /**
     * Отображает форму для редактирования существующего тура
     */
    public function editTour(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    /**
     * Обновляет существующий тур в базе данных
     */
    public function updateTour(Request $request, Tour $tour)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'season' => 'required|string|max:50',
            'data' => 'required|date',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Обновление данных тура
        $tour->name = $validatedData['name'];
        $tour->description = $validatedData['description'];
        $tour->season = $validatedData['season'];
        $tour->data = $validatedData['data'];
        $tour->price = $validatedData['price'];

        // Обновление изображения, если оно было загружено
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно существует
            if ($tour->image && Storage::disk('public')->exists($tour->image)) {
                Storage::disk('public')->delete($tour->image);
            }
            
            // Сохраняем новое изображение
            $imagePath = $request->file('image')->store('tours', 'public');
            $tour->image = $imagePath;
        }

        $tour->save();

        return redirect()->route('admin.tours')->with('success', 'Тур успешно обновлен!');
    }

    /**
     * Удаляет тур из базы данных
     */
    public function destroyTour(Tour $tour)
    {
        // Удаляем изображение, если оно существует
        if ($tour->image && Storage::disk('public')->exists($tour->image)) {
            Storage::disk('public')->delete($tour->image);
        }
        
        $tour->delete();

        return redirect()->route('admin.tours')->with('success', 'Тур успешно удален!');
    }

    /**
     * Переключает роль пользователя между 'user' и 'admin'
     */
    public function toggleUserRole(User $user)
    {
        // Запрещаем менять роль самому себе для безопасности
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')
                ->with('error', 'Вы не можете изменить свою собственную роль');
        }
        
        // Переключаем роль
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();
        
        $roleText = $user->role === 'admin' ? 'администратора' : 'пользователя';
        return redirect()->route('admin.users')
            ->with('success', "Пользователь {$user->name} теперь имеет роль {$roleText}");
    }

    /**
     * Обновляет основные настройки сайта (заглушка)
     */
    public function updateSettings(Request $request)
    {
        // В будущем здесь будет обновление настроек
        return redirect()->route('admin.settings')
            ->with('success', 'Настройки успешно обновлены');
    }
    
    /**
     * Создает резервную копию данных (заглушка)
     */
    public function createBackup()
    {
        // В будущем здесь будет создание резервной копии
        return redirect()->route('admin.settings')
            ->with('success', 'Резервная копия успешно создана');
    }
    
    /**
     * Обновляет SEO настройки (заглушка)
     */
    public function updateSeoSettings(Request $request)
    {
        // В будущем здесь будет обновление SEO настроек
        return redirect()->route('admin.settings')
            ->with('success', 'SEO настройки успешно обновлены');
    }

    //  Другие методы контроллера (например, для управления пользователями, отзывами и т.д.)
}