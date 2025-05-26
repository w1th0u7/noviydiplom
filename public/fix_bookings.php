<?php

// Заголовок для предотвращения кэширования
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Content-Type: text/html; charset=utf-8');

// Инициализируем Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Проверка безопасности
$allowedIPs = ['127.0.0.1', '::1'];
if (!in_array($_SERVER['REMOTE_ADDR'], $allowedIPs)) {
    die('Доступ запрещен. Этот скрипт доступен только с локального компьютера.');
}

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<h1>Инструмент для исправления таблицы бронирований</h1>";

// Получаем действие из параметров
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Просмотр существующих миграций
echo "<h2>Существующие миграции для бронирований:</h2>";
$migrations = DB::table('migrations')
    ->where('migration', 'like', '%bookings%')
    ->orderBy('batch')
    ->get();

echo "<table border='1'><tr><th>ID</th><th>Миграция</th><th>Batch</th></tr>";
foreach ($migrations as $migration) {
    echo "<tr><td>{$migration->id}</td><td>{$migration->migration}</td><td>{$migration->batch}</td></tr>";
}
echo "</table>";

// Информация о таблице
echo "<h2>Структура таблицы бронирований:</h2>";
if (Schema::hasTable('bookings')) {
    $columns = DB::select("SHOW COLUMNS FROM bookings");
    echo "<table border='1'><tr><th>Поле</th><th>Тип</th><th>Null</th><th>Ключ</th><th>По умолчанию</th></tr>";
    foreach ($columns as $column) {
        echo "<tr><td>{$column->Field}</td><td>{$column->Type}</td><td>{$column->Null}</td><td>{$column->Key}</td><td>{$column->Default}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>Таблица bookings не существует!</p>";
}

// Исправление таблицы
if ($action == 'fix_table') {
    echo "<h2>Исправление таблицы bookings:</h2>";
    
    try {
        // Проверяем наличие полей для полиморфных связей
        $hasBookableType = Schema::hasColumn('bookings', 'bookable_type');
        $hasBookableId = Schema::hasColumn('bookings', 'bookable_id');
        
        // Если поля отсутствуют, добавляем их
        if (!$hasBookableType || !$hasBookableId) {
            Schema::table('bookings', function ($table) use ($hasBookableType, $hasBookableId) {
                if (!$hasBookableType) {
                    echo "<p>Добавляем поле bookable_type...</p>";
                    $table->string('bookable_type')->nullable()->after('notes');
                }
                
                if (!$hasBookableId) {
                    echo "<p>Добавляем поле bookable_id...</p>";
                    $table->unsignedBigInteger('bookable_id')->nullable()->after('bookable_type');
                }
                
                echo "<p>Добавляем индекс...</p>";
                $table->index(['bookable_type', 'bookable_id']);
            });
            
            echo "<p>Таблица успешно обновлена!</p>";
        } else {
            echo "<p>Поля для полиморфных связей уже существуют.</p>";
        }
        
        // Проверяем бронирования без привязки к моделям
        $orphanBookings = DB::table('bookings')
            ->whereNull('bookable_type')
            ->orWhereNull('bookable_id')
            ->get();
            
        if ($orphanBookings->count() > 0) {
            echo "<p>Найдено " . $orphanBookings->count() . " бронирований без привязки к моделям.</p>";
            
            // Ищем первый доступный тур для привязки
            $tour = DB::table('tours')->first();
            
            if ($tour) {
                echo "<p>Привязываем бронирования к туру ID: {$tour->id}...</p>";
                
                DB::table('bookings')
                    ->whereNull('bookable_type')
                    ->orWhereNull('bookable_id')
                    ->update([
                        'bookable_type' => 'App\\Models\\Tour',
                        'bookable_id' => $tour->id
                    ]);
                    
                echo "<p>Бронирования успешно привязаны!</p>";
            } else {
                echo "<p>Ошибка: Не найдено ни одного тура для привязки бронирований.</p>";
            }
        } else {
            echo "<p>Все бронирования имеют корректные привязки.</p>";
        }
        
    } catch (Exception $e) {
        echo "<p>Ошибка при исправлении таблицы: " . $e->getMessage() . "</p>";
    }
}

// Форма для создания тестового бронирования
echo "<h2>Создать тестовое бронирование:</h2>";
echo "<form method='get' action=''>";
echo "<input type='hidden' name='action' value='create_test'>";
echo "ID пользователя: <input type='number' name='user_id' required><br>";
echo "<button type='submit'>Создать</button>";
echo "</form>";

// Создание тестового бронирования
if ($action == 'create_test' && isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);
    
    try {
        // Проверяем существование пользователя
        $user = DB::table('users')->where('id', $userId)->first();
        
        if (!$user) {
            echo "<p>Ошибка: Пользователь с ID {$userId} не найден.</p>";
        } else {
            // Находим тур для бронирования
            $tour = DB::table('tours')->first();
            
            if (!$tour) {
                echo "<p>Ошибка: Не найдено ни одного тура для бронирования.</p>";
            } else {
                // Создаем бронирование напрямую через SQL
                $now = date('Y-m-d H:i:s');
                $bookingDate = date('Y-m-d', strtotime('+10 days'));
                
                DB::table('bookings')->insert([
                    'user_id' => $userId,
                    'guest_name' => $user->name,
                    'guest_email' => $user->email,
                    'guest_phone' => '1234567890',
                    'booking_date' => $bookingDate,
                    'persons' => 2,
                    'total_price' => $tour->price * 2,
                    'status' => 'pending',
                    'notes' => 'Тестовое бронирование через fix_bookings.php',
                    'bookable_type' => 'App\\Models\\Tour',
                    'bookable_id' => $tour->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                
                $bookingId = DB::getPdo()->lastInsertId();
                
                echo "<p>Тестовое бронирование успешно создано с ID: {$bookingId}</p>";
                echo "<p>Пользователь: {$user->name} (ID: {$userId})</p>";
                echo "<p>Тур: {$tour->name} (ID: {$tour->id})</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p>Ошибка при создании бронирования: " . $e->getMessage() . "</p>";
    }
}

// Ссылки для навигации
echo "<div style='margin-top: 20px;'>";
echo "<a href='?action=fix_table' style='margin-right: 10px;'>Исправить таблицу</a>";
echo "<a href='/debug_bookings.php' style='margin-right: 10px;'>Отладка бронирований</a>";
echo "<a href='/cabinet/trips' style='margin-right: 10px;'>Перейти в личный кабинет</a>";
echo "</div>"; 