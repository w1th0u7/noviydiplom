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
use Illuminate\Support\Facades\Artisan;

echo "<!DOCTYPE html>
<html>
<head>
    <title>Выполнение миграций</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .log { background-color: #f5f5f5; padding: 10px; font-family: monospace; white-space: pre; }
        .success { color: green; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; }
        h2 { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Выполнение миграций и исправление таблицы bookings</h1>";

// Проверяем запрос
$action = $_GET['action'] ?? '';

if ($action === 'fix_bookings') {
    echo "<h2>Исправление таблицы bookings</h2>";
    
    try {
        echo "<div class='log'>";
        
        // Проверяем существование таблицы
        if (Schema::hasTable('bookings')) {
            echo "Таблица bookings существует\n";
            
            // Проверяем структуру таблицы
            $columns = Schema::getColumnListing('bookings');
            echo "Текущие столбцы: " . implode(', ', $columns) . "\n";
            
            // Проверяем наличие полей для полиморфной связи
            $hasBookableType = in_array('bookable_type', $columns);
            $hasBookableId = in_array('bookable_id', $columns);
            
            echo "Поле bookable_type: " . ($hasBookableType ? 'Есть' : 'Отсутствует') . "\n";
            echo "Поле bookable_id: " . ($hasBookableId ? 'Есть' : 'Отсутствует') . "\n";
            
            // Если не хватает полей для полиморфной связи, добавляем их
            if (!$hasBookableType || !$hasBookableId) {
                echo "Добавляем недостающие поля для полиморфной связи...\n";
                
                Schema::table('bookings', function ($table) use ($hasBookableType, $hasBookableId) {
                    if (!$hasBookableType) {
                        $table->string('bookable_type')->nullable();
                        echo "Добавлено поле bookable_type\n";
                    }
                    
                    if (!$hasBookableId) {
                        $table->unsignedBigInteger('bookable_id')->nullable();
                        echo "Добавлено поле bookable_id\n";
                    }
                    
                    if (!$hasBookableType || !$hasBookableId) {
                        $table->index(['bookable_type', 'bookable_id']);
                        echo "Добавлен индекс для полей bookable_type и bookable_id\n";
                    }
                });
                
                echo "Поля для полиморфной связи успешно добавлены\n";
            } else {
                echo "Все необходимые поля для полиморфной связи уже существуют\n";
            }
            
            // Проверяем тип поля status
            $statusInfo = DB::selectOne("SHOW COLUMNS FROM bookings WHERE Field = 'status'");
            echo "Текущий тип поля status: " . $statusInfo->Type . "\n";
            
            if ($statusInfo->Type !== "enum('pending','confirmed','cancelled','completed')") {
                echo "Изменяем тип поля status на enum...\n";
                DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'confirmed', 'cancelled', 'completed') NOT NULL DEFAULT 'pending'");
                echo "Тип поля status успешно изменен\n";
            } else {
                echo "Тип поля status уже соответствует требуемому\n";
            }
            
            // Проверяем наличие бронирований
            $bookingsCount = DB::table('bookings')->count();
            echo "Количество бронирований в базе данных: {$bookingsCount}\n";
            
            echo "Таблица bookings успешно исправлена\n";
        } else {
            echo "Таблица bookings не существует\n";
            echo "Создаем таблицу bookings...\n";
            
            Schema::create('bookings', function ($table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('guest_name');
                $table->string('guest_email');
                $table->string('guest_phone');
                $table->date('booking_date');
                $table->integer('persons')->default(1);
                $table->decimal('total_price', 10, 2);
                $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
                $table->text('notes')->nullable();
                
                // Полиморфные связи для туров и экскурсий
                $table->string('bookable_type');
                $table->unsignedBigInteger('bookable_id');
                $table->index(['bookable_type', 'bookable_id']);
                
                $table->timestamps();
            });
            
            echo "Таблица bookings успешно создана\n";
        }
        
        echo "</div>";
        
        echo "<p class='success'>Исправление таблицы bookings завершено успешно</p>";
    } catch (\Exception $e) {
        echo "</div>";
        echo "<p class='error'>Ошибка: " . $e->getMessage() . "</p>";
    }
} elseif ($action === 'run_migrations') {
    echo "<h2>Запуск миграций</h2>";
    
    try {
        echo "<div class='log'>";
        
        // Запускаем команду миграции
        Artisan::call('migrate', ['--force' => true]);
        echo Artisan::output();
        
        echo "</div>";
        
        echo "<p class='success'>Миграции выполнены успешно</p>";
    } catch (\Exception $e) {
        echo "</div>";
        echo "<p class='error'>Ошибка при выполнении миграций: " . $e->getMessage() . "</p>";
    }
} else {
    // Отображаем форму выбора действия
    echo "<h2>Выберите действие</h2>";
    echo "<p>Внимание: перед запуском миграций рекомендуется сделать резервную копию базы данных.</p>";
    
    echo "<form method='get'>";
    echo "<p><button type='submit' name='action' value='fix_bookings'>Исправить таблицу bookings</button></p>";
    echo "<p><button type='submit' name='action' value='run_migrations'>Запустить миграции</button></p>";
    echo "</form>";
}

// Навигационные ссылки
echo "<h2>Диагностические инструменты</h2>";
echo "<ul>
    <li><a href='/check_db.php'>Проверить структуру базы данных</a></li>
    <li><a href='/fix_booking.php'>Создать тестовое бронирование</a></li>
    <li><a href='/test_booking.php'>Тестовая форма бронирования</a></li>
    <li><a href='/show_logs.php'>Просмотр логов</a></li>
    <li><a href='/'>Вернуться на главную</a></li>
</ul>";

echo "</body></html>"; 