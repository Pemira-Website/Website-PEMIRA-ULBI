<!-- resources/views/presma-ketua.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Vote</title>
    @vite('resources/css/app.css') <!-- Menghubungkan Tailwind CSS menggunakan Vite -->
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <!-- Container utama dengan ukuran yang lebih besar -->
    <div class="space-y-8 w-full max-w-2xl"> <!-- Mengatur container menjadi lebar maksimum dengan width 2xl (640px) -->

        <!-- Card untuk menu Presma -->
        <div class="flex items-center space-x-6 border-2 border-orange-500 rounded-lg p-6">
            <!-- Icon email di sebelah kiri -->
            <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center border border-gray-400 rounded">
                <img class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                    src="{{ asset('images/bem.png') }}" alt="Logo Bem">
                <path
                    d="M2.94 6.34a2 2 0 00-.94 1.76v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-.94-1.76L10 10.34 2.94 6.34zm-.61-1.39A2 2 0 014 4h12a2 2 0 011.67.95L10 8.94 2.33 4.95z">
                </path>
                </img>
            </div>
            <!-- Deskripsi teks untuk card Presma -->
            <div class="flex-grow">
                <span class="text-orange-500 font-semibold">Presma</span> Kema ULBI Periode 2024/2025
            </div>
            <!-- Tombol untuk memilih Presma -->
            <button class="bg-blue-800 text-white text-sm font-semibold px-6 py-3 rounded hover:bg-blue-700 w-40">
                Pilih Presiden Mahasiswa
            </button>
        </div>

        <!-- Card untuk menu Ketua Himpunan -->
        <div class="flex items-center space-x-6 border-2 border-orange-500 rounded-lg p-6">
            <!-- Icon email di sebelah kiri -->
            <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center border border-gray-400 rounded">
                <img class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                    src="{{ asset('images/Logo_himatif.png') }}" alt="Logo Hima">
                <path
                    d="M2.94 6.34a2 2 0 00-.94 1.76v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-.94-1.76L10 10.34 2.94 6.34zm-.61-1.39A2 2 0 014 4h12a2 2 0 011.67.95L10 8.94 2.33 4.95z">
                </path>
                </img>
            </div>
            <!-- Deskripsi teks untuk card Ketua Himpunan -->
            <div class="flex-grow">
                <span class="text-orange-500 font-semibold">Ketua</span> Himpunan Periode 2024/2025
            </div>
            <!-- Tombol untuk memilih Ketua Himpunan -->
            <button class="bg-blue-800 text-white text-sm font-semibold px-6 py-3 rounded hover:bg-blue-700 w-40">
            <a href="/paslon">
                Pilih Ketua Himpunan
            </a>
            </button>
        </div>

    </div>

</body>

</html>
