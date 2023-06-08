FROM php:8.0-fpm

RUN apt-get update && docker-php-ext-install pdo pdo_mysql

COPY ./../ /var/www/html


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --ignore-platform-reqs;

RUN echo "#!/bin/sh\n" \
  "php artisan migrate\n" > /var/www/html/start.sh

RUN chmod +x /var/www/html/start.sh
