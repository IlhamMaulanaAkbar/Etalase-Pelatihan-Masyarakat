@component('mail::message')
# Pendaftaran Pelatihan Berhasil

Halo {{ $user->name }},

Terima kasih telah mendaftar pada pelatihan **{{ $training->training_name }}**.

- **No. Registrasi**: {{ $registrationNumber }}
- **Lokasi**: {{ $training->location }}
- **Tanggal Mulai**: {{ \Carbon\Carbon::parse($training->start_date)->translatedFormat('d F Y') }}

Kami akan segera memproses pendaftaran Anda.  
Silakan tunggu informasi selanjutnya dari panitia.

@component('mail::button', ['url' => route('public.training.show', $training->id)])
Lihat Detail Pelatihan
@endcomponent

Salam hangat,  
Balai Pelatihan dan Pemberdayaan Masyarakat Desa Tertinggal dan Transmigrasi Banjarmasin
@endcomponent
