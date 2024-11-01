<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <!-- Tambahkan Alpine.js untuk interaktivitas -->
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-white">
<div class="min-h-full">
  <!-- Navbar Statis -->
  <nav class="bg-white shadow fixed top-0 left-0 w-full z-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img class="h-10 w-10" src="{{ asset('images/pp.png') }}" alt="Logo ULBI">
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a href="#" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Beranda</a>
              <a href="#" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Agenda</a>
              
              <!-- Dropdown Info Paslon dengan Alpine.js -->
              <div x-data="{ open: false }" class="relative">
                <!-- Tombol Dropdown -->
                <button @click="open = !open" class="text-gray-700 hover:text-blue-600 text-sm font-medium focus:outline-none flex items-center">
                  Info Paslon
                  <!-- Panah untuk menunjukkan dropdown -->
                  <svg :class="{'rotate-180': open}" class="inline-block w-4 h-4 ml-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>
                <!-- Menu Dropdown -->
                <div x-show="open" @click.outside="open = false" class="absolute left-0 bg-white shadow-lg rounded-md mt-2 w-48 z-10">
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Presma</a>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Himatif</a>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Himalogbis</a>
                </div>
              </div>

              <a href="#" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Tentang Kami</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Header / Body Content -->
  <header class="pt-16 mt-12">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Bagian Teks -->
        <div>
          <h1 class="text-4xl font-bold tracking-tight text-left text-blue-900">
            Selamat Datang di Web Pemira Universitas Logistik dan Bisnis Internasional
          </h1>
          <p class="mt-4 text-lg text-gray-800 text-left">
            Pemira adalah momen penting bagi kita semua. Suara Anda adalah kekuatan untuk membentuk masa depan kampus yang lebih baik dan adil. Pilihlah dengan bijak, karena setiap suara memiliki dampak nyata.
          </p>
          <div class="mt-6">
            <a href="/login" class="bg-blue-900 text-white px-6 py-3 rounded-md text-lg font-medium hover:bg-blue-700">Ayo Voting</a>
          </div>
        </div>

        <!-- Placeholder Gambar -->
        <div class="flex items-center justify-center mt-8">
          <div class="w-full h-64 bg-white- flex items-center justify-center">
            <img class="w-full h-64 object-contain" src="{{ asset('images/LOGO ULBI - WIDE DARK (3).png') }}" alt="Logo Pemira">
          </div>
        </div>
      </div>
    </div>
  </header>

</div>
</body>
</html>
