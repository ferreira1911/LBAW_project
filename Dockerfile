FROM php:8.3-fpm

# 1. Instalar dependências e CRON
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       nginx \
       libpq-dev \
       ca-certificates \
       zip \
       unzip \
       git \
       cron \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/* \
    && rm -f /etc/nginx/sites-enabled/default

# 2. Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Definir diretoria
WORKDIR /var/www

# 4. Instalar dependências PHP
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --prefer-dist --no-progress --no-interaction --no-scripts

# 5. Copiar código da app
COPY --chown=www-data:www-data . .

# 6. Criar pastas de storage e dar permissões (CRÍTICO)
RUN mkdir -p storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/testing \
             storage/framework/views \
             storage/logs \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 7. Copiar configurações
COPY ./etc/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./etc/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY .env.production /var/www/.env

# 8. Configurar Script de Arranque
COPY docker_run.sh /docker_run.sh
RUN chmod +x /docker_run.sh

# 9. Configurar Cron Job (Apenas configurar, não iniciar)
COPY ./etc/cron/laravel-cron /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron \
    && crontab /etc/cron.d/laravel-cron

EXPOSE 80

# O comando que vai arrancar tudo
CMD ["/docker_run.sh"]