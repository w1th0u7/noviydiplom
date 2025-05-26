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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Функция для проверки, есть ли таблица в базе данных
function tableExists($tableName) {
    return Schema::hasTable($tableName);
}

// Функция для получения списка столбцов таблицы
function getTableColumns($tableName) {
    return Schema::getColumnListing($tableName);
}

// Функция для проверки структуры таблицы
function checkTableStructure($tableName) {
    if (!tableExists($tableName)) {
        return "Таблица {$tableName} не существует";
    }
    
    $columns = getTableColumns($tableName);
    return [
        'table' => $tableName,
        'exists' => true,
        'columns' => $columns
    ];
}

// Функция для вывода структуры таблицы
function printTableStructure($structure) {
    if (is_string($structure)) {
        echo "<div style='color: red; font-weight: bold;'>{$structure}</div>";
        return;
    }
    
    echo "<h3>Таблица: {$structure['table']}</h3>";
    echo "<div style='color: green;'>Существует: " . ($structure['exists'] ? 'Да' : 'Нет') . "</div>";
    
    if ($structure['exists']) {
        echo "<h4>Столбцы:</h4>";
        echo "<ul>";
        foreach ($structure['columns'] as $column) {
            echo "<li>{$column}</li>";
        }
        echo "</ul>";
    }
}

// Проверяем таблицу migrations
$migrations = DB::table('migrations')->orderBy('id')->get();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Проверка базы данных</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .critical { color: red; font-weight: bold; }
        .warning { color: orange; }
        .success { color: green; }
        h2, h3, h4 { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Диагностика базы данных</h1>";

// Проверяем таблицу migrations
echo "<h2>Миграции в базе данных</h2>";
echo "<table>
    <tr>
        <th>ID</th>
        <th>Миграция</th>
        <th>Batch</th>
    </tr>";

$bookingsMigrations = [];
foreach ($migrations as $migration) {
    echo "<tr>";
    echo "<td>{$migration->id}</td>";
    echo "<td>" . $migration->migration . "</td>";
    echo "<td>{$migration->batch}</td>";
    echo "</tr>";
    
    // Собираем информацию о миграциях для таблицы bookings
    if (strpos($migration->migration, 'create_bookings_table') !== false || 
        strpos($migration->migration, 'update_bookings_table') !== false) {
        $bookingsMigrations[] = $migration;
    }
}
echo "</table>";

// Выводим информацию о миграциях для таблицы bookings
echo "<h2>Миграции таблицы bookings</h2>";
if (count($bookingsMigrations) > 0) {
    echo "<ul>";
    foreach ($bookingsMigrations as $migration) {
        echo "<li>{$migration->migration} (Batch: {$migration->batch})</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='warning'>Миграции для таблицы bookings не найдены</p>";
}

// Проверяем структуру таблицы bookings
echo "<h2>Структура таблицы bookings</h2>";
$bookingsStructure = checkTableStructure('bookings');
printTableStructure($bookingsStructure);

// Проверяем наличие полиморфных связей
if (is_array($bookingsStructure) && $bookingsStructure['exists']) {
    $hasPolymorphicRelation = in_array('bookable_type', $bookingsStructure['columns']) && 
                            in_array('bookable_id', $bookingsStructure['columns']);
    
    echo "<h3>Полиморфные связи</h3>";
    if ($hasPolymorphicRelation) {
        echo "<div class='success'>Полиморфные связи настроены корректно</div>";
    } else {
        echo "<div class='critical'>Отсутствуют поля для полиморфной связи (bookable_type, bookable_id)</div>";
    }
}

// Проверяем наличие бронирований
echo "<h2>Данные таблицы bookings</h2>";
try {
    $bookings = DB::table('bookings')->get();
    echo "<p>Всего бронирований: " . count($bookings) . "</p>";
    
    if (count($bookings) > 0) {
        echo "<table>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Гость</th>
                <th>Тип объекта</th>
                <th>ID объекта</th>
                <th>Дата</th>
                <th>Статус</th>
            </tr>";
        
        foreach ($bookings as $booking) {
            echo "<tr>";
            echo "<td>{$booking->id}</td>";
            echo "<td>{$booking->user_id}</td>";
            echo "<td>{$booking->guest_name}</td>";
            echo "<td>" . (isset($booking->bookable_type) ? $booking->bookable_type : 'Не указан') . "</td>";
            echo "<td>" . (isset($booking->bookable_id) ? $booking->bookable_id : 'Не указан') . "</td>";
            echo "<td>{$booking->booking_date}</td>";
            echo "<td>{$booking->status}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
} catch (\Exception $e) {
    echo "<div class='critical'>Ошибка при получении данных: " . $e->getMessage() . "</div>";
}

// Навигационные ссылки
echo "<h2>Диагностические инструменты</h2>";
echo "<ul>
    <li><a href='/fix_booking.php'>Создать тестовое бронирование</a></li>
    <li><a href='/test_booking.php'>Тестовая форма бронирования</a></li>
    <li><a href='/show_logs.php'>Просмотр логов</a></li>
    <li><a href='/'>Вернуться на главную</a></li>
</ul>";

echo "</body></html>"; 