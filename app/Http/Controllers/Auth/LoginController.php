<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Генерируем новый api_token
            $user = Auth::user();
            $user->api_token = (string)Str::uuid();
            $user->save();
            
            return response()->json(['message' => 'Успешный вход'], 200);
        }

        return response()->json(['message' => 'Неверные учетные данные'], 401);
    }

    public function logout()
    {
        // Сбрасываем api_token
        $user = Auth::user();
        if ($user) {
            $user->api_token = null;
            $user->save();
        }
        
        Auth::logout();
        
        // Перенаправляем на главную страницу вместо возврата JSON
        return redirect('/');
    }
}
