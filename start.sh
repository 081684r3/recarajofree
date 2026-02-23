#!/bin/bash

# Iniciar servidor PHP en background
php -S 0.0.0.0:80 -t /app &

# Cambiar al directorio de la API
cd /app/FreeFire-Api

# Iniciar API Flask
python app.py