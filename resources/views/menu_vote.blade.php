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
    <div>
        <form method="get" action="{{ route('logout') }}">
            <button type="submit"
                class="w-full text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-900 hover:bg-orange-500 hover:text-white duration-300">
                Log out
            </button>
        </form>
    </div>
</body>

</html>
