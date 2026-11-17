FROM php:8.3-cli-alpine

# Install system dependencies and php extensions
RUN apk add --no-cache \
    sqlite-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql gd zip bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Prepare environment and SQLite database
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    touch database/database.sqlite && \
    php artisan key:generate --force && \
    php artisan storage:link || true

ENV PORT=10000
ENV DB_CONNECTION=sqlite
ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 10000

# Start server: migrate database, seed default admin & pengurus, cache config, and run server
CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
