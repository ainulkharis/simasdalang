@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Statistik Pengunjung</h3>
                    <p class="text-subtitle text-muted">
                        Halaman Statistik Pengunjung
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Statistik Pengunjung
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Statistik Pengunjung Content -->
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Statistik Pengunjung</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Tanggal Kunjungan</th>
                                        <th class="text-center">Jumlah Pengunjung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitors as $visitor)
                                        <tr>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($visitor->visit_date)->format('Y-m-d') }}</td>
                                            <td class="text-center">{{ $visitor->visit_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $visitors->links() }} <!-- Menampilkan pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection