@extends('layouts.admin')

@section('content')
    <div class="w-full px-4 py-6 sm:px-6 lg:px-8 max-w-3xl">
        {{-- Tombol Navigasi Kembali --}}
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-xl px-3.5 py-2 text-sm font-medium text-gray-600 transition hover:bg-white hover:text-gray-900">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Data Pengguna
            </a>
        </div>

        {{-- Card Form Edit Role User --}}
        <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
            <div class="mb-6">
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">Edit Peran Pengguna</h1>
                <p class="mt-1 text-sm text-gray-500">Ubah peran dan hak akses sistem untuk akun {{ $user->name }}</p>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('put')

                {{-- Nama User (Disabled) --}}
                <div>
                    <label for="name" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Pengguna</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ $user->name }}"
                        disabled
                        class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed outline-none"
                    >
                    <p class="text-[11px] text-gray-400 mt-1">Nama pengguna tidak dapat diubah dari form ini</p>
                </div>

                {{-- Email User (Display) --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        value="{{ $user->email }}"
                        disabled
                        class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed outline-none"
                    >
                </div>

                {{-- Pilihan Role --}}
                <div>
                    <label for="role" class="block text-xs font-semibold text-gray-700 mb-1.5">Peran Akses (Role)</label>
                    <select
                        name="role"
                        id="role"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                        required
                    >
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin (Akses Penuh Kelola Data)</option>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User (Akses Kasir & Transaksi)</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-3">
                    <button
                        type="submit"
                        class="rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                    >
                        Simpan Peran
                    </button>
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="rounded-xl bg-gray-100 hover:bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition duration-200"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
