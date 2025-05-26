<?php
// Устанавливаем отображение ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    $log = file_get_contents($logFile);
    $lastLogs = array_slice(explode("\n", $log), -500);
    echo "<h1>Последние 500 строк лога</h1>";
    echo "<pre>";
    echo implode("\n", $lastLogs);
    echo "</pre>";
} else {
    echo "Файл лога не найден: " . $logFile;
}
?> 