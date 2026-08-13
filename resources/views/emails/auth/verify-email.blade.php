@component('mail::message')
# Verifikasi Alamat Email

Halo {{ $user->name }},

Terima kasih telah mendaftar. Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.

@component('mail::button', ['url' => $verificationUrl])
Verifikasi Email
@endcomponent

Link verifikasi ini berlaku selama 60 menit.

Jika Anda tidak merasa membuat akun, abaikan email ini.

Salam hangat,  
Balai Pelatihan dan Pemberdayaan Masyarakat Desa Tertinggal dan Transmigrasi Banjarmasin
@endcomponent
