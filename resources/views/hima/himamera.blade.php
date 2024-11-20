<!-- resources/views/presma-ketua.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Vote</title>
    @vite('resources/css/app.css') <!-- Menghubungkan Tailwind CSS menggunakan Vite -->
</head>

<body class="bg-gradient-to-r from-orange-100 to-indigo-300 flex items-center justify-center min-h-screen">

    <!-- Container utama dengan ukuran yang lebih besar -->
    <div class="space-y-8 w-full max-w-2xl"> <!-- Mengatur container menjadi lebar maksimum dengan width 2xl (640px) -->
        <h1 class="text-center font-extrabold text-3xl drop-shadow-[5px_5px_10px_rgba(255,255,255,0.5)] "><span class="text-blue-900">Gunakan Hak Suara Anda</span> <span class="text-orange-500">Dengan Bijak Ya..</span></h1>
        <br>
        <br>
        <!-- Card untuk menu Presma -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 flex items-center space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-lg p-6">
            <!-- Icon email di sebelah kiri -->
            <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center rounded">
                <img class="max-w-full text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                    src="{{ asset('images/bem.png') }}" alt="Logo Bem">
                <path
                    d="M2.94 6.34a2 2 0 00-.94 1.76v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-.94-1.76L10 10.34 2.94 6.34zm-.61-1.39A2 2 0 014 4h12a2 2 0 011.67.95L10 8.94 2.33 4.95z">
                </path>
                </img>
            </div>
            <!-- Deskripsi teks untuk card Presma -->
            <div class="flex-grow">
                <span class="text-orange-500 text-xl font-extrabold drop-shadow-md shadow-blue-600/50">Presma Kema</span> <span class="text-white font-semibold">ULBI Periode 2025/2026</span>
            </div>
            <!-- Tombol untuk memilih Presma -->
            <button class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-orange-500 hover:scale-110 hover:bg-white hover:text-orange-500 duration-300">
                <a href="{{ url('vote.paslon') }}">
                    Vote Sekarang
                </a>
            </button>
        </div>

        <!-- Card untuk menu Ketua Himpunan -->
        <div class="bg-zinc-500 flex items-center space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-lg p-6">
            <!-- Logo Himpunan di sebelah kiri -->
            <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center">
                <img class="max-w-full" fill="currentColor" viewBox="0 0 20 20"
                    src="{{ asset('images/himamera.png') }}" alt="Logo Hima">
                <path
                    d="M2.94 6.34a2 2 0 00-.94 1.76v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-.94-1.76L10 10.34 2.94 6.34zm-.61-1.39A2 2 0 014 4h12a2 2 0 011.67.95L10 8.94 2.33 4.95z">
                </path>
                </img>
            </div>
            <!-- Deskripsi teks untuk card Ketua Himpunan -->
            <div class="flex-grow">
                <span class="text-white text-xl font-extrabold drop-shadow-md shadow-blue-600/50">Ketua Himamera</span> <span class="text-white font-semibold">Periode 2025/2026</span>
            </div>
            <!-- Tombol untuk memilih Ketua Himpunan -->
            <button class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-400 hover:scale-110 hover:bg-white hover:text-blue-900 duration-300">
            <a href="{{ url ('/vote.paslon_himamera') }}">
                Vote Sekarang
            </a>
            </button>
        </div>

    </div>

</body>

</html>
