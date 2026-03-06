<?php
// test_send_telegram.php - Simulate sending data to send_telegram.php

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

$ch = curl_init('http://localhost:8000/data-ps/recargas/send_telegram.php');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";
?>