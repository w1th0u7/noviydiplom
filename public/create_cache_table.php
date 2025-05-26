<?php
// Инициализируем Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Устанавливаем отображение ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "<!DOCTYPE html>
<html>
<head>
    <title>Создание таблицы кеша</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .log { background-color: #f5f5f5; padding: 10px; font-family: monospace; white-space: pre; }
        .success { color: green; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; }
    </style>
</head>
<body>
    <h1>Создание таблицы кеша</h1>";

try {
    echo "<div class='log'>";
    
    // Проверяем существование таблицы
    if (Schema::hasTable('cache')) {
        echo "Таблица cache уже существует\n";
    } else {
        echo "Создаем таблицу cache...\n";
        
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->mediumText('value');
            $table->integer('expiration');
        });
        
        echo "Таблица cache успешно создана\n";
    }
    
    // Проверяем существование таблицы для тегов кеша
    if (Schema::hasTable('cache_locks')) {
        echo "Таблица cache_locks уже существует\n";
    } else {
        echo "Создаем таблицу cache_locks...\n";
        
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
        
        echo "Таблица cache_locks успешно создана\n";
    }
    
    // Проверяем наличие записей в таблице migrations
    $cacheTableMigration = DB::table('migrations')
        ->where('migration', 'like', '%_create_cache_table')
        ->first();
    
    if (!$cacheTableMigration) {
        echo "Добавляем запись о миграции в таблицу migrations...\n";
        
        $maxBatch = DB::table('migrations')->max('batch') ?: 0;
        
        DB::table('migrations')->insert([
            'migration' => '2023_01_01_000000_create_cache_table',
            'batch' => $maxBatch + 1,
        ]);
        
        echo "Запись о миграции успешно добавлена\n";
    }
    
    echo "</div>";
    
    echo "<p class='success'>Таблицы кеша успешно созданы</p>";
    
    // Добавляем кнопку для очистки кеша
    echo "<form method='post'>";
    echo "<input type='hidden' name='action' value='clear_cache'>";
    echo "<button type='submit'>Очистить кеш</button>";
    echo "</form>";
    
    // Обработка запроса на очистку кеша
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear_cache') {
        echo "<h2>Очистка кеша</h2>";
        echo "<div class='log'>";
        
        // Очищаем таблицу кеша
        DB::table('cache')->delete();
        echo "Таблица cache очищена\n";
        
        // Очищаем таблицу блокировок кеша
        DB::table('cache_locks')->delete();
        echo "Таблица cache_locks очищена\n";
        
        echo "</div>";
        echo "<p class='success'>Кеш успешно очищен</p>";
    }
    
} catch (\Exception $e) {
    echo "</div>";
    echo "<p class='error'>Ошибка: " . $e->getMessage() . "</p>";
}

// Навигационные ссылки
echo "<h2>Диагностические инструменты</h2>";
echo "<ul>
    <li><a href='/check_db.php'>Проверить структуру базы данных</a></li>
    <li><a href='/run_migrations.php'>Выполнить миграции</a></li>
    <li><a href='/fix_booking.php'>Создать тестовое бронирование</a></li>
    <li><a href='/show_logs.php'>Просмотр логов</a></li>
    <li><a href='/'>Вернуться на главную</a></li>
</ul>";

echo "</body></html>"; 