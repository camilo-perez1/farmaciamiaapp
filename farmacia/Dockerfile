# Usamos PHP con Apache
FROM php:8.2-apache

# Instalamos las conexiones a la base de datos
RUN docker-php-ext-install mysqli pdo pdo_mysql

# --- CAMBIO CLAVE ---
# Copiamos tu carpeta 'farmacia' DENTRO de una carpeta 'farmacia' en el servidor.
# Así la ruta "/farmacia/css/style.css" volverá a ser válida.
COPY farmacia/ /var/www/html/farmacia/

# Truco extra: Creamos un index.php en la raíz que redirige automáticamente a /farmacia
# Así no verás una página en blanco al entrar.
RUN echo '<?php header("Location: /farmacia/"); ?>' > /var/www/html/index.php

# Abrimos el puerto
EXPOSE 80