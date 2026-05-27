# Stage 1: Build environment and Composer dependencies
FROM php:8.3-alpine AS builder

# Install system dependencies + PostgreSQL development libraries
RUN apk add --no-cache \
    curl \
    unzip \
    libxml2-dev \
    libzip-dev \
    postgresql-dev

# Install PHP extensions needed for Laravel + PostgreSQL
RUN docker-php-ext-install \
    pdo_pgsql \
    bcmath \
    xml \
    zip

WORKDIR /var/www

# Copy application code
COPY . /var/www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

# Install Laravel production dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --prefer-dist

# =========================================================

# Stage 2: Production image
FROM php:8.3-alpine AS production

# Install PostgreSQL runtime libraries
RUN apk add --no-cache \
    unzip \
    zip \
    libxml2-dev \
    postgresql-libs

# Copy PHP extensions from builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

WORKDIR /var/www

# Use production PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy Laravel application
COPY --from=builder /var/www /var/www

# Create Laravel required directories
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Render/Railway dynamic port
ENV PORT=8080

EXPOSE 8080

# Start Laravel server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT