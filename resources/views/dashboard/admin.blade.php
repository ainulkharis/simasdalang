@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dashboard</h3>
                    <p class="text-subtitle text-muted">
                        Halaman Dashboard Pembimbing
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pembimbing
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Dashboard Admin Content -->
        <section class="row">
            <div class="col-12">
                <div class="row d-flex align-items-stretch">
                    <!-- Card Jumlah User -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4>Jumlah Peserta Terdaftar</h4>
                            </div>
                            <div class="card-body">
                                <h1>{{ $jumlahUser }}</h1>
                                <p>Total peserta yang terdaftar pada sistem.</p>
                                <a href="{{ route('admin.profile.admin-user') }}" class="btn btn-primary">Lihat Semua Peserta</a>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kegiatan</h4>
                            </div>
                            <div class="card-body">
                                <p>Kelola dan pantau kegiatan yang dilakukan oleh pengguna</p>
                                <a href="{{ route('user.activities.index') }}" class="btn btn-primary">Lihat Kegiatan</a>
                            </div>
                        </div>
                    </div> -->

                    <!-- Card Jumlah Surat Masuk -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4>Jumlah Surat Masuk</h4>
                            </div>
                            <div class="card-body">
                                <h1>{{ $jumlahSuratMasuk }}</h1>
                                <p>Total surat masuk yang diterima oleh sistem.</p>
                                <a href="{{ route('admin.surat-masuk.index') }}" class="btn btn-primary">Lihat Surat Masuk</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
