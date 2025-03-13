{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Kegiatan</h3>
                <p class="text-subtitle text-muted">
                    Edit detail kegiatan peserta.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Kegiatan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded">
        <div class="card-body">
            <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $activity->date }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Kegiatan</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $activity->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Kegiatan</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    @if ($activity->photo)
                        <img src="{{ asset('storage/' . $activity->photo) }}" alt="Foto Kegiatan" class="mt-2" style="width: 100px; height: auto;">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection --}}