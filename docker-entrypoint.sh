#!/bin/sh

set -e

echo "🚀 Starting Laravel application..."

# Wait for database to be ready
echo "⏳ Waiting for database..."
sleep 5

# Check if vendor exists
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Check if .env exists
if [ ! -f ".env" ]; then
    echo "🔧 Creating .env file..."
    cp .env.example .env
    php artisan key:generate --force

    # Update database config
    sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' .env
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=laravel/' .env
    sed -i 's/DB_USERNAME=root/DB_USERNAME=laravel_user/' .env
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=laravel_password/' .env
fi

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

# Wait a bit more for database
sleep 10

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force 2>/dev/null || echo "⚠️  Migrations failed - database might not be ready yet"

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "✅ Laravel ready!"
echo "🌐 Access at: http://localhost:8000"

# Start FrankenPHP
exec frankenphp run --config /etc/caddy/Caddyfile
