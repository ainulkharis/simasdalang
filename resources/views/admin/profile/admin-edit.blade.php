@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Data Profil</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Nama Lengkap</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required readonly>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="place_birth" class="col-md-4 col-form-label text-md-end">Tempat Lahir</label>

                    <div class="col-md-6">
                        <input id="place_birth" type="text" class="form-control @error('place_birth') is-invalid @enderror" name="place_birth" value="{{ old('place_birth', $user->place_birth) }}">

                        @error('place_birth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="row mb-3">
                    <label for="date_birth" class="col-md-4 col-form-label text-md-end">Tanggal Lahir</label>
                    <div class="col-md-6">
                        <input id="date_birth" type="date" class="form-control @error('date_birth') is-invalid @enderror" name="date_birth" value="{{ old('date_birth', $user->date_birth ? $user->date_birth->format('Y-m-d') : '') }}">
                        @error('date_birth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address" class="col-md-4 col-form-label text-md-end">Alamat</label>

                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $user->address) }}">

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone_number" class="col-md-4 col-form-label text-md-end">Nomor Telepon</label>

                    <div class="col-md-6">
                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="school" class="col-md-4 col-form-label text-md-end">Sekolah/Kuliah</label>

                    <div class="col-md-6">
                        <input id="school" type="text" class="form-control @error('school') is-invalid @enderror" name="school" value="{{ old('school', $user->school) }}">

                        @error('school')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="major" class="col-md-4 col-form-label text-md-end">Jurusan/Prodi</label>

                    <div class="col-md-6">
                        <input id="major" type="text" class="form-control @error('major') is-invalid @enderror" name="major" value="{{ old('major', $user->major) }}">

                        @error('major')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Mulai Magang -->
                <div class="row mb-3">
                    <label for="internship_start" class="col-md-4 col-form-label text-md-end">Mulai Magang</label>
                    <div class="col-md-6">
                        <input id="internship_start" type="date" class="form-control @error('internship_start') is-invalid @enderror" name="internship_start" value="{{ old('internship_start', $user->internship_start ? $user->internship_start->format('Y-m-d') : '') }}">
                        @error('internship_start')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Selesai Magang -->
                <div class="row mb-3">
                    <label for="internship_end" class="col-md-4 col-form-label text-md-end">Selesai Magang</label>
                    <div class="col-md-6">
                        <input id="internship_end" type="date" class="form-control @error('internship_end') is-invalid @enderror" name="internship_end" value="{{ old('internship_end', $user->internship_end ? $user->internship_end->format('Y-m-d') : '') }}">
                        @error('internship_end')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="photo" class="col-md-4 col-form-label text-md-end">
                        Foto Profil
                        <br>
                        <span class="max-image">(Format JPG, JPEG, PNG Maks. 1 MB)</span>
                    </label>

                    <div class="col-md-6">
                        <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="previewImage(event)">

                        <!-- Tempat untuk menampilkan preview gambar -->
                        <div class="mt-3">
                            <p>Preview Foto Profil:</p>
                            <img id="preview" src="{{ $user->photo ? asset('storage/' . $user->photo) : '#' }}" alt="Preview Gambar" class="img-thumbnail" style="width: 150px; {{ $user->photo ? '' : 'display: none;' }}">
                        </div>

                        @if($user->photo)
                            <small>Foto saat ini: <a href="{{ asset('storage/' . $user->photo) }}" target="_blank">Lihat Foto Profil</a></small>
                        @endif

                        @error('photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary float-end">
                            Perbarui Data
                        </button>
                    </div>
                </div>
            </form>
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
            // Jika tidak ada file yang dipilih, tampilkan gambar lama (jika ada)
            preview.src = "{{ $user->photo ? asset('storage/' . $user->photo) : '#' }}";
            preview.style.display = "{{ $user->photo ? 'block' : 'none' }}";
        }
    }
</script>
@endsection