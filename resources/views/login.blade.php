<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gradient-to-r from-orange-200 to-blue-200 flex items-center justify-center min-h-screen">
    <!-- Container Utama -->
    <div class="bg-white p-8 rounded-lg shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] w-full max-w-md">
        <!-- Title -->
        <h2 class="text-center text-3xl font-extrabold text-blue-900 mb-6">Login <span class="text-orange-500">Pemilih</span></h2>

        <!-- Form Login -->
        <form class="space-y-4" method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Input NPM -->
            <div>
                <label for="npm" class="block text-md font-medium text-gray-700">NPM</label>
                <input type="text" id="npm" name="npm" placeholder="Masukkan NPM"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-md font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tombol Login -->
            <div>
                <button type="submit"
                    class="w-full text-white font-semibold py-2 px-6 rounded transition ease-in-out delay-150 bg-blue-900 hover:bg-orange-500 hover:text-white duration-300">
                    Log in
                </button>
            </div>
        </form>
        @if ($errors->any())
            <div class="text-red-700 p-2 text-center">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</body>

</html>
