#!/usr/bin/env pwsh

<#
.SYNOPSIS
    Setup script untuk Fashion Brand E-Commerce Project

.DESCRIPTION
    Script ini akan melakukan instalasi lengkap project termasuk:
    - Install dependencies (Composer & npm)
    - Setup environment
    - Generate keys
    - Run migrations & seeders
    - Link storage
#>

Write-Host "`n╔══════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║     FASHION BRAND - E-COMMERCE SETUP SCRIPT           ║" -ForegroundColor Cyan
Write-Host "╚══════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

# Check if running in project directory
if (!(Test-Path "composer.json")) {
    Write-Host "[ERROR] Please run this script from the project root directory!" -ForegroundColor Red
    exit 1
}

Write-Host "[1/8] Checking requirements..." -ForegroundColor Yellow

# Check PHP
try {
    $phpVersion = php -v 2>$null
    if ($phpVersion -match "PHP (\d+\.\d+)") {
        Write-Host "  ✓ PHP $($matches[1]) found" -ForegroundColor Green
    }
} catch {
    Write-Host "  ✗ PHP not found. Please install PHP 8.2 or higher." -ForegroundColor Red
    exit 1
}

# Check Composer
try {
    $composerVersion = composer --version 2>$null
    Write-Host "  ✓ Composer found" -ForegroundColor Green
} catch {
    Write-Host "  ✗ Composer not found. Please install Composer." -ForegroundColor Red
    exit 1
}

# Check Node.js
try {
    $nodeVersion = node -v 2>$null
    Write-Host "  ✓ Node.js $nodeVersion found" -ForegroundColor Green
} catch {
    Write-Host "  ✗ Node.js not found. Please install Node.js 18.x or higher." -ForegroundColor Red
    exit 1
}

Write-Host "`n[2/8] Installing PHP dependencies..." -ForegroundColor Yellow
composer install --no-interaction
if ($LASTEXITCODE -eq 0) {
    Write-Host "  ✓ Composer packages installed" -ForegroundColor Green
} else {
    Write-Host "  ✗ Failed to install Composer packages" -ForegroundColor Red
    exit 1
}

Write-Host "`n[3/8] Installing Node.js dependencies..." -ForegroundColor Yellow
npm install
if ($LASTEXITCODE -eq 0) {
    Write-Host "  ✓ npm packages installed" -ForegroundColor Green
} else {
    Write-Host "  ✗ Failed to install npm packages" -ForegroundColor Red
    exit 1
}

Write-Host "`n[4/8] Setting up environment file..." -ForegroundColor Yellow
if (!(Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host "  ✓ .env file created from .env.example" -ForegroundColor Green
} else {
    Write-Host "  ! .env file already exists, skipping..." -ForegroundColor Yellow
}

Write-Host "`n[5/8] Generating application key..." -ForegroundColor Yellow
php artisan key:generate --no-interaction
if ($LASTEXITCODE -eq 0) {
    Write-Host "  ✓ Application key generated" -ForegroundColor Green
}

Write-Host "`n[6/8] Generating JWT secret..." -ForegroundColor Yellow
php artisan jwt:secret --no-interaction 2>$null
if ($LASTEXITCODE -eq 0) {
    Write-Host "  ✓ JWT secret generated" -ForegroundColor Green
}

Write-Host "`n[7/8] Setting up storage link..." -ForegroundColor Yellow
php artisan storage:link --no-interaction 2>$null
Write-Host "  ✓ Storage linked" -ForegroundColor Green

Write-Host "`n[8/8] Database setup..." -ForegroundColor Yellow
Write-Host "  Please ensure your database is created and .env is configured correctly." -ForegroundColor Cyan
$runMigrations = Read-Host "`n  Run database migrations now? (y/n)"

if ($runMigrations -eq "y" -or $runMigrations -eq "Y") {
    Write-Host "`n  Running migrations..." -ForegroundColor Yellow
    php artisan migrate --force

    if ($LASTEXITCODE -eq 0) {
        Write-Host "  ✓ Database migrated successfully" -ForegroundColor Green

        $runSeeders = Read-Host "`n  Seed database with sample products? (y/n)"
        if ($runSeeders -eq "y" -or $runSeeders -eq "Y") {
            Write-Host "`n  Seeding database..." -ForegroundColor Yellow
            php artisan db:seed --force

            if ($LASTEXITCODE -eq 0) {
                Write-Host "  ✓ Database seeded with 12 sample products" -ForegroundColor Green
            }
        }
    } else {
        Write-Host "  ✗ Migration failed. Please check your database configuration in .env" -ForegroundColor Red
    }
} else {
    Write-Host "  ! Skipping database migrations. Run 'php artisan migrate' later." -ForegroundColor Yellow
}

Write-Host "`n╔══════════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║              SETUP COMPLETED SUCCESSFULLY!             ║" -ForegroundColor Green
Write-Host "╚══════════════════════════════════════════════════════════╝`n" -ForegroundColor Green

Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "  1. Configure your database in .env file" -ForegroundColor White
Write-Host "  2. Run migrations: php artisan migrate" -ForegroundColor White
Write-Host "  3. Seed database: php artisan db:seed" -ForegroundColor White
Write-Host "  4. Start Laravel server: php artisan serve" -ForegroundColor White
Write-Host "  5. Start Vite dev server: npm run dev" -ForegroundColor White
Write-Host "  6. Visit: http://localhost:8000`n" -ForegroundColor White

Write-Host "For detailed setup guide, see: SETUP_GUIDE.md`n" -ForegroundColor Yellow
