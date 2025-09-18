@php
    // Membuat URL lengkap ke halaman verifikasi, contoh: https://domain.com/verify/COI-1-ABCDE123
    $verificationUrl = route('certificate.verify', $participant->certificate_number);
    
    // Generate QR Code yang berisi URL tersebut
    $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(90)->generate($verificationUrl);
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat {{ $participant->name }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        .page-container {
            height: 713px;
            padding: 40px;
            /* border: 12px solid #800000; */
            background-image: url('{{ public_path('assets/images/certificate-background.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            /* box-sizing: border-box; */
            text-align: center;
            position: relative;
        }

        .header {
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .header img {
            height: 45px;
            /* diperbesar agar proporsional */
            margin: 0 10px;
            vertical-align: middle;
        }

        .content-wrapper {
            /* Wrapper untuk konten utama agar bisa diatur posisinya */
            padding-top: 80px;
            /* Jarak dari atas untuk header */
            padding-bottom: 150px;
            /* Jarak dari bawah untuk footer */
        }

        .main-title {
            font-size: 22px;
            letter-spacing: 2px;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .event-title {
            font-size: 30px;
            font-weight: bold;
            /* color: #C13584; */
            margin: 15px 0 5px 0;
        }

        .award {
            font-size: 32px;
            margin: 20px 0 10px 0;
        }

        .category {
            font-size: 16px;
            color: #555;
            margin: 0;
        }

        .presented-to-label {
            font-size: 14px;
            color: #666;
            margin-top: 30px;
        }

        .participant-name {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            margin: 10px 0 10px 0;
            padding: 0 20px 5px 20px;
            border-bottom: 2px solid #555;
            display: inline-block;
        }

        .group-name {
            font-size: 16px;
            font-weight: bold;
            color: #555;
        }

        .description {
            font-size: 11px;
            max-width: 750px;
            margin: 25px auto 0 auto;
            line-height: 1.5;
            color: #444;
        }

        .qr-code {
            position: absolute;
            top: 50px;
            /* agak turun agar sejajar bingkai */
            left: 50px;
            /* jarak lebih masuk */
        }

        .footer {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
        }

        .signature-section {
            width: 340px;
            /* lebar kotak tanda tangan; ubah sesuai kebutuhan */
            margin: 0 auto;
            /* center pada halaman */
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* table.signature-section {
            width: 100%;
            border-collapse: collapse;
        } */

        .signature-box {
            height: 80px;
            /* tinggi area tanda tangan — ubah kalau perlu */
            /* border: 2px solid #000; */
            vertical-align: middle;
            text-align: center;
            padding: 6px 8px;
            /* beri sedikit ruang di dalam kotak */
        }

        .signature-box img.sign {
            max-height: 80px;
            max-width: auto;
            display: block;
            margin: 0 auto;
        }

        .sig-name {
            font-size: 12px;
            font-weight: bold;
            padding-top: 10px;
            margin: 0;
            text-align: center;
        }

        .sig-title {
            font-size: 11px;
            color: #444;
            padding-top: 4px;
            margin: 0;
            text-align: center;
        }

        .signature-section td {
            text-align: center;
            /* semua isi kolom tabel signature rata tengah */
        }
    </style>
</head>

<body>
    <div class="page-container">
        <div class="qr-code">
            <img src="data:image/svg+xml;base64, {!! base64_encode($qrCode) !!}">
        </div>
        <div class="header">
            {{-- Anda perlu menambahkan semua logo di sini --}}
            <img src="{{ public_path('assets/images/logo_coi.png') }}">
            <img src="{{ public_path('assets/images/logo_coi.png') }}">
            <img src="{{ public_path('assets/images/logo_coi.png') }}">
            <img src="{{ public_path('assets/images/logo_coi.png') }}">
            <img src="{{ public_path('assets/images/logo_coi.png') }}">
            {{-- ... tambahkan 4 logo lainnya --}}
        </div>

        <div class="content-wrapper">
            <p class="main-title">Certificate of Participation</p>
            <h1 class="event-title">{{ $participant->event->title }}</h1>
            <h2 class="award">{{ $participant->category }}</h2>
            <p class="category">{{ $participant->type }}</p>

            <p class="presented-to-label">Presented To</p>
            <h1 class="participant-name">{{ $participant->name }}</h1>
            <p class="group-name">{{ $participant->group }}</p>

            <p class="description">
                Sebagai bentuk apresiasi atas partisipasi dalam acara
                <strong>{{ $participant->event->title }}</strong>
                yang diselenggarakan pada
                <strong>{{ $participant->event->start_date->format('d F Y') }}</strong>.
                @if(!empty($participant->type) && strtolower($participant->type) == 'winner')
                    Penghargaan ini diberikan sebagai pengakuan atas pencapaian luar biasa Anda sebagai
                    <strong>Pemenang</strong> dalam kompetisi <strong>{{ $participant->purpose }}</strong> kategori
                    <strong>{{ $participant->category }}</strong>.
                @elseif(!empty($participant->type) && strtolower($participant->type) == 'supporting')
                    Kontribusi Anda dalam peran <strong>Pendukung</strong> untuk
                    <strong>{{ $participant->category }}</strong> sangat berharga bagi keberhasilan acara ini.
                @else
                    Anda telah berkontribusi dalam mempromosikan pemahaman dan persahabatan antar peserta.
                @endif
            </p>
        </div>

        <div class="footer">
            <table class="signature-section">
                <tr>
                    <td class="signature-box" valign="middle">
                        <img class="sign" src="{{ public_path('assets/images/signature.png') }}" alt="Tanda Tangan">
                    </td>
                </tr>
                <tr>
                    <td class="sig-name">VIVI SANDRA PUTRI</td>
                </tr>
                <tr>
                    <td class="sig-title">Founder, COLOR OF INDONESIA</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>