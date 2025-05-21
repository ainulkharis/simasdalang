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
                <h3 class="mb-3">Edit Data Kegiatan</h3>
                <form action="{{ route('user.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Tanggal Kegiatan -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal Kegiatan</label>
                        <div class="form-control bg-light">{{ $activity->date->format('d-m-Y') }}</div>
                        <input type="hidden" name="date" value="{{ $activity->date->format('d-m-Y') }}">
                    </div>

                    <!-- Deskripsi Kegiatan -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $activity->description }}</textarea>
                    </div>

                    <!-- Unggah Foto Kegiatan -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">
                            Foto Kegiatan
                            <span class="max-image">(Format JPG, JPEG, PNG Maks. 1 MB)</span>
                        </label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                        
                        <!-- Preview Foto Kegiatan -->
                        <div class="mt-3">
                            <p>Preview Foto Kegiatan:</p>
                            <img id="preview" src="{{ $activity->photo ? asset('storage/' . $activity->photo) : '#' }}" alt="Preview Foto Kegiatan" class="img-thumbnail" style="width: 150px; {{ $activity->photo ? '' : 'display: none;' }}">
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary float-end">Simpan Perubahan</button>
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
            // Jika tidak ada file yang dipilih, tampilkan foto lama (jika ada)
            preview.src = "{{ $activity->photo ? asset('storage/' . $activity->photo) : '#' }}";
            preview.style.display = "{{ $activity->photo ? 'block' : 'none' }}";
        }
    }

    // Nonaktifkan input date jika ada (sebagai pengaman tambahan)
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        if (dateInput) {
            dateInput.disabled = true;
        }
    });
</script>
@endsection