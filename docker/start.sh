#!/bin/sh

echo "Starting Laravel application..."

# Check required env vars
if [ -z "$APP_KEY" ]; then
  echo "APP_KEY is not set. Set it in Cloud Run env vars."
  exit 1
fi

# Log environment (safe, no secrets)
echo "APP_ENV=${APP_ENV:-production}"
echo "APP_DEBUG=${APP_DEBUG:-false}"
echo "APP_URL=${APP_URL:-}"
echo "DB_HOST=${DB_HOST:-not set}"
echo "DB_DATABASE=${DB_DATABASE:-not set}"
echo "PEMIRA_SEED_DUMMY_PEMILIH=${PEMIRA_SEED_DUMMY_PEMILIH:-false}"

# Clear any stale cache
echo "Clearing cache..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run database migrations (don't fail if DB not ready)
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed or skipped"

# Seed admin user
echo "Seeding admin user..."
php artisan db:seed --class=Database\\Seeders\\AdminUserSeeder --force || echo "Admin seeding failed or skipped"

# Seed dummy voters only when explicitly enabled
if [ "${PEMIRA_SEED_DUMMY_PEMILIH:-false}" = "true" ]; then
  echo "Seeding dummy pemilih..."
  php artisan db:seed --class=Database\\Seeders\\PemilihSeeder --force || echo "Dummy pemilih seeding failed or skipped"
else
  echo "Skipping dummy pemilih seed"
fi

# Setup storage link for file uploads
echo "Creating storage link..."
php artisan storage:link --force || true

# Publish Filament assets
echo "Publishing Filament assets..."
php artisan filament:assets || echo "Filament assets skipped"

# Cache config and routes for production
echo "Optimizing for production..."
php artisan config:cache || echo "Config cache failed"
php artisan route:cache || echo "Route cache failed"
php artisan view:cache || echo "View cache failed"
php artisan icons:cache || echo "Icons cache skipped"

echo "Application ready! Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
