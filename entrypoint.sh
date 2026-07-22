#!/bin/sh
set -e

# Render tells the container which port to listen on via $PORT.
# Apache defaults to 80, so rewrite both the port config and the vhost.
PORT="${PORT:-10000}"
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

if [ -z "$APP_KEY" ]; then
    echo "Warning: APP_KEY is not set. Generate one with 'php artisan key:generate --show' and add it in Render's environment variables."
fi

php artisan config:clear
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
