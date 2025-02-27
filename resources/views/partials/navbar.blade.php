<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container container-xl position-relative d-flex align-items-center">
      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Simasdalang</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a class="nav-link {{ ($title === "Home") ? 'active' : '' }}" href="/">Home<br></a></li>
          {{-- <li><a class="nav-link {{ ($title === "Kegiatan") ? 'active' : '' }}" href="/kegiatan">Kegiatan</a></li> --}}
          <li><a class="nav-link {{ ($title === "Tentang") ? 'active' : '' }}" href="/tentang">Tentang</a></li>
          <li><a class="nav-link {{ ($title === "Kontak") ? 'active' : '' }}" href="/kontak">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn-getstarted" href="/login">Login</a>
    </div>
</header>