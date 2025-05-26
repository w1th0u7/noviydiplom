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

use App\Models\Tour;
use Illuminate\Support\Facades\DB;

echo "<!DOCTYPE html>
<html>
<head>
    <title>Исправление дат туров</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 30px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
    </style>
</head>
<body>
    <h1>Исправление дат для туров</h1>";

// Получение списка туров
$tours = Tour::all();

echo "<div class='section'>
    <h2>Найдено туров: " . $tours->count() . "</h2>";

if ($tours->count() === 0) {
    echo "<p class='error'>Туры не найдены в базе данных</p>";
} else {
    echo "<table>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Текущая дата начала</th>
            <th>Текущая дата окончания</th>
            <th>Статус</th>
        </tr>";
    
    foreach ($tours as $tour) {
        $startDate = $tour->start_date ? $tour->start_date->format('Y-m-d') : 'Не указана';
        $endDate = $tour->end_date ? $tour->end_date->format('Y-m-d') : 'Не указана';
        
        $status = 'Даты установлены';
        $statusClass = 'success';
        
        if (!$tour->start_date || !$tour->end_date) {
            $status = 'Требуется обновление';
            $statusClass = 'warning';
        }
        
        echo "<tr>
            <td>{$tour->id}</td>
            <td>{$tour->name}</td>
            <td>{$startDate}</td>
            <td>{$endDate}</td>
            <td class='{$statusClass}'>{$status}</td>
        </tr>";
    }
    
    echo "</table>";
}

echo "</div>";

// Обновление дат туров, если отправлена форма
if (isset($_POST['update_dates'])) {
    echo "<div class='section'>
        <h2>Результаты обновления дат</h2>";
    
    try {
        DB::beginTransaction();
        
        $startDate = date('Y-m-d'); // Текущая дата как дата начала
        $endDate = date('Y-m-d', strtotime('+1 year')); // Год вперед как дата окончания
        
        $updatedCount = 0;
        
        foreach ($tours as $tour) {
            $needsUpdate = false;
            
            if (!$tour->start_date || !$tour->end_date) {
                $needsUpdate = true;
            }
            
            if ($needsUpdate) {
                $tour->start_date = $startDate;
                $tour->end_date = $endDate;
                $tour->save();
                
                echo "<p class='success'>Обновлен тур #{$tour->id} '{$tour->name}': Даты установлены с {$startDate} по {$endDate}</p>";
                $updatedCount++;
            }
        }
        
        DB::commit();
        
        if ($updatedCount > 0) {
            echo "<p class='success'>Всего обновлено туров: {$updatedCount}</p>";
        } else {
            echo "<p>Нет туров, требующих обновления дат</p>";
        }
        
    } catch (\Exception $e) {
        DB::rollback();
        echo "<p class='error'>Ошибка при обновлении дат: " . $e->getMessage() . "</p>";
    }
    
    echo "</div>";
}

// Форма для обновления дат
echo "<div class='section'>
    <h2>Обновление дат для всех туров</h2>
    <p>Нажмите кнопку ниже, чтобы установить даты для всех туров:</p>
    <p>Дата начала: <strong>" . date('Y-m-d') . "</strong> (сегодня)</p>
    <p>Дата окончания: <strong>" . date('Y-m-d', strtotime('+1 year')) . "</strong> (1 год вперед)</p>
    
    <form method='post'>
        <input type='hidden' name='update_dates' value='1'>
        <button type='submit'>Обновить даты для всех туров</button>
    </form>
</div>";

// Перейти к проверке доступности
echo "<div class='section'>
    <h2>Навигация</h2>
    <ul>
        <li><a href='/check_tour_availability.php'>Проверить доступность тура</a></li>
        <li><a href='/debug_form.php'>Вернуться к отладке форм</a></li>
        <li><a href='/'>На главную</a></li>
    </ul>
</div>";

echo "</body></html>"; 