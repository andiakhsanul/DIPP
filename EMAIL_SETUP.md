# Setup Email Verification - Mailtrap

## Masalah: Email Tidak Terkirim

Email verification tidak terkirim karena konfigurasi email saat ini menggunakan `MAIL_MAILER=log`, yang hanya mencatat email ke log file tanpa benar-benar mengirim.

## Solusi: Setup Mailtrap (Free & Mudah)

Mailtrap adalah layanan untuk testing email tanpa mengirim ke email asli. Perfect untuk development!

### 1. Buat Akun Mailtrap (Gratis)

1. Kunjungi: https://mailtrap.io/register/signup
2. Sign up dengan email atau Google
3. Verifikasi email Anda
4. Login ke dashboard

### 2. Dapatkan SMTP Credentials

1. Di dashboard Mailtrap, klik **Email Testing** (inbox pertama)
2. Atau klik **My Inbox** di sidebar
3. Di tab **SMTP Settings**, pilih integration: **Laravel 9+**
4. Copy credentials yang ditampilkan

Credentials akan terlihat seperti:
```
Host: sandbox.smtp.mailtrap.io
Port: 2525
Username: xxxxxxxxxxxx (12 karakter)
Password: xxxxxxxxxxxx (12 karakter)
```

### 3. Update File .env

Update bagian MAIL di file `.env` dengan credentials Mailtrap:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxxxxxxxxxxx
MAIL_PASSWORD=xxxxxxxxxxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@dipp.local"
MAIL_FROM_NAME="${APP_NAME}"
```

**Ganti `xxxxxxxxxxxx` dengan username dan password dari Mailtrap!**

### 4. Clear Config Cache

```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

### 5. Test Email Verification

1. Buka: http://localhost:8000
2. Klik **Register**
3. Isi form registrasi dengan email valid (email apapun, tidak perlu email asli)
4. Klik **Register**
5. Anda akan diredirect ke halaman "Verify Your Email"
6. **Buka Mailtrap inbox** untuk melihat email verification
7. Klik link verification di email
8. Anda akan otomatis login dan redirect ke dashboard

## Alternatif: Gmail SMTP (Production)

Jika ingin menggunakan Gmail untuk mengirim email asli:

### 1. Enable 2-Step Verification
1. Buka: https://myaccount.google.com/security
2. Enable **2-Step Verification**

### 2. Generate App Password
1. Buka: https://myaccount.google.com/apppasswords
2. App name: `DIPP Laravel`
3. Generate dan copy password (16 karakter)

### 3. Update .env
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx (app password 16 digit)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Verifikasi Konfigurasi

### Cek Log Email (Jika masih pakai MAIL_MAILER=log)
```bash
docker-compose exec app tail -f storage/logs/laravel.log
```

### Test Kirim Email Manual
```bash
docker-compose exec app php artisan tinker
```

Kemudian jalankan:
```php
Mail::raw('Test email', function($message) {
    $message->to('test@example.com')->subject('Test');
});
```

Jika berhasil, email akan muncul di Mailtrap inbox.

## Troubleshooting

### Email masih tidak terkirim?

**Checklist:**
1. ✅ `MAIL_MAILER=smtp` (bukan `log`)
2. ✅ `MAIL_HOST=sandbox.smtp.mailtrap.io`
3. ✅ `MAIL_PORT=2525`
4. ✅ `MAIL_USERNAME` dan `MAIL_PASSWORD` sudah diisi
5. ✅ Config cache sudah di-clear
6. ✅ Container sudah direstart

### Error "Connection refused"?
```bash
# Restart container
docker-compose restart app

# Clear cache
docker-compose exec app php artisan config:clear
```

### Cek koneksi ke Mailtrap
```bash
docker-compose exec app php artisan tinker
```
```php
// Test koneksi
try {
    Mail::raw('Test', function($msg) {
        $msg->to('test@test.com')->subject('Test');
    });
    echo "Email sent successfully!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Email Templates

Email verification menggunakan template bawaan Laravel. Jika ingin customize:

```bash
docker-compose exec app php artisan vendor:publish --tag=laravel-mail
```

Template akan tersimpan di: `resources/views/vendor/mail/`

## Quick Links

- **Mailtrap**: https://mailtrap.io
- **Gmail App Passwords**: https://myaccount.google.com/apppasswords
- **Laravel Mail Documentation**: https://laravel.com/docs/11.x/mail

## Status

- ❌ **Sekarang**: Email tidak terkirim (MAIL_MAILER=log)
- ✅ **Setelah fix**: Email terkirim ke Mailtrap inbox untuk testing
