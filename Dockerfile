FROM php:8.2-fpm-alpine

# Install extensions yang dibutuhkan Laravel & PostgreSQL
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Setup working directory
WORKDIR /var/www/html
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Setup konfigurasi Nginx & Server Run
EXPOSE 80
CMD sh -c "php artisan config:cache && php artisan route:cache && nginx -g 'daemon off;'"