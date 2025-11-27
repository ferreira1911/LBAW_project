#!/bin/sh
set -e

cd /var/www

# 1. Passar variáveis de ambiente do Docker para o sistema
# (Isto é CRÍTICO: sem isto, o Cron não consegue ligar à BD)
printenv | grep -v "no_proxy" >> /etc/environment

# 2. Limpar e recriar caches do Laravel
echo "Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Garantir permissões nas pastas de storage
# (Resolve o erro 'View path not found' e problemas de logs)
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 4. Configurar o CRON
echo "Setting up Cron..."
# O output é enviado para storage/logs/cron.log para podermos ver erros se existirem
echo "* * * * * root cd /var/www && php artisan schedule:run >> /var/www/storage/logs/cron.log 2>&1" > /etc/cron.d/laravel-cron

while true; do
    php artisan schedule:run >> /dev/null 2>&1
    sleep 60
done &

# Definir permissões obrigatórias para o cron aceitar o ficheiro
chmod 0644 /etc/cron.d/laravel-cron
crontab /etc/cron.d/laravel-cron

# 5. Iniciar Serviços
echo "Starting Cron service..."
service cron start

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx..."
# Este comando mantém o contentor a correr (daemon off)
nginx -g "daemon off;"