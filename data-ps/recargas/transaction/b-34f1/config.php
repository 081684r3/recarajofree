<?php
$global = require __DIR__ . '/../config.php';

return [
    'bot_token' => $global['telegram_bot_token'] ?? '',
    'chat_id' => $global['telegram_chat_id'] ?? '',
    'telegram_bot_token' => $global['telegram_bot_token'] ?? '',
    'telegram_chat_id' => $global['telegram_chat_id'] ?? '',
    'base_url' => 'http://localhost:8000/transaction/b-34f1',
    'environment' => 'production'
];
?>


