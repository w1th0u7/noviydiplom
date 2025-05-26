<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Аутентификация пользователя
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Проверка, является ли пользователь администратором
            if ($user->role === 'admin') {
                // Если пользователь администратор, перенаправляем его на админ-панель
                return redirect()->route('admin.dashboard')->with('success', 'Добро пожаловать в админ-панель!');
            } else {
                // Если не администратор, перенаправляем на обычную панель
                return redirect()->route('home')->with('success', 'Добро пожаловать!');
            }
        }

        // Если аутентификация не удалась
        return redirect()->back()->withErrors(['email' => 'Неверный email или пароль.']);
    }

  
    public function showLoginForm()
    {
        return view('auth.login'); 
    }
}
