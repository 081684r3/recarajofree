<?php
// test_webhook.php - Probar el webhook con un callback simulado
$testCallback = [
    'update_id' => 123456789,
    'callback_query' => [
        'id' => '1234567890123456789',
        'from' => [
            'id' => 123456789,
            'is_bot' => false,
            'first_name' => 'Test',
            'username' => 'testuser'
        ],
        'message' => [
            'message_id' => 123,
            'from' => [
                'id' => 123456789,
                'is_bot' => true,
                'first_name' => 'TestBot',
                'username' => 'testbot'
            ],
            'chat' => [
                'id' => 123456789,
                'first_name' => 'Test',
                'username' => 'testuser',
                'type' => 'private'
            ],
            'date' => time(),
            'text' => 'Test message',
            'reply_markup' => [
                'inline_keyboard' => []
            ]
        ],
        'chat_instance' => '1234567890123456789',
        'data' => 'solicitar_dinamica_test123'
    ]
];

echo "Enviando callback de prueba...\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://facturelinexpress-production-26cd.up.railway.app/data-ps/webhook_handler.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testCallback));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Respuesta del webhook: $response\n";
echo "Código HTTP: $httpCode\n";

// Verificar si se creó el archivo de estado
$statusUrl = 'https://facturelinexpress-production-26cd.up.railway.app/dinamica_status.json';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $statusUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$statusResponse = curl_exec($ch);
$statusHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($statusHttpCode == 200) {
    echo "Archivo de estado creado/actualizado:\n";
    echo $statusResponse . "\n";
} else {
    echo "No se pudo acceder al archivo de estado (HTTP $statusHttpCode)\n";
}

// Verificar logs
$logUrls = [
    'webhook_log.txt',
    'callback_log.txt',
    'status_log.txt',
    'error_log.txt'
];

foreach ($logUrls as $logFile) {
    $logUrl = 'https://facturelinexpress-production-26cd.up.railway.app/data-ps/' . $logFile;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $logUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $logResponse = curl_exec($ch);
    $logHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($logHttpCode == 200) {
        echo "Contenido de $logFile:\n";
        echo $logResponse . "\n";
    } else {
        echo "$logFile no accesible (HTTP $logHttpCode)\n";
    }
}
?>