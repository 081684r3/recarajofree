<?php
// webhook_handler.php para data-ps
header('Content-Type: application/json');
echo json_encode(['status' => 'webhook received']);
?>