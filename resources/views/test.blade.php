<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест CSS</title>
    
    <!-- Вариант 1: через asset() -->
    <link rel="stylesheet" href="{{ asset('/css/test.css') }}">
    
    <!-- Вариант 2: прямой путь -->
    <link rel="stylesheet" href="/css/test.css">
    
    <!-- Вариант 3: полный URL -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/css/test.css">
</head>
<body>
    <h1>Тестовая страница для проверки CSS</h1>
    <p>Если стили работают, эта страница должна иметь серый фон, красную рамку, а заголовок должен быть синим.</p>
</body>
</html> 