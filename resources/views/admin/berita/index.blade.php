@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Berita Kegiatan</h3>
                <p class="text-subtitle text-muted">Halaman Semua Berita Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Berita
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary mb-3">Tambah Berita Baru</a>

    <!-- Notifikasi -->
    @if(session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                    <table class="table table-bordered" id="table-berita">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Judul Berita</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Gambar</th>
                                <th class="text-center">Tanggal Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($berita as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                                    <td class="text-center">
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                                 alt="Gambar Berita" 
                                                 width="100" 
                                                 style="max-width: 100px; max-height: 100px; object-fit: cover; cursor: pointer;" 
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#imageModal" 
                                                 onclick="showImage('{{ asset('storage/' . $item->gambar) }}')">
                                        @else
                                            <span>Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.berita.edit', $item->slug) }}" 
                                               class="btn btn-warning btn-sm d-flex align-items-center" 
                                               style="line-height: 1; padding: 6px 10px;">
                                                <i class="bi bi-pencil-square fs-6"></i>
                                                <span class="ms-1">Edit</span>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.berita.destroy', $item->slug) }}" 
                                                  method="POST" 
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm d-flex align-items-center" onclick="confirmDelete('{{ route('admin.berita.destroy', $item->slug) }}')" style="line-height: 1; padding: 6px 10px;">
                                                    <i class="bi bi-trash fs-6"></i>
                                                    <span class="ms-1">Hapus</span>
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

<!-- Modal untuk preview gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Gambar Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview Gambar" style="width: 100%; max-height: 500px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan gambar di modal
    function showImage(src) {
        document.getElementById("previewImage").src = src;
    }

    // Script untuk menghilangkan notifikasi setelah 3 detik
    window.onload = function() {
        const successAlert = document.getElementById("success-alert");

        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000);
        }
    };

    // Script untuk Simple DataTables
    document.addEventListener("DOMContentLoaded", function() {
        const dataTable = new simpleDatatables.DataTable("#table-berita", {
            searchable: true, // Aktifkan fitur pencarian
            perPage: 10, // Jumlah baris per halaman
            perPageSelect: [5, 10, 15, 20], // Opsi jumlah baris per halaman
            labels: {
                placeholder: "Cari data...", // Placeholder untuk input pencarian
                searchTitle: "Cari di tabel", // Judul untuk fitur pencarian
                perPage: "Baris per halaman", // Label untuk dropdown perPage
                noRows: "Tidak ada data yang ditemukan", // Pesan jika tidak ada data
                info: "Data {start} - {end} dari total {rows} data keseluruhan.", // Pesan info
                noResults: "Tidak ada hasil yang cocok", // Pesan jika tidak ada hasil pencarian
            },
        });
    });

    // Fungsi untuk konfirmasi penghapusan
    function confirmDelete(url) {
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
                // Buat form dinamis untuk mengirim request DELETE
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
</style>
@endsection