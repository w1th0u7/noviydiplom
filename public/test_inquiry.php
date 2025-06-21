<?php
// Тестовый файл для проверки базы данных
require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost', // или ваш хост базы данных
    'database' => 'your_database_name', // имя вашей базы данных
    'username' => 'your_username', // имя пользователя
    'password' => 'your_password', // пароль
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Попытка создать тестовую заявку
    $result = Capsule::table('inquiries')->insert([
        'name' => 'Тест',
        'phone' => '+7 999 999 99 99',
        'message' => 'Тестовая заявка',
        'status' => 'new',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    if ($result) {
        echo "Заявка успешно создана!";
        
        // Проверяем количество заявок
        $count = Capsule::table('inquiries')->count();
        echo "<br>Всего заявок в базе: " . $count;
    } else {
        echo "Ошибка при создании заявки";
    }
    
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
?> 