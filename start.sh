#!/bin/bash

# Usar puerto de Railway (o 80 por defecto)
PORT=${PORT:-80}

# Cambiar al directorio de la API
cd /app/FreeFire-Api

# Iniciar API Flask en background en puerto 5000
python app.py &

# Cambiar al directorio raíz
cd /app

# Iniciar servidor PHP en el puerto especificado
php -S 0.0.0.0:$PORT -t /app