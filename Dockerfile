FROM php:8.3-fpm

# 1. Instalar dependências do sistema e CRON
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

# 3. Definir diretoria de trabalho
WORKDIR /var/www

# 4. Instalar dependências PHP
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --prefer-dist --no-progress --no-interaction --no-scripts

# 5. Copiar código da aplicação
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

# 7. Copiar configurações (PHP, Nginx, Env)
COPY ./etc/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./etc/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY .env.production /var/www/.env

# 8. Configurar Script de Arranque
COPY docker_run.sh /docker_run.sh
# Garante que o script é executável (mesmo vindo do Windows)
RUN chmod +x /docker_run.sh

EXPOSE 80

# O comando que arranca tudo (chama o script abaixo)
CMD ["/docker_run.sh"]