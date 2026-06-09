FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN chmod -R 775 storage bootstrap/cache && \
    composer install --no-dev --optimize-autoloader

# Laravel init — jalan via s6-overlay SEBELUM nginx/php-fpm start
RUN mkdir -p /etc/cont-init.d && \
    printf '#!/bin/sh\ncd /var/www/html\nphp artisan migrate --force 2>&1 || true\nphp artisan config:cache 2>&1 || true\nphp artisan route:cache 2>&1 || true\nphp artisan view:cache 2>&1 || true\n' \
    > /etc/cont-init.d/00-laravel-init && \
    chmod +x /etc/cont-init.d/00-laravel-init

EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=3s --start-period=120s --retries=3 \
    CMD curl -f http://localhost:8080/ || exit 1