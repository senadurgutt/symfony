# Dockerfile
FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libssl-dev
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
RUN apt-get update && apt-get install -y nano

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]