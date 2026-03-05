<div class="bg-gradient-to-r from-gray-400 to-gray-500 flex items-center justify-between space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-xl p-6">

    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full">
        <img class="max-w-full" src="<?php echo e(asset('images/himamera.png')); ?>" alt="Logo Hima">
    </div>
    <div class="flex-grow text-center">
        <span class="text-3xl font-extrabold bg-gradient-to-r from-blue-700 to-blue-300 bg-clip-text text-transparent">Ketua Himamera</span>
        <br>
        <span class="text-white font-semibold">Periode 2025/2026</span>
    </div>
    <button class="text-white font-extrabold py-2 px-6 rounded-full bg-blue-400 hover:bg-blue-300 hover:scale-110 duration-300">
        <a href="<?php echo e($pml_hima > 0 ? '#' : route('vote.show', ['jenis_pemilihan' => 'himamera'])); ?>" 
            class="block text-center <?php echo e($pml_hima > 0 ? 'cursor-not-allowed' : ''); ?>">
             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pml_hima > 0): ?> Sudah Memilih <?php else: ?> Vote Sekarang <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
         </a>
    </button>
</div><?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views\hima\himamera.blade.php ENDPATH**/ ?>