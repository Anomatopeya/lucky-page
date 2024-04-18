# Використовуємо офіційний образ PHP 8.0
FROM php:8.3-fpm

# Встановлюємо PHP розширення та залежності
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        graphviz \
        wget \

    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-source delete \
    && curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

# Переключаємо робочу директорію
WORKDIR /var/www

# Додаємо глобальну змінну PATH для користувача "root"
RUN echo "export PATH=\"\$HOME/.composer/vendor/bin:\$PATH\"" >> /root/.bashrc
