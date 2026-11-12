@extends('layouts.admin')

@section('content')
    <div class="w-full max-w-4xl">
        {{-- Tombol Navigasi Kembali --}}
        <div class="mb-4 md:mb-6">
            <a href="{{ route('admin.produk.index') }}" class="inline-flex items-center gap-2 rounded-xl px-3 py-1.5 md:px-3.5 md:py-2 text-xs md:text-sm font-medium text-gray-600 transition hover:bg-white hover:text-gray-900">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        {{-- Alert Notifikasi Error Validasi --}}
        @if ($errors->any())
            <div class="mb-5 md:mb-6 rounded-2xl bg-red-50 p-3.5 md:p-4 border-l-4 border-red-500 shadow-sm ring-1 ring-red-200">
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs md:text-sm font-bold text-red-800">Gagal memperbarui produk:</p>
                        <ul class="mt-1 list-disc list-inside text-xs text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Card Form Edit Produk --}}
        <div class="rounded-3xl bg-white p-5 md:p-6 lg:p-8 shadow-sm ring-1 ring-black/5">
            <div class="mb-5 md:mb-6">
                <h1 class="text-xl md:text-2xl font-bold tracking-tight text-gray-900">Edit Produk</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-500">Perbarui rincian informasi dan foto produk {{ $produk->nama_produk }}</p>
            </div>

            <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-5">
                @csrf
                @method('put')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    {{-- Nama Produk --}}
                    <div class="md:col-span-2">
                        <label for="nama_produk" class="block text-xs font-semibold text-gray-700 mb-1">Nama Produk</label>
                        <input
                            type="text"
                            name="nama_produk"
                            id="nama_produk"
                            value="{{ old('nama_produk', $produk->nama_produk) }}"
                            placeholder="Nama produk"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('nama_produk')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori_id" class="block text-xs font-semibold text-gray-700 mb-1">Kategori</label>
                        <select
                            name="kategori_id"
                            id="kategori_id"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
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
                        <label for="harga" class="block text-xs font-semibold text-gray-700 mb-1">Harga Satuan (Rp)</label>
                        <input
                            type="number"
                            name="harga"
                            id="harga"
                            min="0"
                            value="{{ old('harga', $produk->harga) }}"
                            placeholder="Harga produk"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('harga')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label for="stok" class="block text-xs font-semibold text-gray-700 mb-1">Jumlah Stok</label>
                        <input
                            type="number"
                            name="stok"
                            id="stok"
                            min="0"
                            value="{{ old('stok', $produk->stok) }}"
                            placeholder="Jumlah stok"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('stok')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto Produk & Preview --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Foto Produk</label>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-3">
                            {{-- Foto Saat Ini --}}
                            @if ($produk->gambar)
                                <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-gray-50 border border-gray-200 shrink-0">
                                    <img src="{{ asset('images/produk/' . $produk->gambar) }}" alt="Gambar_{{ $produk->nama_produk }}" class="h-14 w-14 md:h-16 md:w-16 rounded-xl object-cover shadow-xs bg-[#e8e4d8]">
                                    <div class="text-left">
                                        <p class="text-xs font-semibold text-gray-800">Foto Saat Ini</p>
                                        <p class="text-[10px] text-gray-500">Tersimpan di server</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Wadah Preview Foto Baru jika Dipilih --}}
                            <div id="image-preview-container" class="hidden flex items-center gap-3 p-2.5 rounded-2xl bg-emerald-50/70 border border-emerald-200 shrink-0">
                                <img id="image-preview" src="#" alt="Preview Foto Baru" class="h-14 w-14 md:h-16 md:w-16 rounded-xl object-cover shadow-xs">
                                <div class="text-left">
                                    <p class="text-xs font-semibold text-emerald-800">Foto Baru</p>
                                    <p class="text-[10px] text-emerald-600">Akan menggantikan foto lama</p>
                                </div>
                            </div>
                        </div>

                        <input
                            type="file"
                            name="produk_gambar"
                            id="produk_gambar"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            onchange="previewUploadImage(this)"
                            class="w-full text-xs md:text-sm text-gray-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#e8e4d8] file:text-gray-800 hover:file:bg-[#dcd7c8] file:cursor-pointer border border-gray-200 bg-gray-50/50 rounded-xl px-2 py-1.5"
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
                        class="rounded-xl bg-gray-900 px-5 md:px-6 py-2.5 text-xs md:text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                    <a
                        href="{{ route('admin.produk.index') }}"
                        class="rounded-xl bg-gray-100 hover:bg-gray-200 px-4 md:px-5 py-2.5 text-xs md:text-sm font-semibold text-gray-700 transition duration-200"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Script JavaScript untuk Preview Foto Baru --}}
    <script>
        function previewUploadImage(input) {
            const previewContainer = document.getElementById('image-preview-container');
            const previewImg = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    </script>
@endsection
