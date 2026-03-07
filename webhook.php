<?php
// Webhook principal que redirige a los webhooks específicos
$request_uri = $_SERVER['REQUEST_URI'] ?? '';

if (strpos($request_uri, '/nequi-1-webhook') !== false) {
    // Redirigir a nequi-1 webhook
    require_once __DIR__ . '/data-ps/recargas/transaction/nequi-1/webhook.php';
    exit;
}

// Si no es una ruta específica, devolver error
http_response_code(404);
echo "Webhook not found";
?>