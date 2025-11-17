# Dockerfile
FROM php:8.2-apache

# Instalar extensiones PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar API
COPY api/ /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Establecer permisos (opcional)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
