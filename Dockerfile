FROM serversideup/php:8.2-fpm-nginx

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN chmod -R 775 storage bootstrap/cache && \
    composer install --no-dev --optimize-autoloader

# Laravel init — jalan via s6-overlay SEBELUM nginx/php-fpm start
COPY --chmod=755 docker/docker-start.sh /etc/cont-init.d/00-laravel-init

EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=3s --start-period=120s --retries=3 \
    CMD curl -f http://localhost:8080/ || exit 1