<?php
// test_telegram.php - Test script to send a message to Telegram

$config = require __DIR__ . '/../config.php';
$botToken = $config['telegram_bot_token'];
$chatId = $config['telegram_chat_id'];

$message = "Test message from VATIA at " . date('Y-m-d H:i:s');

$payload = json_encode([
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'HTML'
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
    echo "SUCCESS: Message sent!\n";
} else {
    echo "ERROR: " . ($result['description'] ?? 'Unknown') . "\n";
}
?>