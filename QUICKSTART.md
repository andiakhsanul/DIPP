# 🚀 Quick Start Guide

## Untuk Teman yang Baru Clone Project

### Prerequisites
- Install **Docker Desktop** ([Download](https://www.docker.com/products/docker-desktop))
- Pastikan Docker Desktop sudah **running** (ada icon whale di taskbar)

### Setup (3 Langkah Simple!)

#### Option 1: Automatic Setup (Recommended) ✨
```bash
# 1. Clone project
git clone https://github.com/andiakhsanul/DIPP.git
cd DIPP

# 2. Jalankan script setup
./setup.sh

# 3. Tunggu selesai, buka browser
# http://localhost:8000
```

#### Option 2: Manual Setup (Jika option 1 error)
```bash
# 1. Clone project
git clone https://github.com/andiakhsanul/DIPP.git
cd DIPP

# 2. Start Docker
docker-compose up -d --build

# 3. Tunggu 30 detik
sleep 30

# 4. Install dependencies
docker-compose exec app composer install

# 5. Setup environment
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# 6. Run migrations
docker-compose exec app php artisan migrate --force

# 7. Buka browser
# http://localhost:8000
```

### ✅ Berhasil jika:
- Browser membuka Laravel welcome page di http://localhost:8000
- phpMyAdmin bisa diakses di http://localhost:8080

### ❌ Troubleshooting

#### Docker not running
```
Error: Cannot connect to the Docker daemon
Solusi: Buka Docker Desktop dan tunggu sampai running
```

#### Port already in use
```
Error: Bind for 0.0.0.0:8000 failed: port is already allocated
Solusi: 
1. Cari aplikasi yang pakai port 8000
2. Atau edit docker-compose.yml ubah "8000:8000" jadi "8001:8000"
```

#### Permission denied
```
Error: Permission denied
Solusi: chmod +x setup.sh
```

#### Database connection error
```
Error: SQLSTATE[HY000] [2002] Connection refused
Solusi: Tunggu lebih lama (database perlu waktu startup)
sleep 30 && docker-compose exec app php artisan migrate --force
```

### 📝 Command Cheat Sheet

```bash
# Lihat status containers
docker-compose ps

# Lihat logs
docker-compose logs -f app

# Stop aplikasi
docker-compose down

# Restart aplikasi
docker-compose restart

# Masuk ke container
docker-compose exec app sh

# Jalankan artisan command
docker-compose exec app php artisan <command>
```

### 🔑 Default Credentials

**Database:**
- Host: localhost:3306
- Database: laravel
- Username: laravel_user
- Password: laravel_password

**phpMyAdmin (http://localhost:8080):**
- Username: root
- Password: root_password

---

**Done! Happy Coding! 🎉**
