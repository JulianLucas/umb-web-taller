FROM php:8.2-apache

# Instalar dependencias necesarias para MySQL
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libmysqlclient-dev

# Instalar extensiones PHP para MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Activar mod_rewrite
RUN a2enmod rewrite

# Copiar tu proyecto completo
COPY . /var/www/html/

# Permisos opcionales
RUN chown -R www-data:www-data /var/www/html
