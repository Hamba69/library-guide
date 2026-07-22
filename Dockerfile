# --- Stage 1: build frontend assets (Vite + Tailwind + Alpine) ---
FROM node:20-alpine AS assets

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build


# --- Stage 2: PHP + Apache runtime ---
FROM php:8.4-apache AS app

# System packages + PHP extensions Laravel needs
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpq-dev \
        libonig-dev \
        libpng-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Composer (copied straight from its official image, no separate install step)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# App code first, then the built assets from stage 1
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Point Apache at Laravel's public/ folder instead of the repo root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 10000
ENTRYPOINT ["entrypoint.sh"]