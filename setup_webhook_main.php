<?php
$token = '8262215506:AAHJjbwyPCnu7AwwWoLypQRSRAb-GWlLCD8';
$webhookUrl = 'https://freefire-app.onrender.com/webhook.php';

$url = 'https://api.telegram.org/bot' . $token . '/setWebhook?url=' . urlencode($webhookUrl);
$response = file_get_contents($url);
$data = json_decode($response, true);

echo 'Set Webhook Response:' . PHP_EOL;
echo json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;

// Verificar el webhook después de configurarlo
$url = 'https://api.telegram.org/bot' . $token . '/getWebhookInfo';
$response = file_get_contents($url);
$data = json_decode($response, true);
echo PHP_EOL . 'Webhook Info after setting:' . PHP_EOL;
echo json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;
?>