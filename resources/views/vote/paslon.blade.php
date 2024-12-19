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
        <div class="bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 shadow rounded-lg w-[700px]">
            <div class="bg-text-white w-[700px]">
                <br>
                <div class="text-center py-2">
                    <h2 class="text-xl text-white font-extrabold">Paslon {{ $key + 1 }}</h2>
                </div>
                <!-- Content Section -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <!-- Ketua -->
                        <div class="w-36 h-48 bg-gray-300 flex flex-col items-center justify-center">
                            <span class="text-black font-semibold">Ketua</span>
                            <img src="{{ asset('storage/' . $paslon->foto_ketua) }}" alt="Foto Ketua" class="w-32 h-40 object-cover rounded-md mb-2">
                            <span class="text-black font-semibold">{{ $paslon->nm_ketua }}</span>
                        </div>
                        <!-- Wakil -->
                        <div class="w-36 h-48 bg-gray-300 flex flex-col items-center justify-center">
                            <img src="{{ asset('storage/' . $paslon->foto_wakil) }}" alt="Foto Wakil" class="w-32 h-40 object-cover rounded-md mb-2">
                            <span class="text-black font-semibold">{{ $paslon->nm_wakil }}</span>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- Button Section -->
            <div class="py-4 flex justify-center gap-4">
                <!-- Tombol Vote -->
                <button id="voteButton{{ $key }}"
                    class="vote-btn text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-700 hover:scale-110 hover:bg-white hover:text-blue-700 duration-300"
                    onclick="vote('voteButton{{ $key }}')">
                    Vote Paslon
                </button>
                <!-- Tombol Detail Profil -->
                <button
                    class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-orange-500 hover:scale-110 hover:bg-white hover:text-orange-500 duration-300"
                    onclick="showDetailModal('{{ $paslon->nm_ketua }}', '{{ $paslon->npm_ketua }}', '{{ $paslon->pd_ketua }}', '{{ $paslon->ang_ketua }}',
                            '{{ $paslon->nm_wakil }}', '{{ $paslon->npm_wakil }}', '{{ $paslon->pd_wakil }}', '{{ $paslon->ang_wakil }}',
                            `{!! addslashes($paslon->visi) !!}`, `{!! addslashes($paslon->misi) !!}`)">
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
                    <h4 class="text-lg font-bold text-blue-700 mb-2">Ketua</h4>
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex-shrink-0 w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 10c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0 2c3.31 0 6 2.69 6 6H4c0-3.31 2.69-6 6-6z" />
                            </svg>
                        </div>
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
                    <h4 class="text-lg font-bold text-orange-700 mb-2">Wakil</h4>
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex-shrink-0 w-16 h-16 bg-orange-500 text-white rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 10c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0 2c3.31 0 6 2.69 6 6H4c0-3.31 2.69-6 6-6z" />
                            </svg>
                        </div>
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

        function showDetailModal(ketuaNama, ketuaNPM, ketuaProdi, ketuaAngkatan, wakilNama, wakilNPM, wakilProdi, wakilAngkatan, visi, misi) {
            document.getElementById('ketuaNama').innerText = ketuaNama;
            document.getElementById('ketuaNPM').innerText = ketuaNPM;
            document.getElementById('ketuaProdi').innerText = ketuaProdi;
            document.getElementById('ketuaAngkatan').innerText = ketuaAngkatan;

            document.getElementById('wakilNama').innerText = wakilNama;
            document.getElementById('wakilNPM').innerText = wakilNPM;
            document.getElementById('wakilProdi').innerText = wakilProdi;
            document.getElementById('wakilAngkatan').innerText = wakilAngkatan;

            document.getElementById('visi').innerText = visi;
            document.getElementById('misi').innerHTML = misi;

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
