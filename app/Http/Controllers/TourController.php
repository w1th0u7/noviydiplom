<?php

namespace App\Http\Controllers;

use App\Models\Tour;

// Импортируйте модель Tour
use Illuminate\Http\Request;

class TourController extends Controller
{
    // Метод для отображения главной страницы с турами
    public function index()
    {
        $tours = Tour::all();
        return view('index', compact('tours')); // или ['tours' => $tours]
    }

    // Метод для отображения всех туров
    public function showAll()
    {
        $tours = Tour::all(); // Получите все туры из базы данных
        return view('index', compact('tours')); // Передайте туры в представление
    }

    // Метод для отображения конкретного тура
    public function show($id)
    {
        $tour = Tour::findOrFail($id); // Получаем конкретный тур по ID
        return view('tours.show', compact('tour'));
    }
}
