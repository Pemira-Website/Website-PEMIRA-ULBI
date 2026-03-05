<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemira 2024</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="bg-gradient-to-r from-orange-100 to-indigo-300 flex items-center justify-center min-h-screen">

    <div class="space-y-8 w-full max-w-2xl">
        <?php echo $__env->make('presma.presma', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prodi == 'D3 Teknik Informatika' || $prodi == 'D4 Teknik Informatika'): ?>
            <?php echo $__env->make('hima.himatif', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($prodi == 'S1 Manajemen Logistik'): ?>
            <?php echo $__env->make('hima.himagis', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($prodi == 'D3 Administrasi Logistik' || $prodi == 'D4 Logistik Bisnis'): ?>
            <?php echo $__env->make('hima.himalogbis', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($prodi == 'S1 Manajemen Transportasi'): ?>
            <?php echo $__env->make('hima.himaporta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($prodi == 'D3 Manajemen Pemasaran' || $prodi == 'D4 Manajemen Perusahaan' ): ?>
            <?php echo $__env->make('hima.himanbis', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($prodi == 'D3 Akuntansi' || $prodi == 'D4 Akuntansi Keuangan'): ?>
            <?php echo $__env->make('hima.hma', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($prodi == 'S1 Sains Data'): ?>
            <?php echo $__env->make('hima.himasta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($prodi == 'D3 Manajemen Informatika'): ?>
            <?php echo $__env->make('hima.hmmi', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</body>

</html>
<?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views\hima\hima.blade.php ENDPATH**/ ?>