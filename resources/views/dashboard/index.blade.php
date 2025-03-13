@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dashboard</h3>
                    <p class="text-subtitle text-muted">
                        Halaman Dashboard Peserta
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('user.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Peserta
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <!-- Menambahkan gambar di dalam card dan memperluas ukuran gambar -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <!-- Gambar yang ditambahkan di dalam card -->
                                <img src="{{ asset('assets/compiled/jpg/welcome-simasdalang.jpg') }}" alt="Gambar Deskripsi" class="img-fluid rounded" style="width: 100%; height: auto; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection