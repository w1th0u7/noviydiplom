<?php

echo "🔧 Создание таблиц кеша Laravel...\n\n";

// Переходим в корневую директорию
chdir(__DIR__ . '/..');

echo "📁 Текущая директория: " . getcwd() . "\n\n";

try {
    // Создаем таблицу кеша
    echo "🗃️ Выполняем: php artisan cache:table\n";
    $output = [];
    $returnCode = 0;
    
    exec('php artisan cache:table 2>&1', $output, $returnCode);
    
    echo "Результат:\n";
    echo implode("\n", $output) . "\n\n";
    
    if ($returnCode === 0) {
        echo "✅ Команда cache:table выполнена успешно\n\n";
    } else {
        echo "⚠️ Команда cache:table завершилась с кодом: $returnCode\n\n";
    }
    
    // Запускаем миграции
    echo "🗄️ Выполняем: php artisan migrate\n";
    $output = [];
    $returnCode = 0;
    
    exec('php artisan migrate 2>&1', $output, $returnCode);
    
    echo "Результат:\n";
    echo implode("\n", $output) . "\n\n";
    
    if ($returnCode === 0) {
        echo "✅ Миграции выполнены успешно\n\n";
    } else {
        echo "❌ Ошибка миграций: код $returnCode\n\n";
    }
    
    echo "🎉 Создание таблиц кеша завершено!\n";
    echo "Теперь можно использовать кеш через базу данных.\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}

?> 