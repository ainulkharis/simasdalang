@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Tambah Surat Masuk</h3>

    <form action="{{ route('user.surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="no_surat" class="form-label">Nomor Surat</label>
            <input type="text" class="form-control" id="no_surat" name="no_surat" required>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Mengirim Surat</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <div class="mb-3">
            <label for="asal_pengirim" class="form-label">Asal Pengirim Surat</label>
            <input type="text" class="form-control" id="asal_pengirim" name="asal_pengirim" required>
        </div>
        <div class="mb-3">
            <label for="file_pdf" class="form-label">Unggah Surat Masuk (Format PDF)</label>
            <input type="file" class="form-control" id="file_pdf" name="file_pdf" accept="application/pdf">
        </div>
        <button type="submit" class="btn btn-primary float-end">Simpan</button>
        {{-- <a href="{{ route('user.surat-masuk.index') }}" class="btn btn-secondary">Kembali</a> --}}
    </form>
</div>
@endsection
