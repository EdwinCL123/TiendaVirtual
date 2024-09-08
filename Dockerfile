# Utilizar la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar las dependencias del sistema necesarias para instalar Composer y otras extensiones de PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar los archivos de la aplicación al contenedor
COPY . /var/www/html

# Establecer los permisos adecuados para el directorio público (en este caso /assets/uploads)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 755 /var/www/html/assets/uploads \
    && chmod -R 644 /var/www/html/assets/uploads/*



# Instalar las dependencias de Composer si existe un archivo composer.json
RUN if [ -f composer.json ]; then composer install; fi

# Exponer el puerto 80 para el servicio web
EXPOSE 80

# Comando para iniciar Apache cuando se inicie el contenedor
CMD ["apache2-foreground"]
