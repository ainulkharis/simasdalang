<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Simasdalang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center align-items-center" style="background-color: #f0f8ff;">
                <div class="form-container">
                    <h2>Lupa Password</h2>
                    <!-- Notifikasi Sukses -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <input type="submit" value="Kirim Link Reset Password">
                    </form>
                    <p>Ingat password? <a href="{{ route('login') }}">Login di sini</a></p>
                    <p>Kembali ke <a href="/">Home</a></p>
                </div>
            </div>
            <div class="col-md-6 info-container">
                <h2 style="font-weight: bold; text-shadow: 4px 4px 7px black;">Selamat Datang di Simasdalang</h2>
                <img src="{{ asset('assets/img/welcome-simasdalang-auth.png') }}" alt="Gambar Deskripsi" class="img-fluid rounded"
                    style="width: 100%; height: 97%; margin-top: 30px;">
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>