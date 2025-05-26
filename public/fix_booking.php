<?php
// Инициализируем Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tour;
use App\Models\Booking;

// Устанавливаем отображение ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Диагностика и исправление проблемы с бронированиями</h1>";

// Проверяем авторизацию
$user = null;
if (Auth::check()) {
    $user = Auth::user();
    echo "<p>Авторизован пользователь: {$user->name} (ID: {$user->id})</p>";
} else {
    echo "<p>Пользователь не авторизован. <a href='/login'>Войти</a></p>";
}

// Проверяем структуру таблицы bookings
echo "<h2>Структура таблицы bookings</h2>";
$bookingsColumns = Schema::getColumnListing('bookings');
echo "<pre>";
print_r($bookingsColumns);
echo "</pre>";

// Проверяем наличие туров
echo "<h2>Доступные туры</h2>";
$tours = Tour::all();
if ($tours->count() > 0) {
    echo "<ul>";
    foreach ($tours as $tour) {
        echo "<li>ID: {$tour->id}, Название: {$tour->name}, Цена: {$tour->price}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Туры не найдены</p>";
}

// Проверяем существующие бронирования
echo "<h2>Существующие бронирования</h2>";
$bookings = Booking::all();
if ($bookings->count() > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Пользователь</th><th>Объект</th><th>Тип объекта</th><th>ID объекта</th><th>Дата</th><th>Статус</th></tr>";
    foreach ($bookings as $booking) {
        echo "<tr>";
        echo "<td>{$booking->id}</td>";
        echo "<td>{$booking->user_id}</td>";
        echo "<td>" . ($booking->bookable ? $booking->bookable->name : 'Не найден') . "</td>";
        echo "<td>{$booking->bookable_type}</td>";
        echo "<td>{$booking->bookable_id}</td>";
        echo "<td>{$booking->booking_date}</td>";
        echo "<td>{$booking->status}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Бронирования не найдены</p>";
}

// Форма для создания тестового бронирования
if ($user) {
    echo "<h2>Создать тестовое бронирование</h2>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='action' value='create_booking'>";
    
    echo "<label>Тур: <select name='tour_id'>";
    foreach ($tours as $tour) {
        echo "<option value='{$tour->id}'>{$tour->name}</option>";
    }
    echo "</select></label><br><br>";
    
    echo "<button type='submit'>Создать тестовое бронирование</button>";
    echo "</form>";
    
    // Обработка формы
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_booking') {
        try {
            $tourId = (int)$_POST['tour_id'];
            $tour = Tour::findOrFail($tourId);
            
            echo "<h3>Создание тестового бронирования</h3>";
            echo "<p>Тур: {$tour->name}</p>";
            
            DB::beginTransaction();
            
            // Создаем бронирование
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->guest_name = $user->name;
            $booking->guest_email = $user->email;
            $booking->guest_phone = '1234567890';
            $booking->booking_date = date('Y-m-d', strtotime('+7 days'));
            $booking->persons = 2;
            $booking->total_price = $tour->price * 2;
            $booking->status = 'pending';
            $booking->notes = 'Тестовое бронирование из fix_booking.php';
            
            // Устанавливаем полиморфные связи напрямую
            $booking->bookable_type = 'App\\Models\\Tour';
            $booking->bookable_id = $tour->id;
            
            // Выводим данные перед сохранением
            echo "<p>Данные бронирования перед сохранением:</p>";
            echo "<pre>";
            print_r($booking->toArray());
            echo "</pre>";
            
            // Сохраняем
            $result = $booking->save();
            
            if ($result) {
                DB::commit();
                echo "<p style='color:green'>Бронирование успешно создано с ID: {$booking->id}</p>";
                
                // Проверяем созданное бронирование
                $newBooking = Booking::with('bookable')->find($booking->id);
                echo "<p>Проверка созданного бронирования:</p>";
                echo "<pre>";
                print_r($newBooking->toArray());
                echo "</pre>";
                
                echo "<p>Полиморфная связь работает: " . ($newBooking->bookable ? 'Да' : 'Нет') . "</p>";
                if ($newBooking->bookable) {
                    echo "<p>Связанный объект: {$newBooking->bookable->name}</p>";
                }
                
                echo "<p><a href='/cabinet/trips'>Перейти в личный кабинет</a></p>";
            } else {
                DB::rollback();
                echo "<p style='color:red'>Ошибка при сохранении бронирования</p>";
            }
        } catch (Exception $e) {
            DB::rollback();
            echo "<p style='color:red'>Ошибка: " . $e->getMessage() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
}

// Добавляем ссылки для навигации
echo "<div style='margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;'>";
echo "<a href='/'>На главную</a> | ";
echo "<a href='/cabinet/trips'>Мои поездки</a> | ";
echo "<a href='/tours'>Все туры</a>";
echo "</div>"; 