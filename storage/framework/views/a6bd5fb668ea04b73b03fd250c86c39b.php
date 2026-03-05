

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 drop-shadow-sm mb-4">
            Live Chart KEMA ULBI
        </h1>
        <p class="text-lg text-gray-600">
            Pantau perolehan suara secara langsung dari seluruh organisasi mahasiswa (Presma, HIMA, dll).
        </p>
    </div>

    <!-- Grid untuk menampilkan semua chart secara bersampingan -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $jenis_pemilihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex justify-center w-full">
                <!-- Komponen Livewire kita dipanggil dengan parameter jenis_pemilihan -->
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('live-chart', ['jenisPemilihan' => $jenis,'jenis_pemilihan' => $jenis]);

$key = 'chart-'.$jenis;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1871148850-0', 'chart-'.$jenis);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views\hasilvote.blade.php ENDPATH**/ ?>