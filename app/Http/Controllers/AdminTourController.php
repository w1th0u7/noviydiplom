<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour; // Импортируем модель Tour

class AdminTourController extends Controller
{
    // Метод для отображения админ-панели
    public function index()
    {
        $tours = Tour::all(); // Получение всех туров
        $tourCount = Tour::count();
        $userCount = \App\Models\User::count();
        $adminCount = \App\Models\User::where('role', 'admin')->count();
        
        return view('admin.dashboard', compact('tours', 'tourCount', 'userCount', 'adminCount'));
    }

    // Метод для добавления нового тура
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'season' => 'required|string|max:50',
            'data' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Сохранение изображения
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('img/tours'), $imageName);
        $imagePath = 'img/tours/' . $imageName;

        Tour::create([
            'name' => $request->name,
            'description' => $request->description,
            'season' => $request->season,
            'data' => $request->data,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Тур добавлен успешно!');
    }

    // Метод для обновления тура
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'season' => 'required|string|max:50',
            'data' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $tour = Tour::findOrFail($id);

        // Сохранение изображения, если оно было загружено
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img/tours'), $imageName);
            $imagePath = 'img/tours/' . $imageName;
            $tour->image = $imagePath;
        }

        $tour->update([
            'name' => $request->name,
            'description' => $request->description,
            'season' => $request->season,
            'data' => $request->data,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Тур обновлен успешно!');
    }

    // Метод для удаления тура
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return redirect()->back()->with('success', 'Тур удален успешно!');
    }
}
