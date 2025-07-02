@extends('layouts.base-public')

@section('content')
    {{-- Section Header --}}
    <section class="bg-light-primary py-5">
        <div class="container">
            <h4 class="text-black fw-semibold mb-0">Kontak Kami</h4>
        </div>
    </section>

    {{-- Section Content --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="{{ asset('assets/images/illustrations/email.png') }}" alt="Ilustrasi" class="img-fluid"
                        style="max-height: 380px;">
                </div>
                <div class="col-lg-6">
                    <h3 class="fw-semibold text-black mb-4">Dengan Senang Hati, Kami Siap Membantu Anda Hari Ini!</h3>

                    <div class="mb-3 text-black">
                        <strong class="text-black">Alamat:</strong><br>
                        Jl. Handil Bakti KM 9,5 No.95 Banjarmasin<br>
                        Kalimantan Selatan, Indonesia
                    </div>

                    <div class="mb-3">
                        <strong class="text-black">Email:</strong><br>
                        <a href="mailto:balatmasbdj@gmail.com" class="text-black">balatmasbdj@gmail.com</a>
                    </div>

                    <div class="mb-4 text-black">
                        <strong class="text-black">Jam Operasional:</strong><br>
                        Senin s/d Kamis: 07.30 - 16.00 WITA<br>
                        Jum’at: 07.30 - 16.30 WITA
                    </div>

                    {{-- Kartu WhatsApp --}}
                    <div class="card shadow border-0 rounded-4 overflow-hidden" style="max-width: 320px;">
                        <div class="card-body bg-primary text-white d-flex align-items-center">
                            <div class="me-3 social-user">
                                <i class="ti ti-user-circle fs-3"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Layanan Masyarakat</div>
                                <div class="small">08115000344</div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top d-grid">
                            <a href="https://wa.me/628115000344" target="_blank" class="btn btn-outline-primary">
                                <i class="ti ti-brand-whatsapp me-2"></i> Chat Via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
