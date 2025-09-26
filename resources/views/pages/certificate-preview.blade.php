<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Sertifikat: {{ $participant->event->title }}</title>
    <style>
        /* Style untuk bingkai pratinjau */
        body {
            background-color: #e5e7eb;
            /* bg-gray-200 */
        }

        .wrapper {
            display: flex;
            justify-content: center;
            padding: 3rem 0;
        }

        .paper-shadow {
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }
    </style>
</head>

<body class="bg-gray-200"> <a href="javascript:history.back()"
        style="position: fixed; top: 1rem; left: 1rem; z-index: 50; background-color: #6d28d9; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none;">
        ← Kembali </a>
    <div class="wrapper"> {{-- Memuat template sertifikat Anda di sini --}}
        @include('certificate.template', ['participant' => $participant, 'is_preview' => true]) </div>
</body>

</html>