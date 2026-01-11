#!/bin/sh
set -e

echo "🚀 Starting Laravel application..."

if [ -z "$APP_KEY" ]; then
  echo "❌ APP_KEY is not set. Set it in Cloud Run env vars."
  exit 1
fi

# Log environment (safe, no secrets)
echo "APP_ENV=${APP_ENV:-}"
echo "APP_DEBUG=${APP_DEBUG:-}"
echo "APP_URL=${APP_URL:-}"

# Run database migrations
echo "📦 Running migrations..."
php artisan migrate --force

# Setup storage link for file uploads
echo "📁 Creating storage link..."
php artisan storage:link --force

# Publish Filament assets
echo "🎨 Publishing Filament assets..."
php artisan filament:assets

# Cache config and routes for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan icons:cache

echo "✅ Application ready!"
exec /usr/bin/supervisord -c /etc/supervisord.conf
