<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Display the contacts page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Contact information
        $contacts = [
            'address' => 'Владимирская область, г. Александров, ул. Ленина, д.16',
            'phone' => '+7 (800) 200-31-52',
            'email' => 'info@rodina-tur.ru',
            'working_hours' => 'Пн-Пт: 9:00-20:00, Сб-Вс: 10:00-18:00',
            'map_coordinates' => [56.397771, 38.727669], // Александров координаты
        ];
        
        // Office locations
        $offices = [
            [
                'name' => 'Главный офис',
                'address' => 'Владимирская область, г. Александров, ул. Ленина, д.16',
                'phone' => '+7 (800) 200-31-52',
                'coordinates' => [56.397771, 38.727669],
            ],
        ];
        
        return view('contacts', compact('contacts', 'offices'));
    }
} 