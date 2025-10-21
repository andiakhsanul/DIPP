# 🚀 Quick Start: Fix Google OAuth "Access Blocked"

## ❌ Error yang Anda Alami

```
Access blocked: project-7805558855's request is invalid
```

## ✅ Solusi: 5 Langkah Mudah (5 Menit)

### 📋 Checklist Sebelum Mulai

Pastikan konfigurasi Laravel sudah benar:
- ✅ Socialite installed: `laravel/socialite v5.23.0`
- ✅ Client ID di `.env`: `7805558855-pj2udkmhvt9ha5nmrvh91vmtkqioigpn.apps.googleusercontent.com`
- ✅ Client Secret di `.env`: `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`
- ✅ Redirect URI: `http://localhost:8000/auth/google/callback`
- ✅ Controller dengan scopes: `['openid', 'profile', 'email']`

**Kesimpulan:** Konfigurasi Laravel sudah 100% benar! ✅

Yang perlu dilakukan: **Setup Google Cloud Console** ⬇️

---

## 🔧 Step 1: Buka OAuth Consent Screen

1. Klik link ini: https://console.cloud.google.com/apis/credentials/consent?project=ragillapps
2. Login dengan akun Google Anda
3. Akan muncul halaman "OAuth consent screen"

---

## 🔧 Step 2: Pilih User Type

Anda akan melihat 2 pilihan:

### Internal (untuk Google Workspace)
```
❌ Jangan pilih ini kecuali Anda punya Google Workspace
```

### External (untuk semua user Google) ✅
```
✅ PILIH INI!
Memungkinkan siapa saja dengan akun Google untuk login
```

**Klik tombol CREATE** setelah memilih "External"

---

## 🔧 Step 3: Isi OAuth Consent Screen

### Page 1: App Information

**App name** (Wajib)
```
DIPP App
```

**User support email** (Wajib)
```
[Pilih email Anda dari dropdown]
```

**App logo** (Optional)
```
Skip dulu - tidak wajib untuk testing
```

**App domain** (Optional untuk testing)
```
Skip dulu - biarkan kosong
```

**Authorized domains** (Optional)
```
Skip dulu - kosong saja untuk localhost
```

**Developer contact information** (Wajib)
```
Masukkan email Anda
Contoh: your-email@gmail.com
```

**Klik: SAVE AND CONTINUE**

---

## 🔧 Step 4: Add Scopes

### Page 2: Scopes

**Klik tombol: ADD OR REMOVE SCOPES**

Akan muncul popup dengan daftar scopes. Centang yang berikut:

#### Scopes yang Wajib:
```
✅ .../auth/userinfo.email
   See your primary Google Account email address

✅ .../auth/userinfo.profile  
   See your personal info, including any personal info you've made publicly available

✅ openid
   Associate you with your personal info on Google
```

**Cara mencari scopes:**
1. Di kolom "Filter", ketik: `userinfo`
2. Centang `userinfo.email` dan `userinfo.profile`
3. Scroll ke atas, centang `openid`

**Klik: UPDATE**

**Klik: SAVE AND CONTINUE**

---

## 🔧 Step 5: Add Test Users (PENTING!)

### Page 3: Test users

**SANGAT PENTING:** Karena app masih dalam mode "Testing", hanya user yang ditambahkan di sini yang bisa login!

**Klik tombol: ADD USERS**

**Masukkan email Google Anda:**
```
your-email@gmail.com
```

**Klik: ADD**

**Klik: SAVE AND CONTINUE**

---

## 🔧 Step 6: Summary & Publish Status

### Page 4: Summary

Review semua informasi yang sudah diisi.

**Klik: BACK TO DASHBOARD**

### Publishing Status

Anda akan melihat status:
```
🟡 Publishing status: Testing
```

**Untuk Development:** Status "Testing" sudah cukup! ✅

**Notes:**
- Maksimal 100 test users
- Refresh token expires setiap 7 hari (user perlu login ulang)
- Hanya test users yang bisa login

**Untuk Production:** Klik "PUBLISH APP" (akan di-review Google, 1-2 minggu)

