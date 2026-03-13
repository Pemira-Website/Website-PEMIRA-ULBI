@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 drop-shadow-sm mb-4">
            Live Chart KEMA ULBI
        </h1>
        <p class="text-lg text-gray-600">
            {{ $results_notice }}
        </p>
    </div>

    @if (!$show_public_results)
        <div class="max-w-3xl mx-auto bg-white border border-orange-200 rounded-2xl p-8 text-center shadow-sm">
            <h2 class="text-2xl font-bold text-orange-700 mb-3">Hasil Sementara Ditutup</h2>
            <p class="text-gray-600 mb-6">
                Mode publik saat ini: <span class="font-semibold">{{ $result_visibility_mode }}</span>.
                Hasil akan dibuka setelah pemungutan dinyatakan selesai oleh panitia.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                Kembali ke Beranda
            </a>
        </div>
    @elseif ($jenis_pemilihans->isEmpty())
        <div class="max-w-3xl mx-auto bg-white border border-slate-200 rounded-2xl p-8 text-center shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800 mb-3">Belum Ada Data Hasil</h2>
            <p class="text-gray-600 mb-6">
                Data kandidat untuk grafik hasil belum tersedia. Silakan cek kembali beberapa saat lagi.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                Kembali ke Beranda
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
            @foreach($jenis_pemilihans as $jenis)
                <div class="flex justify-center w-full">
                    <livewire:live-chart :jenis_pemilihan="$jenis" :key="'chart-'.$jenis" />
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
