# Estágio 1: Build do Frontend (NodeJS)
FROM node:20-alpine as frontend
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm install
COPY resources/ ./resources/
COPY public/ ./public/
COPY tailwind.config.js ./
RUN npm run build

# Estágio 2: Build do Backend (PHP + Composer)
FROM php:8.2-fpm as backend

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libsqlite3-dev

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache pdo_sqlite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar apenas arquivos de dependência primeiro (para cache do Docker)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copiar o restante da aplicação
COPY . .

# Copiar o build do frontend do Estágio 1
COPY --from=frontend /app/public/build ./public/build

# Gerar autoload otimizado
RUN composer dump-autoload --optimize

# Configurar permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copiar entrypoint customizado
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]