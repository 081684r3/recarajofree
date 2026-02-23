FROM python:3.11-slim

# Instalar PHP
RUN apt-get update && apt-get install -y \
    php8.3-cli \
    php8.3-curl \
    && rm -rf /var/lib/apt/lists/*

# Instalar dependencias de Python
WORKDIR /app
COPY FreeFire-Api/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copiar archivos del proyecto
COPY . .

# Exponer puertos
EXPOSE 80 5000

# Script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]