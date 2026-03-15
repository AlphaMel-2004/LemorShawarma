#!/usr/bin/env sh
set -eu

# Railway volumes can mount with root ownership, so normalize required paths
# before running any Artisan command that may write logs/cache/sessions.
mkdir -p \
    /var/www/html/storage/logs \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R ug+rwX /var/www/html/storage /var/www/html/bootstrap/cache || true

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    php artisan migrate --force
fi

if [ "${RUN_DB_SEED:-true}" = "true" ]; then
    php artisan db:seed --force
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
