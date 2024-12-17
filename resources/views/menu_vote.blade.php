<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodi {{ $prodi }}</title>
    @vite('resources/css/app.css')
</head>

    {{-- Menampilkan konten berdasarkan prodi --}}
    @include('hima.hima')
    
    <div>
        <form method="get" action="{{ route('logout') }}">
            <button type="submit"
                class="w-full text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-900 hover:bg-orange-500 hover:text-white duration-300">
                Log out
            </button>
        </form>
    </div>

</html>
