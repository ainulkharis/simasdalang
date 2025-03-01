@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Peserta</h3>
                <p class="text-subtitle text-muted">
                    Halaman Detail Peserta
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Peserta
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
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="profile-picture">
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
                <a href="{{ route('admin.profile.edit', $user->id) }}" class="btn btn-primary float-end">Edit Data Peserta</a>
            </div>
        </div>
    </div>

    <!-- Tabel Kegiatan -->
    <div class="card mt-4 shadow-sm border-0 rounded">
        <div class="card-header">
            <h4 class="card-title">Kegiatan Peserta</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal Kegiatan</th>
                        <th class="text-center">Deskripsi Kegiatan</th>
                        <th class="text-center">Foto Kegiatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($activity->date)->format('d-m-Y') }}</td>
                            <td>{{ $activity->description }}</td>
                            <td class="text-center">
                                @if ($activity->photo)
                                    <img src="{{ asset('storage/' . $activity->photo) }}" alt="Foto Kegiatan" style="width: 100px; height: auto;">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.activities.edit', $activity->id) }}" 
                                    class="btn btn-sm btn-primary d-flex align-items-center" 
                                    style="line-height: 1; padding: 6px 10px;">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                        <span class="ms-1">Edit</span>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('user.activities.destroy', $activity->id) }}" 
                                        method="POST" 
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger d-flex align-items-center" 
                                                onclick="return confirm('Hapus kegiatan ini?')" 
                                                style="line-height: 1; padding: 6px 10px;">
                                            <i class="bi bi-trash fs-6"></i>
                                            <span class="ms-1">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada kegiatan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
