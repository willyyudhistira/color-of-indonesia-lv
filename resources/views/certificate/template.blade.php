@php
    // Ambil data template dari relasi event yang terhubung dengan peserta
    $template = $participant->event->certificateTemplate ?? null;

    // Lokasi background — jika preview gunakan asset(); jika live (PDF) gunakan public_path()
    function image_to_base64($path)
    {
        if (!$path || !file_exists($path)) {
            return null;
        }
        $type = pathinfo($path, PATHINFO_EXTENSION);
        // Fallback untuk ekstensi yang tidak umum
        if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
            $type = 'png';
        }
        // Khusus untuk SVG, formatnya sedikit berbeda
        if ($type === 'svg') {
            return 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($path));
        }
        return 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($path));
    }

    $bgPathValue = $template && $template->background_image ? $template->background_image : null;
    $bgRealPath = $bgPathValue ? Storage::disk('public')->path($bgPathValue) : null;
    // Untuk fallback, gunakan public_path() karena file ada di folder /public/assets
    $fallbackBgPath = public_path('assets/images/certificate-background.png');

    $bgPath = image_to_base64($bgRealPath) ?? image_to_base64($fallbackBgPath);


    $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(90)->generate(route('certificate.verify', $participant->certificate_number));

    $logos = [];
    if ($template) {
        for ($i = 1; $i <= 7; $i++) {
            $logoField = 'logo' . $i;
            if ($template->{$logoField}) {
                $logos[] = image_to_base64(public_path('storage/' . $template->{$logoField}));
            }
        }
    }

    $centerLogoPath = $template && $template->center_logo ? image_to_base64(public_path('storage/' . $template->center_logo)) : null;
    $signature1Path = $template && $template->signature1_image ? image_to_base64(public_path('storage/' . $template->signature1_image)) : null;
    $signature2Path = $template && $template->signature2_image ? image_to_base64(public_path('storage/' . $template->signature2_image)) : null;
    $signature3Path = $template && $template->signature3_image ? image_to_base64(public_path('storage/' . $template->signature3_image)) : null;

    function replace_placeholders($text, $participant)
    {
        if (empty($text))
            return '';

        $placeholders = [
            '[event_title]' => '<strong>' . e($participant->event->title) . '</strong>',
            '[event_date]' => '<strong>' . e($participant->event->start_date->format('d F Y')) . '</strong>',
            '[purpose]' => '<strong>' . e($participant->purpose) . '</strong>',
            '[category]' => '<strong>' . e($participant->category) . '</strong>',
            '[name]' => '<strong>' . e($participant->name) . '</strong>',
            '[group]' => '<strong>' . e($participant->group) . '</strong>',
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $text);
    }

    $nameLength = strlen($participant->name);
    $fontSize = '48px';
    $letterSpacing = 'normal'; // Jarak normal

    if ($nameLength > 25) {
        $fontSize = '40px';
        $letterSpacing = '-1px'; // Jarak dirapatkan
    }
    if ($nameLength > 35) {
        $fontSize = '32px';
        $letterSpacing = '-1.5px'; // Lebih rapat lagi
    }
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

            max-width: 90%;
            /* Batasi lebar maksimal agar teks bisa turun */
            line-height: 1.2;
            /* Atur jarak antar baris jika nama menjadi 2 baris */
            word-wrap: break-word;
            /* Properti utama agar teks bisa turun */
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
            width: 500px;
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

        */
    </style>
</head>

<body>
    @if ($bgPath)
        <img src="{{ $bgPath }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;">
    @endif
    <div class="page-container" style="background-image: url('{{ $bgPath }}');">
        <div class="qr-code">
            <img src="data:image/svg+xml;base64, {!! base64_encode($qrCode) !!}">
        </div>
        <div class="header">
            {{-- PERBAIKAN: Gunakan variabel Base64 untuk logo --}}
            @foreach ($logos as $logo)
                @if($logo) <img src="{{ $logo }}" alt="logo"> @endif
            @endforeach
        </div>



        <div class="content-wrapper">
            <p class="main-title">{{ $template->main_title ?? 'Certificate of Participation' }}</p>
            <h1 class="event-title">{{ $participant->event->title }}</h1>
            <h2 class="category">{{ $participant->category }}</h2>
            <h2 class="category">{{ $participant->subcategory }}</h2>
            <p class="award">{{ $participant->type }}</p>

            <p class="presented-to-label">Presented To</p>
            <h1 class="participant-name" style="font-size: {{ $fontSize }}; letter-spacing: {{ $letterSpacing }};">
                {{ $participant->name }}
            </h1>
            <p class="group-name">{{ $participant->group }}</p>

            <!-- <p class="description">
                In recognition of your participation in the event
                <strong>{{ $participant->event->title }}</strong>,
                held on
                <strong>{{ $participant->event->start_date->format('d F Y') }}</strong>.
                @if(!empty($participant->type) && strtolower($participant->type) == 'winner')
                    This award is given in recognition of your outstanding achievement as the
                    <strong>Winner</strong> in the <strong>{{ $participant->purpose }}</strong> competition,
                    <strong>{{ $participant->category }}</strong> category.
                @elseif(!empty($participant->type) && strtolower($participant->type) == 'supporting')
                    Your contribution in the role of <strong>Supporter</strong> for the
                    <strong>{{ $participant->category }}</strong> was invaluable to the success of this event.
                @else
                    You have contributed to promoting understanding and friendship among participants.
                @endif
            </p> -->
            <p class="description">
                {!! replace_placeholders($template->body_text, $participant) !!}

                @if(!empty($participant->type) && strtolower($participant->type) == 'winner')
                    {!! replace_placeholders($template->winner_text, $participant) !!}
                @elseif(!empty($participant->type) && strtolower($participant->type) == 'supporting')
                    {!! replace_placeholders($template->supporting_text, $participant) !!}
                @else
                    {!! replace_placeholders($template->participant_text, $participant) !!}
                @endif
            </p>
        </div>

        <!-- <div class="footer">
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
        </div> -->

        <div class="footer">
            <table class="signature-section">
                <tr>
                    @if($template && $template->signature1_name)
                        <td class="signature-box">
                            {{-- PERBAIKAN: Gunakan variabel Base64 untuk gambar tanda tangan --}}
                            @if($signature1Path)
                                <img class="sign" src="{{ $signature1Path }}">
                            @endif
                            <div class="sig-name">{{ $template->signature1_name }}</div>
                            <div class="sig-title">{{ $template->signature1_title }}</div>
                        </td>
                    @endif

                    @if($centerLogoPath)
                        <td class="center-logo-box">
                            <img src="{{ $centerLogoPath }}">
                        </td>
                    @endif

                    @if($template && $template->signature2_name)
                        <td class="signature-box">
                            {{-- PERBAIKAN: Gunakan variabel Base64 untuk gambar tanda tangan --}}
                            @if($signature2Path)
                                <img class="sign" src="{{ $signature2Path }}">
                            @endif
                            <div class="sig-name">{{ $template->signature2_name }}</div>
                            <div class="sig-title">{{ $template->signature2_title }}</div>
                        </td>
                    @endif

                    @if($template && $template->signature3_name)
                        <td class="signature-box">
                            {{-- PERBAIKAN: Gunakan variabel Base64 untuk gambar tanda tangan --}}
                            @if($signature3Path)
                                <img class="sign" src="{{ $signature3Path }}">
                            @endif
                            <div class="sig-name">{{ $template->signature3_name }}</div>
                            <div class="sig-title">{{ $template->signature3_title }}</div>
                        </td>
                    @endif
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
