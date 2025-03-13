@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kirim Surat Balasan</h3>
                <p class="text-subtitle text-muted">Halaman Unggah Surat Balasan</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.surat-masuk.balas', $surat_masuk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="balasan_pdf" class="form-label">Kirim Surat Balasan (Format PDF)</label>
                        <input type="file" class="form-control" name="balasan_pdf" accept="application/pdf" required>
                        @error('balasan_pdf')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection