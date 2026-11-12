@extends('layouts.auth')
@section('auth')
    <div class="min-h-screen w-full flex justify-center items-center bg-gray-100">
        <div class="max-w-sm w-full py-10 px-11 bg-white shadow-2xl shadow-black/50 ring-1 ring-black/10 rounded-3xl">
            {{-- Judul --}}
            <div class="flex flex-col gap-2 mb-8">
                <h1 class="text-3xl font-semibold">Register</h1>
                <p class="text-sm">Buat akun anda.</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('register.proses') }}" method="POST" class="flex flex-col mb-5">
                
                {{-- Isi --}}
                <div class="flex flex-col gap-5 mb-10">
                    <div class="flex flex-col gap-2">
                        <label for="" class="block text-amber-900 text-sm">Nama Lengkap</label>
                        <input type="text" name="name" id="" placeholder="Email Anda" class="w-full border border-black/50 px-4 py-3 rounded-lg text-sm" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="" class="block text-amber-900 text-sm">Masukkan Email</label>
                        <input type="email" name="email" id="" placeholder="Email Anda" class="w-full border border-black/50 px-4 py-3 rounded-lg text-sm" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="" class="block text-amber-900 text-sm">Kata Sandi</label>
                        <input type="password" name="password" id="" placeholder="Kata Sandi" class="w-full border border-black/50 px-4 py-3 rounded-lg text-sm" required>
                    </div>
                    @if (session('pesan'))
                        <p class="text-xs text-red-500 w-full bg-gray-300 px-4 py-3 rounded-lg">{{ session('pesan') }}</p>
                    @endif
                </div>

                <button type="submit" class="bg-gray-200 rounded-lg py-3 text-sm font-semibold hover:bg-gray-300 transition duration-300 cursor-pointer">Register</button>
            </form>

            {{-- Register --}}
            <p class="text-xs text-gray-600 text-center">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-amber-900 hover:underline font-semibold">Masuk</a>
            </p>

        </div>
    </div>
@endsection