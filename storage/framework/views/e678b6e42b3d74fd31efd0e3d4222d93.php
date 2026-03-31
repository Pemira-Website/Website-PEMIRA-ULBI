<div class="space-y-8 w-full max-w-2xl">
    <?php echo $__env->make('presma.presma', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($show_hima ?? false) && $hima_type && \Illuminate\Support\Facades\View::exists('hima.' . $hima_type)): ?>
        <?php echo $__env->make('hima.' . $hima_type, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif(($show_hima ?? false) && $hima_type): ?>
        <div class="bg-white border border-red-200 text-red-700 rounded-xl p-4 text-center space-y-3">
            <p>Mapping HIMA tidak ditemukan untuk prodi ini.</p>
            <a href="<?php echo e(route('hasilvote')); ?>" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                Lihat Hasil Sementara
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views/hima/hima.blade.php ENDPATH**/ ?>