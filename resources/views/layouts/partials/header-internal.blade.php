<!-- Header Start -->
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
                @php
                    $notifications = session('admin_notifications', []);
                    $newCount = count($notifications);
                @endphp

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="#" id="drop1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="ti ti-bell-ringing"></i>
                    @if ($newCount > 0)
                        <div class="notification bg-primary rounded-circle"></div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-animate-up p-0" aria-labelledby="drop1"
                    style="width:300px; max-width:90vw;"> {{-- setengah dari lebar sebelumnya --}}

                    <div class="border-bottom px-3 py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Notifications</h6>
                        <span class="badge bg-primary rounded-pill fs-2">{{ $newCount }} new</span>
                    </div>

                    <div class="message-body">
                        @forelse($notifications as $notif)
                            <a href="#" class="dropdown-item d-flex align-items-start gap-3 py-2 px-3">
                                <img src="https://i.pravatar.cc/40?u={{ $notif['user_name'] }}" alt="User"
                                    class="rounded-circle flex-shrink-0" width="40" height="40">

                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 fw-semibold">
                                        @if ($notif['type'] === 'training_registration')
                                            Pendaftaran Pelatihan Baru
                                        @elseif($notif['type'] === 'assistance_registration')
                                            Pendaftaran Pendampingan Baru
                                        @endif
                                    </h6>
                                    <small class="text-muted text-wrap d-block">
                                        {{ $notif['user_name'] }} mendaftar
                                        @if ($notif['type'] === 'training_registration')
                                            pelatihan “{{ $notif['training_name'] }}”
                                        @elseif($notif['type'] === 'assistance_registration')
                                            pendampingan “{{ $notif['assistance_name'] }}”
                                        @endif
                                    </small>
                                    <small class="text-muted d-block">
                                        {{ $notif['time'] }}
                                    </small>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-3">Tidak ada notifikasi</div>
                        @endforelse
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
