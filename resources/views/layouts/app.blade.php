<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemira 2025</title>
    @vite('resources/css/app.css')
    @livewireStyles <!-- Tambahkan ini untuk Livewire -->
</head>
<body class="bg-gradient-to-r from-orange-200 to-blue-200 flex items-center justify-center min-h-screen">
    <main>
        @yield('content')
    </main>
    @livewireScripts <!-- Tambahkan ini untuk Livewire -->
    @vite('resources/js/app.js') <!-- Pastikan ini ada untuk Vite -->
    @stack('js')
</body>
</html>