FROM php:8.2-apache

# Copiar todo el código al servidor Apache
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite
