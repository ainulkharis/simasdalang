@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Surat Masuk</h1>
    
    <form action="{{ route('user.surat-masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- No Surat -->
        <div class="mb-3">
            <label for="no_surat" class="form-label">No. Surat</label>
            <input type="text" class="form-control" id="no_surat" name="no_surat" value="{{ old('no_surat', $suratMasuk->no_surat) }}" required>
        </div>

        <!-- Tanggal -->
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $suratMasuk->tanggal) }}" required>
        </div>

        <!-- Asal Pengirim -->
        <div class="mb-3">
            <label for="asal_pengirim" class="form-label">Asal Pengirim</label>
            <input type="text" class="form-control" id="asal_pengirim" name="asal_pengirim" value="{{ old('asal_pengirim', $suratMasuk->asal_pengirim) }}" required>
        </div>

        <!-- File PDF (Optional) -->
        <div class="mb-3">
            <label for="file_pdf" class="form-label">Upload File PDF (Opsional)</label>
            <input type="file" class="form-control" id="file_pdf" name="file_pdf" accept="application/pdf">
            @if ($suratMasuk->file_pdf)
                <p class="mt-2">File saat ini: <a href="{{ Storage::url('public/' . $suratMasuk->file_pdf) }}" target="_blank">Lihat PDF</a></p>
            @endif
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Update Surat Masuk</button>
        <a href="{{ route('user.surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
