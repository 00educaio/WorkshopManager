# =========================
# Estágio 1: Frontend (Node)
# =========================
FROM node:20-alpine as frontend
WORKDIR /app

COPY package*.json vite.config.js ./
RUN npm install

# Copia apenas o necessário para o build
COPY resources/ ./resources/
COPY public/ ./public/
# Garante que não existe arquivo "hot" residual
RUN rm -rf public/hot
RUN npm run build

# =========================
# Estágio 2: Backend (Produção com Nginx)
# =========================
FROM serversideup/php:8.2-fpm-nginx

# Configurações de Ambiente
ENV PHP_OPCACHE_ENABLE=1
ENV AUTORUN_ENABLED=true

# Troca para root para poder instalar dependências e mudar permissões
USER root

WORKDIR /var/www/html

# 1. Copiar arquivos de dependência
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# 2. Copiar o código da aplicação
COPY . .

# 3. Copiar o build do frontend (CSS/JS)
COPY --from=frontend /app/public/build ./public/build

# 4. Ajustes Finais
RUN rm -rf public/hot
RUN composer dump-autoload --optimize

# --- A CORREÇÃO ESTÁ AQUI ---
# Mudamos de 'webuser' para 'www-data' que é o padrão universal
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Define o usuário que vai rodar o container (Não rodar como root)
USER www-data