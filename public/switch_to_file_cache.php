<?php

echo "🔄 Переключение на файловый кеш Laravel...\n\n";

// Переходим в корневую директорию
chdir(__DIR__ . '/..');

echo "📁 Текущая директория: " . getcwd() . "\n\n";

try {
    // Проверяем текущие настройки кеша
    echo "📋 Текущие настройки кеша:\n";
    $envContent = file_get_contents('.env');
    
    if (strpos($envContent, 'CACHE_DRIVER=') !== false) {
        preg_match('/CACHE_DRIVER=(.*)/', $envContent, $matches);
        echo "Текущий драйвер: " . (isset($matches[1]) ? trim($matches[1]) : 'не найден') . "\n\n";
    } else {
        echo "CACHE_DRIVER не найден в .env\n\n";
    }
    
    // Изменяем настройки кеша на file
    echo "🔧 Изменяем CACHE_DRIVER на 'file'...\n";
    
    if (strpos($envContent, 'CACHE_DRIVER=') !== false) {
        $newEnvContent = preg_replace('/CACHE_DRIVER=.*/', 'CACHE_DRIVER=file', $envContent);
    } else {
        $newEnvContent = $envContent . "\nCACHE_DRIVER=file\n";
    }
    
    // Сохраняем изменения
    file_put_contents('.env', $newEnvContent);
    echo "✅ Настройки кеша изменены на 'file'\n\n";
    
    // Очищаем кеш конфигурации
    echo "🧹 Очищаем кеш конфигурации...\n";
    $commands = [
        'config:clear',
        'cache:clear'
    ];
    
    foreach ($commands as $command) {
        $output = [];
        $returnCode = 0;
        exec("php artisan $command 2>&1", $output, $returnCode);
        
        echo "Выполняем: php artisan $command\n";
        echo "Результат: " . implode("\n", $output) . "\n";
        
        if ($returnCode === 0) {
            echo "✅ $command - OK\n\n";
        } else {
            echo "⚠️ $command - код $returnCode\n\n";
        }
    }
    
    echo "🎉 Переключение на файловый кеш завершено!\n";
    echo "Теперь Laravel будет использовать файлы для кеширования.\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}

?> 