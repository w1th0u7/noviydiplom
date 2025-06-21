<?php

// Секретный токен - ИЗМЕНИТЕ НА СВОЙ!
$secret = 'your_secret_token_here';

// Проверка токена
if (!isset($_GET['token']) || $_GET['token'] !== $secret) {
    http_response_code(403);
    die('Access denied');
}

// Логирование
function logMessage($message) {
    $logFile = __DIR__ . '/../deploy.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

logMessage("Webhook triggered from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));

try {
    // Переходим в корневую директорию
    chdir(__DIR__ . '/..');
    
    // Запускаем deploy.sh
    $output = [];
    $returnCode = 0;
    
    exec('bash deploy.sh 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        logMessage("Deploy successful");
        echo "✅ OK - Deploy successful\n";
        echo implode("\n", $output);
    } else {
        logMessage("Deploy failed with code: $returnCode");
        logMessage("Output: " . implode("\n", $output));
        http_response_code(500);
        echo "❌ FAILED - Deploy failed\n";
        echo implode("\n", $output);
    }
    
} catch (Exception $e) {
    logMessage("Exception: " . $e->getMessage());
    http_response_code(500);
    echo "❌ ERROR: " . $e->getMessage();
}

?> 