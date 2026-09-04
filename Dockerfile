# Build stage
FROM node:24-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

# PHP stage
FROM dunglas/frankenphp:php8.2.33-alpine

WORKDIR /app

# Install PHP extensions
RUN install-php-extensions \
    bcmath ctype curl dom fileinfo filter hash mbstring openssl \
    pcre pdo pdo_mysql session tokenizer xml zip

# Copy composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Copy built assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Create necessary directories
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Cache Laravel configs
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port
EXPOSE 8000

# Start FrankenPHP
CMD ["frankenphp", "run", "--bind=0.0.0.0:8000"]
