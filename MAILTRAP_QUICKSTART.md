# Quick Mailtrap Setup 🚀

## Step 1: Get Mailtrap Credentials

1. Go to **[mailtrap.io](https://mailtrap.io)** and sign up (FREE)
2. Login and go to **Email Testing** → **Inboxes**
3. Click on your inbox (or create new one)
4. Click **Show Credentials** or go to **SMTP Settings** tab
5. Select integration: **Laravel 9+**

You'll see something like:
```
Host: sandbox.smtp.mailtrap.io
Port: 2525
Username: a1b2c3d4e5f6g7
Password: x1y2z3w4v5u6t7
```

## Step 2: Update .env File

Open `.env` file and update these lines:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=a1b2c3d4e5f6g7          # ← Your username here
MAIL_PASSWORD=x1y2z3w4v5u6t7          # ← Your password here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@dipp.unair.ac.id"
MAIL_FROM_NAME="${APP_NAME}"
```

## Step 3: Clear Cache

Run in terminal:
```bash
docker exec laravel_dipp php artisan config:clear
docker exec laravel_dipp php artisan cache:clear
```

## Step 4: Test Email

### Option 1: Register New User
1. Go to http://localhost:8000/register
2. Register with any email
3. Check Mailtrap inbox for verification email

### Option 2: Use Tinker
```bash
docker exec -it laravel_dipp php artisan tinker
```

Then:
```php
Mail::raw('Test email from DIPP', function($message) {
    $message->to('test@example.com')->subject('Test Email');
});
```

Check your Mailtrap inbox!

## ✅ Done!

All emails (verification, notifications, etc.) will now be caught by Mailtrap for testing.

---

**Need Help?** See full documentation in `MAILTRAP_SETUP.md`
