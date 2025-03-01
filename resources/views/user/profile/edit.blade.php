@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">Edit Profil</h3>
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" disabled>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="mb-3">
                        <label for="place_birth" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="place_birth" name="place_birth" value="{{ old('place_birth', $user->place_birth) }}">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="date_birth" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="date_birth" name="date_birth" value="{{ $user->date_birth ? \Carbon\Carbon::parse($user->date_birth)->format('Y-m-d') : '' }}">
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                    </div>

                    <!-- Sekolah -->
                    <div class="mb-3">
                        <label for="school" class="form-label">Sekolah/Kuliah</label>
                        <input type="text" class="form-control" id="school" name="school" value="{{ old('school', $user->school) }}">
                    </div>

                    <!-- Jurusan -->
                    <div class="mb-3">
                        <label for="major" class="form-label">Jurusan/Prodi</label>
                        <input type="text" class="form-control" id="major" name="major" value="{{ old('major', $user->major) }}">
                    </div>

                    <!-- Tanggal Mulai Magang -->
                    <div class="mb-3">
                        <label for="internship_start" class="form-label">Mulai Magang</label>
                        <input type="date" class="form-control" id="internship_start" name="internship_start" value="{{ $user->internship_start ? \Carbon\Carbon::parse($user->internship_start)->format('Y-m-d') : '' }}">
                    </div>

                    <!-- Tanggal Selesai Magang -->
                    <div class="mb-3">
                        <label for="internship_end" class="form-label">Selesai Magang</label>
                        <input type="date" class="form-control" id="internship_end" name="internship_end" value="{{ $user->internship_end ? \Carbon\Carbon::parse($user->internship_end)->format('Y-m-d') : '' }}">
                    </div>

                    <!-- Unggah Foto -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Unggah Foto Profil</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                        @if ($errors->has('photo'))
                            <div class="alert alert-danger">
                                {{ $errors->first('photo') }}
                            </div>
                        @endif

                        @if ($user->photo)
                            <div class="mt-2">
                                <p>Foto Profil Saat Ini:</p>
                                <img src="{{ asset('storage/' . $user->photo) }}?{{ time() }}" alt="Foto Profil" class="img-thumbnail" width="150">
                            </div>
                        @endif

                        <!-- Tempat untuk menampilkan preview gambar -->
                        <div class="mt-3">
                            <p>Preview Foto Profil Baru:</p>
                            <img id="preview" src="#" alt="Preview Gambar" class="img-thumbnail" style="display: none; width: 150px;">
                        </div>
                    </div>

                    <!-- Tombol Submit -->
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
