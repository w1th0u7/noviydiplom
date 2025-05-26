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

use Illuminate\Support\Facades\Auth;
use App\Models\Tour;
use App\Models\User;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Route;

echo "<!DOCTYPE html>
<html>
<head>
    <title>Прямое тестирование бронирования</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 30px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        h2 { color: #333; }
        .success { color: green; }
        .error { color: red; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; }
    </style>
</head>
<body>
    <h1>Прямое тестирование бронирования</h1>";

// Функция для выполнения прямого запроса бронирования
function testDirectBooking($userId, $tourId, $bookingDate, $persons, $guestName, $guestEmail, $guestPhone, $notes = '') {
    try {
        echo "<div class='section'>";
        echo "<h2>Тест прямого бронирования</h2>";
        
        // Авторизуем пользователя
        $user = User::find($userId);
        if (!$user) {
            throw new Exception("Пользователь с ID {$userId} не найден");
        }
        
        Auth::login($user);
        echo "<p>Пользователь авторизован: {$user->name} (ID: {$user->id})</p>";
        
        // Найдем тур
        $tour = Tour::find($tourId);
        if (!$tour) {
            throw new Exception("Тур с ID {$tourId} не найден");
        }
        
        echo "<p>Тур найден: {$tour->name} (ID: {$tour->id})</p>";
        echo "<p>Период проведения тура: " . 
             ($tour->start_date ? $tour->start_date->format('Y-m-d') : 'Не указано') . 
             " - " . 
             ($tour->end_date ? $tour->end_date->format('Y-m-d') : 'Не указано') . 
             "</p>";
        
        // Создаем данные запроса
        $requestData = [
            '_token' => csrf_token(),
            'booking_date' => $bookingDate,
            'persons' => $persons,
            'guest_name' => $guestName,
            'guest_email' => $guestEmail,
            'guest_phone' => $guestPhone,
            'notes' => $notes
        ];
        
        echo "<p>Данные запроса:</p>";
        echo "<pre>" . json_encode($requestData, JSON_PRETTY_PRINT) . "</pre>";
        
        // Записываем в лог начало теста
        \Log::info("======== НАЧАЛО ТЕСТА ПРЯМОГО БРОНИРОВАНИЯ ========");
        \Log::info("Пользователь: {$user->name} (ID: {$user->id})");
        \Log::info("Тур: {$tour->name} (ID: {$tour->id})");
        \Log::info("Данные запроса: " . json_encode($requestData));
        
        // Альтернативный способ: создаем запись бронирования вручную
        try {
            \Log::info("Создаем бронирование вручную...");
            
            // Рассчитываем общую стоимость
            $totalPrice = $tour->price * $persons;
            
            // Создаем объект бронирования
            $booking = new \App\Models\Booking();
            $booking->user_id = $user->id;
            $booking->guest_name = $guestName;
            $booking->guest_email = $guestEmail;
            $booking->guest_phone = $guestPhone;
            $booking->booking_date = $bookingDate;
            $booking->persons = $persons;
            $booking->total_price = $totalPrice;
            $booking->status = 'pending';
            $booking->notes = $notes;
            
            // Устанавливаем полиморфные связи
            $booking->bookable_type = 'App\\Models\\Tour';
            $booking->bookable_id = $tour->id;
            
            // Сохраняем бронирование
            $saved = $booking->save();
            
            echo "<p>Результат сохранения: " . ($saved ? "Успешно" : "Ошибка") . "</p>";
            echo "<p>ID бронирования: {$booking->id}</p>";
            
            \Log::info("Бронирование создано с ID: {$booking->id}");
            
            // Проверяем, что бронирование можно найти
            $freshBooking = \App\Models\Booking::find($booking->id);
            if ($freshBooking) {
                echo "<p class='success'>Бронирование успешно найдено в базе данных</p>";
                \Log::info("Бронирование успешно найдено в базе данных");
            } else {
                echo "<p class='error'>Бронирование не найдено в базе данных!</p>";
                \Log::error("Бронирование не найдено в базе данных!");
            }
            
            // Возвращаем URL для подтверждения бронирования
            $redirectUrl = route('bookings.confirmation', $booking->id);
            echo "<p>URL подтверждения: <a href='{$redirectUrl}' target='_blank'>{$redirectUrl}</a></p>";
            
            \Log::info("URL подтверждения: {$redirectUrl}");
            \Log::info("======== КОНЕЦ ТЕСТА ПРЯМОГО БРОНИРОВАНИЯ ========");
            
            echo "<p class='success'>Тест завершен успешно. Проверьте личный кабинет.</p>";
            echo "<p><a href='/cabinet/trips' target='_blank'>Открыть личный кабинет</a></p>";
            
            // Возвращаем информацию об успешном выполнении
            return [
                'success' => true,
                'booking_id' => $booking->id,
                'redirect' => $redirectUrl
            ];
            
        } catch (\Exception $bookingError) {
            echo "<p class='error'>Ошибка при создании бронирования: " . $bookingError->getMessage() . "</p>";
            \Log::error("Ошибка при создании бронирования: " . $bookingError->getMessage());
            \Log::error("Стек вызовов: " . $bookingError->getTraceAsString());
            
            throw $bookingError;
        }
        
    } catch (Exception $e) {
        \Log::error("Ошибка при прямом тестировании бронирования: " . $e->getMessage());
        \Log::error("Стек вызовов: " . $e->getTraceAsString());
        
        echo "<p class='error'>Ошибка: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
        
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    } finally {
        echo "</div>";
    }
}

// Форма для тестового бронирования
echo "<div class='section'>";
echo "<h2>Форма для прямого тестирования бронирования</h2>";

// Получаем список пользователей и туров для выбора
$users = User::all();
$tours = Tour::all();

if (count($users) == 0 || count($tours) == 0) {
    echo "<p class='error'>Не найдены пользователи или туры для тестирования</p>";
} else {
    echo "<form method='post'>";
    
    // Пользователь
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Пользователь:</label><br>";
    echo "<select name='user_id' required>";
    foreach ($users as $user) {
        echo "<option value='{$user->id}'>{$user->name} (ID: {$user->id})</option>";
    }
    echo "</select>";
    echo "</div>";
    
    // Тур
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Тур:</label><br>";
    echo "<select name='tour_id' required>";
    foreach ($tours as $tour) {
        $dateRange = "";
        if ($tour->start_date && $tour->end_date) {
            $dateRange = " (" . $tour->start_date->format('Y-m-d') . " - " . $tour->end_date->format('Y-m-d') . ")";
        }
        echo "<option value='{$tour->id}'>{$tour->name}{$dateRange} (ID: {$tour->id})</option>";
    }
    echo "</select>";
    echo "</div>";
    
    // Дата бронирования
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Дата бронирования:</label><br>";
    echo "<input type='date' name='booking_date' required value='" . date('Y-m-d') . "'>";
    echo "</div>";
    
    // Количество человек
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Количество человек:</label><br>";
    echo "<input type='number' name='persons' required value='1' min='1'>";
    echo "</div>";
    
    // Имя гостя
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Имя гостя:</label><br>";
    echo "<input type='text' name='guest_name' required>";
    echo "</div>";
    
    // Email гостя
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Email гостя:</label><br>";
    echo "<input type='email' name='guest_email' required>";
    echo "</div>";
    
    // Телефон гостя
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Телефон гостя:</label><br>";
    echo "<input type='tel' name='guest_phone' required>";
    echo "</div>";
    
    // Примечания
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Примечания:</label><br>";
    echo "<textarea name='notes'></textarea>";
    echo "</div>";
    
    echo "<button type='submit' name='test_booking'>Выполнить тестовое бронирование</button>";
    echo "</form>";
}

echo "</div>";

// Обработка отправленной формы
if (isset($_POST['test_booking'])) {
    $userId = $_POST['user_id'] ?? null;
    $tourId = $_POST['tour_id'] ?? null;
    $bookingDate = $_POST['booking_date'] ?? null;
    $persons = $_POST['persons'] ?? null;
    $guestName = $_POST['guest_name'] ?? null;
    $guestEmail = $_POST['guest_email'] ?? null;
    $guestPhone = $_POST['guest_phone'] ?? null;
    $notes = $_POST['notes'] ?? '';
    
    if (!$userId || !$tourId || !$bookingDate || !$persons || !$guestName || !$guestEmail || !$guestPhone) {
        echo "<div class='section error'>";
        echo "<p>Ошибка: Не все обязательные поля заполнены</p>";
        echo "</div>";
    } else {
        testDirectBooking($userId, $tourId, $bookingDate, $persons, $guestName, $guestEmail, $guestPhone, $notes);
    }
}

// Ссылки для навигации
echo "<div class='section'>";
echo "<h2>Навигация</h2>";
echo "<ul>";
echo "<li><a href='/debug_form.php'>Вернуться к отладке форм</a></li>";
echo "<li><a href='/'>На главную</a></li>";
echo "</ul>";
echo "</div>";

echo "</body></html>";
?> 