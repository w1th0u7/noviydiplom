<?php
/**
 * Скрипт для проверки доступности файлов в storage
 * Запускать по адресу: https://rodinaa-tur.ru/storage_check.php
 */

// Отображать ошибки для отладки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Проверяем доступность директорий
$basePathPhysical = dirname(__FILE__);
$storagePathPhysical = $basePathPhysical . '/storage';

echo "<h1>Проверка доступности файлов в storage</h1>";

// Информация о базовом пути
echo "<h2>Информация о путях и файловой системе</h2>";
echo "<p>Физический путь к корню сайта: <code>{$basePathPhysical}</code></p>";
echo "<p>Физический путь к storage: <code>{$storagePathPhysical}</code></p>";

// Проверка существования директорий
echo "<h2>Проверка существования директорий:</h2>";
$dirs = [
    '/storage' => $basePathPhysical . '/storage',
    '/storage/tours' => $storagePathPhysical . '/tours',
    '/storage/excursions' => $storagePathPhysical . '/excursions',
];

echo "<ul>";
foreach ($dirs as $webPath => $physicalPath) {
    $exists = is_dir($physicalPath);
    $readable = is_readable($physicalPath);
    $writable = is_writable($physicalPath);
    $status = $exists ? "✅ Существует" : "❌ Не существует";
    $permStatus = '';
    
    if ($exists) {
        $permStatus .= $readable ? " | 📖 Доступна для чтения" : " | ❌ Недоступна для чтения";
        $permStatus .= $writable ? " | ✏️ Доступна для записи" : " | ❌ Недоступна для записи";
    }
    
    echo "<li><strong>{$webPath}</strong>: {$status}{$permStatus}</li>";
}
echo "</ul>";

// Проверка символической ссылки
$isSymlink = is_link($storagePathPhysical);
$symlinkTarget = $isSymlink ? readlink($storagePathPhysical) : 'Не является символической ссылкой';
echo "<p>Символическая ссылка: " . ($isSymlink ? "✅ Да, указывает на {$symlinkTarget}" : "❌ Нет") . "</p>";

// Попытка найти какие-либо изображения в storage/tours
echo "<h2>Поиск изображений в storage/tours:</h2>";
if (is_dir($storagePathPhysical . '/tours')) {
    $images = glob($storagePathPhysical . '/tours/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    
    if (count($images) > 0) {
        echo "<p>✅ Найдено " . count($images) . " изображений:</p><ul>";
        foreach ($images as $image) {
            $filename = basename($image);
            $webPath = "/storage/tours/{$filename}";
            echo "<li>{$filename} - <a href='{$webPath}' target='_blank'>Проверить доступность</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>❌ Изображений не найдено</p>";
    }
} else {
    echo "<p>❌ Директория storage/tours не существует</p>";
}

// Проверка файла .htaccess в storage
echo "<h2>Проверка файла .htaccess в storage:</h2>";
$htaccessPath = $storagePathPhysical . '/.htaccess';
if (file_exists($htaccessPath)) {
    echo "<p>✅ Файл .htaccess существует</p>";
    echo "<pre>" . htmlspecialchars(file_get_contents($htaccessPath)) . "</pre>";
} else {
    echo "<p>❌ Файл .htaccess не существует</p>";
}

// Конфигурация сервера
echo "<h2>Информация о сервере:</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "</pre>";

// Footer 
echo "<hr><p>Скрипт для проверки доступности файлов в storage</p>"; 