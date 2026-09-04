# Build stage for assets
FROM node:24-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# PHP stage with built-in server for Railway
FROM php:8.2-cli-alpine

WORKDIR /app

# Install runtime dependencies
RUN apk add --no-cache \
    libcurl libxml2 postgresql-dev libpq oniguruma

# Install PHP extensions
RUN apk add --no-cache --virtual .build-deps \
    curl-dev libxml2-dev oniguruma-dev && \
    docker-php-ext-install bcmath ctype curl dom fileinfo filter mbstring pdo pdo_mysql pdo_pgsql session xml zip && \
    apk del .build-deps

# Copy composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Copy built assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Create necessary directories
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Generate app key if not exists
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan key:generate --force

# Cache Laravel configs
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port
EXPOSE 8000

# Start Laravel with built-in PHP server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
