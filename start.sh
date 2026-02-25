#!/bin/bash

# Cambiar al directorio de la API
cd /app/FreeFire-Api

# Iniciar API Flask en background en puerto 5000
python app.py &

# Cambiar al directorio raíz
cd /app

# Iniciar servidor PHP en puerto 80
php -S 0.0.0.0:80 -t /app