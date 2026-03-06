<?php
// config.php para data-ps

// Cargar variables de entorno desde .env si existe (para desarrollo local)
if (file_exists(__DIR__ . '/../.env')) {
    $envFile = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envFile as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

return [
    'telegram_bot_token' => getenv('TELEGRAM_BOT_TOKEN') ?: 'default_token',
    'telegram_chat_id' => getenv('TELEGRAM_CHAT_ID') ?: 'default_chat',
    'environment' => getenv('VATIA_ENVIRONMENT') ?: 'development',
];
?>