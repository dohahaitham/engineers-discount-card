FROM php:8.2-fpm

# تثبيت الحزم والمكتبات الضرورية
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# تثبيت امتدادات PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN composer install --no-dev --optimize-autoloader

# ضبط المجلد العام للارافيل
EXPOSE 80

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80