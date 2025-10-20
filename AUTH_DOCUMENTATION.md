# Authentication System - Complete Guide

## ✨ Features Implemented

✅ **Email & Password Registration**
- Form validation (name, email, password confirmation)
- Password minimum 8 characters
- Secure password hashing with bcrypt

✅ **Email Verification**
- Automatic verification email sent after registration
- Verification link with signed URL
- Resend verification email functionality
- Dashboard protected with verified middleware

✅ **Google OAuth Login**
- One-click login with Google
- Auto-verify email for Google users
- Avatar import from Google profile
- Secure OAuth 2.0 flow

✅ **Dashboard**
- Protected routes (auth + verified)
- User profile information
- Account details display
- Modern Bootstrap 5 UI

## 🚀 Quick Start

### 1. Setup Database
Migrations sudah berjalan otomatis saat container start. Jika perlu manual:

```bash
docker-compose exec app php artisan migrate:fresh
```

### 2. Test Email (Development)

Email verification menggunakan `log` driver (default). Email akan tersimpan di:
```
storage/logs/laravel.log
```

Untuk melihat email verification link:
```bash
docker-compose exec app tail -f storage/logs/laravel.log
```

### 3. Setup Google OAuth (Optional)

Ikuti petunjuk di **`GOOGLE_OAUTH_SETUP.md`** untuk mengaktifkan login dengan Google.

**Quick steps**:
1. Buat project di [Google Cloud Console](https://console.cloud.google.com/)
2. Enable Google+ API
3. Setup OAuth consent screen
4. Create OAuth 2.0 credentials
5. Copy Client ID & Secret ke `.env`:

```env
GOOGLE_CLIENT_ID=your-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret
```

## 📁 File Structure

```
app/
├── Http/Controllers/
│   ├── Auth/
│   │   ├── LoginController.php          # Login logic
│   │   ├── RegisterController.php       # Registration logic
│   │   ├── GoogleController.php         # Google OAuth
│   │   └── EmailVerificationController.php
│   └── DashboardController.php
├── Models/
│   └── User.php                         # User model with MustVerifyEmail

database/migrations/
└── 0001_01_01_000000_create_users_table.php  # Updated with google_id, avatar

resources/views/
├── layouts/
│   └── app.blade.php                    # Main layout with Bootstrap 5
├── auth/
│   ├── login.blade.php                  # Login form
│   ├── register.blade.php               # Registration form
│   └── verify-email.blade.php           # Email verification notice
├── dashboard.blade.php                   # Dashboard page
└── welcome.blade.php                     # Landing page

routes/
└── web.php                              # All authentication routes

config/
└── services.php                         # Google OAuth config
```

## 🔐 Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/` | - | Landing page |
| GET | `/login` | login | Show login form |
| POST | `/login` | - | Process login |
| GET | `/register` | register | Show register form |
| POST | `/register` | - | Process registration |
| POST | `/logout` | logout | Logout user |
| GET | `/email/verify` | verification.notice | Email verification notice |
| GET | `/email/verify/{id}/{hash}` | verification.verify | Verify email |
| POST | `/email/verification-notification` | verification.resend | Resend email |
| GET | `/auth/google` | google.redirect | Redirect to Google |
| GET | `/auth/google/callback` | google.callback | Google callback |
| GET | `/dashboard` | dashboard | Dashboard (auth + verified) |

## 🧪 Testing Flow

### Test 1: Email Registration
1. Buka `http://localhost:8000`
2. Klik **"Register"**
3. Isi form:
   - Name: `Test User`
   - Email: `test@example.com`
   - Password: `password123`
   - Confirm Password: `password123`
4. Submit form
5. **Redirect ke email verification notice**
6. Check verification link di `storage/logs/laravel.log`
7. Copy link dan paste di browser
8. **Berhasil! Redirect ke dashboard**

### Test 2: Google OAuth
1. **Setup Google OAuth** (lihat `GOOGLE_OAUTH_SETUP.md`)
2. Buka `http://localhost:8000/login`
3. Klik **"Continue with Google"**
4. Login dengan Google account
5. **Auto-verified! Langsung masuk dashboard**

### Test 3: Login Existing User
1. Buka `http://localhost:8000/login`
2. Masukkan email & password yang sudah terdaftar
3. Jika belum verify email → redirect ke verification notice
4. Jika sudah verify → redirect ke dashboard

## 🛠️ Configuration

### Mail Configuration (Production)

Untuk production, gunakan SMTP real. Update `.env`:

```env
# Gmail SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Atau gunakan Mailtrap (Development)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
```

### Session Configuration

Session menggunakan database driver (sudah configured):

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## 🎨 UI Components

### Bootstrap 5 Features Used
- **Cards** with shadows and rounded corners
- **Forms** with validation states
- **Buttons** with icons (Bootstrap Icons)
- **Alerts** for flash messages
- **Navbar** with dropdown menu
- **Grid system** for responsive layout
- **Badges** for status indicators

### Custom Styling
- Gradient backgrounds
- Google button with official colors
- Hover effects
- Responsive design
- Dark mode compatible (navbar)

## 📧 Email Templates

Laravel menggunakan default email templates. Untuk customize:

```bash
php artisan vendor:publish --tag=laravel-mail
```

Templates akan tersimpan di `resources/views/vendor/mail/`.

## 🔒 Security Features

✅ **CSRF Protection** - Semua form dilindungi token CSRF
✅ **Password Hashing** - Bcrypt dengan default rounds
✅ **Signed URLs** - Email verification menggunakan signed URL
✅ **Rate Limiting** - Throttle pada resend email (6 attempts/minute)
✅ **SQL Injection Prevention** - Eloquent ORM
✅ **XSS Protection** - Blade template escaping
✅ **Session Security** - Secure session configuration

## 🐛 Troubleshooting

### Error: "No application encryption key has been set"
```bash
docker-compose exec app php artisan key:generate
```

### Error: Database connection refused
```bash
# Pastikan DB service running
docker-compose ps

# Restart containers
docker-compose restart
```

### Email tidak terkirim
- Check `storage/logs/laravel.log` untuk melihat log email
- Pastikan `MAIL_MAILER=log` di `.env` untuk development
- Untuk production, setup SMTP credentials yang benar

### Google OAuth error
- Periksa `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET`
- Pastikan redirect URI di Google Console sama dengan `GOOGLE_REDIRECT_URI`
- Tambahkan test user di OAuth consent screen

## 📚 Additional Resources

- [Laravel Authentication Docs](https://laravel.com/docs/authentication)
- [Laravel Email Verification](https://laravel.com/docs/verification)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.3/)
- [Google OAuth Setup Guide](./GOOGLE_OAUTH_SETUP.md)

## 🎯 Next Steps

Anda bisa extend aplikasi ini dengan:

1. **Forgot Password** - Reset password via email
2. **Profile Management** - Edit user profile & avatar
3. **Two-Factor Authentication** - Extra security layer
4. **Social Login** - Facebook, GitHub, Twitter
5. **Admin Panel** - User management
6. **API Authentication** - Laravel Sanctum
7. **Activity Logs** - Track user activities

Selamat mencoba! 🚀
