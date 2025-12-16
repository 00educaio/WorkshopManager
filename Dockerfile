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
# Usamos esta imagem que já vem com Nginx + PHP-FPM configurados para Laravel
FROM serversideup/php:8.2-fpm-nginx

# Configurações de Ambiente para Produção
ENV PHP_OPCACHE_ENABLE=1
ENV AUTORUN_ENABLED=true
# Usuário padrão desta imagem
USER root

WORKDIR /var/www/html

# 1. Copiar arquivos de dependência primeiro (Cache do Docker)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# 2. Copiar o código da aplicação
COPY . .

# 3. Copiar o build do frontend (CSS/JS)
COPY --from=frontend /app/public/build ./public/build

# 4. Ajustes Finais
# Remove o arquivo hot caso tenha vindo no COPY . .
RUN rm -rf public/hot
# Gera o autoloader otimizado
RUN composer dump-autoload --optimize
# Garante permissões corretas (para o usuário webuser da imagem)
RUN chown -R webuser:webuser /var/www/html/storage /var/www/html/bootstrap/cache

# Volta para o usuário não-root (segurança)
USER webuser

# O Entrypoint dessa imagem já roda as migrations automaticamente se você quiser
# Mas para garantir no Render, vamos definir o comando de boot: