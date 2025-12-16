# =========================
# Estágio 1: Frontend (Vite)
# =========================
FROM node:20-alpine as frontend
WORKDIR /app

COPY package*.json vite.config.js tailwind.config.js ./
RUN npm install

COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# =========================
# Estágio 2: Backend (Laravel)
# =========================
FROM php:8.3-cli

WORKDIR /var/www

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    zip \
 && rm -rf /var/lib/apt/lists/*

# Extensões PHP
RUN docker-php-ext-install \
    pdo_mysql mbstring zip exif pcntl bcmath opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dependências PHP (cache-friendly)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Código da aplicação
COPY . .

# Assets do frontend
COPY --from=frontend /app/public/build ./public/build

# Permissões
RUN chmod -R 775 storage bootstrap/cache

# Porta Railway
EXPOSE 8000

# Start
CMD php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
