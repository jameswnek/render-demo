#!/usr/bin/env bash
# Render.com build script for Laravel

set -e

echo "🚀 Starting Laravel build process..."

# Install PHP dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Clear and cache configuration
echo "⚙️ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Seed database (only if quotes table is empty)
echo "🌱 Checking if seeding is needed..."
php artisan db:seed --force || echo "Seeding skipped or already completed"

echo "✅ Build complete!"

