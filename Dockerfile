# Используем официальный образ PHP с поддержкой FPM
FROM php:8.2-fpm

# Устанавливаем необходимые пакеты и расширения
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Копируем только файлы composer для кеширования зависимостей
COPY composer.json composer.lock /var/www/

# Устанавливаем зависимости Composer (используем кеш)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts --no-progress --no-ansi

# Копируем оставшийся код проекта
COPY . /var/www

# Создаем директории, если они не существуют
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

# Устанавливаем правильные права на директории
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Устанавливаем рабочую директорию в контейнере
WORKDIR /var/www/html

# Веб-сервер будет работать от имени пользователя www-data
USER www-data
