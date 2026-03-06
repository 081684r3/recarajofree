<?php
$url = 'http://localhost:5000/get_player_personal_show?server=US&uid=1234567890';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);
echo 'HTTP Code: ' . $httpCode . PHP_EOL;
echo 'Response: ' . substr($response, 0, 200) . PHP_EOL;
echo 'Error: ' . $error . PHP_EOL;
?>