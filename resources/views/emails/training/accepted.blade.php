@component('mail::message')
# Pendaftaran Pelatihan Diterima

Halo {{ $user->name }},

Selamat, pendaftaran Anda pada pelatihan **{{ $training->training_name }}** telah diterima.

- **No. Registrasi**: {{ $registrationNumber }}
- **Lokasi**: {{ $training->location }}
- **Tanggal Mulai**: {{ \Carbon\Carbon::parse($training->start_date)->translatedFormat('d F Y') }}

Silakan lihat detail pelatihan untuk mengikuti informasi dan jadwal selanjutnya.

@component('mail::button', ['url' => route('public.training.show', $training->id)])
Lihat Detail Pelatihan
@endcomponent

Salam hangat,  
Balai Pelatihan dan Pemberdayaan Masyarakat Desa Tertinggal dan Transmigrasi Banjarmasin
@endcomponent
