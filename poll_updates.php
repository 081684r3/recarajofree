<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$botToken = getenv('TELEGRAM_BOT_TOKEN') ?: 'YOUR_BOT_TOKEN_HERE';
$apiBase  = "https://api.telegram.org/bot{$botToken}";

function tg_call($method, $params = [])
{
    global $apiBase;
    $url = $apiBase . '/' . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$offset = file_exists('tg_offset.txt') ? (int)file_get_contents('tg_offset.txt') : 0;

$updates = tg_call('getUpdates', ['offset' => $offset, 'timeout' => 30]);

if ($updates && isset($updates['result'])) {
    foreach ($updates['result'] as $update) {
        $offset = max($offset, $update['update_id'] + 1);
        
        if (isset($update['message'])) {
            $message = $update['message'];
            $chat_id = $message['chat']['id'];
            $text = $message['text'] ?? '';
            
            // Responder a comandos
            if ($text === '/start') {
                tg_call('sendMessage', [
                    'chat_id' => $chat_id,
                    'text' => '¡Hola! Soy tu bot de recargas Free Fire.'
                ]);
            }
        }
    }
    
    file_put_contents('tg_offset.txt', $offset);
}

echo json_encode(['status' => 'ok', 'offset' => $offset]);
