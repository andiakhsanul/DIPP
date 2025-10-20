# Setup Google OAuth - Quick Guide

Ikuti langkah-langkah berikut untuk mengaktifkan login dengan Google:

## 1. Google Cloud Console Setup

### A. Buat Project Baru
1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Klik **"Select a project"** → **"New Project"**
3. Nama project: `DIPP Auth` (atau nama lain)
4. Klik **"Create"**

### B. Enable Google+ API
1. Di sidebar, pilih **"APIs & Services"** → **"Library"**
2. Cari **"Google+ API"**
3. Klik **"Enable"**

### C. Configure OAuth Consent Screen
1. Di sidebar, pilih **"APIs & Services"** → **"OAuth consent screen"**
2. Pilih **"External"** → Klik **"Create"**
3. Isi form:
   - **App name**: `DIPP Application`
   - **User support email**: Email Anda
   - **Developer contact email**: Email Anda
4. Klik **"Save and Continue"**
5. Di halaman **"Scopes"**, klik **"Add or Remove Scopes"**
6. Pilih:
   - `userinfo.email`
   - `userinfo.profile`
   - `openid`
7. Klik **"Update"** → **"Save and Continue"**
8. Di halaman **"Test users"**, tambahkan email Anda untuk testing
9. Klik **"Save and Continue"**

### D. Create OAuth 2.0 Credentials
1. Di sidebar, pilih **"APIs & Services"** → **"Credentials"**
2. Klik **"Create Credentials"** → **"OAuth client ID"**
3. Pilih **"Web application"**
4. Isi form:
   - **Name**: `DIPP Web Client`
   - **Authorized JavaScript origins**:
     ```
     http://localhost:8000
     ```
   - **Authorized redirect URIs**:
     ```
     http://localhost:8000/auth/google/callback
     ```
5. Klik **"Create"**
6. **COPY** `Client ID` dan `Client Secret` yang muncul

## 2. Update File .env

Buka file `.env` di root project dan update:

```env
GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Ganti**:
- `your-client-id-here` dengan Client ID dari Google
- `your-client-secret-here` dengan Client Secret dari Google

## 3. Test Login

1. Buka browser: `http://localhost:8000/login`
2. Klik tombol **"Continue with Google"**
3. Login dengan Google account Anda
4. Setelah berhasil, Anda akan diarahkan ke Dashboard

## 4. Troubleshooting

### Error: redirect_uri_mismatch
**Solusi**: Pastikan Authorized redirect URIs di Google Console sama persis dengan `GOOGLE_REDIRECT_URI` di `.env`

### Error: invalid_client
**Solusi**: 
- Periksa `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` di `.env`
- Pastikan tidak ada spasi atau karakter tambahan

### User tidak bisa login
**Solusi**: 
- Tambahkan email user ke **Test users** di OAuth consent screen
- Atau publish aplikasi untuk **Production** (jika sudah siap)

## 5. Production Setup (Optional)

Untuk deploy ke production:

1. **Update Authorized redirect URIs** di Google Console:
   ```
   https://your-domain.com/auth/google/callback
   ```

2. **Update `.env` production**:
   ```env
   APP_URL=https://your-domain.com
   GOOGLE_REDIRECT_URI=https://your-domain.com/auth/google/callback
   ```

3. **Publish OAuth Consent Screen**:
   - Kembali ke OAuth consent screen
   - Klik **"Publish App"**
   - Submit untuk review (jika diperlukan)

## 6. Security Best Practices

✅ **Jangan commit** `.env` ke Git
✅ **Gunakan HTTPS** di production
✅ **Batasi Test users** saat development
✅ **Review scope permissions** secara berkala
✅ **Rotate credentials** jika terjadi kebocoran

## Reference

Untuk detail lebih lanjut, baca: `GOOGLE_OAUTH_REFERENCE.md`
