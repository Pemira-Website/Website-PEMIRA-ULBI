<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemira 2024</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-r from-orange-100 to-indigo-300 flex items-center justify-center min-h-screen">

    <div class="space-y-8 w-full max-w-2xl">
        @include('presma.presma')

        @if ($prodi == 'D3 Teknik Informatika' || $prodi == 'D4 Teknik Informatika')
            @include('hima.himatif')
        @elseif ($prodi == 'S1 Manajemen Logistik')
            @include('hima.himagis')
        @elseif ($prodi == 'D3 Administrasi Logistik' || $prodi == 'D4 Logistik Bisnis')
            @include('hima.himalogbis')
        @elseif ($prodi == 'S1 Manajemen Transportasi')
            @include('hima.himaporta')
        @elseif ($prodi == 'D3 Manajemen Pemasaran' || $prodi == 'D4 Manajemen Perusahaan' )
            @include('hima.himanbis')
        @elseif ($prodi == 'D3 Akuntansi' || $prodi == 'D4 Akuntansi Keuangan')
            @include('hima.hma')
        @elseif ($prodi == 'S1 Sains Data')
            @include('hima.himasta')
        @elseif ($prodi == 'D3 Manajemen Informatika')
            @include('hima.hmmi')
        @endif

    </div>
</body>

</html>
