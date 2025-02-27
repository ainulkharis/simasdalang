@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Surat Masuk</h3>
                <p class="text-subtitle text-muted">
                    Halaman Data Surat Masuk
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Surat Masuk
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <a href="{{ route('user.surat-masuk.create') }}" class="btn btn-primary mb-3">Tambah Surat Masuk</a>

    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('balasan'))
        <div id="balasan-alert" class="alert alert-info">
            {{ session('balasan') }}
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                    <table class="table table-bordered" id="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No. Surat</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Asal Pengirim Surat</th>
                                <th class="text-center">File PDF</th>
                                <th class="text-center">Surat Balasan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suratMasuk as $surat)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $surat->no_surat }}</td>
                                    <td class="text-center" style="white-space: nowrap;">{{ \Carbon\Carbon::parse($surat->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $surat->asal_pengirim }}</td>
                                    <td class="text-center">
                                        @if($surat->file_pdf)
                                            <a href="{{ Storage::url($surat->file_pdf) }}" target="_blank">Lihat PDF</a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($surat->balasan_pdf)
                                            <a href="{{ Storage::url($surat->balasan_pdf) }}" target="_blank">Lihat Balasan</a>
                                        @else
                                            Belum ada balasan
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('user.surat-masuk.edit', $surat->id) }}" class="btn btn-warning btn-sm d-flex align-items-center" style="line-height: 1;">
                                                <i class="bi bi-pencil-square" style="font-size: 16px; vertical-align: middle;"></i>
                                                <span class="ms-1" style="vertical-align: middle;">Edit</span>
                                            </a>
                                            <form action="{{ route('user.surat-masuk.destroy', $surat->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm d-flex align-items-center" onclick="confirmDelete({{ $surat->id }})" style="line-height: 1;">
                                                    <i class="bi bi-trash" style="font-size: 16px; vertical-align: middle;"></i>
                                                    <span class="ms-1" style="vertical-align: middle;">Hapus</span>
                                                </button>
                                            </form>
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

    // Fungsi untuk menghapus notifikasi setelah 3 detik
    window.onload = function() {
        const successAlert = document.getElementById("success-alert");
        const balasanAlert = document.getElementById("balasan-alert");

        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000); // Hilang setelah 3 detik
        }

        if (balasanAlert) {
            setTimeout(function() {
                balasanAlert.style.display = 'none';
            }, 3000); // Hilang setelah 3 detik
        }
    };

    // Fungsi untuk menampilkan modal konfirmasi penghapusan
    function confirmDelete(suratId) {
        var formAction = "/surat-masuk/" + suratId;
        document.getElementById("deleteForm").action = formAction;
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        deleteModal.show();
    }
</script>
@endsection
