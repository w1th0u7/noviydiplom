<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TouristInfoController extends Controller
{
    /**
     * Display the tourist information page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tourist_info');
    }
} 