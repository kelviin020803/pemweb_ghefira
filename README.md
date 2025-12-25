# GlamStyle - Fashion E-Commerce

Aplikasi e-commerce fashion menggunakan Laravel 10.

## Persyaratan Sistem

- **PHP:** 8.2.x
- **Composer:** 2.9.x
- **Node.js:** 20.x (LTS)
- **NPM:** 10.x
- **MySQL:** 8.0.x
- **Laragon/XAMPP:** Untuk menjalankan MySQL

## Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/kelviin020803/pemweb_ghefira.git
cd pemweb_ghefira
```

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Install Dependencies Node.js
```bash
npm install
```

### 4. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 5. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fashion_brand_db
DB_USERNAME=root
DB_PASSWORD=
```

**Pastikan MySQL sudah berjalan dan buat database:**
```sql
CREATE DATABASE fashion_brand_db;
```

### 6. Jalankan Migrasi Database
```bash
php artisan migrate
```

### 7. Seed Data (Opsional)
```bash
php artisan db:seed
```

### 8. Generate JWT Secret
```bash
php artisan jwt:secret
```

### 9. Build Assets Frontend
```bash
npm run build
```

### 10. Jalankan Aplikasi
```bash
php artisan serve
```

Aplikasi akan berjalan di: http://localhost:8000

## Mode Development

Untuk development dengan hot reload:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server:**
```bash
npm run dev
```

## Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database
Pastikan database `fashion_brand_db` sudah dibuat di MySQL.

### Error: npm install gagal
Pastikan Node.js versi 20.x sudah terinstall:
```bash
node -v
```

### Error: Class not found
Jalankan ulang autoload:
```bash
composer dump-autoload
```

### Error: Vite manifest not found
Build assets terlebih dahulu:
```bash
npm run build
```

## Struktur Proyek

```
├── app/
│   ├── Http/Controllers/    # Controllers
│   ├── Models/              # Eloquent Models
│   └── Middleware/          # Custom Middleware
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/             # Database Seeders
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript
│   └── views/               # Blade Templates
├── routes/
│   └── web.php              # Web Routes
└── public/                  # Public Assets
```

## Versi Dependencies

### PHP (composer.json)
- laravel/framework: ^10.48
- laravel/sanctum: ^3.3
- php-open-source-saver/jwt-auth: ^2.1

### Node.js (package.json)
- vite: ^5.0.0
- tailwindcss: ^3.4.0
- laravel-vite-plugin: ^1.0.0

## Lisensi

MIT License
