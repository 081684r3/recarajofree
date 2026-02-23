<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
file_put_contents('debug_apiv2.log', 'API called at ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

// ==========================================
// GET - Verificar jugador
// ==========================================
if ($method === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'verify') {
        $uid = $_GET['id'] ?? '';
        $region = strtolower($_GET['region'] ?? 'ind');

        if (empty($uid)) {
            echo json_encode(['success' => false, 'message' => 'ID requerido']);
            exit;
        }

        // API Python - Get Player Personal Show
        $url = "http://127.0.0.1:5000/get_player_personal_show?server=" . urlencode($region) . "&uid=" . urlencode($uid);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Error de conexión
        if ($error) {
            echo json_encode([
                'success' => false,
                'message' => 'No se pudo conectar con la API Python. Asegúrate de ejecutar: python app.py',
                'debug' => $error
            ]);
            exit;
        }

        // Respuesta exitosa
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);

            // Extraer datos de basicinfo
            if (isset($data['basicinfo']['nickname'])) {
                $player = $data['basicinfo'];

                echo json_encode([
                    'success' => true,
                    'nickname' => $player['nickname'],
                    'uid' => $player['accountid'] ?? $uid,
                    'region' => strtoupper($player['region'] ?? $region),
                    'level' => $player['level'] ?? 0,
                    'rank' => $player['rank'] ?? 0,
                    'rankingPoints' => $player['rankingpoints'] ?? 0,
                    'likes' => $player['liked'] ?? 0,
                    'csRank' => $player['csrank'] ?? 0,
                    'seasonId' => $player['seasonid'] ?? 0
                ]);
                exit;
            }

            // Error en la respuesta
            if (isset($data['error'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error: ' . $data['error']
                ]);
                exit;
            }

            // Respuesta vacía
            echo json_encode([
                'success' => false,
                'message' => 'Jugador no encontrado o datos incompletos'
            ]);
            exit;
        }

        // HTTP error
        echo json_encode([
            'success' => false,
            'message' => 'Error del servidor Python',
            'debug' => "HTTP $httpCode"
        ]);
        exit;
    }

    // Info de la API
    echo json_encode([
        'status' => 'API funcionando',
        'timestamp' => date('Y-m-d H:i:s'),
        'version' => '2.1',
        'python_server' => 'http://127.0.0.1:5000',
        'endpoints' => [
            'verify' => '/api.php?action=verify&id={UID}&region={ind|br|sg|us}'
        ]
    ]);
    exit;
}

// ==========================================
// POST - Procesar compra
// ==========================================
if ($method === 'POST') {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);

    if (!$input || !is_array($input)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
        exit;
    }

    $action = $input['action'] ?? '';

    if ($action === 'purchase') {
        $playerId = $input['playerId'] ?? '';
        $region = $input['region'] ?? 'IND';
        $diamonds = $input['diamonds'] ?? '';
        $payment = $input['payment'] ?? '';

        if (empty($playerId) || empty($diamonds) || empty($payment)) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos'
            ]);
            exit;
        }

        // Generar orden de pago
        $orderId = 'FF-' . time() . '-' . rand(1000, 9999);
        $paymentUrl = 'https://tupasarela.com/checkout?order=' . $orderId;

        echo json_encode([
            'success' => true,
            'paymentUrl' => $paymentUrl,
            'orderId' => $orderId,
            'message' => 'Redirigiendo a pasarela de pago...'
        ]);
        exit;
    }

    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Acción no válida'
    ]);
    exit;
}

// Método no permitido
http_response_code(405);
echo json_encode([
    'success' => false,
    'error' => 'Method not allowed'
]);
exit;
