# =========================
# Estágio 1: Frontend (Node)
# =========================
FROM node:20-alpine as frontend
WORKDIR /app

COPY package*.json vite.config.js ./
RUN npm install

COPY resources/ ./resources/
COPY public/ ./public/
RUN rm -rf public/hot
RUN npm run build

# =========================
# Estágio 2: Backend (Produção com Nginx)
# =========================
FROM serversideup/php:8.2-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1
ENV AUTORUN_ENABLED=true

# Troca para root para configurar
USER root

WORKDIR /var/www/html

# 1. Dependências
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# 2. Código
COPY . .

# 3. Frontend Build
COPY --from=frontend /app/public/build ./public/build

# 4. Ajustes Finais
RUN rm -rf public/hot
RUN composer dump-autoload --optimize

# --- CORREÇÃO AQUI ---
# Mudamos para garantir que o www-data seja dono de TUDO dentro do html.
# Isso permite criar o symlink na pasta public e escrever logs/cache sem erro.
RUN chown -R www-data:www-data /var/www/html

# Define o usuário de execução
USER www-data