<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Excursion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExcursionsController extends Controller
{
    /**
     * Отображает список экскурсий в админке
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $excursions = Excursion::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.excursions.index', compact('excursions'));
    }

    /**
     * Отображает форму создания новой экскурсии
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.excursions.create');
    }

    /**
     * Сохраняет новую экскурсию в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'audience_type' => 'required|in:preschool,school,adult,all',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'available_seats' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
        ]);

        // Обработка особенностей экскурсии
        $features = [];
        if ($request->has('features')) {
            $features = array_filter(explode("\n", $validatedData['features']));
            $features = array_map('trim', $features);
        }

        // Загрузка изображения
        $imagePath = $request->file('image')->store('img/excursions', 'public');

        // Создание новой экскурсии
        Excursion::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'region' => $validatedData['region'],
            'duration' => $validatedData['duration'],
            'price' => $validatedData['price'],
            'image' => $imagePath,
            'audience_type' => $validatedData['audience_type'],
            'min_age' => $validatedData['min_age'],
            'max_age' => $validatedData['max_age'],
            'available_seats' => $validatedData['available_seats'] ?? 20,
            'features' => $features,
        ]);

        return redirect()->route('admin.excursions.index')->with('success', 'Экскурсия успешно создана!');
    }

    /**
     * Отображает форму редактирования экскурсии
     *
     * @param  \App\Models\Excursion  $excursion
     * @return \Illuminate\View\View
     */
    public function edit(Excursion $excursion)
    {
        return view('admin.excursions.edit', compact('excursion'));
    }

    /**
     * Обновляет данные экскурсии в базе
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Excursion  $excursion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Excursion $excursion)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'audience_type' => 'required|in:preschool,school,adult,all',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'available_seats' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
        ]);

        // Обработка особенностей экскурсии
        if ($request->has('features')) {
            $features = array_filter(explode("\n", $validatedData['features']));
            $features = array_map('trim', $features);
            $excursion->features = $features;
        }

        // Обновление изображения, если загружено новое
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно существует
            if ($excursion->image && Storage::disk('public')->exists($excursion->image)) {
                Storage::disk('public')->delete($excursion->image);
            }
            $excursion->image = $request->file('image')->store('img/excursions', 'public');
        }

        // Обновление данных экскурсии
        $excursion->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'region' => $validatedData['region'],
            'duration' => $validatedData['duration'],
            'price' => $validatedData['price'],
            'audience_type' => $validatedData['audience_type'],
            'min_age' => $validatedData['min_age'],
            'max_age' => $validatedData['max_age'],
            'available_seats' => $validatedData['available_seats'] ?? 20,
        ]);

        return redirect()->route('admin.excursions.index')->with('success', 'Экскурсия успешно обновлена!');
    }

    /**
     * Удаляет экскурсию из базы данных
     *
     * @param  \App\Models\Excursion  $excursion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Excursion $excursion)
    {
        // Удаляем изображение, если оно существует
        if ($excursion->image && Storage::disk('public')->exists($excursion->image)) {
            Storage::disk('public')->delete($excursion->image);
        }

        // Удаляем экскурсию
        $excursion->delete();

        return redirect()->route('admin.excursions.index')->with('success', 'Экскурсия успешно удалена!');
    }
}
