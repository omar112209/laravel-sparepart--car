FROM serversideup/php:8.2-fpm-nginx

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY --chown=www-data:www-data . .

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port yang diminta Railway
EXPOSE 8080

# Jalankan optimasi Laravel saat container jalan
CMD ["php", "artisan", "config:cache"] && ["php", "artisan", "route:cache"]