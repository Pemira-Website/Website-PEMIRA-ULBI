<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pemira 2025' }}</title>
    <link rel="icon" href="https://github.com/user-attachments/assets/6c156f10-b646-4a46-9157-a6829dd91d0c" type="image/x-icon">
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite('resources/css/app.css')
    @livewireStyles <!-- Tambahkan ini untuk Livewire -->
</head>
<body class="bg-gradient-to-r from-orange-200 to-blue-200 flex items-center justify-center min-h-screen">
    @yield('content')
    <main>
        @yield('livechart')
    </main>
    @livewireScripts <!-- Tambahkan ini untuk Livewire -->
    @vite('resources/js/app.js') <!-- Pastikan ini ada untuk Vite -->
    @stack('js')
</body>
</html>