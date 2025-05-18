<?php
// Подключаем автозагрузчик Composer
require __DIR__.'/vendor/autoload.php';

// Подключаем приложение Laravel
$app = require_once __DIR__.'/bootstrap/app.php';

// Запускаем приложение
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Используем модель пользователя
use App\Models\User;
use Illuminate\Support\Str;

echo "Starting token generation...\n";

// Получаем всех пользователей
$users = User::all();
echo "Total users: " . $users->count() . "\n";

// Выводим текущее состояние
foreach ($users as $user) {
    echo "User: {$user->name}, Email: {$user->email}, Current token: " . ($user->api_token ?: 'NULL') . "\n";
}

// Обновляем токены для всех пользователей
$updated = 0;
foreach ($users as $user) {
    $user->api_token = (string)Str::uuid();
    $user->save();
    echo "Updated token for {$user->name}: {$user->api_token}\n";
    $updated++;
}

echo "Successfully updated tokens for {$updated} users.\n"; 