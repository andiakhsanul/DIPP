@component('mail::message')
# Verifikasi Alamat Email Anda

Halo **{{ $name }}**,

Terima kasih telah mendaftar di Sistem Informasi **Pusat Inovasi Pendidikan dan Teknologi Pembelajaran (PIPTP)** Universitas Airlangga.

Untuk melanjutkan proses pendaftaran, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Verifikasi Alamat Email
@endcomponent

**Link verifikasi ini akan kedaluwarsa dalam 60 menit.**

Jika Anda tidak membuat akun di sistem kami, tidak ada tindakan lebih lanjut yang diperlukan. Abaikan email ini.

---

### Tentang PIPTP

Pusat Inovasi Pendidikan dan Teknologi Pembelajaran (PIPTP) adalah unit kerja di Universitas Airlangga yang berfokus pada pengembangan inovasi pembelajaran dan implementasi teknologi pendidikan.

**Kontak:**
- Email: piptp@mail.unair.ac.id
- Website: [www.unair.ac.id](https://www.unair.ac.id)

<small>© {{ date('Y') }} Universitas Airlangga. All rights reserved.</small>
@endcomponent
