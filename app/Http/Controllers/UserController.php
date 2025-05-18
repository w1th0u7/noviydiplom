<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Tours;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }
        return response()->json(['message' => 'Logout successful']);
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

        // 2. Создание пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => (string)Str::uuid()
        ]);

        $user->api_token = (string)Str::uuid();
        $user->save();
        
        // 3. Возврат успешного ответа
        return response()->json([
            'message' => 'Регистрация успешна',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'api_token' => $user->api_token,  //  <<<--- Возврат API-токена
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