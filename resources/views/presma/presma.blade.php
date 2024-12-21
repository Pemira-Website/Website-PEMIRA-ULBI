<h1 class="text-center font-extrabold text-3xl drop-shadow-[5px_5px_10px_rgba(255,255,255,0.5)]">
    <span class="text-blue-900">Gunakan Hak Suara Anda</span> <span class="text-orange-500">Dengan Bijak Ya..</span>
</h1>
<br>
<div class="bg-gradient-to-r from-blue-700 to-blue-900 flex items-center justify-between space-x-6 shadow-lg rounded-xl p-6">
    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full shadow-lg" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
        <img class="max-w-full" src="{{ asset('images/bem.png') }}" alt="Logo Bem">
    </div>
    <div class="flex-grow text-center">
        <span class="text-3xl font-extrabold bg-gradient-to-r from-orange-500  to-yellow-500 bg-clip-text text-transparent">
            Presma Kema ULBI
        </span>                            
        <br>
        <span class="text-gray-200 font-semibold">Periode 2025/2026</span>
    </div>
    <button class="text-white font-extrabold py-2 px-6 rounded-full bg-orange-600 hover:bg-orange-500 hover:scale-110 duration-300">
        <a href="{{ route('vote.show', ['jenis_pemilihan' => 'presma']) }}">Vote Sekarang</a>
    </button>
</div>
