FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

USER root
RUN apt-get update && \
    apt-get install -y --no-install-recommends libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd && \
    apt-get clean && rm -rf /var/lib/apt/lists/* && \
    chmod -R 775 storage bootstrap/cache && \
    composer install --no-dev --optimize-autoloader

# Laravel init — jalan via s6-overlay SEBELUM nginx/php-fpm start
USER root
RUN mkdir -p /etc/cont-init.d && \
    printf '#!/bin/sh\ncd /var/www/html\n\n# 1. Bersihkan cache lama\nphp artisan route:clear 2>&1 || true\nphp artisan view:clear 2>&1 || true\nphp artisan config:clear 2>&1 || true\n\n# 2. Cache config DULU supaya Railway env vars (DATABASE_URL/MYSQL_*) kepakai\nphp artisan config:cache 2>&1 || true\n\n# 3. Baru jalankan migrasi (pake config yg udah di-cache)\nphp artisan migrate --force 2>&1 || true\n\n# 4. Buat direktori upload (gitignored, jd gak ikut ke deploy) + beri hak www-data\nmkdir -p storage/framework/sessions storage/framework/cache storage/framework/views storage/app/public/img-produk storage/app/public/img-customer storage/app/public/img-user storage/app/public/img-retur\nchown www-data:www-data storage/framework/sessions storage/framework/cache storage/framework/views storage/app/public/img-produk storage/app/public/img-customer storage/app/public/img-user storage/app/public/img-retur\n\n# 5. Storage link\nphp artisan storage:link --force 2>&1 || true\n\n# 6. Cache view\nphp artisan view:cache 2>&1 || true\n' \
    > /etc/cont-init.d/00-laravel-init && \
    chmod +x /etc/cont-init.d/00-laravel-init

EXPOSE 8080

HEALTHCHECK --interval=60s --timeout=5s --start-period=180s --retries=5 \
    CMD curl -sf http://localhost:8080/healthcheck || exit 1