<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('internal.home.dashboard.index') }}" class="text-nowrap logo-img ">
                <img src="{{asset('assets/images/logos/2.png')}}" width="180" alt="logo" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('internal.home.dashboard.index') }}" aria-expanded="false">
                        <span><i class="ti ti-layout-dashboard"></i></span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Halaman</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('internal.training.index')}}" aria-expanded="false">
                        <span><i class="ti ti-chalkboard"></i></span>
                        <span class="hide-menu">Pelatihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span><i class="ti ti-chalkboard"></i></span>
                        <span class="hide-menu">Pendampingan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('internal.training.participants.index')}}" aria-expanded="false">
                        <span><i class="ti ti-user-search"></i></span>
                        <span class="hide-menu">Peserta Pelatihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span><i class="ti ti-user-search"></i></span>
                        <span class="hide-menu">Peserta Pendampingan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('internal.learning.index') }}" aria-expanded="false">
                        <span><i class="ti ti-brand-youtube"></i></span>
                        <span class="hide-menu">Video Pembelajaran</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengguna</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span><i class="ti ti-users"></i></span>
                        <span class="hide-menu">Total Pengguna</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Evaluasi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span><i class="ti ti-graph"></i></span>
                        <span class="hide-menu">Evaluasi Pelatihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span><i class="ti ti-graph"></i></span>
                        <span class="hide-menu">Evaluasi Instruktur</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Laporan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu">Laporan Pelatihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?page=insentif_read" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu">Laporan Pendampingan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?page=insentif_read" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu text-wrap">Laporan Peserta Pelatihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?page=insentif_read" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu text-wrap">Laporan Peserta Pendampingan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?page=insentif_read" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu">Laporan Total Pengguna</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?page=insentif_read" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu text-wrap">Laporan Evaluasi Pelatihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?page=insentif_read" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu text-wrap">Laporan Evaluasi Pendampingan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?page=insentif_read" aria-expanded="false">
                        <span><i class="ti ti-file-analytics"></i></span>
                        <span class="hide-menu text-wrap">Laporan Video Pembelajaran</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
