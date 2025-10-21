# Fix Google OAuth Error: "Access blocked"

## Error yang Anda Alami

```
Access blocked: project-7805558855's request is invalid
```

## Penyebab

Error ini terjadi karena **OAuth Consent Screen** belum dikonfigurasi atau belum lengkap di Google Cloud Console.

## Laravel Socialite Documentation

Implementasi kita sudah sesuai dengan dokumentasi resmi Laravel:
- 📖 **Laravel Socialite Docs**: https://laravel.com/docs/12.x/socialite
- 📖 **Google OAuth Guide**: https://laravel.com/docs/12.x/socialite#google

Konfigurasi Laravel sudah benar ✅, yang perlu dilakukan adalah **setup di Google Cloud Console**.

## ✅ Verifikasi Konfigurasi Laravel

Sebelum setup Google Console, pastikan konfigurasi Laravel sudah benar:

### 1. Cek Socialite Package
```bash
docker-compose exec app composer show laravel/socialite
```
Harus terinstall: ✅ **laravel/socialite v5.23.0**

### 2. Cek config/services.php
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```
✅ Sudah benar!

### 3. Cek .env
```env
GOOGLE_CLIENT_ID=7805558855-pj2udkmhvt9ha5nmrvh91vmtkqioigpn.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```
✅ Sudah benar!

### 4. Cek Controller
Controller menggunakan scopes yang benar:
```php
Socialite::driver('google')
    ->scopes(['openid', 'profile', 'email'])
    ->redirect();
```
✅ Sudah benar!

---

## 🔧 Solusi: Setup Google Cloud Console

Konfigurasi Laravel sudah 100% benar ✅. Yang perlu dilakukan adalah **setup di Google Cloud Console**.

### 1. Konfigurasi OAuth Consent Screen

#### A. Buka OAuth Consent Screen
1. Kunjungi: https://console.cloud.google.com/apis/credentials/consent?project=ragillapps
2. Atau dari menu: **APIs & Services** > **OAuth consent screen**

#### B. Pilih User Type
- **Internal**: Hanya untuk organisasi Google Workspace Anda
- **External**: Untuk semua user dengan akun Google ✅ **PILIH INI**

Klik **CREATE** atau **EDIT APP** jika sudah ada

#### C. Isi App Information (Wajib)

**App information:**
- **App name**: `DIPP App` (atau nama aplikasi Anda)
- **User support email**: Pilih email Anda dari dropdown
- **App logo**: (Optional, bisa diskip dulu)

**App domain:**
- **Application home page**: `http://localhost:8000` (untuk testing)
- **Application privacy policy link**: `http://localhost:8000/privacy` (bisa dibuat nanti)
- **Application terms of service link**: `http://localhost:8000/terms` (bisa dibuat nanti)

**Authorized domains:**
- `localhost` (untuk development)
- (kosongkan dulu untuk testing lokal)

**Developer contact information:**
- **Email addresses**: Masukkan email Anda (wajib)

Klik **SAVE AND CONTINUE**

#### D. Scopes (Permission)

Klik **ADD OR REMOVE SCOPES**

Pilih scopes berikut (minimal):
- ✅ `../auth/userinfo.email` - Lihat alamat email
- ✅ `../auth/userinfo.profile` - Lihat info profil dasar
- ✅ `openid` - OpenID Connect

Klik **UPDATE** > **SAVE AND CONTINUE**

#### E. Test Users (Hanya untuk External + Testing)

**PENTING**: Jika app masih dalam status "Testing", Anda harus menambahkan test users.

1. Klik **ADD USERS**
2. Masukkan email Google yang akan Anda gunakan untuk login
3. Klik **ADD**
4. Klik **SAVE AND CONTINUE**

#### F. Summary

Review informasi Anda, lalu klik **BACK TO DASHBOARD**

### 2. Verifikasi OAuth Client

Pastikan OAuth Client sudah benar:

1. Buka: https://console.cloud.google.com/apis/credentials?project=ragillapps
2. Cari OAuth 2.0 Client ID: `7805558855-pj2udkmhvt9ha5nmrvh91vmtkqioigpn.apps.googleusercontent.com`
3. Klik **Edit** (icon pensil)
4. Pastikan **Authorized redirect URIs** berisi:
   ```
   http://localhost:8000/auth/google/callback
   ```
5. Klik **SAVE**

### 3. Publishing Status

**Status: Testing Mode** (Untuk development)
- ✅ Bisa digunakan untuk testing
- ⚠️ Hanya user yang ditambahkan di "Test users" yang bisa login
- ⚠️ Perlu refresh consent setiap 7 hari

**Status: Production** (Untuk public access)
- Perlu verifikasi dari Google (proses review)
- Semua user bisa login tanpa batasan

Untuk testing, **gunakan status "Testing"** sudah cukup.

## Cara Test Setelah Fix

1. Logout dari aplikasi (jika sudah login)
2. Clear browser cookies untuk `localhost`
3. Buka: http://localhost:8000
4. Klik **Register** atau **Login**
5. Klik **Continue with Google**
6. Login dengan email yang sudah ditambahkan di **Test users**
7. Klik **Continue** untuk memberikan permission

## Troubleshooting

### Masih error "Access blocked"?

**Checklist:**
- ✅ OAuth Consent Screen sudah dikonfigurasi?
- ✅ User Type sudah dipilih (External)?
- ✅ App name sudah diisi?
- ✅ User support email sudah diisi?
- ✅ Developer contact email sudah diisi?
- ✅ Scopes minimal sudah ditambahkan (email, profile, openid)?
- ✅ Email Anda sudah ditambahkan di Test users?
- ✅ Redirect URI sudah benar di OAuth Client?

### Error "invalid_client"?
- Cek Client ID dan Client Secret di `.env`
- Pastikan tidak ada spasi atau typo
- Jalankan: `docker-compose exec app php artisan config:clear`

### Error "redirect_uri_mismatch"?
- Pastikan redirect URI di Google Console: `http://localhost:8000/auth/google/callback`
- Pastikan APP_URL di `.env`: `http://localhost:8000`
- Tidak ada trailing slash `/`

## Quick Links

- **OAuth Consent Screen**: https://console.cloud.google.com/apis/credentials/consent?project=ragillapps
- **Credentials**: https://console.cloud.google.com/apis/credentials?project=ragillapps
- **API Library**: https://console.cloud.google.com/apis/library?project=ragillapps

## Status Publishing App

Untuk mempublikasikan app ke production (agar semua orang bisa login):

1. Lengkapi OAuth Consent Screen dengan semua informasi
2. Buat halaman Privacy Policy dan Terms of Service
3. Submit untuk review: Klik **PUBLISH APP** di OAuth Consent Screen
4. Google akan review (bisa 1-2 minggu)

**Untuk development/testing, tidak perlu publish!**
