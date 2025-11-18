FROM php:8.2-apache

# Instalar dependencias correctas para MySQL en Debian Bookworm
RUN apt-get update && apt-get install -y \
    mariadb-client \
    default-libmysqlclient-dev

# Instalar extensiones PHP para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activar mod_rewrite
RUN a2enmod rewrite

# Copiar tu proyecto (API)
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html
