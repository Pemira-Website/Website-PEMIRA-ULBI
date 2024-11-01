<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">
    <!-- Container Utama -->
    <div class="border p-8 rounded-lg shadow-lg w-full max-w-md">
        <!-- Title -->
        <h2 class="text-center text-xl font-semibold text-blue-900 mb-6">Login <span class="text-orange-500">Pemilih</span></h2>

        <!-- Form Login -->
        <form class="space-y-4" action="{{ route('login') }}" method="POST">
            @csrf <!-- Tambahkan token CSRF untuk keamanan -->
            
            <!-- Menampilkan error jika ada -->
            @if ($errors->any())
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Input NPM -->
            <div>
                <label for="npm" class="block text-md font-medium text-gray-700">NPM</label>
                <input type="text" id="npm" name="npm" placeholder="Masukkan NPM"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-md font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Tombol Login -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-900 text-white px-4 py-2 rounded-md font-semibold hover:bg-blue-700">
                    Log in
                </button>
            </div>
        </form>
    </div>
</body>

</html>
