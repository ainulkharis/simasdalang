@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Surat Masuk</h3>
                <p class="text-subtitle text-muted">
                    Halaman Semua Data Surat Masuk
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
                    <table class="table table-bordered" id="table-surat-masuk">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nomor Surat</th>
                                <th class="text-center">Tanggal Mengirim Surat</th>
                                <th class="text-center">Asal Pengirim Surat</th>
                                <th class="text-center">Surat Masuk</th>
                                <th class="text-center">Surat Balasan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suratMasuk as $surat)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $surat->no_surat }}</td>
                                    <td class="text-center" style="white-space: nowrap;">
                                        {{ \Carbon\Carbon::parse($surat->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $surat->asal_pengirim }}</td>
                                    <td class="text-center">
                                        @if($surat->file_pdf)
                                            <a href="{{ Storage::url($surat->file_pdf) }}" target="_blank">Lihat Surat Masuk</a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($surat->balasan_pdf)
                                            <a href="{{ Storage::url($surat->balasan_pdf) }}" target="_blank">Lihat Surat Balasan</a>
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
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center" onclick="return confirmDelete(event, '{{ route('user.surat-masuk.destroy', $surat->id) }}')" style="line-height: 1;">
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

<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
        const dataTable = new simpleDatatables.DataTable("#table-surat-masuk", {
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