@extends('layouts.admin')

@section('content')
    <div class="w-full px-4 py-6 sm:px-6 lg:px-8 max-w-4xl">
        {{-- Tombol Navigasi Kembali --}}
        <div class="mb-6">
            <a href="{{ route('admin.produk.index') }}" class="inline-flex items-center gap-2 rounded-xl px-3.5 py-2 text-sm font-medium text-gray-600 transition hover:bg-white hover:text-gray-900">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        {{-- Card Form Edit Produk --}}
        <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
            <div class="mb-6">
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900">Edit Produk</h1>
                <p class="mt-1 text-sm text-gray-500">Perbarui rincian informasi produk {{ $produk->nama_produk }}</p>
            </div>

            <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('put')

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    {{-- Nama Produk --}}
                    <div class="sm:col-span-2">
                        <label for="nama_produk" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Produk</label>
                        <input
                            type="text"
                            name="nama_produk"
                            id="nama_produk"
                            value="{{ old('nama_produk', $produk->nama_produk) }}"
                            placeholder="Nama produk"
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
                            @forelse ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori_id', $produk->kategori_id) == $item->id ? 'selected' : '' }}>
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
                        <label for="harga" class="block text-xs font-semibold text-gray-700 mb-1.5">Harga Satuan (Rp)</label>
                        <input
                            type="number"
                            name="harga"
                            id="harga"
                            min="0"
                            value="{{ old('harga', $produk->harga) }}"
                            placeholder="Harga produk"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('harga')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label for="stok" class="block text-xs font-semibold text-gray-700 mb-1.5">Kuantitas Stok</label>
                        <input
                            type="number"
                            name="stok"
                            id="stok"
                            min="0"
                            value="{{ old('stok', $produk->stok) }}"
                            placeholder="Jumlah stok"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('stok')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto Produk & Preview --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Foto Produk</label>

                        @if ($produk->gambar)
                            <div class="mb-3 flex items-center gap-4 p-3 rounded-2xl bg-gray-50 border border-gray-200 w-fit">
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar_{{ $produk->nama_produk }}" class="h-20 w-20 rounded-xl object-cover shadow-xs bg-[#e8e4d8]">
                                <div>
                                    <p class="text-xs font-semibold text-gray-800">Foto Saat Ini</p>
                                    <p class="text-[11px] text-gray-500">Unggah file baru di bawah jika ingin mengganti</p>
                                </div>
                            </div>
                        @endif

                        <input
                            type="file"
                            name="produk_gambar"
                            id="produk_gambar"
                            accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#e8e4d8] file:text-gray-800 hover:file:bg-[#dcd7c8] file:cursor-pointer border border-gray-200 bg-gray-50/50 rounded-xl px-2 py-1.5"
                        >
                        <input type="hidden" name="produk_gambar_lama" value="{{ $produk->gambar }}">
                        @error('produk_gambar')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-3">
                    <button
                        type="submit"
                        class="rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                    <a
                        href="{{ route('admin.produk.index') }}"
                        class="rounded-xl bg-gray-100 hover:bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition duration-200"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
