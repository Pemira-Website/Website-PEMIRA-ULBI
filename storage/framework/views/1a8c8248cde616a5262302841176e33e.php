    <?php $__env->startSection('content'); ?>
    <div class="w-full max-w-5xl space-y-8">
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <a href="<?php echo e(route('menuvote', ['prodi' => $userProdi])); ?>"
                class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                Kembali ke Menu Vote
            </a>
            <a href="<?php echo e(route('hasilvote')); ?>"
                class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                Lihat Hasil Sementara
            </a>
        </div>

        <div class="space-y-10">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $dataPaslon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $paslon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black shadow-2xl rounded-3xl w-[800px] p-8 relative overflow-hidden">
            <div class="pointer-events-none absolute -top-10 -left-10 w-64 h-64 bg-gradient-to-tr from-blue-700 to-blue-500 opacity-20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-10 -right-10 w-72 h-72 bg-gradient-to-tr from-orange-600 to-orange-400 opacity-20 blur-3xl"></div>
        
            <div class="relative z-10 text-center mb-8">
                <h2 class="text-4xl font-bold text-white tracking-wide uppercase drop-shadow-md">
                    Paslon <?php echo e($key + 1); ?>

                </h2>
                <p class="text-sm text-gray-400 italic mt-2">"Pilih pemimpin terbaik untuk masa depan"</p>
            </div>
        
            <?php
                $ketuaFoto = filled($paslon->ft_ketua)
                    ? (Str::startsWith($paslon->ft_ketua, 'http') ? $paslon->ft_ketua : Storage::disk('gcs')->url($paslon->ft_ketua))
                    : null;
                $wakilFoto = filled($paslon->ft_wakil)
                    ? (Str::startsWith($paslon->ft_wakil, 'http') ? $paslon->ft_wakil : Storage::disk('gcs')->url($paslon->ft_wakil))
                    : null;
                $hasWakil = filled($paslon->nm_wakil);
                $detailPayload = [
                    'ketuaFoto' => $ketuaFoto,
                    'ketuaNama' => $paslon->nm_ketua,
                    'ketuaNPM' => (string) $paslon->npm_ketua,
                    'ketuaProdi' => $paslon->pd_ketua,
                    'ketuaAngkatan' => $paslon->ang_ketua,
                    'ketuaJbt' => $paslon->jbt_ketua,
                    'wakilFoto' => $wakilFoto,
                    'wakilNama' => $paslon->nm_wakil,
                    'wakilNPM' => (string) $paslon->npm_wakil,
                    'wakilProdi' => $paslon->pd_wakil,
                    'wakilAngkatan' => $paslon->ang_wakil,
                    'wakilJbt' => $paslon->jbt_wakil,
                    'visi' => $paslon->visi,
                    'misi' => $paslon->misi,
                ];
            ?>

            <div
                class="relative z-10 space-y-4"
                data-detail-trigger="paslon-card"
                data-detail='<?php echo json_encode($detailPayload, 15, 512) ?>'
            >
                <div
                    class="flex justify-center items-start gap-16 cursor-pointer rounded-3xl focus:outline-none focus:ring-4 focus:ring-orange-400/60"
                    role="button"
                    tabindex="0"
                    aria-label="Lihat detail profil paslon <?php echo e($key + 1); ?>"
                    onclick="showDetailModalFromTrigger(this.parentElement)"
                    onkeydown="handleDetailTriggerKeydown(event, this.parentElement)"
                >
                <div class="group relative bg-gradient-to-t from-gray-800 to-gray-700 rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <div class="relative w-72 h-64 overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ketuaFoto): ?>
                            <img src="<?php echo e($ketuaFoto); ?>" alt="Foto ketua" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-slate-700 text-slate-200 font-semibold">Foto belum tersedia</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="text-center py-4 bg-gradient-to-b from-orange-800 to-orange-700">
                        <span class="block text-orange-400 font-bold text-sm uppercase tracking-widest"><?php echo e($paslon->jbt_ketua); ?></span>
                        <span class="block text-white font-extrabold text-xl mt-1"><?php echo e($paslon->nm_ketua); ?></span>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasWakil): ?>
                    <div class="group relative bg-gradient-to-t from-gray-800 to-gray-700 rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300">
                        <div class="relative w-72 h-64 overflow-hidden">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wakilFoto): ?>
                                <img src="<?php echo e($wakilFoto); ?>" alt="Foto Wakil" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-slate-700 text-slate-200 font-semibold">Foto belum tersedia</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="text-center py-4 bg-gradient-to-b from-orange-800 to-orange-700">
                            <span class="block text-orange-400 font-bold text-sm uppercase tracking-widest"><?php echo e($paslon->jbt_wakil); ?></span>
                            <span class="block text-white font-extrabold text-xl mt-1"><?php echo e($paslon->nm_wakil); ?></span>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <p class="text-center text-sm font-medium text-orange-300">
                    Klik kartu paslon untuk lihat detail lengkap
                </p>
            </div>
            <br>
            <div class="relative z-10 py-4 flex justify-center gap-6">
                <form method="POST" action="<?php echo e(route('vote.add')); ?>" id="voteForm-<?php echo e($paslon->id); ?>" class="hidden">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="paslon_id" value="<?php echo e($paslon->id); ?>">
                    <input type="hidden" name="jenis_vote" value="<?php echo e($paslon->jenis_pemilihan); ?>">
                </form>
                <button 
                    type="button"
                    class="text-white font-extrabold py-3 px-10 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 shadow-lg hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-400 transition-all duration-300"
                    onclick="confirmVote(<?php echo e($paslon->id); ?>)">
                    Vote Paslon
                </button>
                <button
                    type="button"
                    class="text-white font-extrabold py-3 px-10 rounded-full bg-gradient-to-r from-orange-500 to-yellow-500 shadow-lg hover:shadow-xl hover:scale-105 hover:bg-gradient-to-r hover:from-orange-400 hover:to-yellow-400 transition-all duration-300"
                    data-detail-trigger="paslon-button"
                    data-detail='<?php echo json_encode($detailPayload, 15, 512) ?>'
                    onclick="showDetailModalFromTrigger(this)">
                    Detail Profil
                </button>
            </div>            
        </div>
        <br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white shadow-lg rounded-2xl border border-slate-200 p-8 text-center space-y-4">
                <h2 class="text-xl font-bold text-slate-800">Belum Ada Kandidat</h2>
                <p class="text-slate-600">
                    Data pasangan calon untuk pemilihan ini belum tersedia. Silakan kembali ke menu utama atau cek hasil sementara.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <a href="<?php echo e(route('menuvote', ['prodi' => $userProdi])); ?>"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-slate-700 text-white font-semibold hover:bg-slate-800 transition">
                        Kembali ke Menu Vote
                    </a>
                    <a href="<?php echo e(route('hasilvote')); ?>"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                        Lihat Hasil Sementara
                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-extrabold text-orange-500">Apakah anda yakin memilih paslon ini?</h3>
                <button onclick="closeConfirmModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <br>
            <!-- Body -->
            <div class="mt-4 text-gray-700">
                <p>Silakan konfirmasi pilihan Anda untuk pasangan calon ini.</p>
            </div>
            <br>
            <!-- Footer -->
            <div class="mt-6 flex justify-end">
                <button id="confirmYes" class="bg-orange-600 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-700 transition mr-2">
                    Ya, Saya Yakin
                </button>
                <button onclick="closeConfirmModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                    Tidak
                </button>
            </div>
        </div>
    </div>

    <div id="modalDetail" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
        <div class="relative bg-white rounded-lg shadow-xl w-[800px] max-w-full max-h-[90vh] overflow-y-auto scrollbar-hide">
            <div class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 rounded-t-lg">
                <h3 class="text-2xl font-bold">Detail Profil Paslon</h3>
            </div>
            <div class="p-8 space-y-6">
                <div>
                    <h4 id="ketuaJbt" class="text-lg font-bold text-blue-700 mb-2"></h4>
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full overflow-hidden bg-gray-100 shadow-md">
                            <img src="" id="ketuaFoto" alt="Foto Ketua" class="w-full h-full object-cover">
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
                <div id="wakilWrapper">
                    <h4 id="wakilJbt" class="text-lg font-bold text-orange-700 mb-2"></h4>
                    <div id="wakilSection" class="flex items-center p-4 border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full overflow-hidden bg-gray-100 shadow-md">
                            <img src="" id="wakilFoto" alt="Foto Wakil" class="w-full h-full object-cover">
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
                <div class="p-4 border-l-4 border-blue-500 bg-gray-50 rounded-lg">
                    <p class="font-semibold text-lg text-gray-800">Visi</p>
                    <p id="visi" class="text-sm text-gray-600 mt-2"></p>
                </div>
                <div class="p-4 border-l-4 border-orange-500 bg-gray-50 rounded-lg">
                    <p class="font-semibold text-lg text-gray-800">Misi</p>
                    <p id="misi" class="text-sm text-gray-600 mt-2"></p>
                </div>
            </div>
            <div class="flex justify-center p-6 bg-gray-100 rounded-b-lg">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition" onclick="closeModalDetail()">Tutup</button>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
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
            <div class="mt-4 text-gray-700">
                <p><?php echo e(session('error')); ?></p>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeModalError()" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('js'); ?>
    <script>
        let currentPaslonId = null;

        function confirmVote(paslonId) {
            currentPaslonId = paslonId; // Simpan ID paslon yang dipilih
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        const confirmYesButton = document.getElementById('confirmYes');
        if (confirmYesButton) {
            confirmYesButton.onclick = function() {
                document.getElementById('voteForm-' + currentPaslonId).submit(); // Kirim formulir
            };
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        function parseDetailPayload(trigger) {
            try {
                return JSON.parse(trigger.dataset.detail ?? '{}');
            } catch (error) {
                console.error('Gagal membaca detail paslon.', error);
                return null;
            }
        }

        function showDetailModalFromTrigger(trigger) {
            const detail = parseDetailPayload(trigger);

            if (!detail) {
                return;
            }

            showDetailModal(detail);
        }

        function handleDetailTriggerKeydown(event, trigger) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            event.preventDefault();
            showDetailModalFromTrigger(trigger);
        }

        function showDetailModal(detail) {
            document.getElementById('ketuaNama').innerText = detail.ketuaNama;
            document.getElementById('ketuaFoto').src = detail.ketuaFoto || '';
            document.getElementById('ketuaNPM').innerText = detail.ketuaNPM;
            document.getElementById('ketuaProdi').innerText = detail.ketuaProdi;
            document.getElementById('ketuaAngkatan').innerText = detail.ketuaAngkatan;
            document.getElementById('ketuaJbt').innerText = detail.ketuaJbt;

            const hasWakil = Boolean(detail.wakilNama);
            const wakilSection = document.getElementById('wakilSection');
            const wakilWrapper = document.getElementById('wakilWrapper');
            if (hasWakil) {
                wakilWrapper.classList.remove('hidden');
                wakilSection.classList.remove('hidden');
                document.getElementById('wakilNama').innerText = detail.wakilNama;
                document.getElementById('wakilFoto').src = detail.wakilFoto || '';
                document.getElementById('wakilNPM').innerText = detail.wakilNPM || '-';
                document.getElementById('wakilProdi').innerText = detail.wakilProdi || '-';
                document.getElementById('wakilAngkatan').innerText = detail.wakilAngkatan || '-';
                document.getElementById('wakilJbt').innerText = detail.wakilJbt || 'Wakil';
            } else {
                wakilWrapper.classList.add('hidden');
                wakilSection.classList.add('hidden');
            }

            document.getElementById('visi').innerText = detail.visi;
            document.getElementById('misi').innerText = detail.misi;

            document.getElementById('modalDetail').classList.remove('hidden');
        }

        function closeModalDetail() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        function closeModalError() {
            document.getElementById('errorModal').classList.add('hidden');
        }
    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views/vote/paslon.blade.php ENDPATH**/ ?>