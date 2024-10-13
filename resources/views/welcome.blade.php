<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class="bg-white">
<div class="min-h-full">
  <!-- Navbar -->
  <nav class="bg-white shadow">
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
              <a href="#" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Info Paslon</a>
              <a href="#" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Tentang Kami</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Header / Body Content -->
  <header>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Bagian Teks -->
        <div>
          <h1 class="text-4xl font-bold tracking-tight text-left text-blue-900">
            Selamat Datang di Web <span class="text-blue-900">Pemira</span> Universitas Logistik dan Bisnis Internasional
          </h1>
          <p class="mt-4 text-lg text-gray-800 text-left">
            Pemira adalah momen penting bagi kita semua. Suara Anda adalah kekuatan untuk membentuk masa depan kampus yang lebih baik dan adil. Pilihlah dengan bijak, karena setiap suara memiliki dampak nyata.
          </p>
          <div class="mt-6">
            <a href="#" class="bg-blue-900 text-white px-6 py-3 rounded-md text-lg font-medium hover:bg-blue-700">Ayo Voting</a>
          </div>
        </div>

        <!-- Placeholder Gambar -->
        <div class="flex items-center justify-center">
          <div class="w-full h-64 bg-white- flex items-center justify-center">
            <!-- Perbaikan URL Gambar -->
            <img class="w-full h-64 object-contain" src="{{ asset('images/LOGO ULBI - WIDE DARK (3).png') }}" alt="Logo Pemira">
          </div>
        </div>
      </div>
    </div>
  </header>

</div>
</body>
</html>
