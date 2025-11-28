FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiamos la carpeta farmacia entera a una subcarpeta en el servidor
COPY farmacia/ /var/www/html/farmacia/

# Creamos un atajo para que al entrar al sitio te mande directo a /farmacia
RUN echo '<?php header("Location: /farmacia/"); ?>' > /var/www/html/index.php

EXPOSE 80