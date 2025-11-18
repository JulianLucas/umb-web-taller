FROM php:8.2-apache

# Instalar extensiones necesarias para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Copiar archivos al servidor Apache
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite
