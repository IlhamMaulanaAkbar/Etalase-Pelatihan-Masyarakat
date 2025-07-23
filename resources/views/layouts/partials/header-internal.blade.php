<!-- Header Start -->
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                    <div class="border-bottom px-3 py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Notifications</h6>
                        <span class="badge bg-primary rounded-pill fs-2">5 new</span>
                    </div>
                    <div class="message-body">
                        <a href="#" class="dropdown-item d-flex align-items-end gap-3 py-2 px-3">
                            <img src="https://i.pravatar.cc/40?img=1" alt="User" class="rounded-circle"
                                width="40" height="40">
                            <div>
                                <h6 class="mb-0 fw-semibold">Pendaftaran Pelatihan Baru</h6>
                                <small class="text-muted">Andi mendaftar pelatihan “Public Speaking”</small>
                            </div>
                        </a>
                    </div>
                    <div class="border-top text-center py-2 px-3">
                        <a href="#" class="btn btn-sm btn-outline-primary w-100 py-2">See All Notifications</a>
                    </div>
                </div>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">Profil Saya</p>
                            </a>
                            <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-settings fs-6"></i>
                                <p class="mb-0 fs-3">Pengaturan</p>
                            </a>
                            <form method="POST" action="{{ route('auth.internal.logout.destroy') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary mt-2 w-75 mx-auto d-block">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
