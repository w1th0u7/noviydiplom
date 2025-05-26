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

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<!DOCTYPE html>
<html>
<head>
    <title>Очистка кеша Laravel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .log { background-color: #f5f5f5; padding: 10px; font-family: monospace; white-space: pre; margin-bottom: 20px; }
        .success { color: green; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Очистка кеша Laravel</h1>
    
    <form method='post'>
        <button type='submit' name='action' value='cache_clear'>Очистить кеш приложения</button>
        <button type='submit' name='action' value='config_clear'>Очистить кеш конфигурации</button>
        <button type='submit' name='action' value='route_clear'>Очистить кеш маршрутов</button>
        <button type='submit' name='action' value='view_clear'>Очистить кеш представлений</button>
        <button type='submit' name='action' value='db_cache_clear'>Очистить кеш в базе данных</button>
        <button type='submit' name='action' value='clear_all'>Очистить все виды кеша</button>
    </form>";

// Обработка запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    echo "<h2>Результаты очистки кеша</h2>";
    echo "<div class='log'>";
    
    try {
        switch ($action) {
            case 'cache_clear':
                echo "Очистка кеша приложения...\n";
                Artisan::call('cache:clear');
                echo Artisan::output();
                echo "Кеш приложения успешно очищен\n";
                break;
                
            case 'config_clear':
                echo "Очистка кеша конфигурации...\n";
                Artisan::call('config:clear');
                echo Artisan::output();
                echo "Кеш конфигурации успешно очищен\n";
                break;
                
            case 'route_clear':
                echo "Очистка кеша маршрутов...\n";
                Artisan::call('route:clear');
                echo Artisan::output();
                echo "Кеш маршрутов успешно очищен\n";
                break;
                
            case 'view_clear':
                echo "Очистка кеша представлений...\n";
                Artisan::call('view:clear');
                echo Artisan::output();
                echo "Кеш представлений успешно очищен\n";
                break;
                
            case 'db_cache_clear':
                echo "Очистка кеша в базе данных...\n";
                
                // Проверяем существование таблицы
                if (Schema::hasTable('cache')) {
                    DB::table('cache')->truncate();
                    echo "Таблица cache очищена\n";
                } else {
                    echo "Таблица cache не существует\n";
                    echo "Создаем таблицу cache...\n";
                    
                    // Создаем таблицу кеша, если она не существует
                    Schema::create('cache', function ($table) {
                        $table->string('key')->unique();
                        $table->mediumText('value');
                        $table->integer('expiration');
                    });
                    
                    echo "Таблица cache успешно создана\n";
                }
                
                // Проверяем существование таблицы для блокировок кеша
                if (Schema::hasTable('cache_locks')) {
                    DB::table('cache_locks')->truncate();
                    echo "Таблица cache_locks очищена\n";
                } else {
                    echo "Таблица cache_locks не существует\n";
                    echo "Создаем таблицу cache_locks...\n";
                    
                    // Создаем таблицу блокировок кеша, если она не существует
                    Schema::create('cache_locks', function ($table) {
                        $table->string('key')->primary();
                        $table->string('owner');
                        $table->integer('expiration');
                    });
                    
                    echo "Таблица cache_locks успешно создана\n";
                }
                
                // Очищаем кеш через фасад
                Cache::flush();
                echo "Кеш в базе данных успешно очищен\n";
                break;
                
            case 'clear_all':
                echo "Очистка всех видов кеша...\n";
                
                // Очистка кеша приложения
                Artisan::call('cache:clear');
                echo "Кеш приложения очищен\n";
                
                // Очистка кеша конфигурации
                Artisan::call('config:clear');
                echo "Кеш конфигурации очищен\n";
                
                // Очистка кеша маршрутов
                Artisan::call('route:clear');
                echo "Кеш маршрутов очищен\n";
                
                // Очистка кеша представлений
                Artisan::call('view:clear');
                echo "Кеш представлений очищен\n";
                
                // Очистка кеша в базе данных
                if (Schema::hasTable('cache')) {
                    DB::table('cache')->truncate();
                    echo "Таблица cache очищена\n";
                }
                
                if (Schema::hasTable('cache_locks')) {
                    DB::table('cache_locks')->truncate();
                    echo "Таблица cache_locks очищена\n";
                }
                
                // Очищаем кеш через фасад
                Cache::flush();
                echo "Кеш в базе данных очищен\n";
                
                echo "Все виды кеша успешно очищены\n";
                break;
                
            default:
                echo "Неизвестное действие: {$action}\n";
                break;
        }
    } catch (\Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
        echo "Стек вызовов: " . $e->getTraceAsString() . "\n";
    }
    
    echo "</div>";
}

// Навигационные ссылки
echo "<h2>Диагностические инструменты</h2>";
echo "<ul>
    <li><a href='/create_cache_table.php'>Создать таблицы кеша</a></li>
    <li><a href='/check_db.php'>Проверить структуру базы данных</a></li>
    <li><a href='/run_migrations.php'>Выполнить миграции</a></li>
    <li><a href='/fix_booking.php'>Создать тестовое бронирование</a></li>
    <li><a href='/show_logs.php'>Просмотр логов</a></li>
    <li><a href='/'>Вернуться на главную</a></li>
</ul>";

echo "</body></html>"; 