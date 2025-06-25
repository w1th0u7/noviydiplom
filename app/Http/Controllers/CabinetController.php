<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CabinetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware 'auth' уже применено в маршрутах routes/web.php
    }

    /**
     * Отображение главной страницы кабинета.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('cabinet.dashboard');
    }

    /**
     * Отображение страницы поездок пользователя.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function trips()
    {
        // Получаем все бронирования текущего пользователя
        // Не загружаем связь bookable автоматически, так как для записей из калькулятора она null
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('cabinet.trips', compact('bookings'));
    }

    /**
     * Отображение страницы настроек.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        return view('cabinet.settings');
    }

    /**
     * Обновление настроек пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Проверяем текущий пароль, если пользователь хочет изменить пароль
        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Текущий пароль указан неверно.',
                ]);
            }
        }

        // Обновляем основные данные
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }

        // Обновляем пароль, если он был указан
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('settings')->with('success', 'Настройки успешно обновлены');
    }
} 