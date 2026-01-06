FROM composer:2 AS composer

FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy composer from composer image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Increase PHP memory limit for composer
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory.ini

# Copy everything
COPY . .

# Create directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Install dependencies with increased memory
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction

# Expose port
EXPOSE 10000

# Start the application
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
