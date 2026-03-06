FROM python:3.11-slim

FROM python:3.11-slim-bookworm

# Instalar PHP
RUN apt-get update && apt-get install -y \
    wget \
    gnupg \
    lsb-release \
    && mkdir -p /etc/apt/keyrings \
    && wget -O /etc/apt/keyrings/sury.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/sury.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list \
    && apt-get update && apt-get install -y \
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