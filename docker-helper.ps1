# Docker Helper Script untuk Windows
# Jalankan dengan: .\docker-helper.ps1 [command]

param(
    [Parameter(Position=0)]
    [string]$Command = "help"
)

function Show-Help {
    Write-Host "Docker Helper Commands:" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "  start       - Start Docker containers" -ForegroundColor Green
    Write-Host "  stop        - Stop Docker containers" -ForegroundColor Yellow
    Write-Host "  restart     - Restart Docker containers" -ForegroundColor Yellow
    Write-Host "  build       - Rebuild Docker images" -ForegroundColor Magenta
    Write-Host "  logs        - Show container logs" -ForegroundColor Blue
    Write-Host "  shell       - Access app container shell" -ForegroundColor Blue
    Write-Host "  artisan     - Run artisan command (e.g., .\docker-helper.ps1 artisan migrate)" -ForegroundColor Blue
    Write-Host "  composer    - Run composer command" -ForegroundColor Blue
    Write-Host "  npm         - Run npm command" -ForegroundColor Blue
    Write-Host "  fresh       - Fresh install (rebuild + migrate)" -ForegroundColor Red
    Write-Host "  clean       - Clean all Docker cache and volumes" -ForegroundColor Red
    Write-Host ""
}

switch ($Command) {
    "start" {
        Write-Host "Starting Docker containers..." -ForegroundColor Green
        docker-compose up -d
        Write-Host "Containers started! Access app at http://localhost:8000" -ForegroundColor Green
    }
    "stop" {
        Write-Host "Stopping Docker containers..." -ForegroundColor Yellow
        docker-compose down
    }
    "restart" {
        Write-Host "Restarting Docker containers..." -ForegroundColor Yellow
        docker-compose restart
    }
    "build" {
        Write-Host "Building Docker images (this may take a while)..." -ForegroundColor Magenta
        docker-compose build --no-cache
        docker-compose up -d
    }
    "logs" {
        docker-compose logs -f app
    }
    "shell" {
        docker-compose exec app bash
    }
    "artisan" {
        $artisanCommand = $args -join " "
        docker-compose exec app php artisan $artisanCommand
    }
    "composer" {
        $composerCommand = $args -join " "
        docker-compose exec app composer $composerCommand
    }
    "npm" {
        $npmCommand = $args -join " "
        docker-compose exec app npm $npmCommand
    }
    "fresh" {
        Write-Host "Fresh installation..." -ForegroundColor Red
        docker-compose down -v
        docker-compose build --no-cache
        docker-compose up -d
        Start-Sleep -Seconds 5
        docker-compose exec app php artisan migrate:fresh --seed
        docker-compose exec app php artisan optimize:clear
    }
    "clean" {
        Write-Host "Cleaning Docker cache..." -ForegroundColor Red
        docker-compose down -v
        docker system prune -af --volumes
        Write-Host "Docker cleaned!" -ForegroundColor Green
    }
    default {
        Show-Help
    }
}
