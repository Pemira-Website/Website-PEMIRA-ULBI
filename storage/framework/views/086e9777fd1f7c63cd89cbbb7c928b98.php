<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e($title ?? 'Pemira 2026'); ?></title>
    <link rel="icon" href="<?php echo e(asset('images/pemira.png')); ?>" type="image/png">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gradient-to-r from-orange-200 to-blue-200 flex items-center justify-center min-h-screen">
    <?php echo $__env->yieldContent('content'); ?>
    <main>
        <?php echo $__env->yieldContent('livechart'); ?>
    </main>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('js'); ?>
</body>
</html><?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views/layouts/app.blade.php ENDPATH**/ ?>