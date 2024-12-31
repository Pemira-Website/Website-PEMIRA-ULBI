<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/pemira.png') }}" type="image/x-icon">
    <title>Logout</title>
    @vite('resources/css/app.css')
    <!-- Tambahkan Alpine.js untuk interaktivitas -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-white">
    <div class="min-h-full">
        <!-- Header / Body Content -->
        <header class="pt-16 mt-12">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <!-- Bagian Teks -->
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight text-left text-blue-900">
                            Terima Kasih Atas Partisipasi Anda!
                        </h1>
                        <p class="mt-4 text-lg text-gray-800 text-justify">
                            Suara Anda telah dicatat dan merupakan kontribusi penting dalam membentuk masa depan kampus
                            kita. Terima kasih telah berpartisipasi dalam menciptakan lingkungan akademis yang lebih
                            inklusif dan inovatif. Hasil pemilihan akan diumumkan pada <span
                                class="font-bold mt-4 text-lg text-blue-900 text-left">[tanggal pengumuman]. </span>
                        </p>
                        <p class="mt-4 text-lg text-gray-800 text-justify"><br>Kunjungi instagram kami di <span class="font-bold mt-4 text-lg text-blue-900 text-left">@pemiraubli</span> untuk informasi lebih lanjut. Kami berharap Anda terus aktif dan terlibat
                            dalam berbagai kegiatan kampus. Sampai bertemu lagi!</p>
                        <div class="mt-6">
                            <a href="/login"
                                class="bg-red-700 text-white px-6 py-3 rounded-md text-lg font-medium hover:bg-red-500">Selesai
                                Voting</a>
                        </div>
                    </div>

                    <!-- Placeholder Gambar -->
                    <div class="flex items-center justify-center mt-8">
                        <div class="w-full h-96 bg-white- flex items-center justify-center">
                            <img class="w-full h-96 object-contain" src="{{ asset('images/pemira.png') }}"
                                alt="Logo Pemira">
                        </div>
                    </div>
                </div>
            </div>
        </header>

    </div>
</body>

</html>
