# 🎯 COMMAND REFERENCE - Fashion Brand Project

## 📦 Installation Commands

### Initial Setup
```powershell
# Automated setup (Recommended)
.\setup.ps1

# Manual setup
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan storage:link
```

---

## 🗄️ Database Commands

### Migration & Seeding
```powershell
# Run migrations
php artisan migrate

# Run migrations fresh (drop all tables first)
php artisan migrate:fresh

# Run seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=ProductSeeder

# Migration fresh + seed (reset everything)
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback
```

### Database Info
```powershell
# Show database info
php artisan db:show

# Show table info
php artisan db:table products
php artisan db:table orders
```

---

## 🚀 Development Server Commands

### Laravel Server
```powershell
# Start Laravel development server
php artisan serve

# Start on specific port
php artisan serve --port=8080

# Start on specific host
php artisan serve --host=0.0.0.0
```

### Frontend Build Tool
```powershell
# Start Vite dev server (Hot reload)
npm run dev

# Build for production
npm run build
```

---

## 🧹 Cache & Optimization Commands

### Clear Cache
```powershell
# Clear all cache
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear compiled classes
php artisan clear-compiled
composer dump-autoload
```

### Optimization (Production)
```powershell
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Run all optimizations
php artisan optimize
```

---

## 🔑 JWT Commands

### JWT Management
```powershell
# Generate JWT secret
php artisan jwt:secret

# Force overwrite JWT secret
php artisan jwt:secret --force
```

---

## 📂 Storage Commands

### Storage Management
```powershell
# Create symbolic link
php artisan storage:link

# Remove storage link
Remove-Item public\storage
```

---

## 🔍 Debug & Testing Commands

### Artisan Commands
```powershell
# List all artisan commands
php artisan list

# Show help for specific command
php artisan help migrate

# Interactive tinker shell
php artisan tinker
```

### Routes
```powershell
# List all routes
php artisan route:list

# List API routes only
php artisan route:list --path=api

# Search specific route
php artisan route:list --name=products
```

### Database Queries (Tinker)
```powershell
# Open tinker
php artisan tinker

# In tinker:
App\Models\Product::count()
App\Models\Product::all()
App\Models\Product::where('category', 'Shoes')->get()
App\Models\Order::with('user', 'product')->latest()->take(5)->get()
```

---

## 📊 Useful Laravel Commands

### Generate Commands
```powershell
# Generate controller
php artisan make:controller Api/ProductController

# Generate model
php artisan make:model Product -m

# Generate migration
php artisan make:migration create_products_table

# Generate seeder
php artisan make:seeder ProductSeeder

# Generate middleware
php artisan make:middleware JwtMiddleware
```

---

## 🌐 HeidiSQL Queries

### Database Management
```sql
-- Create database
CREATE DATABASE fashion_brand_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use database
USE fashion_brand_db;

-- Show tables
SHOW TABLES;

-- Describe table structure
DESCRIBE products;
DESCRIBE orders;
DESCRIBE users;

-- Count records
SELECT COUNT(*) FROM products;
SELECT COUNT(*) FROM orders;

-- View all products
SELECT id, slug, brand, name, category, price, stock FROM products;

-- View all orders
SELECT o.id, o.uuid, u.name as customer, p.name as product, o.quantity, o.total_price, o.status
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN products p ON o.product_id = p.id;

-- Products by category
SELECT * FROM products WHERE category = 'Shoes';

-- Low stock products
SELECT name, stock FROM products WHERE stock < 10 ORDER BY stock ASC;

-- Orders by status
SELECT COUNT(*) as count, status FROM orders GROUP BY status;

-- Total sales
SELECT SUM(total_price) as total_sales FROM orders WHERE status = 'completed';

-- Clear all data (keep structure)
TRUNCATE TABLE orders;
TRUNCATE TABLE products;
TRUNCATE TABLE users;

-- Drop database
DROP DATABASE IF EXISTS fashion_brand_db;
```

---

## 🧪 Testing API with cURL

### Authentication
```powershell
# Register
curl -X POST http://localhost:8000/api/auth/register `
  -H "Content-Type: application/json" `
  -d '{"name":"Test User","email":"test@example.com","password":"password123"}'

# Login
curl -X POST http://localhost:8000/api/auth/login `
  -H "Content-Type: application/json" `
  -d '{"email":"test@example.com","password":"password123"}'

# Get current user
curl -X GET http://localhost:8000/api/auth/me `
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Products
```powershell
# Get all products
curl http://localhost:8000/api/products

# Get products with filters
curl "http://localhost:8000/api/products?category=Shoes&per_page=12"

# Get product by slug
curl http://localhost:8000/api/products/air-jordan-1-retro-high-og
```

### Orders
```powershell
# Create order
curl -X POST http://localhost:8000/api/orders `
  -H "Authorization: Bearer YOUR_TOKEN_HERE" `
  -H "Content-Type: application/json" `
  -d '{"product_id":1,"quantity":2,"shipping_address":"Jl. Test","phone":"081234567890"}'

# Get user orders
curl -X GET http://localhost:8000/api/orders `
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 🐛 Troubleshooting Commands

### Fix Permissions (Windows - Run as Admin)
```powershell
icacls storage /grant Everyone:F /T
icacls bootstrap\cache /grant Everyone:F /T
```

### Reset Everything
```powershell
# Clear all caches
php artisan optimize:clear

# Reset database
php artisan migrate:fresh --seed

# Reinstall dependencies
Remove-Item vendor -Recurse -Force
Remove-Item node_modules -Recurse -Force
composer install
npm install

# Rebuild frontend
npm run build
```

### Check Environment
```powershell
# PHP version
php -v

# Composer version
composer --version

# Node version
node -v

# NPM version
npm -v

# Laravel version
php artisan --version

# Check installed packages
composer show
npm list
```

---

## 📝 Git Commands (Optional)

### Initialize Repository
```powershell
git init
git add .
git commit -m "Initial commit - Fashion Brand E-Commerce"
```

### Common Git Commands
```powershell
# Check status
git status

# Add files
git add .

# Commit changes
git commit -m "Your message"

# Push to remote
git remote add origin <your-repo-url>
git push -u origin main

# Pull latest
git pull origin main
```

---

## 🎯 Quick Reference

### Start Development (2 Terminals)
```powershell
# Terminal 1
php artisan serve

# Terminal 2
npm run dev

# Browser
http://localhost:8000
```

### Reset Database
```powershell
php artisan migrate:fresh --seed
```

### Clear All Caches
```powershell
php artisan optimize:clear
```

### Full Reset
```powershell
php artisan optimize:clear
php artisan migrate:fresh --seed
npm run build
```

---

## 💡 Pro Tips

### Laravel Shortcuts
```powershell
# Create model with migration, controller, and seeder
php artisan make:model Product -mcs

# Run migration and seed in one command
php artisan migrate --seed

# View SQL queries in tinker
DB::enableQueryLog();
App\Models\Product::all();
dd(DB::getQueryLog());
```

### NPM Shortcuts
```powershell
# Install and save dependency
npm install package-name

# Install dev dependency
npm install -D package-name

# Update all packages
npm update

# Check outdated packages
npm outdated
```

---

**Quick Help**: Type `php artisan list` untuk semua command Laravel yang tersedia!
