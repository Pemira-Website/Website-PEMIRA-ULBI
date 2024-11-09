<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodi {{ $prodi }}</title>
</head>
<body>
        {{-- <h1>Menu Vote untuk Prodi: {{ $prodi }}</h1> --}}

        {{-- Menampilkan konten berdasarkan prodi --}}
        @if ($prodi == 'Teknik Informatika')
            @include('hima.himatif')
        @elseif ($prodi == 'Manajemen Logistik')
            @include('hima.himagis')
        @else
            @include('hima.prodi_lain')
        @endif
    </div>
</body>
</html>
