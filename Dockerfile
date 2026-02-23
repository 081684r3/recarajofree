FROM php:8.3-cli

# Instalar extensiones necesarias si las hay
# RUN docker-php-ext-install pdo pdo_mysql

# Copiar archivos
COPY . /var/www/html

# Exponer puerto
EXPOSE 80

# Comando para servir
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]