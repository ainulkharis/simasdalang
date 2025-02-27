@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Pengguna</h3>
                <p class="text-subtitle text-muted">
                    Halaman Data Pengguna
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pengguna
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.profile.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>

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
                                <th class="text-center">Nama</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Tempat/Tanggal Lahir</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Nomor Telepon</th>
                                <th class="text-center">Asal Sekolah</th>
                                <th class="text-center">Jurusan</th>
                                <th class="text-center">Periode Magang</th>
                                <th class="text-center">Foto</th>
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
                                    {{ $user->place_birth ? $user->place_birth . ', ' : '' }}{{ \Carbon\Carbon::parse($user->date_birth)->format('d-m-Y') }}
                                </td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->school }}</td>
                                <td>{{ $user->major }}</td>
                                <td class="text-center">
                                    {{ $user->internship_start ? \Carbon\Carbon::parse($user->internship_start)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($user->internship_end)->format('d-m-Y') : 'Belum Ditentukan' }}
                                </td>
                                <td class="text-center">
                                    @if ($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" width="50" height="50">
                                    @else
                                    <span>No Photo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex justify-content-center align-items-center">
                                        <a href="{{ route('admin.profile.show', $user) }}" class="btn btn-info btn-sm mx-1">
                                            <i class="bi bi-eye" style="font-size: 16px;"></i>
                                            Lihat
                                        </a>

                                        <a href="{{ route('admin.profile.edit', $user) }}" class="btn btn-warning btn-sm mx-1">
                                            <i class="bi bi-pencil-square" style="font-size: 16px;"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.profile.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1">
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

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data pengguna ini?</p>
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
    document.addEventListener("DOMContentLoaded", function() {
        const dataTable = new simpleDatatables.DataTable("#table", {
            sortable: false // Matikan fitur sorting di semua kolom
        });
    });

    function confirmDelete(userId) {
        var formAction = "/admin/users/" + userId;
        document.getElementById("deleteForm").action = formAction;
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        deleteModal.show();
    }

    window.onload = function() {
        const successAlert = document.getElementById("success-alert");
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000); // Hilang setelah 3 detik
        }
    };
</script>
@endsection
