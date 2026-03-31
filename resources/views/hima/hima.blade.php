<div class="space-y-8 w-full max-w-2xl">
    @include('presma.presma')

    @if (($show_hima ?? false) && $hima_type && \Illuminate\Support\Facades\View::exists('hima.' . $hima_type))
        @include('hima.' . $hima_type)
    @elseif (($show_hima ?? false) && $hima_type)
        <div class="bg-white border border-red-200 text-red-700 rounded-xl p-4 text-center space-y-3">
            <p>Mapping HIMA tidak ditemukan untuk prodi ini.</p>
            <a href="{{ route('hasilvote') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                Lihat Hasil Sementara
            </a>
        </div>
    @endif
</div>
