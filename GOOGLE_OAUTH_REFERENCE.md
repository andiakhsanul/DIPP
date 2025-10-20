# 🔐 Referensi Lengkap: Login dengan Google di Laravel

## 📚 Overview

Google OAuth 2.0 memungkinkan user login menggunakan akun Google mereka tanpa perlu membuat password baru di aplikasi Anda.

---

## 🎯 Cara Kerja Google OAuth

```
┌─────────┐         ┌──────────┐         ┌────────┐
│  User   │────1───▶│  Laravel │────2───▶│ Google │
│ Browser │         │   App    │         │  OAuth │
└─────────┘         └──────────┘         └────────┘
     │                    │                    │
     │◀──────3────────────┘                    │
     │                                         │
     │────────────4─────────────────────────▶  │
     │         (Login di Google)               │
     │                                         │
     │◀──────────5──────────────────────────── │
     │         (Redirect + Token)              │
     │                                         │
     │────────────6────────────▶               │
     │      (Callback URL)                     │
     │                    │                    │
     │◀──────7────────────┘                    │
     │    (Logged In)                          │
```

**Step by step:**
1. User klik "Login with Google"
2. Laravel redirect ke Google OAuth
3. Browser dibawa ke halaman login Google
4. User login dengan akun Google mereka
5. Google redirect kembali dengan authorization code
6. Laravel exchange code dengan access token
7. Laravel ambil data user dari Google dan login

---

## 🔧 Setup Google Cloud Console

### Step 1: Buat Project

1. Buka https://console.cloud.google.com/
2. Klik dropdown project (pojok kiri atas)
3. Klik "New Project"
4. Isi nama project: "DIPP Laravel Auth"
5. Klik "Create"

### Step 2: Enable APIs

1. Di dashboard, cari menu "APIs & Services"
2. Klik "Enable APIs and Services"
3. Cari "Google+ API" atau "People API"
4. Klik "Enable"

### Step 3: Create OAuth Credentials

1. Di "APIs & Services" → "Credentials"
2. Klik "Create Credentials" → "OAuth client ID"
3. Jika diminta, configure consent screen dulu:
   - Pilih "External"
   - App name: "DIPP"
   - User support email: email Anda
   - Developer email: email Anda
   - Save
4. Kembali ke Create OAuth client ID:
   - Application type: "Web application"
   - Name: "DIPP Web Client"
   - Authorized redirect URIs:
     ```
     http://localhost:8000/auth/google/callback
     http://localhost:8001/auth/google/callback (jika pakai port lain)
     ```
   - Klik "Create"

### Step 4: Copy Credentials

Setelah create, Anda akan dapat:
- **Client ID**: `123456789-abcdefg.apps.googleusercontent.com`
- **Client Secret**: `GOCSPX-xxxxxxxxxxxxxx`

⚠️ **PENTING**: Jangan share credentials ini ke public!

---

## 📦 Install Laravel Socialite

```bash
docker-compose exec app composer require laravel/socialite
```

---

## ⚙️ Konfigurasi Laravel

### 1. Environment Variables (.env)

Tambahkan di file `.env`:

```env
# Google OAuth
GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 2. Config Services (config/services.php)

Tambahkan di array return:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

---

## 💾 Database Migration

Update tabel users untuk menyimpan Google ID:

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('google_id')->nullable()->unique()->after('email');
    $table->string('avatar')->nullable()->after('google_id');
});
```

---

## 🎨 User Model

Update model `app/Models/User.php`:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'google_id',
    'avatar',
    'email_verified_at',
];
```

---

## 🛣️ Routes

Tambahkan di `routes/web.php`:

```php
use App\Http\Controllers\Auth\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('auth.google');
    
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');
```

---

## 🎮 Controller

Buat file `app/Http/Controllers/Auth/GoogleController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            // Get user info dari Google
            $googleUser = Socialite::driver('google')->user();
            
            // Cari atau buat user di database
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                // Update Google ID jika user sudah ada
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'email_verified_at' => now(), // Auto verify email
                ]);
            } else {
                // Buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(uniqid()), // Random password
                    'email_verified_at' => now(), // Auto verify email
                ]);
            }
            
            // Login user
            Auth::login($user);
            
            return redirect()->intended('/dashboard');
            
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google');
        }
    }
}
```

---

## 🖼️ View (Login Button)

Tambahkan button di halaman login:

```html
<!-- resources/views/auth/login.blade.php -->

<div class="text-center mt-3">
    <p class="mb-2">Atau login dengan:</p>
    <a href="{{ route('auth.google') }}" class="btn btn-outline-danger">
        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            <path fill="none" d="M0 0h48v48H0z"/>
        </svg>
        Login dengan Google
    </a>
</div>
```

---

## 🔒 Security Best Practices

### 1. Validate Email Domain (Optional)
Jika hanya allow domain tertentu:

```php
$allowedDomains = ['gmail.com', 'company.com'];
$emailDomain = explode('@', $googleUser->email)[1];

if (!in_array($emailDomain, $allowedDomains)) {
    return redirect('/login')->with('error', 'Domain email tidak diizinkan');
}
```

### 2. Rate Limiting
Tambahkan middleware throttle:

```php
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->middleware('throttle:10,1'); // 10 requests per minute
```

### 3. State Parameter
Socialite otomatis handle CSRF protection via state parameter.

---

## 🧪 Testing

### Manual Testing:
1. Buka http://localhost:8000/login
2. Klik "Login dengan Google"
3. Pilih akun Google
4. Allow permissions
5. Redirect ke dashboard

### Debugging:
Jika error, check:
- ✅ Google Cloud Console credentials benar
- ✅ Redirect URI sama persis (case-sensitive)
- ✅ APIs enabled
- ✅ .env file ter-load (restart container after edit)

---

## 📱 Production Setup

Untuk production, tambahkan domain production di:

1. **Google Cloud Console**:
   - Authorized redirect URIs: `https://yourdomain.com/auth/google/callback`

2. **.env production**:
   ```env
   GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
   ```

3. **SSL Required**: Google OAuth require HTTPS di production

---

## 🎯 Features Tambahan

### 1. Link/Unlink Google Account
User bisa link Google account ke existing account:

```php
public function linkGoogle()
{
    $user = Auth::user();
    $googleUser = Socialite::driver('google')->user();
    
    $user->update([
        'google_id' => $googleUser->id,
        'avatar' => $googleUser->avatar,
    ]);
    
    return redirect()->back()->with('success', 'Google account linked');
}
```

### 2. Multiple OAuth Providers
Tambahkan Facebook, GitHub, dll dengan cara yang sama:

```php
'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'redirect' => env('FACEBOOK_REDIRECT_URI'),
],
```

---

## 📚 Resources

- **Laravel Socialite Docs**: https://laravel.com/docs/socialite
- **Google OAuth Docs**: https://developers.google.com/identity/protocols/oauth2
- **Google Cloud Console**: https://console.cloud.google.com/
- **Socialite GitHub**: https://github.com/laravel/socialite

---

## ❓ FAQ

**Q: Apakah gratis?**
A: Ya, Google OAuth gratis untuk unlimited users.

**Q: Butuh credit card?**
A: Tidak untuk OAuth saja.

**Q: Bagaimana jika user tidak punya Gmail?**
A: User harus punya akun Google (bisa buat dengan email non-Gmail).

**Q: Data apa saja yang didapat dari Google?**
A: Name, email, avatar, Google ID. Bisa request lebih dengan scopes.

**Q: Apakah perlu verify domain?**
A: Tidak untuk development. Production recommended verify untuk avoid warning screen.

---

**Siap untuk implementasi! 🚀**
