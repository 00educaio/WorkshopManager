#!/bin/bash

# Sai se qualquer comando der erro
set -e

# Se não existir o .env, copia do .env.example (útil na primeira vez)
if [ ! -f .env ]; then
    echo "Criando arquivo .env..."
    cp .env.example .env
    php artisan key:generate
fi

# Rodar migrations (Cuidado em produção: idealmente isso é feito manualmente ou via CI/CD)
# Mas para deploy simples, ajuda muito.
echo "Rodando migrações..."
php artisan migrate --force
php artisan db:seed

echo "Limpando e criando caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ajusta permissões finais (caso volumes tenham alterado)
chown -R www-data:www-data /var/www/storage

echo "Iniciando PHP-FPM..."
exec "$@"