# Update Google OAuth Redirect URI

## Credentials Anda

Credentials Google OAuth sudah dikonfigurasi dengan detail berikut:

- **Client ID**: `7805558855-pj2udkmhvt9ha5nmrvh91vmtkqioigpn.apps.googleusercontent.com`
- **Client Secret**: `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`
- **Project ID**: `ragillapps`

## ⚠️ PENTING: Update Redirect URI

Anda **HARUS** menambahkan redirect URI berikut ke Google Cloud Console:

### Redirect URI yang Diperlukan:
```
http://localhost:8000/auth/google/callback
```

## Langkah-langkah Update di Google Cloud Console

### 1. Buka Google Cloud Console
- Kunjungi: https://console.cloud.google.com/
- Login dengan akun Google Anda

### 2. Pilih Project "ragillapps"
- Klik dropdown project di bagian atas
- Pilih project: **ragillapps**

### 3. Navigasi ke Credentials
- Di menu sebelah kiri, pilih: **APIs & Services** > **Credentials**
- Atau kunjungi langsung: https://console.cloud.google.com/apis/credentials

### 4. Edit OAuth 2.0 Client ID
- Cari client ID: `7805558855-pj2udkmhvt9ha5nmrvh91vmtkqioigpn.apps.googleusercontent.com`
- Klik icon **pensil** (✏️) untuk edit

### 5. Tambahkan Authorized Redirect URIs
Di bagian **Authorized redirect URIs**, tambahkan:

#### Untuk Development (localhost):
```
http://localhost:8000/auth/google/callback
```

#### Untuk Production (jika sudah deploy):
```
https://yourdomain.com/auth/google/callback
```

### 6. Tambahkan Authorized JavaScript Origins (Optional)
Di bagian **Authorized JavaScript origins**, pastikan ada:
```
http://localhost:8000
```

### 7. Save Changes
- Klik tombol **SAVE** di bagian bawah
- Tunggu beberapa detik untuk perubahan diterapkan

## Verifikasi Konfigurasi

### 1. Cek File .env
Pastikan `.env` sudah berisi:
```env
GOOGLE_CLIENT_ID=7805558855-pj2udkmhvt9ha5nmrvh91vmtkqioigpn.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 2. Test Google Login
1. Buka browser: http://localhost:8000
2. Klik tombol **Register** atau **Login**
3. Klik tombol **Continue with Google**
4. Pilih akun Google Anda
5. Jika berhasil, Anda akan diredirect ke dashboard

## Troubleshooting

### Error: "redirect_uri_mismatch"
**Penyebab**: Redirect URI di aplikasi tidak sesuai dengan yang terdaftar di Google Cloud Console

**Solusi**:
1. Pastikan redirect URI di Google Cloud Console adalah: `http://localhost:8000/auth/google/callback`
2. Pastikan tidak ada typo atau spasi
3. Pastikan menggunakan `http://` bukan `https://` untuk localhost
4. Clear config cache: `docker-compose exec app php artisan config:clear`
5. Refresh browser dan coba lagi

### Error: "invalid_client"
**Penyebab**: Client ID atau Client Secret salah

**Solusi**:
1. Cek kembali Client ID dan Client Secret di `.env`
2. Pastikan tidak ada spasi atau karakter tambahan
3. Clear config cache: `docker-compose exec app php artisan config:clear`

### Error: "access_denied"
**Penyebab**: User membatalkan login atau tidak memberikan izin

**Solusi**:
1. Coba login lagi
2. Berikan izin yang diminta oleh aplikasi

## Redirect URIs Saat Ini di Google Cloud

Berdasarkan file JSON Anda, redirect URI yang terdaftar saat ini:
```json
"redirect_uris": [
  "https://ragillapps.firebaseapp.com/__/auth/handler"
]
```

**Anda perlu menambahkan** (tidak mengganti):
```
http://localhost:8000/auth/google/callback
```

Jadi total redirect URIs menjadi:
1. `https://ragillapps.firebaseapp.com/__/auth/handler` (tetap ada)
2. `http://localhost:8000/auth/google/callback` (tambahkan ini)

## URL Penting

- **Google Cloud Console**: https://console.cloud.google.com/
- **Credentials Page**: https://console.cloud.google.com/apis/credentials?project=ragillapps
- **OAuth Consent Screen**: https://console.cloud.google.com/apis/credentials/consent?project=ragillapps

## Catatan Keamanan

⚠️ **JANGAN** commit file yang berisi Client Secret ke repository publik!

File yang harus di `.gitignore`:
- `.env`
- `client_secret_*.json`

## Status Konfigurasi

- ✅ Client ID sudah dikonfigurasi
- ✅ Client Secret sudah dikonfigurasi
- ✅ Redirect URI di aplikasi sudah dikonfigurasi
- ⚠️ **PERLU DILAKUKAN**: Tambahkan redirect URI di Google Cloud Console

## Next Steps

1. ✅ Credentials sudah dikonfigurasi di `.env`
2. ⏳ **Update redirect URI di Google Cloud Console** (ikuti langkah di atas)
3. ⏳ Test Google OAuth login
4. ⏳ Setup email verification (optional)
5. ⏳ Deploy to production (optional)
