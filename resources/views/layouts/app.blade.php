<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Voting</title>
    @vite('resources/css/app.css')
    @livewireStyles <!-- Tambahkan ini untuk Livewire -->
</head>
<body>
    <main>
        @yield('content')
    </main>
    @livewireScripts <!-- Tambahkan ini untuk Livewire -->
    @vite('resources/js/app.js') <!-- Pastikan ini ada untuk Vite -->
    @stack('js')
</body>
</html>