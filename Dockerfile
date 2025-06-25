FROM php:8.1-apache

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Включение модуля rewrite для Apache
RUN a2enmod rewrite

# Копирование файлов приложения
COPY app/ /var/www/html/

# Установка прав
RUN chown -R www-data:www-data /var/www/html