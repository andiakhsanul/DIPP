# 🎓 DIPP - Sistem Informasi Pendaftaran Magang
### Pusat Inovasi Pendidikan dan Teknologi Pembelajaran (PIPTP)
### Universitas Airlangga

Aplikasi sistem informasi pendaftaran magang dengan fitur **Authentication**, **Email Verification**, **Google OAuth**, dan **Admin Dashboard** menggunakan **Laravel 12**, **FrankenPHP**, **MySQL 8.0**, **Bootstrap 5**, dan **Docker**.

---

## ✨ Features

### Authentication & Security
✅ **Email & Password Registration** - Form registrasi dengan validasi lengkap  
✅ **Custom Email Verification** - Email branded PIPTP Universitas Airlangga  
✅ **Google OAuth Login** - Login cepat dengan akun Google  
✅ **Secure Authentication** - Password hashing & CSRF protection  
✅ **Role-based Access Control** - Admin & User roles

### User Features
✅ **User Profile Management** - Kelola profil lengkap  
✅ **Batch Registration** - Daftar ke batch magang yang tersedia  
✅ **Dashboard** - Lihat status pendaftaran  
✅ **Modern UI** - Bootstrap 5 dengan responsive design

### Admin Features
✅ **Admin Dashboard** - Overview pendaftaran dan statistik  
✅ **Batch Management** - CRUD batch magang  
✅ **Registration Management** - Approve/reject pendaftaran  
✅ **User Management** - Lihat semua user terdaftar

---

## 📋 Requirements

