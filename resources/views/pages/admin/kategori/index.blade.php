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
            <h1 class="text-xl md:text-2xl font-bold tracking-tight text-gray-900">Kategori Produk</h1>
            <p class="mt-1 text-xs md:text-sm text-gray-500">Kelola klasifikasi dan kelompok produk pada toko Ninetasy</p>
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

        {{-- Layout Grid: Form Tambah Kategori & Tabel (Responsif Tablet) --}}
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            {{-- Form Tambah Kategori --}}
            <div class="lg:col-span-1">
                <div class="rounded-3xl bg-white p-5 md:p-6 shadow-sm ring-1 ring-black/5">
                    <h2 class="text-base md:text-lg font-bold text-gray-900 mb-1">Tambah Kategori</h2>
                    <p class="text-xs text-gray-500 mb-4 md:mb-5">Tambahkan kelompok baru untuk produk</p>

                    <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="nama_kategori" class="block text-xs font-semibold text-gray-700 mb-1">Nama Kategori</label>
                            <input
                                type="text"
                                name="nama_kategori"
                                id="nama_kategori"
                                placeholder="Contoh: Minuman Dingin, Snack"
                                value="{{ old('nama_kategori') }}"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                                required
                            >
                            @error('nama_kategori')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-gray-900 px-5 py-2.5 text-xs md:text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                        >
                            Tambahkan Kategori
                        </button>
                    </form>
                </div>
            </div>

            {{-- Tabel Data Kategori --}}
            <div class="lg:col-span-2">
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-black/5">
                    <div class="border-b border-gray-100 px-4 md:px-6 py-3.5 md:py-4 flex items-center justify-between">
                        <div>
                            <h2 class="font-bold text-sm md:text-base text-gray-900">Daftar Kategori</h2>
                            <p class="text-xs text-gray-500">Total {{ $kategori->count() }} kategori terdaftar</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs md:text-sm text-gray-600">
                            <thead class="bg-gray-50/80 text-[11px] md:text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                                <tr>
                                    <th class="px-3 md:px-5 py-3 font-semibold text-center w-12">No</th>
                                    <th class="px-3 md:px-5 py-3 font-semibold">Nama Kategori</th>
                                    <th class="px-3 md:px-5 py-3 font-semibold text-center whitespace-nowrap">Digunakan</th>
                                    <th class="px-3 md:px-5 py-3 font-semibold text-right w-28 md:w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($kategori as $item)
                                    <tr class="transition hover:bg-gray-50/70">
                                        <td class="px-3 md:px-5 py-3 md:py-3.5 text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-3 md:px-5 py-3 md:py-3.5 font-semibold text-gray-900 text-xs md:text-sm">{{ $item->nama_kategori }}</td>
                                        <td class="px-3 md:px-5 py-3 md:py-3.5 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center rounded-full bg-[#e8e4d8] px-2.5 py-0.5 md:px-3 md:py-1 text-[11px] md:text-xs font-semibold text-gray-800">
                                                {{ $item->produk_count }} Produk
                                            </span>
                                        </td>
                                        <td class="px-3 md:px-5 py-3 md:py-3.5 text-right">
                                            <div class="inline-flex items-center gap-1.5 md:gap-2 justify-end">
                                                {{-- Tombol Edit --}}
                                                <a
                                                    href="{{ route('admin.kategori.edit', $item->id) }}"
                                                    class="rounded-lg bg-[#e8e4d8] hover:bg-[#dcd7c8] text-gray-800 px-2.5 py-1.5 md:px-3 md:py-1.5 text-xs font-semibold transition duration-150"
                                                >
                                                    Edit
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $item->nama_kategori }}?')">
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
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 md:px-6 py-10 md:py-12 text-center text-xs md:text-sm text-gray-500">
                                            Belum ada kategori yang dibuat. Gunakan formulir untuk menambahkan kategori baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
