<?php
// api_proxy.php - Proxy to internal Flask API
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Get the requested endpoint from the URL
$request_uri = $_SERVER['REQUEST_URI'];
$endpoint = str_replace('/api_proxy.php', '', $request_uri);

// Build the internal API URL
$internal_url = 'http://localhost:5000' . $endpoint;

// Add query parameters if any
if (!empty($_SERVER['QUERY_STRING'])) {
    $internal_url .= '?' . $_SERVER['QUERY_STRING'];
}

// For POST requests, forward the body
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $internal_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    curl_setopt($ch, CURLOPT_POST, true);
    $post_data = file_get_contents('php://input');
    if (!empty($post_data)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post_data)
        ]);
    }
}

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal API error', 'details' => $error]);
    exit;
}

http_response_code($http_code);
echo $response;
?>