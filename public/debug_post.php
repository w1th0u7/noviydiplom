<?php
// Отладочный файл для прямой отправки POST-запроса на бронирование через cURL

// Получаем данные
$tourId = $_GET['tour_id'] ?? 1;
$userId = $_GET['user_id'] ?? 1;
$date = $_GET['date'] ?? date('Y-m-d');

// Отображаем страницу
?>
<!DOCTYPE html>
<html>
<head>
    <title>Отладка POST запроса</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; }
        .panel { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .success { color: green; }
        .error { color: red; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; }
        button { padding: 10px 15px; background: #4285f4; color: white; border: none; cursor: pointer; }
        input, select { padding: 8px; margin-bottom: 10px; width: 100%; }
        label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Отладка POST запроса бронирования</h1>
        
        <div class="panel">
            <h2>Отправить POST запрос напрямую</h2>
            
            <?php
            // Если была нажата кнопка отправки
            if (isset($_POST['send_post'])) {
                $tourId = $_POST['tour_id'];
                $data = [
                    'booking_date' => $_POST['booking_date'],
                    'persons' => $_POST['persons'],
                    'guest_name' => $_POST['guest_name'],
                    'guest_email' => $_POST['guest_email'],
                    'guest_phone' => $_POST['guest_phone'],
                    '_token' => $_POST['_token']
                ];
                
                // Базовый URL сайта (протокол + домен)
                $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                
                // URL для бронирования
                $url = $baseUrl . "/tours/{$tourId}/book";
                
                // Инициализируем cURL
                $ch = curl_init($url);
                
                // Настройки запроса
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                // Включаем отслеживание заголовков
                curl_setopt($ch, CURLOPT_HEADER, 1);
                
                // Выполняем запрос
                $response = curl_exec($ch);
                $error = curl_error($ch);
                $info = curl_getinfo($ch);
                
                // Закрываем соединение
                curl_close($ch);
                
                // Выводим результаты
                echo "<h3>Результаты отправки POST запроса:</h3>";
                
                if ($error) {
                    echo "<div class='error'><strong>Ошибка cURL:</strong> $error</div>";
                }
                
                echo "<div><strong>HTTP код ответа:</strong> {$info['http_code']}</div>";
                echo "<div><strong>URL запроса:</strong> $url</div>";
                echo "<div><strong>Отправленные данные:</strong></div>";
                echo "<pre>" . print_r($data, true) . "</pre>";
                
                echo "<div><strong>Заголовки и тело ответа:</strong></div>";
                echo "<pre>" . htmlspecialchars($response) . "</pre>";
            }
            ?>
            
            <form method="post">
                <input type="hidden" name="send_post" value="1">
                
                <div>
                    <label for="tour_id">ID тура:</label>
                    <input type="number" name="tour_id" value="<?php echo $tourId; ?>" required>
                </div>
                
                <div>
                    <label for="_token">CSRF Token:</label>
                    <input type="text" name="_token" placeholder="Вставьте CSRF токен из страницы" required>
                    <p><small>Получить CSRF токен можно, открыв исходный код страницы тура и найдя input с name="_token"</small></p>
                </div>
                
                <div>
                    <label for="booking_date">Дата бронирования:</label>
                    <input type="date" name="booking_date" value="<?php echo $date; ?>" required>
                </div>
                
                <div>
                    <label for="persons">Количество человек:</label>
                    <input type="number" name="persons" value="1" min="1" required>
                </div>
                
                <div>
                    <label for="guest_name">Имя гостя:</label>
                    <input type="text" name="guest_name" value="Тестовый Гость" required>
                </div>
                
                <div>
                    <label for="guest_email">Email:</label>
                    <input type="email" name="guest_email" value="test@example.com" required>
                </div>
                
                <div>
                    <label for="guest_phone">Телефон:</label>
                    <input type="text" name="guest_phone" value="79001234567" required>
                </div>
                
                <button type="submit">Отправить POST запрос</button>
            </form>
        </div>
    </div>
</body>
</html> 