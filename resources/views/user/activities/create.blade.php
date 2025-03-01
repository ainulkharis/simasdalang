@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="section">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">Tambah Kegiatan</h3>
                <form action="{{ route('user.activities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Kegiatan</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                    </div>

                    <!-- Tempat untuk menampilkan preview gambar -->
                    <div class="mt-3">
                        <p>Preview Foto Kegiatan:</p>
                        <img id="preview" src="#" alt="Preview Gambar" class="img-thumbnail" style="display: none; width: 150px;">
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
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
