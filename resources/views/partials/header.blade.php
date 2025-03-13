<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="dropdown ms-auto">
                    @auth
                        <!-- Tampilkan foto profil jika sudah login -->
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-menu d-flex">
                                <div class="user-name text-end me-3">
                                    <h6 class="mb-0 text-gray-600">
                                        {{ Auth::user()->name }}
                                    </h6>
                                    <p class="mb-0 text-sm text-gray-600">
                                        {{ Auth::user()->role == 'admin' ? 'Pembimbing' : 'Peserta' }}
                                    </p>
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md">
                                        <img src="{{ asset(Auth::user()->photo ? 'storage/' . Auth::user()->photo : 'assets/compiled/jpg/profile.jpg') }}" class="profile-picture" alt="User Photo" />
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <!-- Tampilkan tombol Login jika belum login -->
                        <a class="btn btn-primary" href="/login">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login
                        </a>
                    @endauth

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">Halo, {{ Auth::check() ? Auth::user()->name : 'Guest' }}</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        @auth
                            <!-- Menu untuk kembali ke Landing Page -->
                            <li>
                                <a class="dropdown-item" href="/">
                                    <i class="icon-mid bi bi-house-door me-2"></i> Beranda
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <!-- Menu Kelola Profil (Hanya untuk Admin) -->
                            @if (Auth::user()->role == 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.profile.edit', Auth::user()->id) }}">
                                        <i class="icon-mid bi bi-person-gear me-2"></i> Kelola Profil
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                            @endif

                            <!-- Menu Keluar -->
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" href="/login">
                                    <i class="icon-mid bi bi-box-arrow-in-right me-2"></i> Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>