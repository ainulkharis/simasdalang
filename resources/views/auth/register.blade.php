<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Simasdalang</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center align-items-center" style="background-color: #f0f8ff;">
                <div class="form-container">
                    <h2>Register</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        {{-- Input Name --}}
                        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        {{-- Input Email --}}
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        {{-- Input Password --}}
                        <div class="password-container" style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Password" required style="width: 100%; padding-right: 40px;">

                            <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        {{-- Input Password Confirmation --}}
                        <div class="password-container" style="position: relative;">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required style="width: 100%; padding-right: 40px;">

                            <span id="togglePasswordConfirm" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <i class="fa fa-eye" id="eyeIconConfirm"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        {{-- Submit Button --}}
                        <input type="submit" value="Register">
                    </form>
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                    <p>Kembali ke <a href="/">Beranda</a></p>
                </div>
            </div>
            <div class="col-md-6 info-container">
                <h2 style="font-weight: bold; text-shadow: 4px 4px 7px black;">Selamat Datang di Simasdalang</h2>
                <img src="{{ asset('assets/img/welcome-simasdalang-auth.png') }}" alt="Gambar Deskripsi" class="img-fluid rounded"
                    style="width: 100%; height: 97%; margin-top: 30px;">
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function togglePassword(inputId, iconId) {
            var passwordField = document.getElementById(inputId);
            var eyeIcon = document.getElementById(iconId);

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash"); // Ganti ikon ke "mata tertutup"
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye"); // Ganti ikon ke "mata terbuka"
            }
        }

        document.getElementById("togglePassword").addEventListener("click", function() {
            togglePassword("password", "eyeIcon");
        });

        document.getElementById("togglePasswordConfirm").addEventListener("click", function() {
            togglePassword("password_confirmation", "eyeIconConfirm");
        });
    </script>
</body>
</html>