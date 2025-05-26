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

echo "<!DOCTYPE html>
<html>
<head>
    <title>Проверка доступности тура</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 30px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Проверка доступности тура</h1>";

// Получаем первый тур
$tour = Tour::first();

if (!$tour) {
    echo "<div class='section error'>Туры не найдены в базе данных</div>";
} else {
    echo "<div class='section'>";
    echo "<h2>Информация о туре</h2>";
    echo "<table>
        <tr><th>ID</th><td>{$tour->id}</td></tr>
        <tr><th>Название</th><td>{$tour->name}</td></tr>
        <tr><th>Доступных мест</th><td>{$tour->available_seats}</td></tr>
        <tr><th>Дата начала</th><td>" . ($tour->start_date ? $tour->start_date->format('Y-m-d') : 'Не указана') . "</td></tr>
        <tr><th>Дата окончания</th><td>" . ($tour->end_date ? $tour->end_date->format('Y-m-d') : 'Не указана') . "</td></tr>
    </table>";
    echo "</div>";
    
    // Проверяем доступность на текущую дату
    $today = date('Y-m-d');
    $isAvailable = $tour->isAvailableOn($today);
    
    echo "<div class='section'>";
    echo "<h2>Проверка доступности на текущую дату ({$today})</h2>";
    
    // Отладочная информация для isAvailableOn
    try {
        // Проверяем даты проведения тура
        $hasDateRange = ($tour->start_date && $tour->end_date);
        
        if ($hasDateRange) {
            $tourStart = new \DateTime($tour->start_date);
            $tourEnd = new \DateTime($tour->end_date);
            $checkDate = new \DateTime($today);
            
            $dateInRange = ($checkDate >= $tourStart && $checkDate <= $tourEnd);
            
            echo "<p>Тур имеет период проведения: <strong>" . ($hasDateRange ? 'Да' : 'Нет') . "</strong></p>";
            echo "<p>Текущая дата входит в период проведения: <strong>" . ($dateInRange ? 'Да' : 'Нет') . "</strong></p>";
        } else {
            echo "<p class='error'>Тур не имеет указанного периода проведения (start_date и/или end_date не заданы)</p>";
        }
        
        // Проверяем количество бронирований
        $bookingsCount = $tour->bookings()
            ->whereDate('booking_date', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('persons');
            
        echo "<p>Количество забронированных мест на {$today}: <strong>{$bookingsCount}</strong></p>";
        echo "<p>Общее количество мест: <strong>{$tour->available_seats}</strong></p>";
        echo "<p>Доступных мест: <strong>" . max(0, $tour->available_seats - $bookingsCount) . "</strong></p>";
        
    } catch (\Exception $e) {
        echo "<p class='error'>Ошибка при проверке доступности: " . $e->getMessage() . "</p>";
    }
    
    // Итоговый результат
    echo "<p>Результат проверки доступности: <strong class='" . ($isAvailable ? 'success' : 'error') . "'>" 
        . ($isAvailable ? 'Доступен' : 'Недоступен') . "</strong></p>";
    
    echo "</div>";
    
    // Проверка на будущую дату
    $futureDate = date('Y-m-d', strtotime('+1 month'));
    $isAvailableFuture = $tour->isAvailableOn($futureDate);
    
    echo "<div class='section'>";
    echo "<h2>Проверка доступности на будущую дату ({$futureDate})</h2>";
    
    try {
        // Проверяем даты проведения тура для будущей даты
        if ($hasDateRange) {
            $checkFutureDate = new \DateTime($futureDate);
            $dateInRange = ($checkFutureDate >= $tourStart && $checkFutureDate <= $tourEnd);
            
            echo "<p>Будущая дата входит в период проведения: <strong>" . ($dateInRange ? 'Да' : 'Нет') . "</strong></p>";
        }
        
        // Проверяем количество бронирований на будущую дату
        $bookingsCountFuture = $tour->bookings()
            ->whereDate('booking_date', $futureDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('persons');
            
        echo "<p>Количество забронированных мест на {$futureDate}: <strong>{$bookingsCountFuture}</strong></p>";
        echo "<p>Доступных мест: <strong>" . max(0, $tour->available_seats - $bookingsCountFuture) . "</strong></p>";
        
    } catch (\Exception $e) {
        echo "<p class='error'>Ошибка при проверке доступности: " . $e->getMessage() . "</p>";
    }
    
    echo "<p>Результат проверки доступности: <strong class='" . ($isAvailableFuture ? 'success' : 'error') . "'>" 
        . ($isAvailableFuture ? 'Доступен' : 'Недоступен') . "</strong></p>";
    
    echo "</div>";
}

// Форма для проверки конкретной даты
echo "<div class='section'>
    <h2>Проверить доступность для конкретной даты</h2>
    <form method='get'>
        <input type='date' name='check_date' required value='" . ($_GET['check_date'] ?? date('Y-m-d')) . "'>
        <button type='submit'>Проверить</button>
    </form>";

if (isset($_GET['check_date']) && $tour) {
    $checkDate = $_GET['check_date'];
    $isAvailableCheck = $tour->isAvailableOn($checkDate);
    
    echo "<h3>Результаты проверки для даты {$checkDate}:</h3>";
    
    try {
        // Проверка дат проведения
        if ($tour->start_date && $tour->end_date) {
            $tourStart = new \DateTime($tour->start_date);
            $tourEnd = new \DateTime($tour->end_date);
            $dateToCheck = new \DateTime($checkDate);
            
            $dateInRange = ($dateToCheck >= $tourStart && $dateToCheck <= $tourEnd);
            
            echo "<p>Выбранная дата входит в период проведения: <strong>" . ($dateInRange ? 'Да' : 'Нет') . "</strong></p>";
            
            if (!$dateInRange) {
                echo "<p class='error'>Дата {$checkDate} находится вне периода проведения тура ({$tour->start_date} - {$tour->end_date})</p>";
            }
        }
        
        // Проверка бронирований
        $bookingsCheckCount = $tour->bookings()
            ->whereDate('booking_date', $checkDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('persons');
            
        echo "<p>Количество забронированных мест на {$checkDate}: <strong>{$bookingsCheckCount}</strong></p>";
        echo "<p>Доступных мест: <strong>" . max(0, $tour->available_seats - $bookingsCheckCount) . "</strong></p>";
        
    } catch (\Exception $e) {
        echo "<p class='error'>Ошибка при проверке доступности: " . $e->getMessage() . "</p>";
    }
    
    echo "<p>Результат проверки доступности: <strong class='" . ($isAvailableCheck ? 'success' : 'error') . "'>" 
        . ($isAvailableCheck ? 'Доступен' : 'Недоступен') . "</strong></p>";
}

echo "</div>";

// Навигационные ссылки
echo "<div class='section'>
    <h2>Навигация</h2>
    <ul>
        <li><a href='/debug_form.php'>Вернуться к отладке форм</a></li>
        <li><a href='/'>На главную</a></li>
    </ul>
</div>";

echo "</body></html>"; 