# Base image
FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/html

# Güncellemeleri ve gerekli paketleri yükle
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Xdebug kanalını güncelle
RUN pecl channel-update pecl.php.net

# Xdebug'i yükle
RUN pecl install xdebug-3.0.4 \
    && docker-php-ext-enable xdebug

# Diğer PHP uzantılarını yükle
RUN docker-php-ext-install pdo pdo_pgsql

# Xdebug yapılandırması için ayarları ekleyin
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# PHP ayarlarını kopyala
COPY ./docker/nginx/php.ini /usr/local/etc/php/php.ini

# Copy Symfony application files
COPY . /var/www/html

# Allow Composer plugins to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
