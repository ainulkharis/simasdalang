@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Tambah Berita Baru</h3>
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Berita</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Berita</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
            </div>
            <!-- Tempat untuk menampilkan preview gambar -->
            <div class="mb-3">
                <p>Preview Gambar Berita:</p>
                <img id="preview" src="#" alt="Preview Gambar" class="img-thumbnail" style="display: none; width: 150px;">
            </div>
            <button type="submit" class="btn btn-primary float-end">Simpan</button>
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
                preview.src = '#';
                preview.style.display = 'none'; // Sembunyikan elemen preview jika tidak ada file
            }
        }
    </script>
@endsection