<?php
// Подключаем автозагрузчик Composer
require __DIR__ . '/../vendor/autoload.php';

// Подключаем приложение Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Запускаем приложение
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Используем необходимые классы
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Проверяем, авторизован ли пользователь
if (Auth::check()) {
    // Получаем текущего пользователя
    $user = Auth::user();
    
    // Выводим информацию о текущем состоянии
    echo "Пользователь: " . $user->name . " (" . $user->email . ")<br>";
    echo "Текущий API Token: " . ($user->api_token ?: 'NULL') . "<br>";
    
    // Генерируем и сохраняем новый токен
    $user->api_token = (string)Str::uuid();
    $user->save();
    
    echo "Новый API Token: " . $user->api_token . "<br>";
    echo "<p>Токен успешно обновлен!</p>";
    echo '<p><a href="/">Вернуться на главную страницу</a></p>';
} else {
    echo "<p>Вы не авторизованы.</p>";
    echo '<p><a href="/login">Войти в систему</a></p>';
} 