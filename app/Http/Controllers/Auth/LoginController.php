<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Успешный вход'], 200);
        }

        return response()->json(['message' => 'Неверные учетные данные'], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Вы вышли из системы'], 200);
    }
}
