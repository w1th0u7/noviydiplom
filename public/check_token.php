<?php
// Подключаем автозагрузчик Composer
require __DIR__ . '/../vendor/autoload.php';

// Подключаем приложение Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';


$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();


use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Проверяем, авторизован ли пользователь
echo "<h1>Проверка состояния API-токена</h1>";

if (Auth::check()) {
    $user = Auth::user();
    echo "<h2>Информация о пользователе:</h2>";
    echo "<p>ID: {$user->id}</p>";
    echo "<p>Имя: {$user->name}</p>";
    echo "<p>Email: {$user->email}</p>";
    echo "<p>API Token: " . ($user->api_token ?: '<strong>NULL</strong>') . "</p>";
    
    // Проверяем все поля в токене (на случай, если есть проблемы с колонкой в БД)
    echo "<h2>Все поля пользователя:</h2>";
    echo "<pre>";
    print_r($user->toArray());
    echo "</pre>";
    
    // Проверяем пользователя напрямую из базы данных
    $userFromDb = User::find($user->id);
    echo "<h2>Данные из базы:</h2>";
    echo "<p>API Token в БД: " . ($userFromDb->api_token ?: '<strong>NULL</strong>') . "</p>";
    
    echo "<p><a href='/'>Вернуться на главную</a></p>";
} else {
    echo "<p>Вы не авторизованы.</p>";
    echo "<p><a href='/login'>Войти в систему</a></p>";
} 