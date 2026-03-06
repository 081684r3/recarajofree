<?php
// webhook.php - improved flow: generate a short-lived token stored server-side
// and edit the Telegram message to include a URL the user can open in browser.

// Cargar configuración
$config = require __DIR__ . '/config.php';

$log_file = __DIR__ . '/webhook.log';
$update = json_decode(file_get_contents('php://input'), true);
file_put_contents($log_file, date('Y-m-d H:i:s') . " - Received: " . json_encode($update) . "\n", FILE_APPEND);

if (isset($update['callback_query'])) {
    $cb = $update['callback_query'];
    $data = $cb['data'] ?? '';
    $parts = explode(':', $data);
    $action = $parts[0] ?? null;
    $transaction_id = $parts[1] ?? null;

    $chat_from = $cb['from']['id'] ?? null;
    $message = $cb['message'] ?? [];
    $chat_id = $message['chat']['id'] ?? ($cb['message']['chat']['id'] ?? null);
    $message_id = $message['message_id'] ?? null;

    // immediate answer so the user sees feedback
    $answer = [
        'callback_query_id' => $cb['id'],
        'text' => 'Procesando solicitud...',
        'show_alert' => false
    ];

    $ch = curl_init("https://api.telegram.org/bot" . $config['bot_token'] . "/answerCallbackQuery");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($answer),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    curl_exec($ch);
    curl_close($ch);

    // create token and store state server-side so browser can validate later
    $token = bin2hex(random_bytes(16));
    $dir = __DIR__ . '/callback_sessions';
    if (!is_dir($dir)) @mkdir($dir, 0755, true);

    $payload = [
        'action' => $action,
        'transaction_id' => $transaction_id,
        'chat_from' => $chat_from,
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'created_at' => time()
    ];

    file_put_contents($dir . '/' . $token . '.json', json_encode($payload, JSON_UNESCAPED_UNICODE));

    // Also save action for polling fallback
    $actionFile = __DIR__ . '/actions/' . $transaction_id . '.json';
    if (!is_dir(__DIR__ . '/actions')) @mkdir(__DIR__ . '/actions', 0755, true);
    file_put_contents($actionFile, json_encode(['action' => $action, 'timestamp' => time()]));

    // build a URL the user can open in the browser; will be validated by continue.php
    $base = rtrim($config['base_url'] ?? '', '/');
    $url = $base . '/continue.php?token=' . $token;

    // Edit the message to include a button that opens the URL
    if ($chat_id && $message_id) {
        $editApi = "https://api.telegram.org/bot" . $config['bot_token'] . "/editMessageReplyMarkup";
        $reply_markup = [
            'inline_keyboard' => [
                [[ 'text' => 'Continuar en navegador', 'url' => $url ]]
            ]
        ];

        $body = [
            'chat_id' => (int)$chat_id,
            'message_id' => (int)$message_id,
            'reply_markup' => $reply_markup
        ];

        $ch2 = curl_init($editApi);
        curl_setopt_array($ch2, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        $response = curl_exec($ch2);
        curl_close($ch2);
        
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - editMessageReplyMarkup response: " . $response . "\n", FILE_APPEND);
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Token generated: $token, URL: $url\n", FILE_APPEND);
    }

}

http_response_code(200);
echo "OK";

?>



