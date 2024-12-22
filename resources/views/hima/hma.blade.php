<!-- Card untuk menu Ketua Himpunan -->
<div class="bg-gradient-to-r from-white to-blue-600 flex items-center justify-between space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-xl p-6">
    <!-- Logo Himpunan di sebelah kiri -->
    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full">
        <img class="max-w-full" src="{{ asset('images/hma.png') }}" alt="Logo Hima">
    </div>
    <div class="flex-grow text-center">
        <span class="text-blue-800 text-3xl font-extrabold drop-shadow-md shadow-blue-600/50">Ketua Hma</span>
        <br>
        <span class="text-blue-800 font-semibold">Periode 2025/2026</span>
    </div>
    <button class="text-blue-600 font-extrabold py-2 px-6 rounded-full bg-yellow-400 hover:scale-110 hover:bg-yellow-300 duration-300">
        <a href="{{ route('vote.show', ['jenis_pemilihan' => 'hma']) }}">Vote Sekarang</a>
    </button>
</div>