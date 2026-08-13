@component('mail::message')
# Reset Password

Halo {{ $user->name }},

Kami menerima permintaan reset password untuk akun Anda.

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

Link reset password ini berlaku selama 60 menit.

Jika Anda tidak meminta reset password, abaikan email ini.

Salam hangat,  
Balai Pelatihan dan Pemberdayaan Masyarakat Desa Tertinggal dan Transmigrasi Banjarmasin
@endcomponent
