<?php

namespace App\Http\Controllers;

use App\Models\Tour; // Укажите модель Tour (предполагается, что она у вас есть)
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Отображает панель управления администратора.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получите данные, необходимые для отображения на панели администратора.
        // Например, общее количество туров, пользователей и т.д.
        $tourCount = Tour::count(); // Предполагаем, что у вас есть модель Tour
        // Другая логика получения данных

        return view('admin.adminpanel', compact('tourCount')); // Передаем данные в представление
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
        $tours = Tour::all(); // Получите все туры из базы данных
        return view('admin.tours.index', compact('tours')); // Создайте представление для отображения списка туров
    }

    //  Другие методы контроллера (например, для управления пользователями, отзывами и т.д.)
}