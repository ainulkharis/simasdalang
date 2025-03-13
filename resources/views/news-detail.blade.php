@extends('layouts.detail-berita')

@section('berita-content')
    <section class="section">
        <div class="container">
            <!-- Judul dan Informasi Publikasi -->
            <div class="section-title">
                <h1>{{ $berita->judul }}</h1>
                <p class="text-muted mb-1">
                    Dipublikasikan pada: {{ $berita->created_at->translatedFormat('d F Y') }} | 
                    Oleh: Admin | 
                    Kategori: Berita Kegiatan
                </p>
            </div>
            <!-- Gambar Berita -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    @if ($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid rounded mt-1" alt="{{ $berita->judul }}" loading="lazy">
                    @else
                        <img src="https://via.placeholder.com/800x400" class="img-fluid rounded mt-1" alt="Placeholder Image" loading="lazy">
                    @endif
                </div>
            </div>
            <!-- Deskripsi Berita -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="mt-3">
                        <p class="lead">{{ $berita->deskripsi }}</p>
                    </div>
                </div>
            </div>
            <!-- Tombol Kembali -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 text-center">
                    <a href="{{ route('berita') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Berita
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection