<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .verification-container {
            max-width: 100%;
            width: 100%;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .verification-container h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .verification-container p {
            font-size: 16px;
            color: #6c757d;
        }
        .verification-container .btn {
            width: 100%;
            margin-top: 10px;
        }

        @media (min-width: 576px) {
            .verification-container {
                max-width: 540px;
                padding: 30px;
                margin: 20px auto;
            }
        }

        @media (min-width: 768px) {
            .verification-container {
                max-width: 600px;
            }
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="verification-container">
        <h1>Verifikasi Email Anda</h1>
        <p>Terima kasih telah mendaftar. Sebelum melanjutkan, silahkan periksa email Anda pada <strong>kotak masuk</strong> atau <strong>folder spam</strong> untuk melihat tautan verifikasi.</p>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <p>Jika Anda tidak menerima email, klik tombol di bawah ini untuk mengirim ulang tautan verifikasi.</p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
        </form>

        <!-- Tombol Kembali ke Halaman Awal -->
        <div class="d-flex justify-content-center">
            <a href="/" class="btn btn-secondary">Kembali ke Halaman Awal</a>
        </div>
    </div>
</div>
</body>
</html>