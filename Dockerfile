# Stage 1: Build environment and Composer dependencies
FROM php:8.3-alpine AS builder

# Install system dependencies + SQLITE DEVELOPMENT LIBRARIES (sqlite-dev)
RUN apk add --no-cache \
    curl \
    unzip \
    libxml2-dev \
    libzip-dev \
    sqlite-dev

# Install the extensions needed for Laravel API + SQLite
RUN docker-php-ext-install \
    pdo_sqlite \
    bcmath \
    xml \
    zip

WORKDIR /var/www

# Copy the entire Laravel application code
COPY . /var/www

# Install Composer and production dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# Stage 2: Ultra-lightweight Production environment
FROM php:8.3-alpine AS production

# Install runtime utilities and SQLite shared runtime libraries (sqlite-libs)
RUN apk add --no-cache \
    zip \
    unzip \
    libxml2-dev \
    sqlite-libs

# Copy installed extensions from the builder stage
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

WORKDIR /var/www

# Copy the production PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy the application code and vendor dependencies from the builder stage
COPY --from=builder /var/www /var/www

RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Ensure directory permissions are accessible to the web process
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Railway assigns a dynamic port, but defaults to 8080 if not defined
ENV PORT=8080
EXPOSE 8080

# Run Laravel's native web server engine directly
CMD php artisan serve --host=0.0.0.0 --port=$PORT