Yang perlu diinstall:
- **Docker Desktop** ([Download](https://www.docker.com/products/docker-desktop))
- **Docker Compose** (sudah include di Docker Desktop)

**HANYA ITU!** Tidak perlu install PHP, Composer, MySQL, atau apapun lagi. Semua sudah ada di Docker! 🎉

---

## ⚡ Quick Start

### 1️⃣ Clone Repository

```bash
git clone https://github.com/andiakhsanul/DIPP.git
cd DIPP
```

### 2️⃣ Start Docker Containers

```bash
docker-compose up -d --build
```

Tunggu 30-60 detik untuk setup awal database dan dependencies.

### 3️⃣ Access Application

- **Aplikasi Laravel**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080

**SELESAI!** 🎊

---

## 🔧 Manual Setup (Jika Diperlukan)

Jika langkah Quick Start ada error, jalankan setup manual:

```bash
# 1. Start Docker containers
docker-compose up -d --build

# 2. Tunggu database ready
sleep 30

# 3. Install dependencies (jika belum)
docker-compose exec app composer install

# 4. Setup environment (jika belum ada .env)
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# 5. Run migrations
docker-compose exec app php artisan migrate --force

# 6. Seed admin user (optional)
docker-compose exec app php artisan db:seed --class=AdminAndBatchSeeder
```

### Default Admin Credentials
```
Email: admin@dipp.test
Password: admin123
```

---

## 🏗️ Architecture & Structure

### Technology Stack
- **PHP**: 8.3
- **Laravel**: 12.x
- **Web Server**: FrankenPHP (Modern PHP App Server)
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5 + Bootstrap Icons
- **Authentication**: Laravel Breeze-style + Socialite (Google OAuth)
- **Email**: Brevo SMTP
- **Container**: Docker + Docker Compose

### Project Structure
```
DIPP/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/              # Authentication controllers
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── GoogleController.php
│   │   │   └── EmailVerificationController.php
│   │   ├── Admin/             # Admin controllers
│   │   │   ├── DashboardController.php
│   │   │   ├── BatchController.php
│   │   │   └── RegistrationManagementController.php
│   │   ├── ProfileController.php
│   │   ├── RegistrationController.php
│   │   └── DashboardController.php
│   ├── Models/                # Eloquent models
│   │   ├── User.php
│   │   ├── UserProfile.php
│   │   ├── Batch.php
│   │   ├── Registration.php
│   │   └── Form.php
│   ├── Notifications/         # Custom notifications
│   │   └── CustomVerifyEmail.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   ├── views/                 # Blade templates
│   │   ├── auth/              # Auth views
│   │   ├── admin/             # Admin views
│   │   ├── layouts/           # Layout templates
│   │   └── emails/            # Email templates
│   └── css/                   # Stylesheets
├── routes/
│   └── web.php                # Web routes
├── docker-compose.yml         # Docker services config
├── Dockerfile                 # FrankenPHP image
├── Caddyfile                  # Web server config
└── .env                       # Environment variables
```

---

## 🔐 Authentication System

### Registration Flow
1. User mengisi form registrasi (nama, email, password)
2. System membuat user baru dan trigger `Registered` event
3. Email verifikasi dikirim otomatis dari **PIPTP Universitas Airlangga**
4. User klik link verifikasi di email
5. User redirect ke halaman profile creation
6. Setelah lengkapi profile, bisa akses dashboard

### Google OAuth Flow
1. User klik "Continue with Google"
2. Redirect ke Google OAuth consent screen
3. User pilih Google account
4. Google redirect callback dengan user data
5. System create/update user dengan Google credentials
6. Email otomatis ter-verifikasi
7. Redirect ke profile creation atau dashboard

### Email Verification
- **Custom branded email** dari PIPTP Universitas Airlangga
- **Professional template** dengan logo dan informasi kontak
- **Warna tema** biru UNAIR (#003d7a)
- **Secure signed URLs** dengan expiry 60 menit
- **SMTP Provider**: Brevo (production-ready)

---

## 🗄️ Database Information

### MySQL Database
```
Host: localhost (dari host) / db (dari container)
Port: 3306
Database: laravel
Username: laravel_user
Password: laravel_password
```

### phpMyAdmin Access
URL: http://localhost:8080
```
Server: db
Username: root
Password: root_password
```

### Database Tables
- **users** - User accounts dengan role (admin/user)
- **user_profiles** - Extended user information
- **batches** - Batch magang available
- **registrations** - User registrations ke batch
- **forms** - Custom forms (future feature)
- **sessions** - Active sessions
- **cache** - Application cache
- **jobs** - Queue jobs

---

## 📧 Email Configuration

Email menggunakan **Brevo SMTP** untuk production-ready delivery.

### Current Configuration (.env)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=652978002@smtp-brevo.com
MAIL_PASSWORD=xsmtpsib-...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=652978002@smtp-brevo.com
MAIL_FROM_NAME="PIPTP Universitas Airlangga"
```

### Email Features
- ✅ Custom verification email template
- ✅ Professional PIPTP branding
- ✅ Logo Universitas Airlangga
- ✅ Contact information
- ✅ Responsive design
- ✅ Custom color theme (UNAIR blue)

---

## 🔑 Google OAuth Setup

### Prerequisites
1. Google Cloud Console account
2. Create new project atau gunakan existing

### Setup Steps

#### 1. Enable Google+ API
```
1. Go to: https://console.cloud.google.com/
2. Select your project
3. Navigate to: APIs & Services > Library
4. Search: "Google+ API"
5. Click "Enable"
```

#### 2. Configure OAuth Consent Screen
```
1. Go to: APIs & Services > OAuth consent screen
2. Select: External
3. Fill application information:
   - App name: DIPP - PIPTP UNAIR
   - User support email: your-email@gmail.com
   - Developer contact: your-email@gmail.com
4. Save and continue
5. Add test users (optional for development)
```

#### 3. Create OAuth 2.0 Credentials
```
1. Go to: APIs & Services > Credentials
2. Click: Create Credentials > OAuth 2.0 Client ID
3. Application type: Web application
4. Name: DIPP Web Client
5. Authorized redirect URIs:
   - http://localhost:8000/auth/google/callback
   - http://localhost/auth/google/callback
6. Click Create
7. Copy Client ID and Client Secret
```

#### 4. Update .env File
```env
GOOGLE_CLIENT_ID=your-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-your-client-secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

#### 5. Restart Application
```bash
docker-compose restart app
docker-compose exec app php artisan config:clear
```

---

## 📝 Common Commands

### Docker Commands
```bash
# View container status
docker-compose ps

# View application logs
docker-compose logs -f app

# Stop all containers
docker-compose down

# Restart containers
docker-compose restart

# Rebuild containers
docker-compose up -d --build

# Access app container shell
docker-compose exec app sh
```

### Laravel Artisan Commands
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Rollback migrations
docker-compose exec app php artisan migrate:rollback

# Seed database
docker-compose exec app php artisan db:seed

# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# View routes
docker-compose exec app php artisan route:list

# Create new controller
docker-compose exec app php artisan make:controller ControllerName

# Create new model
docker-compose exec app php artisan make:model ModelName -m
```

### Composer Commands
```bash
# Install dependencies
docker-compose exec app composer install

# Update dependencies
docker-compose exec app composer update

# Install new package
docker-compose exec app composer require vendor/package

# Remove package
docker-compose exec app composer remove vendor/package
```

---

## 🎯 User Flow

### For Regular Users
1. **Register** → Email verification → **Profile creation**
2. **Login** → **Dashboard**
3. View available **batches**
4. **Register** to batch
5. Wait for **admin approval**
6. View registration **status** in dashboard

### For Admin Users
1. **Login** with admin account
2. Access **Admin Dashboard**
3. **Manage batches** (create, edit, delete)
4. **View all registrations**
5. **Approve or reject** user registrations
6. View **statistics** and reports

---

## ❗ Troubleshooting

### Port Already in Use
```bash
# Check what's using the port
lsof -i :8000  # on Mac/Linux
netstat -ano | findstr :8000  # on Windows

# Change port in docker-compose.yml
ports:
  - "8001:8000"  # Change 8000 to 8001
```

### Database Connection Error
```bash
# Wait for database to be ready
sleep 30

# Check database container
docker-compose logs db

# Restart containers
docker-compose restart
```

### Permission Errors
```bash
# Fix storage permissions
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Email Not Sending
```bash
# Check logs
docker-compose exec app tail -f storage/logs/laravel.log

# Clear config cache
docker-compose exec app php artisan config:clear

# Test email connection
docker-compose exec app php artisan tinker
>>> Mail::raw('Test', fn($m) => $m->to('test@example.com')->subject('Test'));
```

### Google OAuth Errors
```
Error: redirect_uri_mismatch
Solution: Check GOOGLE_REDIRECT_URI in .env matches Google Console

Error: invalid_client
Solution: Verify GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET

Error: access_denied
Solution: Add test users in OAuth consent screen
```

---

## 🚀 Development Tips

### Hot Reload (Auto-refresh on code changes)
Laravel Mix with Vite:
```bash
docker-compose exec app npm install
docker-compose exec app npm run dev
```

### Database Management
- Use phpMyAdmin at http://localhost:8080
- Or use TablePlus/MySQL Workbench with credentials above

### Debugging
```php
// In your code
dd($variable);  // Dump and die
dump($variable);  // Dump without stopping

// In Blade
@dd($variable)
@dump($variable)
```

### Testing
```bash
# Run tests
docker-compose exec app php artisan test

# Create test
docker-compose exec app php artisan make:test FeatureTest
```

---

## 📚 Additional Documentation

- **`AUTH_DOCUMENTATION.md`** - Complete authentication guide
- **`QUICKSTART.md`** - Quick reference untuk setup

---

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 License

Open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Credits

**Developed by**: Andi Akhsanul  
**Institution**: Pusat Inovasi Pendidikan dan Teknologi Pembelajaran (PIPTP)  
**University**: Universitas Airlangga  

---

**Made with ❤️ for PIPTP Universitas Airlangga**
