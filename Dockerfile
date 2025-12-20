# -------------------------------------------
# Estágio 1: Frontend (Node)
# -------------------------------------------
FROM node:20-alpine as frontend
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm install
COPY resources/ ./resources/
COPY public/ ./public/
RUN rm -rf public/hot
RUN npm run build

# -------------------------------------------
# Estágio 2: Backend (PHP + Nginx)
# -------------------------------------------
FROM serversideup/php:8.2-fpm-nginx

# Habilita cache e correções automáticas
ENV PHP_OPCACHE_ENABLE=1
ENV AUTORUN_ENABLED=true

# Troca para root para configurar permissões
USER root
WORKDIR /var/www/html

# Dependências
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# Código
COPY . .
COPY --from=frontend /app/public/build ./public/build

# Limpeza e Otimização
RUN rm -rf public/hot
RUN composer dump-autoload --optimize

# Permissões: O usuário padrão dessa imagem é 'www-data' (id 33)
# Damos permissão para ele ser dono de tudo
RUN chown -R www-data:www-data /var/www/html

# Volta para o usuário seguro
USER www-data