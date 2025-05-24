<?php
// Подключаем автозагрузчик Composer
require __DIR__ . '/../vendor/autoload.php';

// Подключаем приложение Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Запускаем приложение
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Используем модель пользователя и аутентификацию
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Сбрасываем API токен
$user = Auth::user();
if ($user) {
    $user->api_token = null;
    $user->save();
}

// Выполняем выход
Auth::logout();

// Перенаправляем на главную страницу
header('Location: /');
exit(); 