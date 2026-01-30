<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pemira 2026</title>
    <link rel="icon" href="{{ asset('images/pemira.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <main>
        @yield('content')
    </main>
    @livewireScripts
</body>
</html>