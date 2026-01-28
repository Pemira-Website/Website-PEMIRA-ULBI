<?php $__env->startSection('content'); ?>
<div class="min-h-full bg-gradient-to-b from-gray-50 to-white">

  <!-- Hero Section -->
  <header class="pt-20 pb-16 bg-gradient-to-br from-blue-900 via-blue-800 to-orange-600">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- Bagian Teks -->
        <div class="order-2 md:order-1">
          <span class="inline-block px-4 py-1 bg-orange-500 text-white rounded-full text-sm font-semibold mb-4 shadow-lg">
            PEMIRA KEMA ULBI 2026
          </span>
          <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-white leading-tight">
            Selamat Datang di<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-yellow-300">
              PEMIRA ULBI
            </span>
          </h1>
          <p class="mt-6 text-lg text-blue-100 leading-relaxed">
            Pemira adalah momen penting bagi kita semua. Suara Anda adalah kekuatan untuk membentuk masa depan kampus yang lebih baik dan adil. Pilihlah dengan bijak, karena setiap suara memiliki dampak nyata.
          </p>
          <div class="mt-8 flex flex-wrap gap-4">
            <a href="/login" class="inline-flex items-center bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-3 rounded-lg text-lg font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Ayo Voting
            </a>
            <a href="#tentang" class="inline-flex items-center border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white/10 transition-all duration-300">
              Pelajari Lebih Lanjut
            </a>
          </div>
        </div>

        <!-- Gambar Hero -->
        <div class="order-1 md:order-2 flex items-center justify-center">
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-full blur-3xl opacity-30 animate-pulse"></div>
            <img class="relative w-full max-w-md h-auto object-contain drop-shadow-2xl" 
                 src="https://github.com/user-attachments/assets/6c156f10-b646-4a46-9157-a6829dd91d0c" 
                 alt="Logo Pemira ULBI">
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Tentang PEMIRA Section -->
  <section id="tentang" class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <span class="inline-block px-4 py-1 bg-blue-900 text-white rounded-full text-sm font-semibold mb-4">
          TENTANG KAMI
        </span>
        <h2 class="text-3xl md:text-4xl font-bold text-blue-900">
          Apa itu PEMIRA?
        </h2>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
          Pemilihan Raya (PEMIRA) adalah pesta demokrasi mahasiswa untuk memilih pemimpin organisasi kemahasiswaan.
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1 - Demokratis -->
        <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-t-4 border-blue-900">
          <div class="w-16 h-16 bg-gradient-to-r from-blue-800 to-blue-900 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-blue-900 mb-3">Demokratis</h3>
          <p class="text-gray-600">Setiap mahasiswa memiliki hak suara yang sama untuk menentukan pemimpin organisasi kemahasiswaan.</p>
        </div>

        <!-- Card 2 - Aman & Rahasia -->
        <div class="group bg-gradient-to-br from-teal-50 to-cyan-100 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-t-4 border-teal-500">
          <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-teal-700 mb-3">Aman & Rahasia</h3>
          <p class="text-gray-600">Sistem voting online kami menjamin keamanan dan kerahasiaan pilihan setiap pemilih.</p>
        </div>

        <!-- Card 3 - Transparan -->
        <div class="group bg-gradient-to-br from-orange-50 to-amber-100 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-t-4 border-orange-500">
          <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-orange-600 mb-3">Transparan</h3>
          <p class="text-gray-600">Proses pemilihan yang terbuka dan hasil yang dapat dipertanggungjawabkan kepada seluruh civitas akademika.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Alur Pemilihan Section -->
  <section id="alur" class="py-20 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <span class="inline-block px-4 py-1 bg-orange-500 text-white rounded-full text-sm font-semibold mb-4">
          PANDUAN
        </span>
        <h2 class="text-3xl md:text-4xl font-bold text-white">
          Alur Pemilihan
        </h2>
        <p class="mt-4 text-lg text-blue-200 max-w-3xl mx-auto">
          Ikuti langkah-langkah berikut untuk memberikan suara Anda
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Step 1 -->
        <div class="relative text-center">
          <div class="w-20 h-20 bg-gradient-to-r from-orange-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-orange-500/30">
            <span class="text-3xl font-bold text-white">1</span>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Login</h3>
          <p class="text-blue-200">Masuk menggunakan NIM dan password yang telah terdaftar</p>
          <div class="hidden md:block absolute top-10 left-[60%] w-full h-0.5 bg-gradient-to-r from-orange-400 to-transparent"></div>
        </div>

        <!-- Step 2 -->
        <div class="relative text-center">
          <div class="w-20 h-20 bg-gradient-to-r from-teal-400 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-teal-500/30">
            <span class="text-3xl font-bold text-white">2</span>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Lihat Kandidat</h3>
          <p class="text-blue-200">Pelajari visi misi dan profil setiap kandidat</p>
          <div class="hidden md:block absolute top-10 left-[60%] w-full h-0.5 bg-gradient-to-r from-teal-400 to-transparent"></div>
        </div>

        <!-- Step 3 -->
        <div class="relative text-center">
          <div class="w-20 h-20 bg-gradient-to-r from-pink-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-pink-500/30">
            <span class="text-3xl font-bold text-white">3</span>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Pilih Kandidat</h3>
          <p class="text-blue-200">Tentukan pilihan Anda dengan mengklik tombol voting</p>
          <div class="hidden md:block absolute top-10 left-[60%] w-full h-0.5 bg-gradient-to-r from-pink-400 to-transparent"></div>
        </div>

        <!-- Step 4 -->
        <div class="text-center">
          <div class="w-20 h-20 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-red-500/30">
            <span class="text-3xl font-bold text-white">4</span>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Konfirmasi</h3>
          <p class="text-blue-200">Verifikasi dan konfirmasi pilihan Anda</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Jadwal Pemilihan Section -->
  <section id="jadwal" class="py-20 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <span class="inline-block px-4 py-1 bg-orange-500 text-white rounded-full text-sm font-semibold mb-4">
          TIMELINE
        </span>
        <h2 class="text-3xl md:text-4xl font-bold text-blue-900">
          Jadwal PEMIRA KEMA ULBI 2026
        </h2>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
          Pastikan Anda tidak melewatkan momen penting dalam PEMIRA 2026
        </p>
      </div>
      
      <div class="max-w-4xl mx-auto">
        <!-- Timeline Item 1 - Pendaftaran Paslon BEM -->
        <div class="relative pl-8 pb-8 border-l-4 border-blue-900">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-blue-900 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-blue-900 text-white text-sm font-semibold rounded-full mb-2">
              Kamis, 15 Januari – Rabu, 21 Januari 2026
            </span>
            <h3 class="text-xl font-bold text-blue-900">📝 Pendaftaran Paslon BEM</h3>
            <p class="text-gray-600 mt-2">Periode pendaftaran calon ketua dan wakil ketua BEM KEMA ULBI.</p>
          </div>
        </div>

        <!-- Timeline Item 2 - Verifikasi Berkas -->
        <div class="relative pl-8 pb-8 border-l-4 border-teal-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-teal-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-teal-500 text-white text-sm font-semibold rounded-full mb-2">
              Kamis, 22 Januari – Sabtu, 24 Januari 2026
            </span>
            <h3 class="text-xl font-bold text-teal-700">📋 Verifikasi & Pengumpulan Berkas Paslon BEM</h3>
            <p class="text-gray-600 mt-2">Proses verifikasi kelengkapan dan keabsahan berkas pendaftaran paslon.</p>
          </div>
        </div>

        <!-- Timeline Item 3 - Fit & Proper Test -->
        <div class="relative pl-8 pb-8 border-l-4 border-cyan-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-cyan-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-cyan-50 to-sky-50 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-cyan-500 text-white text-sm font-semibold rounded-full mb-2">
              Senin, 26 Januari 2026
            </span>
            <h3 class="text-xl font-bold text-cyan-700">🎤 Fit & Proper Test Paslon BEM</h3>
            <p class="text-gray-600 mt-2">Uji kelayakan dan kepatutan calon ketua dan wakil ketua BEM.</p>
          </div>
        </div>

        <!-- Timeline Item 4 - Penetapan Paslon -->
        <div class="relative pl-8 pb-8 border-l-4 border-yellow-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-yellow-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-full mb-2">
              Selasa, 27 Januari 2026
            </span>
            <h3 class="text-xl font-bold text-yellow-600">🏷️ Penetapan Paslon BEM & Nomor Urut</h3>
            <p class="text-gray-600 mt-2">Pengumuman resmi paslon yang lolos dan pemberian nomor urut.</p>
          </div>
        </div>

        <!-- Timeline Item 5 - Masa Kampanye BEM -->
        <div class="relative pl-8 pb-8 border-l-4 border-orange-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-orange-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-orange-500 text-white text-sm font-semibold rounded-full mb-2">
              Rabu, 28 Januari – Selasa, 10 Februari 2026
            </span>
            <h3 class="text-xl font-bold text-orange-600">📢 Masa Kampanye Paslon BEM</h3>
            <p class="text-gray-600 mt-2">Para kandidat mempresentasikan visi, misi, dan program kerja kepada seluruh mahasiswa.</p>
          </div>
        </div>

        <!-- Timeline Item 6 - Debat Paslon BEM -->
        <div class="relative pl-8 pb-8 border-l-4 border-pink-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-pink-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-pink-500 text-white text-sm font-semibold rounded-full mb-2">
              Minggu, 2 Februari 2026
            </span>
            <h3 class="text-xl font-bold text-pink-600">🎙️ Debat Paslon BEM</h3>
            <p class="text-gray-600 mt-2">Debat terbuka antar kandidat untuk memaparkan solusi atas permasalahan kampus.</p>
          </div>
        </div>

        <!-- Timeline Item 7 - Pendaftaran HMJ -->
        <div class="relative pl-8 pb-8 border-l-4 border-blue-600">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-blue-600 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-blue-600 text-white text-sm font-semibold rounded-full mb-2">
              Mulai Rabu, 4 Februari 2026
            </span>
            <h3 class="text-xl font-bold text-blue-700">📝 Pendaftaran Paslon HMJ</h3>
            <p class="text-gray-600 mt-2">Periode pendaftaran calon ketua dan wakil ketua Himpunan Mahasiswa Jurusan.</p>
          </div>
        </div>

        <!-- Timeline Item 8 - Kampanye HMJ -->
        <div class="relative pl-8 pb-8 border-l-4 border-purple-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-purple-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-purple-50 to-fuchsia-50 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-purple-500 text-white text-sm font-semibold rounded-full mb-2">
              Rabu, 4 Februari – Selasa, 10 Februari 2026
            </span>
            <h3 class="text-xl font-bold text-purple-600">📢 Masa Kampanye Paslon HMJ</h3>
            <p class="text-gray-600 mt-2">Para kandidat HMJ mempresentasikan visi, misi, dan program kerja.</p>
          </div>
        </div>

        <!-- Timeline Item 9 - Hari Tenang -->
        <div class="relative pl-8 pb-8 border-l-4 border-gray-400">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-gray-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-gray-50 to-slate-100 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-gray-500 text-white text-sm font-semibold rounded-full mb-2">
              Rabu, 11 Februari 2026
            </span>
            <h3 class="text-xl font-bold text-gray-700">🤫 Hari Tenang PEMIRA</h3>
            <p class="text-gray-600 mt-2">Masa jeda tanpa kampanye untuk persiapan hari pemungutan suara.</p>
          </div>
        </div>

        <!-- Timeline Item 10 - Hari Pemilihan -->
        <div class="relative pl-8 pb-8 border-l-4 border-red-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-red-500 rounded-full border-4 border-white shadow animate-pulse"></div>
          <div class="bg-gradient-to-r from-red-50 to-rose-100 rounded-xl p-6 ml-4 shadow-lg hover:shadow-xl transition-shadow duration-300 ring-2 ring-red-400">
            <span class="inline-block px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-full mb-2">
              Kamis, 12 Februari 2026
            </span>
            <h3 class="text-xl font-bold text-red-600">🗳️ Pemungutan & Penghitungan Suara</h3>
            <p class="text-gray-600 mt-2">HARI PEMILIHAN! Gunakan hak suara Anda untuk menentukan pemimpin terbaik!</p>
          </div>
        </div>

        <!-- Timeline Item 11 - Pengumuman -->
        <div class="relative pl-8 border-l-4 border-yellow-500">
          <div class="absolute -left-3 top-0 w-6 h-6 bg-yellow-500 rounded-full border-4 border-white shadow"></div>
          <div class="bg-gradient-to-r from-yellow-50 to-amber-100 rounded-xl p-6 ml-4 shadow-md hover:shadow-lg transition-shadow duration-300">
            <span class="inline-block px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-full mb-2">
              Jumat, 13 Februari 2026
            </span>
            <h3 class="text-xl font-bold text-yellow-600">🏆 Pengaduan & Pengumuman Hasil Suara</h3>
            <p class="text-gray-600 mt-2">Pengumuman resmi hasil pemilihan dan penetapan pemenang PEMIRA 2026.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-16 bg-gradient-to-r from-blue-900 via-blue-800 to-orange-600">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
        Siap Memberikan Suara Anda?
      </h2>
      <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
        Suara Anda sangat berarti untuk masa depan kampus kita. Jangan lewatkan kesempatan ini!
      </p>
      <a href="/login" class="inline-flex items-center bg-gradient-to-r from-orange-500 to-red-500 text-white px-10 py-4 rounded-xl text-lg font-bold shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        Mulai Voting Sekarang
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
        <!-- Logo & Description -->
        <div class="md:col-span-2">
          <div class="flex items-center mb-6">
            <img src="https://github.com/user-attachments/assets/6c156f10-b646-4a46-9157-a6829dd91d0c" 
                 alt="Logo PEMIRA" 
                 class="w-12 h-12 mr-3">
            <span class="text-2xl font-bold">PEMIRA <span class="text-orange-400">KEMA ULBI</span></span>
          </div>
          <p class="text-blue-200 leading-relaxed mb-6">
            Pemilihan Raya (PEMIRA) Keluarga Mahasiswa Universitas Logistik dan Bisnis Internasional merupakan wadah demokrasi mahasiswa untuk memilih pemimpin organisasi kemahasiswaan yang amanah dan bertanggung jawab.
          </p>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center hover:bg-orange-500 transition-colors duration-300">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
              </svg>
            </a>
            <a href="#" class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center hover:bg-orange-500 transition-colors duration-300">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </a>
            <a href="#" class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center hover:bg-orange-500 transition-colors duration-300">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-lg font-bold mb-6 text-orange-400">Tautan Cepat</h3>
          <ul class="space-y-3">
            <li><a href="#tentang" class="text-blue-200 hover:text-orange-400 transition-colors duration-300">Tentang PEMIRA</a></li>
            <li><a href="#alur" class="text-blue-200 hover:text-orange-400 transition-colors duration-300">Alur Pemilihan</a></li>
            <li><a href="#jadwal" class="text-blue-200 hover:text-orange-400 transition-colors duration-300">Jadwal</a></li>
            <li><a href="/login" class="text-blue-200 hover:text-orange-400 transition-colors duration-300">Login</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-lg font-bold mb-6 text-orange-400">Kontak</h3>
          <ul class="space-y-4">
            <li class="flex items-start">
              <svg class="w-5 h-5 mr-3 text-orange-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              <span class="text-blue-200">Jl. Sariasih No.54, Sarijadi, Bandung</span>
            </li>
            <li class="flex items-center">
              <svg class="w-5 h-5 mr-3 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              <span class="text-blue-200">pemira@ulbi.ac.id</span>
            </li>
            <li class="flex items-center">
              <svg class="w-5 h-5 mr-3 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
              <span class="text-blue-200">(022) 2009-568</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Copyright -->
      <div class="border-t border-blue-800 mt-12 pt-8 text-center">
        <p class="text-blue-300">
          © 2026 PEMIRA KEMA ULBI. All rights reserved. | Dibuat dengan ❤️ untuk Demokrasi Kampus
        </p>
      </div>
    </div>
  </footer>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Website-PEMIRA-ULBI\resources\views/welcome.blade.php ENDPATH**/ ?>