@component('mail::message')
@slot('header')
    Simasdalang
@endslot

Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.

@component('mail::button', ['url' => $verificationUrl])
    Verifikasi Alamat Email
@endcomponent

Jika Anda tidak membuat akun, tidak ada tindakan lebih lanjut yang diperlukan.

Salam,  
Tim Simasdalang

@component('mail::subcopy')
    Jika Anda mengalami masalah saat mengklik tombol "Verifikasi Alamat Email", salin dan tempel URL berikut ke browser web Anda:  
    [{{ $verificationUrl }}]({{ $verificationUrl }})
@endcomponent
@endcomponent