<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ToursController extends Controller
{
    /**
     * Отображает список туров в админке
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tours = Tour::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    /**
     * Отображает форму создания нового тура
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tours.create');
    }

    /**
     * Сохраняет новый тур в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'season' => 'required|string|max:50',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'audience_type' => 'required|in:preschool,school,adult,all',
            'available_seats' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
        ]);

        // Обработка особенностей тура
        $features = [];
        if ($request->has('features')) {
            $features = array_filter(explode("\n", $validatedData['features']));
            $features = array_map('trim', $features);
        }

        // Загрузка изображения
        $imagePath = $request->file('image')->store('tours', 'public');

        // Создание нового тура
        Tour::create([
            'name' => $validatedData['name'],
            'type' => $validatedData['type'],
            'season' => $validatedData['season'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'duration' => $validatedData['duration'],
            'price' => $validatedData['price'],
            'data' => Carbon::now(), // Используем текущую дату для поля data
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'image' => 'img/' . $imagePath,
            'audience_type' => $validatedData['audience_type'],
            'available_seats' => $validatedData['available_seats'] ?? 20,
            'features' => $features,
        ]);

        return redirect()->route('admin.tours.index')->with('success', 'Тур успешно создан!');
    }

    /**
     * Отображает форму редактирования тура
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\View\View
     */
    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    /**
     * Обновляет данные тура в базе
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tour $tour)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'season' => 'required|string|max:50',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'audience_type' => 'required|in:preschool,school,adult,all',
            'available_seats' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
        ]);

        // Обработка особенностей тура
        if ($request->has('features')) {
            $features = array_filter(explode("\n", $validatedData['features']));
            $features = array_map('trim', $features);
            $tour->features = $features;
        }

        // Обновление изображения, если загружено новое
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно существует и не является стандартным
            if ($tour->image && Storage::disk('public')->exists($tour->image) && !str_starts_with($tour->image, 'img/')) {
                Storage::disk('public')->delete($tour->image);
            }
            $imagePath = $request->file('image')->store('tours', 'public');
            $tour->image = 'img/' . $imagePath;
        }

        // Обновление данных тура
        $tour->update([
            'name' => $validatedData['name'],
            'type' => $validatedData['type'],
            'season' => $validatedData['season'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'duration' => $validatedData['duration'],
            'price' => $validatedData['price'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'audience_type' => $validatedData['audience_type'],
            'available_seats' => $validatedData['available_seats'] ?? 20,
        ]);

        return redirect()->route('admin.tours.index')->with('success', 'Тур успешно обновлен!');
    }

    /**
     * Удаляет тур из базы данных
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tour $tour)
    {
        // Удаляем изображение, если оно существует и не является стандартным
        if ($tour->image && Storage::disk('public')->exists($tour->image) && !str_starts_with($tour->image, 'img/')) {
            Storage::disk('public')->delete($tour->image);
        }

        // Удаляем тур
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Тур успешно удален!');
    }
}
