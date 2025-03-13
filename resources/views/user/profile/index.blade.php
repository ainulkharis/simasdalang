@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Profil</h3>
                <p class="text-subtitle text-muted">
                    Halaman Lengkap Data Profil
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Profil
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0 rounded">
        <div class="card-body position-relative">
            <div class="text-center mb-4" style="margin-top: -50px;">
                <div class="profile-picture-frame">
                    <img src="{{ asset($userPhotoPath) }}" alt="Foto Profil" class="profile-picture">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Lengkap:</strong> <span class="text-muted">{{ $user->name ?? '-' }}</span></p>
                    <p><strong>Email:</strong> <span class="text-muted">{{ $user->email ?? '-' }}</span></p>
                    <p><strong>Tempat Lahir:</strong> <span class="text-muted">{{ $user->place_birth ?? '-' }}</span></p>
                    <p><strong>Tanggal Lahir:</strong> <span class="text-muted">{{ $user->date_birth ? \Carbon\Carbon::parse($user->date_birth)->format('d-m-Y') : '-' }}</span></p>
                    <p><strong>Alamat:</strong> <span class="text-muted">{{ $user->address ?? '-' }}</span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nomor Telepon:</strong> <span class="text-muted">{{ $user->phone_number ?? '-' }}</span></p>
                    <p><strong>Sekolah/Kuliah:</strong> <span class="text-muted">{{ $user->school ?? '-' }}</span></p>
                    <p><strong>Jurusan/Prodi:</strong> <span class="text-muted">{{ $user->major ?? '-' }}</span></p>
                    <p><strong>Mulai Magang:</strong> <span class="text-muted">{{ $user->internship_start ? \Carbon\Carbon::parse($user->internship_start)->format('d-m-Y') : '-' }}</span></p>
                    <p><strong>Selesai Magang:</strong> <span class="text-muted">{{ $user->internship_end ? \Carbon\Carbon::parse($user->internship_end)->format('d-m-Y') : '-' }}</span></p>
                </div>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('user.profile.edit') }}" class="btn btn-primary float-end">Perbarui Data Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection