<?php
// Подключаем автозагрузчик Laravel для получения доступа к моделям и базе данных
require __DIR__.'/../vendor/autoload.php';

// Загружаем переменные окружения
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Получаем подключение к базе данных
$db = $app->make('db');

// Подключаем модели
use App\Models\Tour;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $tourId = $_POST['tour_id'] ?? null;
    $userId = $_POST['user_id'] ?? null;
    $bookingDate = $_POST['booking_date'] ?? date('Y-m-d');
    $persons = $_POST['persons'] ?? 1;
    $guestName = $_POST['guest_name'] ?? '';
    $guestEmail = $_POST['guest_email'] ?? '';
    $guestPhone = $_POST['guest_phone'] ?? '';
    
    // Проверяем, что тур и пользователь существуют
    $tour = Tour::find($tourId);
    $user = User::find($userId);
    
    if ($tour && $user) {
        try {
            // Создаем бронирование напрямую
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->guest_name = $guestName;
            $booking->guest_email = $guestEmail;
            $booking->guest_phone = $guestPhone;
            $booking->booking_date = $bookingDate;
            $booking->persons = $persons;
            $booking->total_price = $tour->price * $persons;
            $booking->status = 'pending';
            $booking->notes = 'Создано через debug_form.php';
            $booking->bookable_type = 'App\\Models\\Tour';
            $booking->bookable_id = $tour->id;
            
            // Сохраняем
            $saved = $booking->save();
            
            if ($saved) {
                $message = "Бронирование успешно создано! ID: {$booking->id}";
                $success = true;
            } else {
                $message = "Ошибка при сохранении бронирования";
                $success = false;
            }
        } catch (Exception $e) {
            $message = "Ошибка: " . $e->getMessage();
            $success = false;
        }
    } else {
        $message = "Тур или пользователь не найдены";
        $success = false;
    }
}

// Получаем список пользователей и туров для формы
$users = User::all();
$tours = Tour::all();

// Простой HTML-вывод
?>
<!DOCTYPE html>
<html>
<head>
    <title>Отладочная форма бронирования</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; }
        .success { color: green; }
        .error { color: red; }
        label { display: block; margin-top: 10px; }
        input, select { margin-bottom: 10px; padding: 5px; width: 300px; }
        button { padding: 10px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Отладочная форма бронирования</h1>
    
    <?php if (isset($message)): ?>
        <div class="<?php echo $success ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <h2>Создать бронирование напрямую</h2>
        
        <label for="user_id">Пользователь:</label>
        <select name="user_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user->id; ?>"><?php echo $user->name; ?> (<?php echo $user->email; ?>)</option>
            <?php endforeach; ?>
        </select>
        
        <label for="tour_id">Тур:</label>
        <select name="tour_id" required>
            <?php foreach ($tours as $tour): ?>
                <option value="<?php echo $tour->id; ?>"><?php echo $tour->name; ?> (<?php echo $tour->price; ?>₽)</option>
            <?php endforeach; ?>
        </select>
        
        <label for="booking_date">Дата начала тура:</label>
        <input type="date" name="booking_date" value="<?php echo date('Y-m-d'); ?>" required>
        
        <label for="persons">Количество человек:</label>
        <input type="number" name="persons" value="1" min="1" required>
        
        <label for="guest_name">Имя гостя:</label>
        <input type="text" name="guest_name" required>
        
        <label for="guest_email">Email гостя:</label>
        <input type="email" name="guest_email" required>
        
        <label for="guest_phone">Телефон гостя:</label>
        <input type="tel" name="guest_phone" required>
        
        <button type="submit">Создать бронирование</button>
    </form>
    
    <h2>Существующие бронирования</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Тур/Экскурсия</th>
            <th>Дата</th>
            <th>Статус</th>
            <th>Создано</th>
        </tr>
        <?php
        $bookings = Booking::with(['user', 'bookable'])->orderBy('created_at', 'desc')->get();
        foreach ($bookings as $booking):
        ?>
        <tr>
            <td><?php echo $booking->id; ?></td>
            <td><?php echo $booking->user->name ?? 'Н/Д'; ?></td>
            <td>
                <?php 
                if ($booking->bookable) {
                    echo $booking->bookable->name . ' (' . class_basename($booking->bookable_type) . ')';
                } else {
                    echo 'Не найдено (тип: ' . $booking->bookable_type . ', ID: ' . $booking->bookable_id . ')';
                }
                ?>
            </td>
            <td><?php echo $booking->booking_date; ?></td>
            <td><?php echo $booking->status; ?></td>
            <td><?php echo $booking->created_at; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html> 