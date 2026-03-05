<div class="bg-gradient-to-r from-zinc-700 to-zinc-900 flex items-center justify-between space-x-6  shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-xl p-6">
    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-full bg-white">
        <img class="max-w-full" src="<?php echo e(asset('images/himatif.png')); ?>" alt="Logo Hima">
    </div>
    <div class="flex-grow text-center">
        <span class="text-3xl font-extrabold bg-gradient-to-r from-red-500 to-red-400 bg-clip-text text-transparent">Ketua Himatif</span>
        <br>
        <span class="text-white font-semibold">Periode 2025/2026</span>
    </div>
    <button class="text-white font-extrabold py-2 px-6 rounded-full bg-red-700 hover:bg-red-600 hover:scale-110 duration-300">
    <a href="<?php echo e($pml_hima > 0 ? '#' : route('vote.show', ['jenis_pemilihan' => 'himatif'])); ?>" 
        class="block text-center <?php echo e($pml_hima > 0 ? 'cursor-not-allowed' : ''); ?>">
         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pml_hima > 0): ?> Sudah Memilih <?php else: ?> Vote Sekarang <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     </a>
    </button>
</div>
<?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views\hima\himatif.blade.php ENDPATH**/ ?>