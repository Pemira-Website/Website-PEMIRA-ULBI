<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Pemira 2025'); ?></title>
    <link rel="icon" href="https://github.com/user-attachments/assets/6c156f10-b646-4a46-9157-a6829dd91d0c" type="image/x-icon">
    <script src="//unpkg.com/alpinejs" defer></script>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?> <!-- Tambahkan ini untuk Livewire -->
</head>
<body class="bg-gradient-to-r from-orange-200 to-blue-200 flex items-center justify-center min-h-screen">
    <?php echo $__env->yieldContent('content'); ?>
    <main>
        <?php echo $__env->yieldContent('livechart'); ?>
    </main>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?> <!-- Tambahkan ini untuk Livewire -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?> <!-- Pastikan ini ada untuk Vite -->
    <?php echo $__env->yieldPushContent('js'); ?>
</body>
</html><?php /**PATH C:\laragon\www\Website-PEMIRA-ULBI\resources\views/layouts/app.blade.php ENDPATH**/ ?>