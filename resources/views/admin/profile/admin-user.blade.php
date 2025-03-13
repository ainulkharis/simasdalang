@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Profil Peserta</h3>
                <p class="text-subtitle text-muted">
                    Halaman Semua Data Peserta
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Peserta
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

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
                    <table class="table table-bordered" id="table-peserta">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama Lengkap</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Tempat/Tanggal Lahir</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Nomor Telepon</th>
                                <th class="text-center">Sekolah/Kuliah</th>
                                <th class="text-center">Jurusan/Prodi</th>
                                <th class="text-center">Mulai Magang</th>
                                <th class="text-center">Selesai Magang</th>
                                <th class="text-center">Foto Profil</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center" style="white-space: nowrap;">
                                    {{ $user->place_birth ? $user->place_birth . ', ' : '' }}
                                    {{ $user->date_birth ? \Carbon\Carbon::parse($user->date_birth)->format('d-m-Y') : 'Belum di isi'}}
                                </td>
                                <td>{{ $user->address ? : 'Belum di isi' }}</td>
                                <td>{{ $user->phone_number ? : 'Belum di isi' }}</td>
                                <td>{{ $user->school ? : 'Belum di isi' }}</td>
                                <td>{{ $user->major ? : 'Belum di isi' }}</td>
                                <td class="text-center">
                                    {{ $user->internship_start ? \Carbon\Carbon::parse($user->internship_start)->format('d-m-Y') : 'Belum di isi' }}
                                </td>
                                <td class="text-center">
                                    {{ $user->internship_end ? \Carbon\Carbon::parse($user->internship_end)->format('d-m-Y') : 'Belum di isi' }}
                                </td>
                                <td class="text-center">
                                    @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" width="50" height="50">
                                    @else
                                    <span>Belum ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex justify-content-center align-items-center">
                                        <a href="{{ route('admin.profile.show', $user) }}" class="btn btn-info btn-sm mx-1">
                                            <i class="bi bi-eye" style="font-size: 16px;"></i>
                                            Lihat
                                        </a>

                                        {{-- <a href="{{ route('admin.profile.edit', $user) }}" class="btn btn-warning btn-sm mx-1">
                                            <i class="bi bi-pencil-square" style="font-size: 16px;"></i>
                                            Edit
                                        </a> --}}

                                        <form action="{{ route('admin.profile.destroy', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirmDelete(event, '{{ route('admin.profile.destroy', $user) }}')">
                                                <i class="bi bi-trash" style="font-size: 16px;"></i>
                                                Hapus
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
</script>
<script>
    // Script untuk Simple DataTables
    document.addEventListener("DOMContentLoaded", function() {
        const dataTable = new simpleDatatables.DataTable("#table-peserta", {
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