#!/bin/bash

# Script de inicio para la aplicación Free Fire
echo "🚀 Iniciando aplicación Free Fire..."

# Cambiar al directorio de la aplicación
cd /app

# Verificar que los archivos existen
if [ ! -f "index.php" ]; then
    echo "❌ Error: index.php no encontrado"
    exit 1
fi

if [ ! -d "FreeFire-Api" ]; then
    echo "❌ Error: Directorio FreeFire-Api no encontrado"
    exit 1
fi

# Iniciar servidor PHP en segundo plano
echo "📡 Iniciando servidor PHP..."
php -S 0.0.0.0:80 -t . &
PHP_PID=$!

# Esperar un momento para que PHP inicie
sleep 2

# Verificar que PHP está corriendo
if ! kill -0 $PHP_PID 2>/dev/null; then
    echo "❌ Error: Servidor PHP no pudo iniciarse"
    exit 1
fi

echo "✅ Servidor PHP corriendo en puerto 80 (PID: $PHP_PID)"

# Cambiar al directorio de la API de Python
cd FreeFire-Api

# Iniciar servidor Python
echo "🐍 Iniciando servidor Python..."
python app.py &
PYTHON_PID=$!

# Esperar un momento para que Python inicie
sleep 3

# Verificar que Python está corriendo
if ! kill -0 $PYTHON_PID 2>/dev/null; then
    echo "❌ Error: Servidor Python no pudo iniciarse"
    kill $PHP_PID 2>/dev/null
    exit 1
fi

echo "✅ Servidor Python corriendo en puerto 5000 (PID: $PYTHON_PID)"
echo "🎉 Aplicación Free Fire iniciada correctamente!"
echo "🌐 PHP: http://localhost:80"
echo "🔧 API Python: http://localhost:5000"

# Mantener el contenedor corriendo
wait