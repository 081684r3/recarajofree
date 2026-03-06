<?php
// Script para probar un chat ID específico
// Uso: php test_chat_id.php <CHAT_ID>

if ($argc < 2) {
    echo "Uso: php test_chat_id.php <CHAT_ID>\n";
    echo "Ejemplo: php test_chat_id.php -1001234567890\n";
    exit(1);
}

$chatId = $argv[1];
$botToken = '8649687947:AAF32CCBrBUFPm-C11qsD6acGAnNPoM2dcc';

echo "Probando chat ID: $chatId\n";

$message = "🧪 *Prueba de chat ID*\n" . date('d/m/Y H:i:s');

$payload = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

$ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
$result = json_decode($response, true);

if ($result && $result['ok']) {
    echo "✅ ¡CHAT ID CORRECTO! Mensaje enviado.\n";
    echo "Actualiza config.php con: 'chat_id' => '$chatId'\n";
} else {
    echo "❌ Chat ID incorrecto o sin acceso\n";
    echo "Error: " . ($result['description'] ?? 'Unknown') . "\n";
}
?>