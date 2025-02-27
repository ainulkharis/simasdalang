@component('mail::message')
# Halo!

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.

@component('mail::button', ['url' => $resetUrl])
    Reset Password
@endcomponent

Jika Anda tidak meminta reset password, abaikan email ini.

Salam,  
Tim Simasdalang

@component('mail::subcopy')
    Jika Anda mengalami masalah saat mengklik tombol "Reset Password", salin dan tempel URL berikut ke browser web Anda:  
    [{{ $resetUrl }}]({{ $resetUrl }})
@endcomponent
@endcomponent