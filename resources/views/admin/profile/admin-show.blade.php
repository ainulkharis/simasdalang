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
                    <!-- Tampilkan foto profil, jika tidak ada gunakan foto default -->
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/compiled/jpg/profile.jpg') }}" 
                         alt="Foto Profil" 
                         class="profile-picture">
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
        </div>
    </div>

    <!-- Tabel Kegiatan -->
    <div class="card mt-4 shadow-sm border-0 rounded">
        <div class="card-header">
            <h4 class="card-title">Kegiatan Peserta</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                <table class="table table-bordered" id="table-kegiatan">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Kegiatan</th>
                            <th class="text-center">Deskripsi Kegiatan</th>
                            <th class="text-center">Foto Kegiatan</th>
                            <th class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">{{ \Carbon\Carbon::parse($activity->date)->format('d-m-Y') }}</td>
                                <td class="align-middle">{{ $activity->description }}</td>
                                <td class="text-center align-middle">
                                    @if ($activity->photo)
                                        <img src="{{ asset('storage/' . $activity->photo) }}" 
                                             alt="Foto Kegiatan" 
                                             style="width: 100px; height: auto; cursor: pointer; display: block; margin: 0 auto;" 
                                             onclick="showPreview('{{ asset('storage/' . $activity->photo) }}')">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    @if (!$activity->sudah_dinilai)
                                        <form action="{{ route('admin.activities.grade', $activity->id) }}" method="POST" class="d-flex justify-content-center">
                                            @csrf
                                            <input type="number" name="nilai" class="form-control form-control-sm me-2" style="width: 70px;" min="0" max="100" required>
                                            <button type="submit" class="btn btn-sm btn-primary">Nilai</button>
                                        </form>
                                    @else
                                        {{ $activity->nilai }} / 100
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada kegiatan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk preview foto kegiatan -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Preview Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview Foto" style="max-width: 100%; max-height: 500px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan preview foto
    function showPreview(imageUrl) {
        // Set sumber gambar di modal
        document.getElementById('previewImage').src = imageUrl;

        // Buka modal
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }

    // Script untuk Simple DataTables
    document.addEventListener("DOMContentLoaded", function() {
        const dataTable = new simpleDatatables.DataTable("#table-kegiatan", {
            searchable: true, // Aktifkan fitur pencarian
            perPage: 10, // Jumlah baris per halaman
            perPageSelect: [5, 10, 15, 20], // Opsi jumlah baris per halaman
            labels: {
                placeholder: "Cari data...", // Placeholder untuk input pencarian
                searchTitle: "Cari di tabel", // Judul untuk fitur pencarian
                perPage: "Baris per halaman", // Label untuk dropdown perPage
                noRows: "Belum ada data.", // Pesan jika tidak ada data
                info: "Menampilkan {start} - {end} dari {rows} data keseluruhan.", // Pesan info
                noResults: "Tidak ada hasil yang ditemukan.", // Pesan jika tidak ada hasil pencarian
            },
        });
    });
</script>

<style>
    /* Override CSS Simple DataTables */
    #table-kegiatan tbody td, 
    #table-kegiatan tbody th, 
    #table-kegiatan tfoot td, 
    #table-kegiatan tfoot th, 
    #table-kegiatan thead td, 
    #table-kegiatan thead th {
        vertical-align: middle !important; /* Memaksa alignment vertikal ke tengah */
        text-align: center !important; /* Memaksa alignment horizontal ke tengah */
    }

    /* Khusus untuk kolom Deskripsi Kegiatan, alignment kiri */
    #table-kegiatan tbody td:nth-child(3) {
        text-align: left !important;
    }

    /* CSS tambahan untuk gambar */
    #table-kegiatan tbody td img {
        display: block;
        margin: 0 auto; /* Memposisikan gambar di tengah */
    }

    /* CSS untuk profile picture */
    .profile-picture-frame {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
        border: 5px solid #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-picture {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Pindahkan kolom pencarian ke kanan */
    .datatable-search {
        float: right; /* Pindahkan ke kanan */
        margin-bottom: 10px; /* Beri jarak dari tabel */
    }

    /* Optional: Atur lebar input pencarian */
    .datatable-search input {
        width: 200px; /* Sesuaikan lebar input */
    }
</style>
@endsection