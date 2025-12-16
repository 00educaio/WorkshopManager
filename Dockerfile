# =========================
# Estágio 1: Frontend
# =========================
FROM node:20-alpine as frontend
WORKDIR /app

COPY package*.json vite.config.js tailwind.config.js ./
RUN npm install

COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# =========================
# Estágio 2: Backend
# =========================
FROM php:8.2-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev zip \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo_mysql mbstring zip exif pcntl bcmath opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dependências PHP (sem scripts!)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Código
COPY . .

# Assets do frontend
COPY --from=frontend /app/public/build ./public/build

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan db:seed && \
    php artisan serve --host=0.0.0.0 --port=8000
