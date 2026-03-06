<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../config.php';

$message = $_POST['message'] ?? '';
$transactionId = $_POST['transactionId'] ?? '';

if (empty($message) || empty($transactionId)) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

echo json_encode([
    'status' => 'success',
    'messageId' => 'deshabilitado'
]);


