#!/usr/bin/with-contenv sh
cd /var/www/html

php artisan migrate --force 2>&1 || true
php artisan config:cache 2>&1 || true
php artisan route:cache 2>&1 || true
php artisan view:cache 2>&1 || true
