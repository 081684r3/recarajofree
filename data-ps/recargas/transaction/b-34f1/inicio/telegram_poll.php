<?php
function pollTelegramAction(string $botToken, string $transactionId, array $validActions, string $sessionKey): array
{
    $offset = $_SESSION[$sessionKey] ?? 0;
    $endpoint = "https://api.telegram.org/bot{$botToken}/getUpdates?offset=" . ($offset + 1);

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false || $response === null) {
        return ['action' => null, 'error' => $curlError ?: 'Sin respuesta de Telegram'];
    }

    $data = json_decode($response, true);
    if (empty($data['ok']) || empty($data['result'])) {
        return ['action' => null];
    }

    foreach ($data['result'] as $update) {
        $callback = $update['callback_query'] ?? null;
        if (!$callback || empty($callback['data'])) {
            continue;
        }

        if (strpos($callback['data'], $transactionId) === false) {
            continue;
        }

        $_SESSION[$sessionKey] = $update['update_id'];

        $actionType = explode(':', $callback['data'], 2)[0];
        if (!isset($validActions[$actionType])) {
            continue;
        }

        $callbackId = $callback['id'] ?? null;
        if ($callbackId) {
            telegramPost($botToken, 'answerCallbackQuery', [
                'callback_query_id' => $callbackId,
                'text' => 'Acción registrada',
                'show_alert' => false
            ]);
        }

        $message   = $callback['message'] ?? [];
        $chatId    = $message['chat']['id'] ?? null;
        $messageId = $message['message_id'] ?? null;

        if ($chatId && $messageId) {
            telegramPost($botToken, 'editMessageReplyMarkup', [
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'reply_markup' => ['inline_keyboard' => []]
            ]);
        }

        return ['action' => $validActions[$actionType]];
    }

    return ['action' => null];
}

function telegramPost(string $botToken, string $method, array $payload): void
{
    $ch = curl_init("https://api.telegram.org/bot{$botToken}/{$method}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_UNICODE));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_exec($ch);
    curl_close($ch);
}
