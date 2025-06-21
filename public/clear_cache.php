<?php
// Скрипт для очистки кеша на хостинге

try {
    // Подключаем Laravel
    require_once __DIR__ . '/../bootstrap/app.php';
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    echo "🧹 Очистка кеша Laravel...\n\n";
    
    // Очистка кеша представлений
    try {
        $viewPath = storage_path('framework/views');
        if (is_dir($viewPath)) {
            $files = glob($viewPath . '/*');
            foreach($files as $file) {
                if(is_file($file)) {
                    unlink($file);
                }
            }
            echo "✅ Кеш представлений очищен\n";
        }
    } catch (Exception $e) {
        echo "⚠️ Ошибка при очистке кеша представлений: " . $e->getMessage() . "\n";
    }
    
    // Очистка кеша конфигурации
    try {
        $configPath = bootstrap_path('cache/config.php');
        if (file_exists($configPath)) {
            unlink($configPath);
            echo "✅ Кеш конфигурации очищен\n";
        }
    } catch (Exception $e) {
        echo "⚠️ Ошибка при очистке кеша конфигурации: " . $e->getMessage() . "\n";
    }
    
    // Очистка кеша маршрутов
    try {
        $routesPath = bootstrap_path('cache/routes-v7.php');
        if (file_exists($routesPath)) {
            unlink($routesPath);
            echo "✅ Кеш маршрутов очищен\n";
        }
    } catch (Exception $e) {
        echo "⚠️ Ошибка при очистке кеша маршрутов: " . $e->getMessage() . "\n";
    }
    
    echo "\n🎉 Кеш успешно очищен!\n";
    echo "📝 Рекомендация: перезапустите веб-сервер если возможно\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}
?> 