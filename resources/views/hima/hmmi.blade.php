<div class="bg-gradient-to-r from-orange-400 to-white flex items-center justify-between space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-xl p-6">
    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full">
        <img class="max-w-full" src="{{ asset('images/hmmi.png') }}" alt="Logo Hima">
    </div>
    <div class="flex-grow text-center">
        <span class="text-3xl font-extrabold bg-gradient-to-r from-blue-900 to-blue-600 bg-clip-text text-transparent">Ketua HMMI</span>
        <br>
        <span class="text-blue-900 font-semibold">Periode 2025/2026</span>
    </div>
    <button class="text-white font-extrabold py-2 px-6 rounded-full bg-blue-900 hover:bg-blue-600 hover:scale-110 duration-300">
        <a href="{{ route('vote.show', ['jenis_pemilihan' => 'hmm']) }}">Vote Sekarang</a>
    </button>
</div>