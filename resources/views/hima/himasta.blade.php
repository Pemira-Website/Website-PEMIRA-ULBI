        <!-- Card untuk menu Ketua Himpunan -->
        <div
            class="bg-indigo-950 flex items-center space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-lg p-6">
            <!-- Logo Himpunan di sebelah kiri -->
            <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center">
                <img class="max-w-full h-auto text-gray-600" fill="currentColor" src="{{ asset('images/himasta.png') }}"
                    alt="Logo Hima">
                <path
                    d="M2.94 6.34a2 2 0 00-.94 1.76v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-.94-1.76L10 10.34 2.94 6.34zm-.61-1.39A2 2 0 014 4h12a2 2 0 011.67.95L10 8.94 2.33 4.95z">
                </path>
                </img>
            </div>
            <!-- Deskripsi teks untuk card Ketua Himpunan -->
            <div class="flex-grow">
                <span class="text-white text-xl font-extrabold drop-shadow-md shadow-blue-600/50">Ketua Himasta</span>
                <span class="text-white font-semibold">Periode 2025/2026</span>
            </div>
            <!-- Tombol untuk memilih Ketua Himpunan -->
            <button
                class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-orange-500 hover:scale-110 hover:bg-white hover:text-blue-800 duration-300">
                <a href="{{ route('vote.paslon', ['prodi' => Session::get('prodi')]) }}">
                    Vote Sekarang
                </a>
            </button>
        </div>
