FROM php:8.2-apache

# Instalar extensiones necesarias para MYSQL (no PostgreSQL)
RUN docker-php-ext-install pdo pdo_mysql

# Copiar el proyecto al servidor Apache
COPY . /var/www/html/

# Habilitar mod_rewrite para APIs o rutas amigables
RUN a2enmod rewrite
