php artisan migrate
php artisan db:seed# 🎯 Fashion Brand - Setup Guide

## 📋 Daftar Isi
- [Persyaratan](#persyaratan)
- [Setup Database](#setup-database)
- [Instalasi Project](#instalasi-project)
- [Testing](#testing)
- [Fitur Utama](#fitur-utama)

---

## 🔧 Persyaratan

### Software yang Diperlukan:
1. **PHP** >= 8.2
2. **Composer** (Latest version)
3. **Node.js** >= 18.x
4. **MySQL** / **MariaDB**
5. **HeidiSQL** (untuk manage database)

### Versi yang Digunakan:
- Laravel 12
- PHP 8.2
- Tailwind CSS 4.0
- JWT Auth (php-open-source-saver/jwt-auth v2.8)

---

## 🗄️ Setup Database (HeidiSQL)

### 1. Buka HeidiSQL

1. Jalankan HeidiSQL
2. Klik "New" untuk membuat koneksi baru
3. Isi detail koneksi:
   - **Network type**: MariaDB atau MySQL (TCP/IP)
   - **Hostname / IP**: `127.0.0.1`
   - **User**: `root`
   - **Password**: (kosongkan jika default)
   - **Port**: `3306`
4. Klik "Open" untuk connect

### 2. Buat Database

Setelah terkoneksi, jalankan query berikut di HeidiSQL:

```sql
CREATE DATABASE fashion_brand_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau lewat GUI:
1. Klik kanan pada connection
2. Pilih "Create new" → "Database"
3. Nama database: `fashion_brand_db`
4. Collation: `utf8mb4_unicode_ci`
5. Klik OK

### 3. Verifikasi Database

Database `fashion_brand_db` akan muncul di sidebar kiri HeidiSQL.

---

## 📦 Instalasi Project

### 1. Clone/Copy Project

Pastikan project sudah ada di folder:
```
c:\Users\kelviin\Downloads\ghefira\web-uap
```

### 2. Install Dependencies

Buka PowerShell/CMD di folder project, lalu jalankan:

```powershell
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Setup Environment

```powershell
# Copy .env.example menjadi .env
Copy-Item .env.example .env

# Generate application key
php artisan key:generate

# Generate JWT secret key
php artisan jwt:secret
```

### 4. Konfigurasi .env

Buka file `.env` dan pastikan konfigurasi database sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fashion_brand_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migrasi & Seeder

```powershell
# Jalankan migrasi (membuat tabel)
php artisan migrate

# Jalankan seeder (isi data dummy)
php artisan db:seed
```

**Tabel yang akan dibuat:**
- `users` - Untuk akun user
- `products` - Untuk data produk fashion
- `orders` - Untuk transaksi pembelian
- `cache`, `jobs`, `sessions` - Untuk Laravel system
- `personal_access_tokens` - Untuk Sanctum (opsional)

**Data Dummy yang akan diisi:**
- 12 produk fashion (Shoes, Hoodies, Bags, Jackets)

### 6. Link Storage

```powershell
# Buat symbolic link untuk storage (untuk upload gambar)
php artisan storage:link
```

---

## 🚀 Menjalankan Project

### Development Mode

Buka **2 terminal/PowerShell** di folder project:

**Terminal 1** - Laravel Server:
```powershell
php artisan serve
```
Server akan jalan di: `http://localhost:8000`

**Terminal 2** - Vite (Frontend):
```powershell
npm run dev
```

### Akses Website

Buka browser dan kunjungi:
```
http://localhost:8000
```

---

## ✅ Testing

### 1. Test Database Connection

Di HeidiSQL:
```sql
-- Pilih database
USE fashion_brand_db;

-- Lihat semua tabel
SHOW TABLES;

-- Lihat data products
SELECT * FROM products;

-- Lihat struktur tabel
DESCRIBE products;
```

### 2. Test Website

1. **Halaman Home**: `http://localhost:8000/home`
2. **Register**: `http://localhost:8000/register`
   - Buat akun baru dengan email & password
3. **Login**: `http://localhost:8000/login`
   - Login dengan akun yang baru dibuat
4. **Products**: `http://localhost:8000/products`
   - Filter by category, search, dll
5. **Checkout**: Pilih produk → Buy Now → Isi form checkout

### 3. Test API (Postman/Thunder Client)

**Register User:**
```http
POST http://localhost:8000/api/auth/register
Content-Type: application/json

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123"
}
```

**Login:**
```http
POST http://localhost:8000/api/auth/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password123"
}
```

Response akan berisi `access_token` (JWT).

**Get Products (Public):**
```http
GET http://localhost:8000/api/products
```

**Create Order (Protected - perlu JWT):**
```http
POST http://localhost:8000/api/orders
Authorization: Bearer {your_jwt_token}
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 2,
  "shipping_address": "Jl. Contoh No. 123, Jakarta",
  "phone": "081234567890"
}
```

---

## 🎨 Fitur Utama

### ✨ Authentication (JWT)
- [x] Register dengan validasi
- [x] Login dengan JWT token
- [x] Logout
- [x] Protected routes dengan middleware

### 🛍️ Product Management
- [x] CRUD Products (Create, Read, Update, Delete)
- [x] Filter by category
- [x] Search products
- [x] Sort (latest, price, name)
- [x] Auto-generate slug untuk SEO
- [x] Stock management

### 🛒 Order Management
- [x] Create order dengan validasi stock
- [x] Auto-generate UUID untuk order
- [x] Order status (pending, processing, completed, cancelled)
- [x] Automatic stock reduction
- [x] User order history
- [x] Update/Cancel order

### 🎭 Frontend Features
- [x] Responsive design (mobile-friendly)
- [x] Modern UI dengan Tailwind CSS 4.0
- [x] Category browsing
- [x] Product modal/detail
- [x] Shopping cart flow
- [x] Protected checkout (login required)

---

## 📊 Struktur Database

### Tabel: products
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| slug | varchar | URL-friendly identifier |
| brand | varchar | Nama brand (Nike, Adidas, dll) |
| name | varchar | Nama produk |
| category | varchar | Kategori (Shoes, Hoodie, Bag, Jacket) |
| price | decimal(10,2) | Harga produk |
| stock | integer | Jumlah stok |
| description | text | Deskripsi produk |
| image_path | varchar | Path gambar di storage |
| created_at | timestamp | Tanggal dibuat |
| updated_at | timestamp | Tanggal diupdate |

### Tabel: orders
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| uuid | char(36) | UUID untuk identifier |
| user_id | bigint | Foreign key ke users |
| product_id | bigint | Foreign key ke products |
| quantity | integer | Jumlah barang |
| total_price | decimal(10,2) | Total harga |
| status | enum | pending/processing/completed/cancelled |
| shipping_address | text | Alamat pengiriman |
| phone | varchar | Nomor telepon |
| created_at | timestamp | Tanggal order |
| updated_at | timestamp | Tanggal update |

---

## 🐛 Troubleshooting

### Error: Database Connection Failed
**Solusi:**
1. Pastikan MySQL/MariaDB sudah running
2. Cek konfigurasi `.env` (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
3. Test koneksi di HeidiSQL

### Error: JWT Secret Not Set
**Solusi:**
```powershell
php artisan jwt:secret
```

### Error: Class not found
**Solusi:**
```powershell
composer dump-autoload
```

### Error: Vite Manifest Not Found
**Solusi:**
```powershell
npm run build
```

### Error: Storage Link
**Solusi:**
```powershell
php artisan storage:link
```

---

## 📝 Catatan Penting

1. **Jangan hapus file migrations** yang sudah ada
2. **Backup database** sebelum migrate fresh
3. **JWT Token** disimpan di localStorage browser
4. **Slug** auto-generate dari nama produk
5. **Stock** akan berkurang otomatis saat order
6. **Order status** default adalah "pending"

---

## 🎓 Untuk UAP

### Checklist Penilaian:

**Backend (40%)**
- ✅ Laravel 12 implementation
- ✅ JWT Authentication (Login/Register/Logout)
- ✅ Database dengan 2 tabel berelasi (products & orders)
- ✅ CRUD operations

**Frontend Integration (40%)**
- ✅ Tailwind CSS integration
- ✅ Responsive design
- ✅ Frontend-backend interaction
- ✅ Error handling

**UI Design (20%)**
- ✅ Dashboard rapi & konsisten
- ✅ Modern design (2025/2026)
- ✅ Penamaan jelas
- ✅ User-friendly

### Data Identifier:
- **Products**: Menggunakan **SLUG** (contoh: `air-jordan-1-retro-high-og`)
- **Orders**: Menggunakan **UUID** (contoh: `550e8400-e29b-6d3b-a456-426614174000`)

---

**Dibuat untuk UAP Pemrograman Website**
**Fashion Brand Project - 2025**
