# Utilizar la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Establecer el directorio de trabajo
WORKDIR /var/www/html/TiendaVirtual

# Instalar las dependencias del sistema necesarias para instalar Composer y otras extensiones de PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar los archivos de la aplicación al nuevo directorio TiendaVirtual
COPY . /var/www/html/TiendaVirtual

# Establecer los permisos adecuados para el nuevo directorio
RUN chown -R www-data:www-data /var/www/html/TiendaVirtual \
    && chmod -R 755 /var/www/html/TiendaVirtual \
    && chmod -R 755 /var/www/html/TiendaVirtual/assets/uploads \
    && chmod -R 644 /var/www/html/TiendaVirtual/assets/uploads/*

# Modificar DocumentRoot en Apache y añadir ServerName
RUN echo "<VirtualHost *:80>\n\
    ServerName 20.84.91.157\n\
    DocumentRoot /var/www/html/TiendaVirtual\n\
    <Directory /var/www/html/TiendaVirtual>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

# Habilitar módulos y reiniciar Apache
RUN a2enmod rewrite && service apache2 restart

# Instalar las dependencias de Composer si existe un archivo composer.json
RUN if [ -f composer.json ]; then composer install; fi

# Exponer el puerto 80 para el servicio web
EXPOSE 80

# Comando para iniciar Apache cuando se inicie el contenedor
CMD ["apache2-foreground"]
