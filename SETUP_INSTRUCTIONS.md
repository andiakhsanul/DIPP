# 📋 Instruksi untuk Teman yang Clone Project

## 🎯 Yang Perlu Disiapkan

Hanya **1 aplikasi**: **Docker Desktop**

- Download: https://www.docker.com/products/docker-desktop
- Install dan pastikan Docker Desktop **running** (ada icon whale di taskbar/menu bar)

**TIDAK PERLU INSTALL:**
- ❌ PHP
- ❌ Composer  
- ❌ MySQL
- ❌ Web Server
- ❌ Apapun lainnya!

Semua sudah ada di dalam Docker! 🎉

---

## 🚀 Cara Setup Project (3 Langkah)

### Langkah 1: Clone Project
```bash
git clone https://github.com/andiakhsanul/DIPP.git
cd DIPP
```

### Langkah 2: Jalankan Setup

**Untuk Mac/Linux:**
```bash
./setup.sh
```

**Untuk Windows:**
```bash
setup.bat
```

**Atau Manual (Semua OS):**
```bash
docker-compose up -d --build
```

### Langkah 3: Tunggu & Buka Browser

- Tunggu 1-2 menit (untuk build pertama kali)
- Buka browser: **http://localhost:8000**
- Selesai! ✅

---

## 🎨 Yang Akan Dijalankan

Script akan otomatis:

1. ✅ Build Docker containers (FrankenPHP, MySQL, phpMyAdmin)
2. ✅ Install Laravel dependencies (composer install)
3. ✅ Setup environment file (.env)
4. ✅ Generate application key
5. ✅ Konfigurasi database connection
6. ✅ Run database migrations
7. ✅ Set permissions

**Total waktu: 2-3 menit** (pertama kali)

---

## 📱 Akses Aplikasi

Setelah setup selesai:

- **Laravel App**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080

---

## 🔑 Database Info

Jika perlu akses database:

**Via Laravel (.env sudah configured):**
```
DB_CONNECTION=mysql
DB_HOST=db
DB_DATABASE=laravel
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password
```

**Via phpMyAdmin (http://localhost:8080):**
```
Server: db
Username: root
Password: root_password
```

**Via Tool External (TablePlus, Sequel Pro, dll):**
```
Host: localhost
Port: 3306
Database: laravel
Username: laravel_user
Password: laravel_password
```

---

## 🛠️ Perintah Berguna

```bash
# Lihat status containers
docker-compose ps

# Lihat logs aplikasi
docker-compose logs -f app

# Stop aplikasi
docker-compose down

# Restart aplikasi
docker-compose restart

# Masuk ke container untuk eksekusi command
docker-compose exec app sh

# Jalankan Laravel artisan command
docker-compose exec app php artisan migrate
docker-compose exec app php artisan route:list
docker-compose exec app php artisan cache:clear

# Install package baru via Composer
docker-compose exec app composer require vendor/package
```

---

## ❗ Troubleshooting Common Issues

### 1. Error: "Cannot connect to the Docker daemon"
**Penyebab:** Docker Desktop tidak running  
**Solusi:** Buka Docker Desktop dan tunggu sampai status "Running"

### 2. Error: "Port 8000 is already allocated"
**Penyebab:** Ada aplikasi lain pakai port 8000  
**Solusi 1:** Stop aplikasi yang pakai port 8000  
**Solusi 2:** Edit `docker-compose.yml`, ganti `"8000:8000"` menjadi `"8001:8000"`, akses di http://localhost:8001

### 3. Error: "Permission denied: ./setup.sh"
**Penyebab:** File tidak executable (Mac/Linux)  
**Solusi:**
```bash
chmod +x setup.sh
./setup.sh
```

### 4. Error: "SQLSTATE[HY000] [2002] Connection refused"
**Penyebab:** Database belum ready  
**Solusi:** Tunggu lebih lama, lalu jalankan:
```bash
docker-compose exec app php artisan migrate --force
```

### 5. Laravel menampilkan error 500
**Penyebab:** Permission atau .env issue  
**Solusi:**
```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

### 6. Vendor folder kosong
**Penyebab:** Composer dependencies belum terinstall  
**Solusi:**
```bash
docker-compose exec app composer install
```

---

## 📂 Struktur Project

```
DIPP/
├── setup.sh              # Setup script untuk Mac/Linux
├── setup.bat             # Setup script untuk Windows
├── docker-compose.yml    # Docker configuration
├── Dockerfile            # FrankenPHP image
├── README.md             # Dokumentasi lengkap
├── QUICKSTART.md         # Quick start guide (file ini)
├── app/                  # Laravel code
├── routes/               # Routes
├── resources/            # Views
├── database/             # Migrations
└── ...
```

---

## 🎓 Tips Development

1. **Edit code langsung** di folder project, changes akan auto-sync ke container
2. **Restart tidak perlu** untuk perubahan code (kecuali config/env)
3. **Database persistent** - data tidak hilang walau container di-stop
4. **Logs tersimpan** di `storage/logs/laravel.log`

---

## 📞 Butuh Bantuan?

- Lihat **README.md** untuk dokumentasi lengkap
- Check **QUICKSTART.md** untuk troubleshooting
- Atau hubungi maintainer project

---

**Happy Coding! 🎉**
