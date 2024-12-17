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

            @if ($prodi == 'Teknik Informatika')
                @include('hima.himatif')
            @elseif ($prodi == 'Manajemen Logistik')
                @include('hima.himagis')
            @elseif ($prodi == 'Administrasi Logistik')
                @include('hima.himalogbis')
            @elseif ($prodi == 'Logistik Bisnis')
                @include('hima.himalogbis')
            @elseif ($prodi == 'Manajemen Transportasi')
                @include('hima.himaporta')
            @elseif ($prodi == 'Manajemen Perusahaan')
                @include('hima.himanbis')
            @elseif ($prodi == 'Manajemen Pemasaran')
                @include('hima.himanbis')
            @elseif ($prodi == 'Akuntansi')
                @include('hima.hma')
            @elseif ($prodi == 'Bisnis Digital')
                @include('hima.himabig')
            @elseif ($prodi == 'Ecommerce Logistics')
                @include('hima.hicomlog')
            @elseif ($prodi == 'Sains Data')
                @include('hima.himasta')
            @elseif ($prodi == 'Manajemen Rekayasa')
                @include('hima.himamera')
            @endif
            
        </div>
    </body>
</html>