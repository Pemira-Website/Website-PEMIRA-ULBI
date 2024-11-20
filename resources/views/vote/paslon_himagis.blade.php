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
        <div class="bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 shadow- rounded-lg w-[700px]">
            <div class="bg-text-white w-[700px]">
                <br>
                <div class="text-center py-2">
                    <h2 class="text-xl text-white font-extrabold">Paslon 1</h2>
                </div>
                <!-- Content Section -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Cakahim</span>
                        </div>
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Cawakahim</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button Section -->
            <div class="py-4 flex justify-center gap-4">
                <button id="voteButton1" class="vote-btn text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-700 hover:scale-110 hover:bg-white hover:text-blue-700 duration-300" onclick="vote('voteButton1')">
                    Vote
                </button>
                <button class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-orange-500 hover:scale-110 hover:bg-white hover:text-orange-500 duration-300">
                    Detail Profil
                </button>
            </div>
        </div>

        <br>
        <!-- Card Component for Paslon 2 -->
        <div class="bg-[conic-gradient(at_bottom_right,_var(--tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900 shadow- rounded-lg w-[700px]">
            <div class="bg-text-white w-[700px]">
                <br>
                <div class="text-center py-2">
                    <h2 class="text-xl text-white font-extrabold">Paslon 2</h2>
                </div>
                <!-- Content Section -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Cakahim</span>
                        </div>
                        <div class="w-36 h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-black font-semibold">Cawakahim</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button Section -->
            <div class="py-4 flex justify-center gap-4">
                <button id="voteButton2" class="vote-btn text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-700 hover:scale-110 hover:bg-white hover:text-blue-700 duration-300" onclick="vote('voteButton2')">
                    Vote
                </button>
                <button class="text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-orange-500 hover:scale-110 hover:bg-white hover:text-orange-500 duration-300">
                    Detail Profil
                </button>
            </div>
        </div>
        <br>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 z-10 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01m-6.938 4h13.856C19.988 20 21 18.988 21 17.764V6.236C21 5.012 19.988 4 18.764 4H5.236C4.012 4 3 5.012 3 6.236v11.528C3 18.988 4.012 20 5.236 20z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Konfirmasi Vote</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin memberikan suara untuk paslon ini?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto" onclick="confirmVote()">
                        Ya, Vote
                    </button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" onclick="closeModal()">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedButtonId = null;

        // Fungsi untuk menangani klik vote
        function vote(buttonId) {
            selectedButtonId = buttonId;  // Menyimpan ID tombol yang diklik
            // Menampilkan modal
            document.getElementById("modal").classList.remove("hidden");
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
        }

        // Fungsi untuk konfirmasi dan menghilangkan tombol yang tidak dipilih serta menonaktifkan tombol vote
        function confirmVote() {
            // Menyembunyikan tombol vote yang tidak dipilih
            if (selectedButtonId === 'voteButton1') {
                document.getElementById('voteButton2').style.display = 'none';  // Menyembunyikan tombol paslon 2
                document.getElementById('voteButton1').disabled = true;  // Menonaktifkan tombol vote paslon 1
            } else {
                document.getElementById('voteButton1').style.display = 'none';  // Menyembunyikan tombol paslon 1
                document.getElementById('voteButton2').disabled = true;  // Menonaktifkan tombol vote paslon 2
            }
            // Menutup modal setelah konfirmasi
            closeModal();
        }
    </script>
</body>
</html>
