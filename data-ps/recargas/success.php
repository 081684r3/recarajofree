<?php
// success.php - Página de confirmación de pago Free Fire
session_start();

// Obtener datos de la sesión
$formData = $_SESSION['freefire_data'] ?? [];
$banco = $_GET['banco'] ?? 'Desconocido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Procesado - Free Fire</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin: 20px 0;
        }

        .info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }

        .info div {
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .info strong {
            color: #333;
            display: inline-block;
            width: 120px;
        }

        .btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../../images/free-fire-icon.png" alt="Free Fire" class="logo">
        <h1>¡Pago Procesado!</h1>

        <div class="success-icon">✅</div>

        <div class="info">
            <div><strong>Jugador:</strong> <?php echo htmlspecialchars($formData['playerName'] ?? 'N/A'); ?> (ID: <?php echo htmlspecialchars($formData['playerId'] ?? 'N/A'); ?>)</div>
            <div><strong>Diamantes:</strong> <?php echo htmlspecialchars($formData['diamonds'] ?? '0'); ?> (Bonus: <?php echo htmlspecialchars($formData['bonus'] ?? '0'); ?>)</div>
            <div><strong>Monto:</strong> <?php echo htmlspecialchars($formData['price'] ?? 'N/A'); ?></div>
            <div><strong>Banco:</strong> <?php echo htmlspecialchars($banco); ?></div>
            <div><strong>Email:</strong> <?php echo htmlspecialchars($formData['correo'] ?? 'N/A'); ?></div>
            <div><strong>Fecha:</strong> <?php echo date('d/m/Y H:i:s'); ?></div>
        </div>

        <div class="warning">
            <strong>Nota:</strong> Esta es una versión de prueba. En producción, el pago sería procesado por el banco seleccionado.
        </div>

        <a href="../../index.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>