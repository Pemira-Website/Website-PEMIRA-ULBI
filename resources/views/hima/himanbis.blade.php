<div class="bg-gradient-to-r from-black to-blue-500 flex items-center justify-between space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-xl p-6">

    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full">
        <img class="max-w-full" src="{{ asset('images/himanbis.png') }}" alt="Logo Hima">
    </div>
    <div class="flex-grow text-center">
        <span class="text-3xl font-extrabold bg-gradient-to-r from-pink-500 to-purple-400 bg-clip-text text-transparent">Ketua Himanbis</span>
        <br>
        <span class="text-white font-semibold">Periode 2025/2026</span>
    </div>
    <button class="text-white font-extrabold py-2 px-6 rounded-full bg-purple-500 hover:bg-purple-400 hover:scale-110 duration-300">
        <a href="{{ $pml_hima > 0 ? '#' : route('vote.show', ['jenis_pemilihan' => 'himanbis']) }}" 
            class="block text-center {{ $pml_hima > 0 ? 'cursor-not-allowed' : '' }}">
             @if($pml_hima > 0) Sudah Memilih @else Vote Sekarang @endif
         </a>
    </button>
</div>