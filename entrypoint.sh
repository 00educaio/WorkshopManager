#!/bin/sh

# 1. Roda as migrações automaticamente no deploy (opcional, mas recomendado)
# echo "Rodando migrações..."
# php artisan migrate --force

# 2. Inicia o Worker da fila em background (& no final é o segredo)
echo "Iniciando Fila..."
php artisan queue:work --verbose --tries=3 --timeout=90 &

# 3. Passa o controle para o sistema da imagem (que inicia o Nginx/PHP)
echo "Iniciando Servidor..."
exec /init