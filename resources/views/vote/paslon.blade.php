<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page</title>
    @vite('resources/css/app.css') <!-- Include Tailwind CSS -->
</head>

<body class="bg-gradient-to-r from-orange-200 to-blue-200 flex items-center justify-center">
    <div class="space-y-10">
        <br>
        <!-- Foreach untuk menampilkan data Paslon -->
        @foreach ($dataPaslon as $key => $paslon)
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black shadow-2xl rounded-3xl w-[800px] p-8 relative overflow-hidden">
            <!-- Dekorasi Latar -->
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-gradient-to-tr from-blue-700 to-blue-500 opacity-20 blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-gradient-to-tr from-orange-600 to-orange-400 opacity-20 blur-3xl"></div>
        
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold text-white tracking-wide uppercase drop-shadow-md">
                    Paslon {{ $key + 1 }}
                </h2>
                <p class="text-sm text-gray-400 italic mt-2">"Pilih pemimpin terbaik untuk masa depan"</p>
            </div>
        
            <!-- Konten Kandidat -->
            <div class="flex justify-center items-start gap-16">
                <!-- Ketua -->
                <div class="group relative bg-gradient-to-t from-gray-800 to-gray-700 rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <!-- Gambar Ketua -->
                    <div class="relative w-64 h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $paslon->ft_ketua) }}" alt="Foto ketua" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <!-- Detail Wakil -->
                    <div class="text-center py-4 bg-gradient-to-b from-orange-800 to-orange-700">
                        <span class="block text-orange-400 font-bold text-sm uppercase tracking-widest">{{ $paslon->jbt_ketua }}</span>
                        <span class="block text-white font-extrabold text-xl mt-1">{{ $paslon->nm_ketua }}</span>
                    </div>
                </div>
        
                <!-- Wakil -->
                <div class="group relative bg-gradient-to-t from-gray-800 to-gray-700 rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <!-- Gambar Wakil -->
                    <div class="relative w-64 h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $paslon->ft_wakil) }}" alt="Foto Wakil" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <!-- Detail Wakil -->
                    <div class="text-center py-4 bg-gradient-to-b from-orange-800 to-orange-700">
                        <span class="block text-orange-400 font-bold text-sm uppercase tracking-widest">{{ $paslon->jbt_wakil }}</span>
                        <span class="block text-white font-extrabold text-xl mt-1">{{ $paslon->nm_wakil }}</span>
                    </div>
                </div>
            </div>
            <br>
            <!-- Button Section -->
            <div class="py-4 flex justify-center gap-6">
                <!-- Tombol Vote -->
                <button id="voteButton{{ $key }}"
                    class="text-white font-semibold py-3 px-10 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 shadow-lg hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 transition-all duration-300"
                    onclick="vote('voteButton{{ $key }}')">
                    Vote Paslon
                </button>
            
                <!-- Tombol Detail Profil -->
                <button
                    class="text-white font-semibold py-3 px-10 rounded-full bg-gradient-to-r from-orange-500 to-yellow-500 shadow-lg hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-orange-400 hover:to-yellow-400 transition-all duration-300"
                    onclick="showDetailModal(
                        '{{ asset('storage/' . $paslon->ft_ketua) }}',
                        '{{ $paslon->nm_ketua }}',
                        '{{ $paslon->npm_ketua }}',
                        '{{ $paslon->pd_ketua }}',
                        '{{ $paslon->ang_ketua }}',
                        '{{ $paslon->jbt_ketua }}',
                        '{{ asset('storage/' . $paslon->ft_wakil) }}',
                        '{{ $paslon->nm_wakil }}',
                        '{{ $paslon->npm_wakil }}',
                        '{{ $paslon->pd_wakil }}',
                        '{{ $paslon->ang_wakil }}',
                        '{{ $paslon->jbt_wakil }}',
                        `{!! addslashes($paslon->visi) !!}`,
                        `{!! addslashes($paslon->misi) !!}`
                    )">
                    Detail Profil
                </button>
            </div>            
        </div>
        <br>
        @endforeach
    </div>

    <div id="modalDetail" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
        <div class="relative bg-white rounded-lg shadow-xl w-[800px] max-w-full max-h-[90vh] overflow-y-auto scrollbar-hide">
            <!-- Header -->
            <div class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 rounded-t-lg">
                <h3 class="text-2xl font-bold">Detail Profil Paslon</h3>
            </div>
    
            <!-- Body -->
            <div class="p-8 space-y-6">
                <!-- Label Ketua -->
                <div>
                    <h4 id="ketuaJbt" class="text-lg font-bold text-blue-700 mb-2"></h4>
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg shadow-sm">
                        <!-- Foto Ketua -->
                        <div class="flex-shrink-0 w-16 h-16 rounded-full overflow-hidden bg-gray-100 shadow-md">
                            <img src="" id="ketuaFoto" alt="Foto Ketua" class="w-full h-full object-cover">
                        </div>
                        <!-- Detail Ketua -->
                        <div class="ml-4 w-full">
                            <table class="w-full text-sm text-gray-600">
                                <tr>
                                    <td class="font-medium text-gray-800 w-[100px]">Nama</td>
                                    <td>:</td>
                                    <td id="ketuaNama"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-gray-800">NPM</td>
                                    <td>:</td>
                                    <td id="ketuaNPM"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-gray-800">Prodi</td>
                                    <td>:</td>
                                    <td id="ketuaProdi"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-gray-800">Angkatan</td>
                                    <td>:</td>
                                    <td id="ketuaAngkatan"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
    
                <!-- Label Wakil -->
                <div>
                    <h4 id="wakilJbt" class="text-lg font-bold text-orange-700 mb-2"></h4>
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg shadow-sm">
                        <!-- Foto Wakil -->
                        <div class="flex-shrink-0 w-16 h-16 rounded-full overflow-hidden bg-gray-100 shadow-md">
                            <img src="" id="wakilFoto" alt="Foto Wakil" class="w-full h-full object-cover">
                        </div>
                        <!-- Detail Wakil -->
                        <div class="ml-4 w-full">
                            <table class="w-full text-sm text-gray-600">
                                <tr>
                                    <td class="font-medium text-gray-800 w-[100px]">Nama</td>
                                    <td>:</td>
                                    <td id="wakilNama"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-gray-800">NPM</td>
                                    <td>:</td>
                                    <td id="wakilNPM"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-gray-800">Prodi</td>
                                    <td>:</td>
                                    <td id="wakilProdi"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-gray-800">Angkatan</td>
                                    <td>:</td>
                                    <td id="wakilAngkatan"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
    
                <!-- Visi -->
                <div class="p-4 border-l-4 border-blue-500 bg-gray-50 rounded-lg">
                    <p class="font-semibold text-lg text-gray-800">Visi</p>
                    <p id="visi" class="text-sm text-gray-600 mt-2"></p>
                </div>
    
                <!-- Misi -->
                <div class="p-4 border-l-4 border-orange-500 bg-gray-50 rounded-lg">
                    <p class="font-semibold text-lg text-gray-800">Misi</p>
                    <p id="misi" class="text-sm text-gray-600 mt-2"></p>
                </div>
            </div>
    
            <!-- Footer -->
            <div class="flex justify-center p-6 bg-gray-100 rounded-b-lg">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition" onclick="closeModalDetail()">Tutup</button>
            </div>
        </div>
    </div>
    
    
    <!-- Modal Error -->
    @if (session('error'))
    <div id="errorModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-semibold text-red-600">Kesalahan</h3>
                <button onclick="closeModalError()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
    
            <!-- Body -->
            <div class="mt-4 text-gray-700">
                <p>{{ session('error') }}</p>
            </div>
    
            <!-- Footer -->
            <div class="mt-6 flex justify-end">
                <button onclick="closeModalError()" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    
    @endif


    <!-- Script Modal -->
    <script>
        let selectedButtonId = null;

        function vote(buttonId) {
            selectedButtonId = buttonId; // Menyimpan ID tombol yang diklik
            alert("Anda memilih: " + buttonId);
        }

        function showDetailModal(ketuaFoto, ketuaNama, ketuaNPM, ketuaProdi, ketuaAngkatan, ketuaJbt, wakilFoto, wakilNama, wakilNPM, wakilProdi, wakilAngkatan, wakilJbt, visi, misi) {
            document.getElementById('ketuaNama').innerText = ketuaNama;
            document.getElementById('ketuaFoto').src = ketuaFoto; 
            document.getElementById('ketuaNPM').innerText = ketuaNPM;
            document.getElementById('ketuaProdi').innerText = ketuaProdi;
            document.getElementById('ketuaAngkatan').innerText = ketuaAngkatan;
            document.getElementById('ketuaJbt').innerText = ketuaJbt;

            document.getElementById('wakilNama').innerText = wakilNama;
            document.getElementById('wakilFoto').src = wakilFoto;
            document.getElementById('wakilNPM').innerText = wakilNPM;
            document.getElementById('wakilProdi').innerText = wakilProdi;
            document.getElementById('wakilAngkatan').innerText = wakilAngkatan;
            document.getElementById('wakilJbt').innerText = wakilJbt;

            document.getElementById('visi').innerText = visi;
            document.getElementById('misi').innerText = misi;

            document.getElementById('modalDetail').classList.remove('hidden');
        }
        function closeModalDetail() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        function closeModalError() {
             document.getElementById('errorModal').classList.add('hidden');
         }
    </script>

    
</body>

</html>
