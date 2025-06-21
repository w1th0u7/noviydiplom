<?php
// Подключение к базе данных напрямую
$host = 'localhost';
$dbname = ''; // укажите имя вашей базы данных
$username = ''; // укажите имя пользователя
$password = ''; // укажите пароль

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Создание тестовой заявки
    $stmt = $pdo->prepare("INSERT INTO inquiries (name, phone, message, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        'Тестовый пользователь',
        '+7 999 999 99 99',
        'Тестовая заявка от скрипта',
        'new',
        date('Y-m-d H:i:s'),
        date('Y-m-d H:i:s')
    ]);
    
    if ($result) {
        echo "Заявка успешно создана!<br>";
        
        // Проверяем общее количество заявок
        $stmt = $pdo->query("SELECT COUNT(*) FROM inquiries");
        $count = $stmt->fetchColumn();
        echo "Общее количество заявок: " . $count . "<br>";
        
        // Показываем последние 5 заявок
        $stmt = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 5");
        $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Последние заявки:</h3>";
        foreach ($inquiries as $inquiry) {
            echo "ID: {$inquiry['id']}, Имя: {$inquiry['name']}, Телефон: {$inquiry['phone']}, Статус: {$inquiry['status']}, Дата: {$inquiry['created_at']}<br>";
        }
    }
    
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?> 