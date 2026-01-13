@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8
            bg-gradient-to-br from-blue-900 via-blue-600 to-orange-500">


    <!-- Login Card -->
    <div class="w-full max-w-md">
        <!-- White Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="https://github.com/user-attachments/assets/6c156f10-b646-4a46-9157-a6829dd91d0c" 
                         alt="Logo Pemira" 
                         class="w-20 h-20 object-contain">
                </div>
                <h2 class="text-2xl font-bold text-blue-900">
                    LOGIN <span class="text-orange-500">PEMILIH</span>
                </h2>
                <p class="text-gray-500 text-sm mt-1">Masuk untuk menggunakan hak suara Anda</p>
            </div>

            <!-- Form Login -->
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="space-y-4">
                    <!-- Input NPM -->
                    <div class="space-y-2">
                        <label for="npm" class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            NPM
                        </label>
                        <input type="text" id="npm" name="npm" placeholder="Masukkan NPM"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 
                                   transition-all duration-300
                                   placeholder:text-gray-400">
                    </div>

                    <!-- Input Password -->
                    <div class="space-y-2">
                        <label for="password" class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••"
                                class="w-full px-4 py-3 bg-gray-100 border-0 rounded-xl
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 
                                       transition-all duration-300
                                       placeholder:text-gray-400 pr-10">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIcon" class="w-5 h-5 text-gray-400 hover:text-blue-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-red-700 text-sm">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tombol Login -->
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-blue-900
                           text-white font-semibold py-3.5 px-6 rounded-full shadow-lg
                           hover:bg-blue-800
                           transform hover:scale-[1.01] hover:shadow-xl
                           transition-all duration-300 ease-out
                           focus:outline-none focus:ring-4 focus:ring-blue-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 flex items-center justify-between pt-4 border-t border-gray-200">
                <a href="/" class="inline-flex items-center gap-2 text-blue-900 hover:text-orange-500 font-medium text-sm transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error -->
@if (session('error'))
<div id="errorModal" class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform animate-fadeIn">
        <div class="flex justify-between items-center p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-red-600">Kesalahan</h3>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition p-1 hover:bg-gray-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-5">
            <p class="text-gray-700">{{ session('error') }}</p>
        </div>
        <div class="p-5 pt-0 flex justify-end">
            <button onclick="closeModal()"
                class="bg-red-500 text-white px-5 py-2 rounded-xl shadow hover:bg-red-600 transition-all duration-300 font-medium">
                Tutup
            </button>
        </div>
    </div>
</div>
@endif

<!-- Modal Success -->
@if (session('success'))
<div id="successModal" class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform animate-fadeIn">
        <div class="flex justify-between items-center p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-green-600">Berhasil</h3>
            </div>
            <button onclick="closeSuccessModal()" class="text-gray-400 hover:text-gray-600 transition p-1 hover:bg-gray-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-5">
            <p class="text-gray-700">{{ session('success') }}</p>
        </div>
        <div class="p-5 pt-0 flex justify-end">
            <button onclick="closeSuccessModal()"
                class="bg-green-500 text-white px-5 py-2 rounded-xl shadow hover:bg-green-600 transition-all duration-300 font-medium">
                Tutup
            </button>
        </div>
    </div>
</div>
@endif

<!-- Scripts -->
<script>
    function closeModal() {
        document.getElementById('errorModal').classList.add('hidden');
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
    }

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>
@endsection
