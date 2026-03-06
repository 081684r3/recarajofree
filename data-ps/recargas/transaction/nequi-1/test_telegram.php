<?php
// Script para probar la conectividad con Telegram
$botToken = '8649687947:AAF32CCBrBUFPm-C11qsD6acGAnNPoM2dcc';
$chatId = '-5238438739';

// Para chats privados con usuarios, el chat ID es positivo (ID del usuario)
// Para grupos/canales, es negativo y puede necesitar -100
// Vamos a probar con el ID original primero

echo "=== PRUEBA DE CONECTIVIDAD CON TELEGRAM ===\n\n";

// Probar getMe para obtener el ID del bot
echo "Obteniendo información del bot...\n";
$ch = curl_init("https://api.telegram.org/bot{$botToken}/getMe");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);
$meResponse = curl_exec($ch);
curl_close($ch);

$meResult = json_decode($meResponse, true);
if ($meResult && $meResult['ok']) {
    $botId = $meResult['result']['id'];
    echo "Bot ID: $botId\n";

    // Probar enviar mensaje al propio bot (chat privado consigo mismo)
    echo "Probando envío a chat privado del bot...\n";
    $payload = [
        'chat_id' => $botId,
        'text' => "🧪 *Prueba de conectividad*\n" . date('d/m/Y H:i:s'),
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "HTTP Code: $httpCode\n";
    $result = json_decode($response, true);
    if ($result && $result['ok']) {
        echo "✅ ¡Mensaje enviado al bot mismo!\n";
        echo "Esto significa que el bot funciona, pero el chat ID configurado es incorrecto.\n";
        echo "Para obtener el chat ID correcto:\n";
        echo "1. Crea un grupo o canal en Telegram\n";
        echo "2. Agrega el bot @" . ($meResult['result']['username'] ?? 'desconocido') . " al grupo/canal\n";
        echo "3. Envía un mensaje al grupo\n";
        echo "4. Usa @userinfobot o un bot similar para obtener el chat ID\n";
        echo "5. Actualiza el config.php con el chat ID correcto\n";
        exit;
    }
}

// Probar envío de mensaje simple
echo "Probando envío de mensaje...\n";
$message = "🧪 *Prueba de conectividad*\n" . date('d/m/Y H:i:s');

// Intentar enviar mensaje directamente
$payload = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

$ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
$result = json_decode($response, true);
if ($result && $result['ok']) {
    echo "✅ Mensaje enviado correctamente\n";
    echo "Mensaje ID: " . ($result['result']['message_id'] ?? 'N/A') . "\n";
} else {
    echo "❌ Error enviando mensaje\n";
    echo "Respuesta: $response\n";

    // Intentar con diferentes formatos de chat ID
    echo "\nProbando con diferentes formatos de chat ID...\n";

    $alternativeChatIds = [
        '-100' . ltrim($chatId, '-'), // Para canales
        ltrim($chatId, '-'), // ID positivo para usuarios
        '@' . ltrim($chatId, '-'), // Username si aplica
    ];

    foreach ($alternativeChatIds as $altChatId) {
        echo "Probando con: $altChatId\n";
        $payload['chat_id'] = $altChatId;

        $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $response = curl_exec($ch);
        $result = json_decode($response, true);
        curl_close($ch);

        if ($result && $result['ok']) {
            echo "✅ ¡Éxito con chat ID: $altChatId!\n";
            break;
        } else {
            echo "❌ Falló: " . ($result['description'] ?? 'Unknown error') . "\n";
        }
    }
}

$ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
$result = json_decode($response, true);
if ($result && $result['ok']) {
    echo "✅ Mensaje enviado correctamente\n";
} else {
    echo "❌ Error enviando mensaje\n";
    echo "Respuesta: $response\n";
}
?>