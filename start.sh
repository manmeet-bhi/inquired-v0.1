#!/bin/bash
set -e

echo "Starting deployment setup..."

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Cache configurations for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear

echo "Setup complete. Starting FrankenPHP..."
# Execute FrankenPHP, binding to the Railway provided PORT (defaults to 8080 if not set)
exec frankenphp php-server -r public/ --listen :${PORT:-8080}
