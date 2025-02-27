@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Pengguna</h3>
                <p class="text-subtitle text-muted">
                    Halaman Detail Pengguna
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pengguna
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
                <a href="{{ route('admin.profile.edit', $user->id) }}" class="btn btn-warning float-end">Edit Profile</a>
                <a href="{{ route('admin.profile.admin-user') }}" class="btn btn-secondary float-start">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Tabel Kegiatan -->
    <div class="card mt-4 shadow-sm border-0 rounded">
        <div class="card-header">
            <h4 class="card-title">Kegiatan Pengguna</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($activity->date)->format('d-m-Y') }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>
                                @if ($activity->photo)
                                    <img src="{{ asset('storage/' . $activity->photo) }}" alt="Foto Kegiatan" style="width: 100px; height: auto;">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.activities.edit', $activity->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('user.activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kegiatan ini?')">Hapus</button>
                                </form>
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
