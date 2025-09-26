{{-- resources/views/admin/participants/print.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Sertifikat - {{ $participant->name }}</title>
    {{-- Hapus margin bawaan browser untuk print --}}
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            margin: 0;
        }
    </style>
</head>
<body>

    {{-- Memuat tampilan sertifikat yang sudah ada --}}
    @include('certificate.template', ['participant' => $participant, 'is_preview' => false])

    {{-- Script untuk otomatis memicu dialog print saat halaman dimuat --}}
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>