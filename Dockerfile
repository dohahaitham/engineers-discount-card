FROM php:8.2-cli

# تثبيت الأدوات والمكتبات الأساسية للضغط والبيئة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip

# جلب كنسول Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# تثبيت حزم المشروع وتجاوز متطلبات الامتدادات الصارمة
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

EXPOSE 10000

# تشغيل سيرفر لارافيل
CMD php artisan serve --host=0.0.0.0 --port=10000