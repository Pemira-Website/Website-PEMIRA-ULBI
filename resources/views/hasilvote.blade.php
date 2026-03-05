@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 drop-shadow-sm mb-4">
            Live Chart KEMA ULBI
        </h1>
        <p class="text-lg text-gray-600">
            Pantau perolehan suara secara langsung dari seluruh organisasi mahasiswa (Presma, HIMA, dll).
        </p>
    </div>

    <!-- Grid untuk menampilkan semua chart secara bersampingan -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
        @foreach($jenis_pemilihans as $jenis)
            <div class="flex justify-center w-full">
                <!-- Komponen Livewire kita dipanggil dengan parameter jenis_pemilihan -->
                <livewire:live-chart :jenis_pemilihan="$jenis" :key="'chart-'.$jenis" />
            </div>
        @endforeach
    </div>
</div>
@endsection
