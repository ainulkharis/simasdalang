@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kegiatan</h3>
                <p class="text-subtitle text-muted">
                    Halaman Semua Data Kegiatan
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Kegiatan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <a href="{{ route('user.activities.create') }}" class="btn btn-primary mb-3">Tambah Kegiatan Baru</a>

    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">
                <!-- Tabel -->
                <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                    <table class="table table-bordered" id="table-activities">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Tanggal Kegiatan</th>
                                <th class="text-center">Deskripsi Kegiatan</th>
                                <th class="text-center">Foto Kegiatan</th>
                                <th class="text-center">Nilai</th>
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
                                        @if($activity->sudah_dinilai)
                                            {{ $activity->nilai }}/100
                                        @else
                                            Belum dinilai
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @unless($activity->sudah_dinilai)
                                            <div class="d-inline-flex justify-content-center align-items-center">
                                                <a href="{{ route('user.activities.edit', $activity->id) }}" class="btn btn-warning btn-sm d-flex align-items-center mx-1" style="line-height: 1;">
                                                    <i class="bi bi-pencil-square" style="font-size: 16px; vertical-align: middle;"></i>
                                                    <span class="ms-1" style="vertical-align: middle;">Edit</span>
                                                </a>

                                                <form action="{{ route('user.activities.destroy', $activity->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center mx-1" onclick="return confirmDelete(event, '{{ route('user.activities.destroy', $activity->id) }}')" style="line-height: 1;">
                                                        <i class="bi bi-trash" style="font-size: 16px; vertical-align: middle;"></i>
                                                        <span class="ms-1" style="vertical-align: middle;">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-success" data-bs-toggle="tooltip" title="Kegiatan sudah dinilai">
                                                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                                            </span>
                                        @endunless
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

<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi untuk menampilkan gambar di modal
    function showImage(src) {
        document.getElementById("previewImage").src = src;
    }

    // Fungsi untuk konfirmasi penghapusan dengan SweetAlert2
    function confirmDelete(event, url) {
        event.preventDefault(); // Mencegah form dikirim secara otomatis
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, kirim form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                // Tambahkan CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Tambahkan method spoofing untuk DELETE
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Script untuk Simple DataTables
    document.addEventListener("DOMContentLoaded", function() {
        const dataTable = new simpleDatatables.DataTable("#table-activities", {
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

    // Fungsi untuk menghapus notifikasi setelah 3 detik
    window.onload = function() {
        const successAlert = document.getElementById("success-alert");
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000); // Hilang setelah 3 detik
        }
    };

    // Tooltip untuk ikon ceklis
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<style>
    /* Pindahkan kolom pencarian ke kanan */
    .datatable-search {
        float: right; /* Pindahkan ke kanan */
        margin-bottom: 10px; /* Beri jarak dari tabel */
    }

    /* Optional: Atur lebar input pencarian */
    .datatable-search input {
        width: 200px; /* Sesuaikan lebar input */
    }

    /* CSS untuk ceklis penilaian */
    .bi-check-circle-fill {
        color: #28a745; /* Warna hijau Bootstrap */
        transition: transform 0.2s;
    }
    .bi-check-circle-fill:hover {
        transform: scale(1.2);
    }
</style>
@endsection