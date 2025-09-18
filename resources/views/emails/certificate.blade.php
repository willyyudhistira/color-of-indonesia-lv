<!DOCTYPE html>
<html>
<body>
    <h2>Halo, {{ $participant->name }}!</h2>
    <p>Terima kasih telah berpartisipasi dalam acara kami: <strong>{{ $participant->event->title }}</strong>.</p>
    <p>Gunakan nomor sertifikat unik di bawah ini untuk mengunduh E-Certificate Anda di website kami:</p>
    <h3 style="background-color:#f0f0f0; padding:10px; border-radius:5px;">{{ $participant->certificate_number }}</h3>
    <p>Silakan kunjungi <a href="{{ route('e-certificate.index') }}">halaman verifikasi kami</a> untuk mengunduh sertifikat.</p>
</body>
</html>