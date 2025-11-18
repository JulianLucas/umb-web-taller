FROM php:8.2-apache

# Instalar extensiones necesarias para PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Copiar API dentro de Apache
COPY api/ /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite
    