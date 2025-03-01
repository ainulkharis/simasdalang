@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Profil Admin</h3>
                <p class="text-subtitle text-muted">
                    Edit detail profil admin.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Profil
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded">
        <div class="card-body">
            <form action="{{ route('admin.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="mt-2" style="width: 100px; height: auto;">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection