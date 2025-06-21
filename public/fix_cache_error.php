<?php

echo "🔧 Исправление ошибки кеша Laravel...\n\n";

// Переходим в корневую директорию
chdir(__DIR__ . '/..');

echo "📁 Текущая директория: " . getcwd() . "\n";

try {
    // Создаем таблицы кеша
    echo "🗃️ Создание таблиц кеша...\n";
    $output = [];
    $returnCode = 0;
    
    exec('php8.2 artisan cache:table 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "✅ Команда cache:table выполнена успешно\n";
        echo implode("\n", $output) . "\n";
    } else {
        echo "⚠️ Команда cache:table вернула код: $returnCode\n";
        echo implode("\n", $output) . "\n";
    }
    
    // Запускаем миграции
    echo "\n🗄️ Запуск миграций...\n";
    $output = [];
    $returnCode = 0;
    
    exec('php8.2 artisan migrate --force 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "✅ Миграции выполнены успешно\n";
        echo implode("\n", $output) . "\n";
    } else {
        echo "❌ Ошибка миграций: код $returnCode\n";
        echo implode("\n", $output) . "\n";
    }
    
    // Очищаем кеш
    echo "\n🧹 Очистка кеша...\n";
    $commands = [
        'cache:clear',
        'config:clear', 
        'view:clear',
        'route:clear'
    ];
    
    foreach ($commands as $command) {
        $output = [];
        $returnCode = 0;
        exec("php8.2 artisan $command 2>&1", $output, $returnCode);
        
        if ($returnCode === 0) {
            echo "✅ $command - OK\n";
        } else {
            echo "⚠️ $command - код $returnCode\n";
            echo implode("\n", $output) . "\n";
        }
    }
    
    echo "\n🎉 Исправление завершено! Попробуйте обновить сайт.\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}

?> 