@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Berita Kegiatan</h3>
        <form action="{{ route('admin.berita.update', $berita->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ $berita->judul }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Berita</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ $berita->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Berita</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                <!-- Tempat untuk menampilkan preview gambar -->
                <div class="mt-3">
                    <p>Preview Gambar Berita:</p>
                    <img id="preview" src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : '#' }}" alt="Preview Gambar" class="img-thumbnail" style="width: 150px; {{ $berita->gambar ? '' : 'display: none;' }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary float-end">Simpan Perubahan</button>
        </form>
    </div>

    <script>
        // Fungsi untuk menampilkan preview gambar
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                // Set gambar saat file selesai dimuat
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Tampilkan elemen preview
                };

                // Membaca file gambar
                reader.readAsDataURL(input.files[0]);
            } else {
                // Jika tidak ada file yang dipilih, tampilkan gambar lama (jika ada)
                preview.src = "{{ $berita->gambar ? asset('storage/' . $berita->gambar) : '#' }}";
                preview.style.display = "{{ $berita->gambar ? 'block' : 'none' }}";
            }
        }
    </script>
@endsection