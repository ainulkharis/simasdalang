<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container container-xl position-relative d-flex align-items-center">
        <!-- Tampilkan foto profil atau tombol login di sebelah kiri logo hanya di mobile -->
        @auth
            <div class="dropdown d-xl-none me-3"> <!-- Hanya tampil di mobile -->
                <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-sm">
                                <img src="{{ asset(Auth::user()->photo ? 'storage/' . Auth::user()->photo : 'assets/compiled/jpg/profile.jpg') }}" 
                                     class="rounded-circle profile-picture border border-2 border-white" 
                                     alt="User Photo" />
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                    <li>
                        <h6 class="dropdown-header">{{ Auth::user()->name }} ({{ Auth::user()->role == 'admin' ? 'Pembimbing' : 'Peserta' }})</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                            <i class="icon-mid bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a class="btn-getstarted d-xl-none me-3" href="/login">Login</a> <!-- Hanya tampil di mobile -->
        @endauth

        <!-- Logo -->
        <a href="/" class="logo d-flex align-items-center me-auto">
            <h1 class="sitename">SIMASDALANG</h1>
        </a>

        <!-- Navbar Menu -->
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a class="nav-link {{ ($title === "Home") ? 'active' : '' }}" href="/">Beranda<br></a></li>
                <li><a class="nav-link {{ ($title === "Berita") ? 'active' : '' }}" href="/berita">Berita</a></li>
                <li><a class="nav-link {{ ($title === "Tentang") ? 'active' : '' }}" href="/tentang">Tentang</a></li>
                <li><a class="nav-link {{ ($title === "Kontak") ? 'active' : '' }}" href="/kontak">Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- Tampilkan foto profil atau tombol login di sebelah kanan navbar di desktop -->
        @auth
            <div class="dropdown ms-3 d-none d-xl-block"> <!-- Hanya tampil di desktop -->
                <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        {{-- <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600">
                                {{ Auth::user()->name }}
                            </h6>
                            <p class="mb-0 text-sm text-gray-600">
                                {{ Auth::user()->role == 'admin' ? 'Pembimbing' : 'Peserta' }}
                            </p>
                        </div> --}}
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="{{ asset(Auth::user()->photo ? 'storage/' . Auth::user()->photo : 'assets/compiled/jpg/profile.jpg') }}" 
                                     class="rounded-circle profile-picture border border-3 border-white" 
                                     alt="User Photo" />
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                    <li>
                        <h6 class="dropdown-header">{{ Auth::user()->name }} ({{ Auth::user()->role == 'admin' ? 'Pembimbing' : 'Peserta' }})</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                            <i class="icon-mid bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a class="btn-getstarted ms-3 d-none d-xl-block" href="/login">Login</a> <!-- Hanya tampil di desktop -->
        @endauth
    </div>
</header>