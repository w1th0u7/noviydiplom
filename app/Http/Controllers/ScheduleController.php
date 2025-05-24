<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;

class ScheduleController extends Controller
{
    /**
     * Display the schedule page with tours.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Получаем все туры из базы данных
        $tours = Tour::orderBy('start_date', 'asc')->get();
        
        // Подготавливаем доступные типы туров для фильтра
        $tourTypes = $tours->pluck('type')->unique()->filter()->toArray();
        
        return view('schedule', compact('tours', 'tourTypes'));
    }
} 