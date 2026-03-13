@extends('layouts.app')

@section('content')
    @php
        $statusMap = [
            'not_voted' => [
                'label' => 'Belum Memilih',
                'badge' => 'bg-gray-100 text-gray-700 border border-gray-300',
                'next' => 'Silakan lanjutkan memilih kandidat.',
            ],
            'pending' => [
                'label' => 'Sedang Diproses',
                'badge' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                'next' => 'Vote sudah masuk antrean. Tunggu beberapa saat lalu refresh halaman.',
            ],
            'completed' => [
                'label' => 'Selesai',
                'badge' => 'bg-green-100 text-green-800 border border-green-300',
                'next' => 'Vote sudah tercatat. Tidak perlu submit ulang.',
            ],
            'failed' => [
                'label' => 'Gagal',
                'badge' => 'bg-red-100 text-red-700 border border-red-300',
                'next' => 'Terjadi kendala sistem. Silakan coba submit ulang.',
            ],
        ];

        $defaultStatus = $statusMap['not_voted'];
        $presmaMeta = $statusMap[$presma_status] ?? $defaultStatus;
        $himaMeta = $statusMap[$hima_status] ?? $defaultStatus;
        $isSpecialHima = \App\Support\PemiraConfig::isSpecialHima($hima_type);
        $presmaLocked = \App\Models\Pemilih::isLockedVoteStatus($presma_status);
        $himaLocked = \App\Models\Pemilih::isLockedVoteStatus($hima_status);
        $allVotesLocked = $isSpecialHima ? $presmaLocked : ($presmaLocked && $himaLocked);
    @endphp

    <div class="w-full max-w-4xl space-y-6">
        <div class="bg-white/95 shadow-lg rounded-2xl p-6 border border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">Status Hak Suara</h2>
            <p class="text-sm text-slate-600 mt-1">
                Pastikan status sudah sesuai sebelum meninggalkan halaman.
            </p>

            <div class="grid gap-4 mt-4 {{ $isSpecialHima ? 'grid-cols-1' : 'grid-cols-1 md:grid-cols-2' }}">
                <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
                    <div class="flex items-center justify-between gap-3">
                        <p class="font-semibold text-slate-800">Presma</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $presmaMeta['badge'] }}">
                            {{ $presmaMeta['label'] }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-600 mt-2">{{ $presmaMeta['next'] }}</p>
                </div>

                @unless ($isSpecialHima)
                    <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-semibold text-slate-800">HIMA</p>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $himaMeta['badge'] }}">
                                {{ $himaMeta['label'] }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mt-2">{{ $himaMeta['next'] }}</p>
                    </div>
                @endunless
            </div>
        </div>

        @if ($allVotesLocked)
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="font-semibold text-blue-900">Seluruh hak suara Anda sudah terkunci.</p>
                    <p class="text-sm text-blue-700 mt-1">Anda bisa melihat hasil sementara atau logout dari sesi pemilih.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('hasilvote') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                        Lihat Hasil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-white border border-blue-300 text-blue-700 font-semibold hover:bg-blue-100 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <div>
            @include('hima.hima')
        </div>
    </div>
    @if (session('success'))
        <div id="successModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-lg font-semibold text-green-600">Berhasil</h3>
                    <button onclick="closeModal('successModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-4 text-gray-700">
                    <p>{{ session('success') }}</p>
                </div>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeModal('successModal')" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div id="errorModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-lg font-semibold text-red-600">Kesalahan</h3>
                    <button onclick="closeModal('errorModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-4 text-gray-700">
                    <p>{{ session('error') }}</p>
                </div>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeModal('errorModal')" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script>
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
            }
        }
    </script>
@endpush
