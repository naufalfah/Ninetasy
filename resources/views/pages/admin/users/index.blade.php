@extends('layouts.admin')

@section('content')
    <div class="w-full">
        {{-- Tombol Navigasi Kembali --}}
        <div class="mb-4 md:mb-6">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 md:px-3.5 md:py-2 text-xs md:text-sm font-medium text-gray-600 transition hover:bg-white hover:text-gray-900">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Header Halaman --}}
        <div class="mb-6 md:mb-8">
            <h1 class="text-xl md:text-2xl font-bold tracking-tight text-gray-900">Manajemen Pengguna</h1>
            <p class="mt-1 text-xs md:text-sm text-gray-500">Kelola akun pengguna, peran akses (Admin / User), dan keamanan sistem</p>
        </div>

        {{-- Alert Notifikasi Pesan --}}
        @if (session('pesan'))
            <div class="mb-5 md:mb-6 flex items-center justify-between gap-3 rounded-2xl bg-white p-3.5 md:p-4 shadow-sm ring-1 ring-black/5 border-l-4 border-emerald-500">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-xs md:text-sm font-medium text-gray-800">{{ session('pesan') }}</p>
                </div>
            </div>
        @endif

        {{-- Form Tambah User Baru (Responsif Tablet 2 Kolom) --}}
        <div class="mb-8 md:mb-10 rounded-3xl bg-white p-5 md:p-6 lg:p-8 shadow-sm ring-1 ring-black/5">
            <div class="mb-5 md:mb-6">
                <h2 class="text-base md:text-lg font-bold text-gray-900">Tambah Pengguna Baru</h2>
                <p class="text-xs text-gray-500">Daftarkan akun pengguna baru beserta peran aksesnya</p>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 md:space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Budi Santoso"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="budi@ninetasy.test"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Minimal 6 karakter"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-xs font-semibold text-gray-700 mb-1">Peran Akses (Role)</label>
                        <select
                            name="role"
                            id="role"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Kasir)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="w-full sm:w-auto rounded-xl bg-gray-900 px-6 py-2.5 text-xs md:text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                    >
                        Tambahkan Pengguna
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Data Users (Tablet-Friendly) --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-black/5">
            <div class="border-b border-gray-100 px-4 md:px-6 py-3.5 md:py-4 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-sm md:text-base text-gray-900">Daftar Pengguna</h2>
                    <p class="text-xs text-gray-500">Total {{ $user->count() }} pengguna terdaftar</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs md:text-sm text-gray-600">
                    <thead class="bg-gray-50/80 text-[11px] md:text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="px-3 md:px-5 py-3 font-semibold text-center w-12">No</th>
                            <th class="px-3 md:px-5 py-3 font-semibold min-w-[140px]">Pengguna</th>
                            <th class="px-3 md:px-5 py-3 font-semibold min-w-[150px]">Email</th>
                            <th class="px-3 md:px-5 py-3 font-semibold text-center whitespace-nowrap">Role</th>
                            <th class="px-3 md:px-5 py-3 font-semibold text-right w-28 md:w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($user as $item)
                            <tr class="transition hover:bg-gray-50/70">
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5">
                                    <div class="flex items-center gap-2.5 md:gap-3">
                                        <div class="h-8 w-8 md:h-9 md:w-9 shrink-0 rounded-xl bg-[#e8e4d8] text-amber-900 flex items-center justify-center font-bold text-xs shadow-xs">
                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-gray-900 text-xs md:text-sm truncate">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-gray-600 text-xs md:text-sm">{{ $item->email }}</td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-center whitespace-nowrap">
                                    @if ($item->role === 'admin')
                                        <span class="inline-flex items-center rounded-full bg-amber-100 text-amber-900 border border-amber-300/40 px-2.5 py-0.5 md:px-3 md:py-1 text-[11px] md:text-xs font-bold uppercase tracking-wider">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-0.5 md:px-3 md:py-1 text-[11px] md:text-xs font-semibold uppercase tracking-wider">
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-right">
                                    <div class="inline-flex items-center gap-1.5 md:gap-2 justify-end">
                                        {{-- Tombol Edit Role --}}
                                        <a
                                            href="{{ route('admin.users.edit', $item->id) }}"
                                            class="rounded-lg bg-[#e8e4d8] hover:bg-[#dcd7c8] text-gray-800 px-2.5 py-1.5 md:px-3 md:py-1.5 text-xs font-semibold transition duration-150"
                                        >
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun {{ $item->name }}?')">
                                            @csrf
                                            @method('delete')
                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-800 px-2.5 py-1.5 md:px-3 md:py-1.5 text-xs font-semibold transition duration-150 cursor-pointer"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
