@echo off
REM Script ini otomatis setup Laravel dengan Docker untuk Windows
REM Untuk teman yang baru clone project

echo ========================================
echo  DIPP - Laravel Setup dengan Docker
echo ========================================
echo.

REM Check if Docker is running
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Docker tidak berjalan!
    echo         Silakan start Docker Desktop terlebih dahulu
    echo.
    pause
    exit /b 1
)

echo [OK] Docker detected
echo.

REM Stop container lama jika ada
echo Membersihkan container lama...
docker-compose down 2>nul

REM Build and start containers
echo.
echo Building Docker containers...
echo (Ini akan memakan waktu beberapa menit untuk pertama kali)
docker-compose up -d --build

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal build containers
    pause
    exit /b 1
)

echo.
echo Menunggu services siap (30 detik)...
timeout /t 30 /nobreak >nul

REM Install dependencies jika vendor tidak ada
if not exist "vendor\" (
    echo.
    echo Installing Composer dependencies...
    docker-compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader
)

REM Setup .env jika belum ada
if not exist ".env" (
    echo.
    echo Setting up environment file...
    docker-compose exec -T app cp .env.example .env
    docker-compose exec -T app php artisan key:generate
)

REM Update database config
echo.
echo Configuring database connection...
docker-compose exec -T app sed -i "s/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/" .env
docker-compose exec -T app sed -i "s/DB_HOST=127.0.0.1/DB_HOST=db/" .env
docker-compose exec -T app sed -i "s/DB_DATABASE=laravel/DB_DATABASE=laravel/" .env
docker-compose exec -T app sed -i "s/DB_USERNAME=root/DB_USERNAME=laravel_user/" .env
docker-compose exec -T app sed -i "s/DB_PASSWORD=/DB_PASSWORD=laravel_password/" .env

REM Set permissions
echo.
echo Setting permissions...
docker-compose exec -T app chmod -R 777 storage bootstrap/cache

REM Run migrations
echo.
echo Running database migrations...
docker-compose exec -T app php artisan migrate --force

echo.
echo ========================================
echo  SETUP SELESAI!
echo ========================================
echo.
echo Akses aplikasi di:
echo   Laravel App : http://localhost:8000
echo   phpMyAdmin  : http://localhost:8080
echo.
echo Database credentials:
echo   Host     : db (atau localhost:3306 dari host)
echo   Database : laravel
echo   Username : laravel_user
echo   Password : laravel_password
echo.
echo phpMyAdmin login:
echo   Username : root
echo   Password : root_password
echo.
echo Perintah berguna:
echo   docker-compose ps            # Lihat status
echo   docker-compose logs -f app   # Lihat logs
echo   docker-compose down          # Stop containers
echo   docker-compose restart       # Restart
echo.
pause
