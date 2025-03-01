@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Kegiatan</h3>
                <p class="text-subtitle text-muted">
                    Halaman Data Kegiatan
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Kegiatan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <a href="{{ route('user.activities.create') }}" class="btn btn-primary mb-3">Tambah Kegiatan</a>

    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                    <table class="table table-bordered" id="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Tanggal Kegiatan</th>
                                <th class="text-center">Deskripsi Kegiatan</th>
                                <th class="text-center">Foto Kegiatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center" style="white-space: nowrap;">{{ $activity->date->format('d-m-Y') }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td class="text-center">
                                        @if ($activity->photo)
                                            <img src="{{ asset('storage/' . $activity->photo) }}" alt="Foto" width="100" style="max-width: 100px; max-height: 100px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ asset('storage/' . $activity->photo) }}')">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex justify-content-center align-items-center">
                                            <a href="{{ route('user.activities.edit', $activity->id) }}" class="btn btn-warning btn-sm d-flex align-items-center mx-1" style="line-height: 1;">
                                                <i class="bi bi-pencil-square" style="font-size: 16px; vertical-align: middle;"></i>
                                                <span class="ms-1" style="vertical-align: middle;">Edit</span>
                                            </a>

                                            <button type="button" class="btn btn-danger btn-sm d-flex align-items-center mx-1" onclick="confirmDelete({{ $activity->id }})" style="line-height: 1;">
                                                <i class="bi bi-trash" style="font-size: 16px; vertical-align: middle;"></i>
                                                <span class="ms-1" style="vertical-align: middle;">Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal untuk preview gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview Foto" style="width: 100%; max-height: 500px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script>
    // Inisialisasi tabel dengan fitur sorting dinonaktifkan
    document.addEventListener("DOMContentLoaded", function() {
        const dataTable = new simpleDatatables.DataTable("#table", {
            sortable: false  // Matikan fitur sorting di semua kolom
        });
    });

    // Fungsi untuk menampilkan gambar di modal
    function showImage(src) {
        document.getElementById("previewImage").src = src;
    }

    // Fungsi untuk menghapus notifikasi setelah 3 detik
    window.onload = function() {
        const successAlert = document.getElementById("success-alert");
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000); // Hilang setelah 3 detik
        }
    };

    // Fungsi untuk menampilkan modal konfirmasi penghapusan
    function confirmDelete(activityId) {
        var formAction = "/activities/" + activityId;
        document.getElementById("deleteForm").action = formAction;
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        deleteModal.show();
    }
</script>
@endsection