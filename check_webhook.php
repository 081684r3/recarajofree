<?php
$token = '8262215506:AAHJjbwyPCnu7AwwWoLypQRSRAb-GWlLCD8';
$url = 'https://api.telegram.org/bot' . $token . '/getWebhookInfo';
$response = file_get_contents($url);
$data = json_decode($response, true);
echo 'Webhook Info:' . PHP_EOL;
echo json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;
?>