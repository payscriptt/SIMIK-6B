FROM php:8.4-fpm-alpine

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

# Konfigurasi Nginx agar mengarah ke folder /public Laravel
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php index.html; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/http.d/default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Pastikan permission folder storage Laravel aman
RUN chmod -R 777 storage bootstrap/cache

# Setup konfigurasi Nginx & Server Run (Menyalakan PHP-FPM dan Nginx bersamaan)
EXPOSE 80
CMD sh -c "php artisan config:cache && php artisan route:cache && php-fpm -D && nginx -g 'daemon off;'"