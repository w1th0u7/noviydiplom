<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
   
   {  public function index()
    {
        $newTours = Tour::orderBy('created_at', 'desc')->get();
        $upcomingTours = Tour::orderBy('data', 'asc')->where('data', '>', now())->get();
        $popularTours = Tour::orderBy('price', 'desc')->get();
        $summerTours = Tour::where('season', 'Лето')->orWhere('season', 'летние')->get();
        $winterTours = Tour::where('season', 'Зима')->orWhere('season', 'зимние')->get();
        $autumnTours = Tour::where('season', 'Осень')->orWhere('season', 'осенние')->get();
        $springTours = Tour::where('season', 'Весна')->orWhere('season', 'весенние')->get();

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
        return view('tours.all', compact('tours')); // Отдельное представление для списка всех туров
    }

    /**
     * Отображает детали одного тура.
     */
    public function show($id)
    {
        $tour = Tour::findOrFail($id);
        return view('tours.show', compact('tour'));
    }

    /**
     * Обрабатывает поисковый запрос.
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');
        $tours = Tour::where('name', 'like', '%' . $searchTerm . '%')->paginate(6);
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
            $imagePath = $image->storeAs('images', $imageName, 'public');
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
}
