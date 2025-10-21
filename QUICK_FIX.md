# 🚨 QUICK FIX - Kedua Masalah Anda

## Masalah 1: Google OAuth Error ❌

### Error:
```
Access blocked: project-7805558855's request is invalid
```

### Penyebab:
OAuth Consent Screen belum dikonfigurasi dengan benar di Google Cloud Console.

### Solusi Cepat (5 Menit):

1. **Buka OAuth Consent Screen:**
   https://console.cloud.google.com/apis/credentials/consent?project=ragillapps

2. **Pilih User Type: External** → Klik **CREATE**

3. **Isi Form App Information:**
   - App name: `DIPP App`
   - User support email: [pilih email Anda]
   - Developer contact email: [email Anda]
   - Klik **SAVE AND CONTINUE**

4. **Add Scopes:**
   - Klik **ADD OR REMOVE SCOPES**
   - Pilih: `userinfo.email`, `userinfo.profile`, `openid`
   - Klik **UPDATE** → **SAVE AND CONTINUE**

5. **Add Test Users** (PENTING!):
   - Klik **ADD USERS**
   - Masukkan email Google yang akan Anda gunakan untuk login
   - Klik **ADD** → **SAVE AND CONTINUE**

6. **Summary** → **BACK TO DASHBOARD**

### Verifikasi Redirect URI:
https://console.cloud.google.com/apis/credentials?project=ragillapps

Pastikan ada: `http://localhost:8000/auth/google/callback`

### Test Lagi:
1. Buka: http://localhost:8000
2. Klik **Login** → **Continue with Google**
3. Login dengan email yang sudah ditambahkan di Test users
4. ✅ Seharusnya berhasil!

📄 **Panduan lengkap:** `GOOGLE_OAUTH_FIX.md`

---

## Masalah 2: Email Tidak Terkirim ❌

### Penyebab:
Email dikonfigurasi sebagai `log` (hanya dicatat di file, tidak benar-benar terkirim).

### Solusi Cepat dengan Mailtrap (Gratis):

#### 1. Daftar Mailtrap (2 menit):
   - Kunjungi: https://mailtrap.io/register/signup
   - Sign up dengan email/Google
   - Verifikasi email

#### 2. Dapatkan SMTP Credentials:
   - Login ke Mailtrap
   - Klik **Email Testing** (atau My Inbox)
   - Pilih **SMTP Settings** → **Laravel 9+**
   - Copy credentials (Username & Password)

#### 3. Update File `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=paste_username_dari_mailtrap
   MAIL_PASSWORD=paste_password_dari_mailtrap
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@dipp.local"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

#### 4. Clear Cache:
   ```bash
   docker-compose exec app php artisan config:clear
   ```

#### 5. Test Email Verification:
   1. Buka: http://localhost:8000
   2. Klik **Register**
   3. Isi form dengan email apapun (tidak perlu email asli)
   4. Klik **Register**
   5. **Buka Mailtrap inbox** → Email verification akan muncul di sana!
   6. Klik link verification
   7. ✅ Berhasil verified dan login!

📄 **Panduan lengkap:** `EMAIL_SETUP.md`

---

## Checklist Final ✅

### Google OAuth:
- [ ] OAuth Consent Screen sudah dikonfigurasi (User Type: External)
- [ ] App name, support email, developer email sudah diisi
- [ ] Scopes (email, profile, openid) sudah ditambahkan
- [ ] Email Anda sudah ditambahkan di Test users
- [ ] Redirect URI sudah benar: `http://localhost:8000/auth/google/callback`
- [ ] Test login dengan Google berhasil

### Email Verification:
- [ ] File `.env` sudah diupdate dengan Mailtrap credentials
- [ ] `MAIL_MAILER=smtp` (bukan `log`)
- [ ] Username dan password Mailtrap sudah diisi
- [ ] Cache sudah di-clear
- [ ] Test register dan email muncul di Mailtrap inbox
- [ ] Test klik link verification berhasil

---

## Commands yang Mungkin Diperlukan

```bash
# Clear all cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear

# Restart container jika perlu
docker-compose restart app

# Test email manual
docker-compose exec app php artisan tinker
# Lalu ketik:
Mail::raw('Test', function($m) { $m->to('test@test.com')->subject('Test'); });
```

---

## Butuh Bantuan?

Jika masih ada error:

1. **Google OAuth Error:**
   - Screenshot error message
   - Cek apakah email sudah ditambahkan di Test users
   - Cek OAuth Consent Screen sudah selesai dikonfigurasi

2. **Email Error:**
   - Cek log: `docker-compose logs app`
   - Pastikan Mailtrap credentials benar
   - Test koneksi manual dengan tinker

---

## File Dokumentasi:

- 📄 `GOOGLE_OAUTH_FIX.md` - Fix OAuth error lengkap
- 📄 `EMAIL_SETUP.md` - Setup email verification lengkap
- 📄 `GOOGLE_OAUTH_UPDATE.md` - Setup redirect URI
- 📄 `GOOGLE_OAUTH_SETUP.md` - Setup awal Google OAuth
- 📄 `AUTH_DOCUMENTATION.md` - Dokumentasi lengkap authentication

Semoga membantu! 🚀
