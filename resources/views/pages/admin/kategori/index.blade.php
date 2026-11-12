@extends('layouts.admin')

@section('content')
    <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
        {{-- Tombol Navigasi Kembali --}}
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl px-3.5 py-2 text-sm font-medium text-gray-600 transition hover:bg-white hover:text-gray-900">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Header Halaman --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Kategori Produk</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola kelompok dan klasifikasi produk pada toko Ninetasy</p>
        </div>

        {{-- Alert Notifikasi Pesan --}}
        @if (session('pesan'))
            <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-black/5 border-l-4 border-emerald-500">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-800">{{ session('pesan') }}</p>
                </div>
            </div>
        @endif

        {{-- Layout Grid: Form Tambah Kategori (Kiri/Atas) & Daftar Kategori (Kanan/Bawah) --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Form Tambah Kategori --}}
            <div class="lg:col-span-1">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Tambah Kategori</h2>
                    <p class="text-xs text-gray-500 mb-5">Tambahkan kategori baru untuk produk</p>

                    <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="nama_kategori" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Kategori</label>
                            <input
                                type="text"
                                name="nama_kategori"
                                id="nama_kategori"
                                placeholder="Contoh: Minuman, Makanan"
                                value="{{ old('nama_kategori') }}"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                                required
                            >
                            @error('nama_kategori')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                        >
                            Tambahkan Kategori
                        </button>
                    </form>
                </div>
            </div>

            {{-- Tabel Data Kategori --}}
            <div class="lg:col-span-2">
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-black/5">
                    <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h2 class="font-bold text-gray-900">Daftar Kategori</h2>
                            <p class="text-xs text-gray-500">Total {{ $kategori->count() }} kategori terdaftar</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50/80 text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3.5 font-semibold text-center w-16">No</th>
                                    <th class="px-6 py-3.5 font-semibold">Nama Kategori</th>
                                    <th class="px-6 py-3.5 font-semibold text-center">Jumlah Produk</th>
                                    <th class="px-6 py-3.5 font-semibold text-right w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($kategori as $item)
                                    <tr class="transition hover:bg-gray-50/70">
                                        <td class="px-6 py-4 text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nama_kategori }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center rounded-full bg-[#e8e4d8] px-3 py-1 text-xs font-semibold text-gray-800">
                                                {{ $item->produk_count }} Produk
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="inline-flex items-center gap-2">
                                                {{-- Tombol Edit --}}
                                                <a
                                                    href="{{ route('admin.kategori.edit', $item->id) }}"
                                                    class="rounded-lg bg-[#e8e4d8] hover:bg-[#dcd7c8] text-gray-800 px-3 py-1.5 text-xs font-semibold transition duration-150"
                                                >
                                                    Edit
                                                </a>

                                                {{-- Tombol Delete --}}
                                                <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $item->nama_kategori }}?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button
                                                        type="submit"
                                                        class="rounded-lg bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-800 px-3 py-1.5 text-xs font-semibold transition duration-150 cursor-pointer"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                            Belum ada data kategori. Tambahkan kategori baru di sebelah kiri.
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
