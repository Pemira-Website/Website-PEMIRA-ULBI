<!-- Card untuk menu Ketua Himpunan -->
<div class="bg-gradient-to-r from-zinc-700 to-zinc-900 flex items-center justify-between space-x-6 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-xl p-6">
    <!-- Logo Himpunan di sebelah kiri -->
    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full">
        <img class="max-w-full" src="<?php echo e(asset('images/himaporta.png')); ?>" alt="Logo Hima">
    </div>
    <div class="flex-grow text-center">
        <span class="text-3xl font-extrabold bg-gradient-to-r from-orange-500 to-orange-300 bg-clip-text text-transparent">Ketua Himaporta</span>
        <br>
        <span class="text-white font-semibold">Periode 2025/2026</span>
    </div>
    <button class="text-white font-extrabold py-2 px-6 rounded-full bg-orange-800 hover:bg-orange-700  hover:scale-110 duration-300">
        <a href="<?php echo e($pml_hima > 0 ? '#' : route('vote.show', ['jenis_pemilihan' => 'himaporta'])); ?>" 
            class="block text-center <?php echo e($pml_hima > 0 ? 'cursor-not-allowed' : ''); ?>">
             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pml_hima > 0): ?> Sudah Memilih <?php else: ?> Vote Sekarang <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
         </a>
    </button>
</div><?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views\hima\himaporta.blade.php ENDPATH**/ ?>