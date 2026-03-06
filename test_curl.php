<?php
echo "cURL enabled: " . (function_exists('curl_init') ? 'YES' : 'NO') . PHP_EOL;

$ch = curl_init('https://httpbin.org/get');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: $httpCode" . PHP_EOL;
echo "Error: $error" . PHP_EOL;

if ($httpCode === 200) {
    echo "✅ Conectividad externa funciona" . PHP_EOL;
} else {
    echo "❌ Problema de conectividad" . PHP_EOL;
}
?>