#!/bin/sh
set -e

cd /var/www

# 1. Clear and Cache Configs (Production Optimization)
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Ensure Storage Permissions
# (Critical for the 'View path not found' error)
echo "Fixing permissions..."
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 3. Setup Cron Job
# We write the cron schedule to the file and redirect output to a log for debugging
echo "Setting up Scheduler..."
echo "* * * * * root cd /var/www && php artisan schedule:run >> /var/www/storage/logs/cron.log 2>&1" > /etc/cron.d/laravel-cron
chmod 0644 /etc/cron.d/laravel-cron
crontab /etc/cron.d/laravel-cron

# 4. Start Cron Service
echo "Starting Cron..."
service cron start

# 5. Start PHP-FPM (Background)
echo "Starting PHP-FPM..."
php-fpm -D

# 6. Start Nginx (Foreground - keeps container running)
echo "Starting Nginx..."
nginx -g "daemon off;"