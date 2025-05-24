<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Tours;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{



    public function index()
    {
        $users = User::paginate(10); // Возвращает объект пагинации
        return view('users', ['users' => $users]);
    }

    public function showRegistrationForm()
    {
        return view('user.login');
    }

    public function showLoginForm()
    {
        return view('user.login2');
    }

    public function login(Request $request)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Попытка аутентификации
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            // Аутентификация успешна
            $request->session()->regenerate();
            
            // Генерируем новый api_token
            $user = Auth::user();
            $user->api_token = (string)Str::uuid();
            $saved = $user->save();
            
            // Для отладки
            \Log::info("Login: API token assigned to {$user->email}: {$user->api_token}, saved: " . ($saved ? 'yes' : 'no'));
            
            // Проверяем, есть ли сохраненный URL для бронирования
            if (session()->has('booking_return_url')) {
                $returnUrl = session()->get('booking_return_url');
                $formData = session()->get('booking_form_data', []);
                
                // Очищаем сессию
                session()->forget(['booking_return_url', 'booking_form_data']);
                
                // Перенаправляем обратно на страницу бронирования
                return redirect($returnUrl)->with('form_data', $formData)
                    ->with('success', 'Вы успешно авторизованы. Теперь можете продолжить бронирование.');
            }
            
            // Перенаправление в личный кабинет
            return redirect()->route('cabinet');
        }

        // Ошибка аутентификации
        return redirect()->back()
            ->withErrors(['email' => 'Неверный email или пароль.'])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        // Сбрасываем api_token пользователя
        $user = Auth::user();
        if ($user) {
            $user->api_token = null;
            $saved = $user->save();
            \Log::info("Logout: API token cleared for {$user->email}, saved: " . ($saved ? 'yes' : 'no'));
        }
        
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        // Всегда перенаправляем на главную страницу
        return redirect('/');
    }

    /**
     * Регистрация нового пользователя через API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // 1. Валидация данных
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Возврат ошибок валидации
        }

        // 2. Создание пользователя с api_token
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => (string)Str::uuid()
        ]);
        
        // 3. Возврат успешного ответа
        return response()->json([
            'message' => 'Регистрация успешна',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'api_token' => $user->api_token,
            ],
        ], 201);
    }

    

    protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'], //  "confirmed" требует наличия поля "password_confirmation"
    ]);

}
}