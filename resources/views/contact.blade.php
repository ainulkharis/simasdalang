@extends('layouts.main')

@section('content')
  <!-- Contact Section -->
  <section id="contact" class="contact section" style="margin-bottom: 20px;">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Kontak</h2>
      <p>Hubungi kami jika ada hal yang perlu ditanyakan, melalui informasi di bawah ini:</p>
    </div><!-- End Section Title -->

    <div class="container position-relative d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4 d-flex justify-content-center w-100">
        <!-- Isi konten yang memenuhi seluruh layar -->
        <div class="col-12 col-md-6">
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h3>Email</h3>
              <p>dinkominfotik@brebeskab.go.id</p>
              <p>madinkominfotik@gmail.com</p>
            </div>
          </div><!-- End Info Item -->
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-telephone flex-shrink-0"></i>
            <div>
              <h3>Telepon</h3>
              <p>+62 858-6818-1989</p>
            </div>
          </div><!-- End Info Item -->
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h3>Alamat</h3>
              <p>Jl. MT Haryono Jl. Saditan Baru No.76, RW.01, Saditan, Brebes, Kec. Brebes, Kabupaten Brebes, Jawa Tengah 52212</p>
            </div>
          </div><!-- End Info Item -->
        </div>
      </div>
    </div>
  </section><!-- /Contact Section -->
@endsection