---

## ✅ Verification: Update Redirect URI

Pastikan Authorized Redirect URI sudah benar:

1. Buka: https://console.cloud.google.com/apis/credentials?project=ragillapps
2. Klik **Edit** (icon pensil) pada OAuth Client ID Anda
3. Di **Authorized redirect URIs**, pastikan ada:
   ```
   http://localhost:8000/auth/google/callback
   ```
4. Jika belum ada, klik **ADD URI** dan tambahkan
5. Klik **SAVE**

---

## 🧪 Test Google OAuth

### 1. Clear Cache Laravel
```bash
docker-compose exec app php artisan config:clear
```

### 2. Test Login

1. Buka: http://localhost:8000/login
2. Klik tombol: **Continue with Google**
3. Pilih akun Google (yang sudah ditambahkan di Test users)
4. Klik **Continue** untuk memberikan permission
5. ✅ **Berhasil!** Anda akan redirect ke dashboard

---

## 🐛 Troubleshooting

### Error masih "Access blocked"?

**Checklist:**
- [ ] User Type sudah dipilih "External"?
- [ ] App name sudah diisi?
- [ ] User support email sudah diisi?
- [ ] Developer contact email sudah diisi?
- [ ] Scopes sudah ditambahkan (email, profile, openid)?
- [ ] **Email Anda sudah ditambahkan di Test users?** ⚠️ (paling sering lupa!)
- [ ] Redirect URI sudah benar: `http://localhost:8000/auth/google/callback`

### Error "redirect_uri_mismatch"?

Redirect URI di Google Console tidak sesuai dengan di aplikasi.

**Solusi:**
1. Cek `.env`: `GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback`
2. Cek Google Console: Harus sama persis
3. Tidak ada trailing slash `/`
4. Tidak ada typo
5. Clear cache: `docker-compose exec app php artisan config:clear`

### Error "invalid_client"?

Client ID atau Client Secret salah.

**Solusi:**
1. Copy ulang Client ID dari Google Console
2. Copy ulang Client Secret dari Google Console
3. Update di `.env`
4. Clear cache

### User tidak bisa login (bukan Test user)?

Jika user lain coba login dan dapat error:

**Penyebab:** User tersebut belum ditambahkan di Test users

**Solusi:**
1. Buka OAuth Consent Screen
2. Scroll ke **Test users**
3. Klik **ADD USERS**
4. Tambahkan email user tersebut
5. User coba login lagi

---

## 📊 Summary

### ✅ Yang Sudah Benar (Tidak Perlu Diubah):
- Laravel Socialite configuration
- Controller implementation
- Routes configuration
- Scopes definition
- Client ID & Secret di `.env`

### ⏳ Yang Perlu Dilakukan (5 Menit):
1. Setup OAuth Consent Screen
2. Pilih User Type: External
3. Isi App name & emails
4. Add Scopes (email, profile, openid)
5. **Add Test users (email Anda)** ⚠️
6. Verify Redirect URI

### 🎯 Expected Result:
```
✅ Login dengan Google berhasil
✅ Auto-verify email
✅ Redirect ke dashboard
✅ Avatar Google tersimpan
```

---

## 📄 Reference

- **Laravel Socialite Docs**: https://laravel.com/docs/12.x/socialite
- **Google OAuth Guide**: https://developers.google.com/identity/protocols/oauth2
- **OAuth Consent Screen**: https://console.cloud.google.com/apis/credentials/consent?project=ragillapps
- **Credentials**: https://console.cloud.google.com/apis/credentials?project=ragillapps

---

## 💡 Tips

1. **Gunakan email yang sama** untuk Test user dan login
2. **Logout dari Google** terlebih dahulu jika mau test ulang
3. **Clear browser cookies** untuk localhost jika ada masalah
4. **Status "Testing" sudah cukup** untuk development
5. **Publish APP** hanya jika sudah mau production

---

Selamat! Setelah mengikuti langkah ini, Google OAuth akan berfungsi dengan sempurna! 🎉
