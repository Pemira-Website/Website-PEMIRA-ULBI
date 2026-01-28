<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemira 2025</title>
    <link rel="icon" href="https://github.com/user-attachments/assets/6c156f10-b646-4a46-9157-a6829dd91d0c" type="image/x-icon">
    <script src="//unpkg.com/alpinejs" defer></script>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?> <!-- Tambahkan ini untuk Livewire -->
</head>
<body>
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?> <!-- Tambahkan ini untuk Livewire -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?> <!-- Pastikan ini ada untuk Vite -->
</body>
</html><?php /**PATH C:\laragon\www\Website-PEMIRA-ULBI\resources\views/layouts/app1.blade.php ENDPATH**/ ?>