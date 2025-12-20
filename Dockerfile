# =========================
# Backend (PHP + Nginx) - ÚNICO ESTÁGIO
# =========================
FROM serversideup/php:8.2-fpm-nginx

# Habilita cache e correções automáticas
ENV PHP_OPCACHE_ENABLE=1
ENV AUTORUN_ENABLED=true

# Troca para root para configurar
USER root
WORKDIR /var/www/html

# 1. Instala dependências do PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# 2. Copia TODO o código (incluindo a pasta public/build que agora está no Git)
COPY . .

# 3. Limpezas e Otimizações
RUN rm -rf public/hot
RUN composer dump-autoload --optimize

# 4. Garante permissões (Isso é crucial)
RUN chown -R www-data:www-data /var/www/html

# 5. Define usuário final
USER www-data