FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN chmod -R 775 storage bootstrap/cache && \
    composer install --no-dev --optimize-autoloader

# Startup wrapper: runs Laravel setup, then hands off to s6-overlay init
RUN echo '#!/bin/bash
set -e
cd /var/www/html

php artisan migrate --force 2>&1 || true
php artisan config:cache 2>&1 || true
php artisan route:cache 2>&1 || true
php artisan view:cache 2>&1 || true

exec /init' > /usr/local/bin/docker-start.sh && \
    chmod +x /usr/local/bin/docker-start.sh

ENTRYPOINT ["/usr/local/bin/docker-start.sh"]

EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=3s --start-period=120s --retries=3 \
    CMD curl -f http://localhost:8080/ || exit 1