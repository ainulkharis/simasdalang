@extends('layouts.main')

@section('content')
  <!-- Hero Section -->
  <section id="hero" class="hero section">

    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>Sistem Informasi Manajemen Data PKL dan Magang</h1>
          <p>Mudahnya kelola data peserta PKL dan Magang bersama Simasdalang</p>
          <div class="d-flex">
            <a href="/register" class="btn-get-started">Register</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img">
          <img src="assets\img\welcome-simasdalang-transparan.png" class="img-fluid animated" alt="Hero Image">
        </div>
      </div>
    </div>

  </section><!-- /Hero Section -->  
@endsection