FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN chmod -R 775 storage bootstrap/cache && \
    composer install --no-dev --optimize-autoloader

# Laravel init — jalan via s6-overlay SEBELUM nginx/php-fpm start
USER root
RUN mkdir -p /etc/cont-init.d && \
    printf '#!/bin/sh\ncd /var/www/html\n\n# Bersihkan cache lama\nphp artisan route:clear 2>&1 || true\nphp artisan view:clear 2>&1 || true\nphp artisan config:clear 2>&1 || true\n\n# Cek & jalankan migrasi (gagal silently kalau DB belum connect)\nphp artisan migrate --force 2>&1 || true\n\nphp artisan storage:link --force 2>&1 || true\nphp artisan config:cache 2>&1 || true\nphp artisan view:cache 2>&1 || true\n' \
    > /etc/cont-init.d/00-laravel-init && \
    chmod +x /etc/cont-init.d/00-laravel-init

EXPOSE 8080

HEALTHCHECK --interval=60s --timeout=5s --start-period=180s --retries=5 \
    CMD curl -sf http://localhost:8080/healthcheck || exit 1