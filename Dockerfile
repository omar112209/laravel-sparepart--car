FROM serversideup/php:8.2-fpm-nginx

# Set working directory di dalam container
WORKDIR /var/www/html

# Menyalin seluruh file proyek ke dalam container
COPY --chown=www-data:www-data . .

# Mengatur izin akses (permission) folder agar Laravel tidak error 500
RUN chmod -R 775 storage bootstrap/cache

# Menjalankan composer install untuk mengunduh library PHP
RUN composer install --no-dev --optimize-autoloader

# Expose port standar web
EXPOSE 8080

# Jalankan migrasi database dan optimasi cache Laravel secara otomatis saat aplikasi dinyalakan
CMD php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && exec /entrypoint.sh