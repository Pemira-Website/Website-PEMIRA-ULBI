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
        <!-- Card Component for Paslon 1 -->
        <div
            class="bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 shadow- rounded-lg w-[700px]">
            <div class="bg-text-white w-[700px]">
                <br>
                <div class="text-center py-2">
                    <h2 class="text-xl text-white font-extrabold">Paslon 1</h2>
                </div>
                <!-- Content Section -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Capresma</span>
                        </div>
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Cawapresma</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button Section -->
            <div class="py-4 flex justify-center gap-4">
                <button id="voteButton1"
                    class="vote-btn text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-700 hover:scale-110 hover:bg-white hover:text-blue-700 duration-300"
                    onclick="vote('voteButton1')">
                    Vote
                </button>
                <button
                    class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-orange-500 hover:scale-110 hover:bg-white hover:text-orange-500 duration-300"
                    onclick="showDetailModal('Jane Doe', '123456', 'Teknik Informatika', '2020', 'Jane Smith', '654321', 'Sistem Informasi', '2021',
    'Menjadi organisasi yang lebih transparan, efektif, dan berorientasi pada kepentingan mahasiswa.',
    '1. Meningkatkan kualitas pelayanan untuk mahasiswa.<br> 2. Menyediakan platform komunikasi yang lebih baik antara mahasiswa dan pihak kampus.<br> 3. Meningkatkan partisipasi aktif mahasiswa dalam kegiatan organisasi.')">
                    Detail Profil
                </button>
            </div>
        </div>

        <br>
        <!-- Card Component for Paslon 2 -->
        <div
            class="bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 shadow- rounded-lg w-[700px]">
            <div class="bg-text-white w-[700px]">
                <br>
                <div class="text-center py-2">
                    <h2 class="text-xl text-white font-extrabold">Paslon 2</h2>
                </div>
                <!-- Content Section -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Capresma</span>
                        </div>
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Cawapresma</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button Section -->
            <div class="py-4 flex justify-center gap-4">
                <button id="voteButton2"
                    class="vote-btn text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-700 hover:scale-110 hover:bg-white hover:text-blue-700 duration-300"
                    onclick="vote('voteButton2')">
                    Vote
                </button>
                <button
                    class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-orange-500 hover:scale-110 hover:bg-white hover:text-orange-500 duration-300"
                    onclick="showDetailModal('Jane Doe', '123456', 'Teknik Informatika', '2020', 'Jane Smith', '654321', 'Sistem Informasi', '2021',
    'Menjadi organisasi yang lebih transparan, efektif, dan berorientasi pada kepentingan mahasiswa.',
    '1. Meningkatkan kualitas pelayanan untuk mahasiswa.<br> 2. Menyediakan platform komunikasi yang lebih baik antara mahasiswa dan pihak kampus.<br> 3. Meningkatkan partisipasi aktif mahasiswa dalam kegiatan organisasi.')">
                    Detail Profil
                </button>

            </div>
        </div>
        <br>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 z-10 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 4h.01m-6.938 4h13.856C19.988 20 21 18.988 21 17.764V6.236C21 5.012 19.988 4 18.764 4H5.236C4.012 4 3 5.012 3 6.236v11.528C3 18.988 4.012 20 5.236 20z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Konfirmasi Vote
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Kamu Yakin Memberikan Suara Untuk Paslon Ini?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button"
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto"
                        onclick="confirmVote()">
                        Yes, Vote
                    </button>
                    <button type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                        onclick="closeModal()">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Profil -->
    <div id="modalDetail" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-[800px] max-w-full max-h-[80vh] overflow-y-auto">
            <h3 class="text-3xl font-bold mb-6 text-center text-gray-800">Detail Profil</h3>
            <div class="space-y-6 text-gray-700">
                <!-- Paslon 2 -->
                <div class="text-center mb-6">
                    <h4 class="text-2xl font-semibold text-gray-800">Paslon 2</h4>
                </div>

                <!-- Ketua -->
                <div class="p-4 border border-gray-200 rounded-md">
                    <p class="font-semibold text-xl">Ketua</p>
                    <p id="ketuaInfo" class="text-lg">
                        <strong>Nama:</strong> John Doe<br>
                        <strong>NPM:</strong> 123456789<br>
                        <strong>Prodi:</strong> Teknik Informatika<br>
                        <strong>Angkatan:</strong> 2020
                    </p>
                </div>
                <!-- Wakil Ketua -->
                <div class="p-4 border border-gray-200 rounded-md">
                    <p class="font-semibold text-xl">Wakil Ketua</p>
                    <p id="wakilInfo" class="text-lg">
                        <strong>Nama:</strong> Jane Doe<br>
                        <strong>NPM:</strong> 987654321<br>
                        <strong>Prodi:</strong> Sistem Informasi<br>
                        <strong>Angkatan:</strong> 2021
                    </p>
                </div>
                <!-- Visi -->
                <div class="p-4 border border-gray-200 rounded-md">
                    <p class="font-semibold text-xl">Visi</p>
                    <p id="visi" class="text-lg">
                        "Menjadi organisasi yang lebih transparan, efektif, dan berorientasi pada kepentingan
                        mahasiswa."
                    </p>
                </div>
                <!-- Misi -->
                <div class="p-4 border border-gray-200 rounded-md">
                    <p class="font-semibold text-xl">Misi</p>
                    <p id="misi" class="text-lg">
                        1. Meningkatkan kualitas pelayanan untuk mahasiswa.<br>
                        2. Menyediakan platform komunikasi yang lebih baik antara mahasiswa dan pihak kampus.<br>
                        3. Meningkatkan partisipasi aktif mahasiswa dalam kegiatan organisasi.
                    </p>
                </div>
            </div>
            <div class="mt-6 text-center">
                <button class="bg-red-500 text-white px-6 py-3 rounded hover:bg-red-200 text-xl"
                    onclick="closeModalProfile()">Tutup</button>
            </div>
        </div>
    </div>
    </div>








    <script>
        let selectedButtonId = null;

        // Fungsi untuk menangani klik vote
        function vote(buttonId) {
            selectedButtonId = buttonId; // Menyimpan ID tombol yang diklik
            // Menampilkan modal
            document.getElementById("modal").classList.remove("hidden");
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
        }

        function showDetailModal(ketua, npmKetua, prodiKetua, angkatanKetua, wakil, npmWakil, prodiWakil,
            angkatanWakil, visiText, misiText) {
            document.getElementById('ketuaInfo').innerHTML =
                `<strong>Nama:</strong> ${ketua}<br><strong>NPM:</strong> ${npmKetua}<br><strong>Prodi:</strong> ${prodiKetua}<br><strong>Angkatan:</strong> ${angkatanKetua}`;
            document.getElementById('wakilInfo').innerHTML =
                `<strong>Nama:</strong> ${wakil}<br><strong>NPM:</strong> ${npmWakil}<br><strong>Prodi:</strong> ${prodiWakil}<br><strong>Angkatan:</strong> ${angkatanWakil}`;
            document.getElementById('visi').innerHTML = ` ${visiText}`;
            document.getElementById('misi').innerHTML = ` ${misiText}`;
            document.getElementById('modalDetail').classList.remove('hidden');
        }



        // Fungsi untuk konfirmasi dan menghilangkan tombol yang tidak dipilih serta menonaktifkan tombol vote
        function confirmVote() {
            // Menyembunyikan tombol vote yang tidak dipilih
            if (selectedButtonId === 'voteButton1') {
                document.getElementById('voteButton2').style.display = 'none'; // Menyembunyikan tombol paslon 2
                document.getElementById('voteButton1').disabled = true; // Menonaktifkan tombol vote paslon 1
            } else {
                document.getElementById('voteButton1').style.display = 'none'; // Menyembunyikan tombol paslon 1
                document.getElementById('voteButton2').disabled = true; // Menonaktifkan tombol vote paslon 2
            }
            // Menutup modal setelah konfirmasi
            closeModal();

            // Mengarahkan kembali ke halaman sebelumnya
            window.history.back();
        }

        // Fungsi untuk menutup modal profile
        function closeModalProfile() {
            document.getElementById("modalDetail").classList.add("hidden");
        }
    </script>
</body>

</html>
