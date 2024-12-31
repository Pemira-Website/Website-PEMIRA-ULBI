@extends('layouts.app')

@section('content')
    <!-- Container Utama -->
    <div class="bg-white p-8 rounded-lg shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px] w-full max-w-md">
        <!-- Title -->
        <h2 class="text-center text-3xl font-extrabold text-blue-900 mb-6">LOGIN <span
                class="text-orange-500">PEMILIH</span></h2>

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
        <!-- Modal Error -->
        @if (session('error'))
            <div id="errorModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center border-b pb-3">
                        <h3 class="text-lg font-semibold text-red-600">Kesalahan</h3>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="mt-4 text-gray-700">
                        <p>{{ session('error') }}</p>
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 flex justify-end">
                        <button onclick="closeModal()"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Script Modal -->
        <script>
            function closeModal() {
                document.getElementById('errorModal').classList.add('hidden');
            }
        </script>
    </div>
@endsection