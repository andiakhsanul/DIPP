# 🚀 DIPP - Aplikasi Pendaftaran Laravel

Aplikasi pendaftaran dengan **Login/Register**, **Email Verification**, dan **Google OAuth** menggunakan **Laravel 12**, **FrankenPHP**, **MySQL 8.0**, **Bootstrap 5**, dan **Docker**.

## ✨ Features

✅ **Email & Password Registration** - Form registration dengan validasi  
✅ **Email Verification** - Konfirmasi email sebelum login  
✅ **Google OAuth Login** - Login dengan akun Google  
✅ **Secure Authentication** - Password hashing & CSRF protection  
✅ **Modern UI** - Bootstrap 5 dengan responsive design  
✅ **Dashboard** - Protected page dengan user info  

---

## 📋 Requirements

Yang perlu diinstall:
- **Docker Desktop** ([Download](https://www.docker.com/products/docker-desktop))
- **Docker Compose** (sudah include di Docker Desktop)

**HANYA ITU!** Tidak perlu install PHP, Composer, MySQL, atau apapun lagi. Semua sudah ada di Docker! 🎉

---

## ⚡ Quick Start (Clone & Run)

Jika teman Anda ingin clone project ini, cukup 3 langkah:

### 1️⃣ Clone Repository

```bash
git clone https://github.com/andiakhsanul/DIPP.git
cd DIPP
```

### 2️⃣ Jalankan Docker

```bash
docker-compose up -d --build
```

### 3️⃣ Tunggu 30 detik, lalu buka browser

- **Aplikasi Laravel**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080

**SELESAI!** 🎊

### 4️⃣ Test Authentication

1. **Buka**: http://localhost:8000
2. **Klik "Register"** → Isi form → Submit
3. **Email verification link** ada di `storage/logs/laravel.log`
4. **Copy link** → Paste di browser → Dashboard terbuka!

**Untuk Google OAuth**: Lihat `GOOGLE_OAUTH_SETUP.md`

---

## 🔧 Setup Manual (Jika Ada Error)

Jika langkah di atas ada error, jalankan setup manual:

```bash
# 1. Start Docker containers
docker-compose up -d --build

# 2. Tunggu database ready (30 detik)
sleep 30

# 3. Install dependencies (jika belum)
docker-compose exec app composer install

# 4. Setup environment
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# 5. Jalankan migrations
docker-compose exec app php artisan migrate --force
```

---

## 🗄️ Informasi Database

### MySQL
- **Host**: `localhost` (dari host) / `db` (dari container)
- **Port**: `3306`
- **Database**: `laravel`
- **Username**: `laravel_user`
- **Password**: `laravel_password`

### phpMyAdmin (http://localhost:8080)
- **Server**: `db`
- **Username**: `root`
- **Password**: `root_password`

---

## 📝 Perintah Docker Berguna

```bash
# Lihat status containers
docker-compose ps

# Lihat logs aplikasi
docker-compose logs -f app

# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# Masuk ke container Laravel
docker-compose exec app sh

# Jalankan artisan command
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:list

# Install package baru
docker-compose exec app composer require nama-package
```

---

## 🏗️ Struktur Project

```
DIPP/
├── docker-compose.yml      # Konfigurasi Docker (3 services)
├── Dockerfile              # FrankenPHP PHP 8.3
├── Caddyfile              # Web server config
├── .env                   # Environment variables
├── app/                   # Laravel application code
├── routes/                # Route definitions
├── resources/             # Views & frontend assets
├── database/              # Migrations & seeders
├── public/                # Public files (entry point)
└── storage/               # Logs & uploaded files
```

---

## 🐳 Docker Services

Project ini menjalankan 3 containers:

1. **laravel_app** (Port 8000)
   - FrankenPHP + PHP 8.3
   - Laravel 12

2. **mysql_db** (Port 3306)
   - MySQL 8.0
   - Database otomatis dibuat

3. **phpmyadmin** (Port 8080)
   - Web interface untuk manage database

---

## 🛠️ Development

### Edit Code
Semua file di folder `DIPP/` otomatis ter-sync dengan container. Edit file, refresh browser, done!

### Tambah Route Baru
1. Edit `routes/web.php`
2. Buat controller: `docker-compose exec app php artisan make:controller NamaController`
3. Edit view di `resources/views/`

### Tambah Migration Baru
```bash
docker-compose exec app php artisan make:migration create_nama_table
docker-compose exec app php artisan migrate
```

### Install Package Baru
```bash
docker-compose exec app composer require vendor/package
```

---

## ❗ Troubleshooting

### Port sudah digunakan
Edit `docker-compose.yml`, ubah port mapping:
```yaml
ports:
  - "8001:8000"  # Ganti 8000 ke 8001
```

### Container tidak bisa start
```bash
docker-compose down
docker-compose up -d --build
```

### Permission error
```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Database connection error
Tunggu 30 detik setelah start, database perlu waktu untuk ready.

---

## 📚 Documentation

Untuk dokumentasi lengkap, baca file-file berikut:

- **`AUTH_DOCUMENTATION.md`** - Complete authentication guide (LOGIN/REGISTER)
- **`GOOGLE_OAUTH_SETUP.md`** - Setup Google OAuth step-by-step
- **`GOOGLE_OAUTH_REFERENCE.md`** - Technical reference untuk OAuth
- **`SETUP_INSTRUCTIONS.md`** - Detailed setup instructions
- **`QUICKSTART.md`** - Quick reference commands
- **`CLONE_INSTRUCTIONS.md`** - Instructions for team members

---

## 🎯 Teknologi Stack

- **PHP**: 8.3
- **Laravel**: 12.x (Latest!)
- **Web Server**: FrankenPHP (Modern PHP App Server)
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5 + Bootstrap Icons
- **Authentication**: Laravel Breeze-style manual + Socialite
- **Container**: Docker + Docker Compose

---

## 📄 License

Open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
