@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Surat Masuk</h3>
                <p class="text-subtitle text-muted">Halaman untuk menampilkan semua surat masuk</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Surat Masuk
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
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
                                    <td class="text-center">{{ \Carbon\Carbon::parse($surat->tanggal)->format('d-m-Y') }}</td>
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
                                        <a href="{{ route('admin.surat-masuk.edit', $surat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.surat-masuk.destroy', $surat->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                        </form>
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

<script>
    // Script untuk menghilangkan notifikasi setelah 3 detik
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
@endsection