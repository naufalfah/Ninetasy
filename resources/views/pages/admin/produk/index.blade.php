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
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Manajemen Produk</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola katalog barang, ketersediaan stok, harga, dan kategori toko Ninetasy</p>
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

        {{-- Form Tambah Produk Baru --}}
        <div class="mb-10 rounded-3xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900">Tambah Produk Baru</h2>
                <p class="text-xs text-gray-500">Isi formulir di bawah ini untuk menambahkan barang ke dalam sistem</p>
            </div>

            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    {{-- Nama Produk --}}
                    <div class="sm:col-span-2">
                        <label for="nama_produk" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Produk</label>
                        <input
                            type="text"
                            name="nama_produk"
                            id="nama_produk"
                            value="{{ old('nama_produk') }}"
                            placeholder="Contoh: Kopi Susu Aren"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('nama_produk')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori_id" class="block text-xs font-semibold text-gray-700 mb-1.5">Kategori</label>
                        <select
                            name="kategori_id"
                            id="kategori_id"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                            <option value="" disabled selected>Pilih kategori</option>
                            @forelse ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada kategori</option>
                            @endforelse
                        </select>
                        @error('kategori_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label for="harga" class="block text-xs font-semibold text-gray-700 mb-1.5">Harga (Rp)</label>
                        <input
                            type="number"
                            name="harga"
                            id="harga"
                            min="0"
                            value="{{ old('harga') }}"
                            placeholder="Contoh: 15000"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('harga')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label for="stok" class="block text-xs font-semibold text-gray-700 mb-1.5">Jumlah Stok</label>
                        <input
                            type="number"
                            name="stok"
                            id="stok"
                            min="0"
                            value="{{ old('stok') }}"
                            placeholder="Contoh: 50"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('stok')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto / Gambar Produk --}}
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label for="produk_gambar" class="block text-xs font-semibold text-gray-700 mb-1.5">Foto Produk (Opsional)</label>
                        <input
                            type="file"
                            name="produk_gambar"
                            id="produk_gambar"
                            accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#e8e4d8] file:text-gray-800 hover:file:bg-[#dcd7c8] file:cursor-pointer border border-gray-200 bg-gray-50/50 rounded-xl px-2 py-1.5"
                        >
                        @error('produk_gambar')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                    >
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Data Produk --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-black/5">
            <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-900">Daftar Produk</h2>
                    <p class="text-xs text-gray-500">Total {{ $produk->count() }} produk terdaftar di sistem</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/80 text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3.5 font-semibold text-center w-16">No</th>
                            <th class="px-6 py-3.5 font-semibold">Produk</th>
                            <th class="px-6 py-3.5 font-semibold">Kategori</th>
                            <th class="px-6 py-3.5 font-semibold text-right">Harga</th>
                            <th class="px-6 py-3.5 font-semibold text-center">Stok</th>
                            <th class="px-6 py-3.5 font-semibold text-right w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($produk as $item)
                            <tr class="transition hover:bg-gray-50/70">
                                <td class="px-6 py-4 text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-[#e8e4d8] shadow-xs">
                                            @if ($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="flex h-full items-center justify-center text-[10px] text-gray-500">Tanpa foto</div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate">{{ $item->nama_produk }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full bg-[#e8e4d8] px-3 py-1 text-xs font-semibold text-gray-800">
                                        {{ $item->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-900">
                                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($item->stok > 10)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 px-2.5 py-0.5 text-xs font-semibold">
                                            {{ $item->stok }}
                                        </span>
                                    @elseif ($item->stok > 0)
                                        <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 px-2.5 py-0.5 text-xs font-semibold">
                                            {{ $item->stok }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-50 text-red-600 px-2.5 py-0.5 text-xs font-semibold">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a
                                            href="{{ route('admin.produk.edit', $item->id) }}"
                                            class="rounded-lg bg-[#e8e4d8] hover:bg-[#dcd7c8] text-gray-800 px-3 py-1.5 text-xs font-semibold transition duration-150"
                                        >
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $item->nama_produk }}?')">
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
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                    Belum ada produk yang ditambahkan. Gunakan form di atas untuk menambah produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
