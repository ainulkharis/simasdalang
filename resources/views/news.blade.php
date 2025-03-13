@extends('layouts.main')

@section('content')
    <section class="section">
        <div class="container">
            <div class="container section-title" data-aos="fade-up">
                <h2>Berita Kegiatan</h2>
                <p>Informasi Seputar Kegiatan PKL dan Magang di Dinas Komunikasi, Informatika dan Statistik Kabupaten Brebes</p>
            </div>
            <div class="row">
                @foreach ($berita as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}" loading="lazy" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Placeholder Image" loading="lazy" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $item->judul }}</h5>
                                <p class="card-text flex-grow-1">{{ Str::limit($item->deskripsi, 100) }}</p>
                                <div class="mt-auto">
                                    <a href="{{ route('berita.detail', $item->slug) }}" class="btn btn-primary w-100">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Manual -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Tombol Previous --}}
                        @if ($berita->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo; Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $berita->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                            </li>
                        @endif

                        {{-- Tombol Next --}}
                        @if ($berita->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $berita->nextPageUrl() }}" rel="next">Next &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>

            <!-- Informasi "Showing X to Y of Z results" -->
            <div class="text-center mt-3">
                <p class="text-muted">
                    Showing {{ $berita->firstItem() }} to {{ $berita->lastItem() }} of {{ $berita->total() }} results
                </p>
            </div>
        </div>
    </section>
@endsection