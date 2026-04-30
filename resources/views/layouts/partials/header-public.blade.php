<header class="bg-white shadow-sm w-100 sticky-top">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-xl py-2 w-100">
        <div class="container">
            {{-- Logo dan Judul --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Logo" width="50" height="50"
                    class="me-2">
                <div class="lh-sm">
                    <div class=" fs-2 fw-bolder text-black small">E-LATMAS</div>
                    <small class="fs-2 fw-bolder text-black small">Etalase Pelatihan Masyarakat</small>
                </div>
            </a>

            {{-- Toggle Menu Mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu Utama --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-lg-3 d-xl-flex align-items-xl-center">
                    {{-- Menu --}}
                    <li class="nav-item"><a class="nav-link text-dark fs-2 fw-semibold"
                            href="{{ route('public.home.dashboard.index') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link text-dark fs-2 fw-semibold"
                            href="{{ route('public.training.index') }}">Pelatihan</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-dark fs-2 fw-semibold"
                            href="{{ route('public.assistance.index') }}">Pendampingan</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-dark fs-2 fw-semibold"
                            href="{{ route('public.learning.index') }}">Pembelajaran</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-dark fs-2 fw-semibold"
                            href="{{ route('public.about.index') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-dark fs-2 fw-semibold"
                            href="{{ route('public.contact.index') }}">Kontak</a></li>

                    @guest('user')
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('auth.user.login.index') }}"
                                class="btn btn-outline-primary btn-sm ms-lg-2 fs-2 w-100 w-lg-auto mx-auto">
                                Login
                            </a>
                        </li>
                    @else
                        @php
                            $authUser = Auth::guard('user')->user();
                            $headerProfilePhotoUrl = $authUser?->photo
                                ? asset('storage/' . $authUser->photo)
                                : asset('assets/images/profile/user-1.jpg');
                        @endphp
                        <li class="nav-item dropdown ">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ $headerProfilePhotoUrl }}" alt="Profil" width="35" height="35"
                                    class="rounded-circle" style="object-fit: cover;">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="{{ route('public.account.profile.index') }}"
                                        class="d-flex align-items-xl-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">Profil Saya</p>
                                    </a>
                                    <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-settings fs-6"></i>
                                        <p class="mb-0 fs-3">Pengaturan</p>
                                    </a>
                                    <form method="POST" action="{{ route('auth.user.logout.destroy') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary mt-2 w-75 mx-auto d-block">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
