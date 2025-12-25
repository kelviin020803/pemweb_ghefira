# 🚀 QUICK START GUIDE

## Cara Cepat Memulai Project

### 1. Setup Otomatis (Recommended)

```powershell
# Jalankan script setup otomatis
.\setup.ps1
```

Script ini akan:
- ✅ Install semua dependencies
- ✅ Setup environment file
- ✅ Generate application & JWT keys
- ✅ Link storage folder

### 2. Setup Database

#### Menggunakan HeidiSQL:

1. **Buka HeidiSQL** dan connect ke MySQL
2. **Buat Database Baru**:
   ```sql
   CREATE DATABASE fashion_brand_db;
   ```

3. **Update file `.env`**:
   ```env
   DB_DATABASE=fashion_brand_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run Migrations & Seeder**:
   ```powershell
   php artisan migrate
   php artisan db:seed
   ```

### 3. Jalankan Development Server

Buka **2 terminal**:

**Terminal 1 - Backend:**
```powershell
php artisan serve
```

**Terminal 2 - Frontend:**
```powershell
npm run dev
```

### 4. Akses Website

Buka browser: **http://localhost:8000**

---

## 🎯 Testing Cepat

### 1. Register Akun Baru
- Klik "Register" di homepage
- Isi form registrasi
- Submit

### 2. Login
- Klik "Login"
- Gunakan email & password yang baru dibuat
- Submit

### 3. Browse Products
- Klik "Products" atau kategori di homepage
- Filter by category: Shoes, Hoodies, Bags, Jackets
- Search products
- Klik "View Details" pada produk

### 4. Checkout
- Pada product detail, klik "Buy Now"
- Isi form checkout:
  - Quantity
  - Shipping address
  - Phone number
- Klik "Place Order"

---

## 📊 Data Default Setelah Seeding

### Products (12 items):

**Shoes:**
- Nike Air Jordan 1 Retro High OG - Rp 2,599,000
- Adidas Yeezy Boost 350 V2 - Rp 3,200,000
- Converse Chuck Taylor All Star - Rp 899,000

**Hoodies:**
- Supreme Box Logo Hoodie - Rp 1,899,000
- The North Face Drew Peak - Rp 1,299,000
- Champion Reverse Weave - Rp 999,000

**Bags:**
- Herschel Little America - Rp 1,499,000
- Fjallraven Kanken Classic - Rp 1,299,000
- Anello Large Backpack - Rp 699,000

**Jackets:**
- Levi's Trucker Jacket - Rp 1,799,000
- Uniqlo Ultra Light Down - Rp 999,000
- Stussy Stock Coach Jacket - Rp 1,599,000

---

## 🔑 Fitur Utama yang Harus Dicoba

### ✅ Authentication
- [x] Register dengan validasi
- [x] Login dengan JWT
- [x] Logout
- [x] Session persistence

### ✅ Product Management
- [x] Browse all products
- [x] Filter by category
- [x] Search products
- [x] Sort by price/name
- [x] View product details
- [x] Check stock availability

### ✅ Order System
- [x] Add to cart flow
- [x] Checkout form
- [x] Stock validation
- [x] Order confirmation
- [x] UUID tracking

---

## ⚠️ Troubleshooting Cepat

### Error: "Database connection failed"
```powershell
# Pastikan MySQL running
# Check .env configuration
DB_DATABASE=fashion_brand_db
DB_USERNAME=root
DB_PASSWORD=
```

### Error: "JWT Secret not set"
```powershell
php artisan jwt:secret
```

### Error: "Vite manifest not found"
```powershell
npm run dev
# atau
npm run build
```

### Error: "Class not found"
```powershell
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

---

## 📱 Struktur Halaman

```
┌─ http://localhost:8000
│
├─ /                    → Redirect ke /login
├─ /login              → Login page
├─ /register           → Registration page
├─ /home               → Homepage (categories & featured)
├─ /products           → Product catalog (dengan filter)
└─ /checkout           → Checkout page (protected)
```

---

## 🎓 Untuk UAP - Checklist Penilaian

### Backend (40%)
- ✅ Laravel 12 + PHP 8.2
- ✅ JWT Authentication
- ✅ 2 Tabel berelasi (products & orders)
- ✅ CRUD lengkap

### Frontend (40%)
- ✅ Tailwind CSS 4.0 integration
- ✅ Responsive design
- ✅ API integration
- ✅ Error handling

### UI/UX (20%)
- ✅ Modern design 2025
- ✅ Dashboard rapi
- ✅ Penamaan jelas
- ✅ User-friendly

### Data Identifier
- ✅ Products: SLUG (judul-artikel)
- ✅ Orders: UUID (550e8400-e29b...)

---

## 📞 Need Help?

1. Baca **SETUP_GUIDE.md** untuk panduan lengkap
2. Lihat file **README.md** untuk dokumentasi detail
3. Check **routes/api.php** untuk API endpoints
4. Lihat **database/seeders** untuk data sample

---

**Happy Coding! 🎉**
