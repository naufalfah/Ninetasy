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
            <h1 class="text-xl md:text-2xl font-bold tracking-tight text-gray-900">Manajemen Produk</h1>
            <p class="mt-1 text-xs md:text-sm text-gray-500">Kelola katalog produk, ketersediaan stok, harga, dan foto produk toko</p>
        </div>

        {{-- Alert Notifikasi Pesan Sukses --}}
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
                        <p class="text-xs md:text-sm font-bold text-red-800">Gagal menyimpan produk:</p>
                        <ul class="mt-1 list-disc list-inside text-xs text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Peringatan Jika Kategori Masih Kosong --}}
        @if ($kategori->isEmpty())
            <div class="mb-5 md:mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-2xl bg-amber-50 p-4 border border-amber-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs md:text-sm font-semibold text-amber-900">Belum Ada Kategori</p>
                        <p class="text-xs text-amber-700">Setiap produk wajib memiliki kategori. Silakan buat minimal satu kategori terlebih dahulu.</p>
                    </div>
                </div>
                <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-600 hover:bg-amber-700 text-white px-3.5 py-2 text-xs font-semibold shrink-0 transition">
                    + Tambah Kategori
                </a>
            </div>
        @endif

        {{-- Form Tambah Produk Baru (Responsif Tablet 2 Kolom) --}}
        <div class="mb-8 md:mb-10 rounded-3xl bg-white p-5 md:p-6 lg:p-8 shadow-sm ring-1 ring-black/5">
            <div class="mb-5 md:mb-6">
                <h2 class="text-base md:text-lg font-bold text-gray-900">Tambah Produk Baru</h2>
                <p class="text-xs text-gray-500">Masukkan rincian informasi produk dan unggah foto produk</p>
            </div>

            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
                    {{-- Nama Produk --}}
                    <div class="md:col-span-2">
                        <label for="nama_produk" class="block text-xs font-semibold text-gray-700 mb-1">Nama Produk</label>
                        <input
                            type="text"
                            name="nama_produk"
                            id="nama_produk"
                            value="{{ old('nama_produk') }}"
                            placeholder="Contoh: Kopi Susu Aren"
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
                        <label for="harga" class="block text-xs font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                        <input
                            type="number"
                            name="harga"
                            id="harga"
                            min="0"
                            value="{{ old('harga') }}"
                            placeholder="Contoh: 15000"
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
                            value="{{ old('stok') }}"
                            placeholder="Contoh: 50"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2 md:py-2.5 text-xs md:text-sm text-gray-800 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200"
                            required
                        >
                        @error('stok')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Foto Produk dengan Preview Instan (Tablet Touch-Friendly) --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="produk_gambar" class="block text-xs font-semibold text-gray-700 mb-1">Foto Produk (Maks. 4MB: JPG, PNG, WEBP)</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            <input
                                type="file"
                                name="produk_gambar"
                                id="produk_gambar"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                onchange="previewUploadImage(this)"
                                class="w-full text-xs md:text-sm text-gray-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#e8e4d8] file:text-gray-800 hover:file:bg-[#dcd7c8] file:cursor-pointer border border-gray-200 bg-gray-50/50 rounded-xl px-2 py-1.5"
                            >
                            {{-- Wadah Preview Gambar Baru --}}
                            <div id="image-preview-container" class="hidden shrink-0">
                                <img id="image-preview" src="#" alt="Preview" class="h-14 w-14 rounded-xl object-cover border border-gray-200 shadow-xs">
                            </div>
                        </div>
                        @error('produk_gambar')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="w-full sm:w-auto rounded-xl bg-gray-900 px-6 py-2.5 text-xs md:text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-gray-700 active:scale-[0.98] cursor-pointer"
                    >
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Data Produk (Dioptimalkan untuk Layar Tablet) --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-black/5">
            <div class="border-b border-gray-100 px-4 md:px-6 py-3.5 md:py-4 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-sm md:text-base text-gray-900">Daftar Produk</h2>
                    <p class="text-xs text-gray-500">Total {{ $produk->count() }} produk terdaftar</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs md:text-sm text-gray-600">
                    <thead class="bg-gray-50/80 text-[11px] md:text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="px-3 md:px-5 py-3 font-semibold text-center w-10 md:w-14">No</th>
                            <th class="px-3 md:px-5 py-3 font-semibold min-w-[160px] md:min-w-[200px]">Produk</th>
                            <th class="px-3 md:px-5 py-3 font-semibold">Kategori</th>
                            <th class="px-3 md:px-5 py-3 font-semibold text-right whitespace-nowrap">Harga</th>
                            <th class="px-3 md:px-5 py-3 font-semibold text-center">Stok</th>
                            <th class="px-3 md:px-5 py-3 font-semibold text-right w-28 md:w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($produk as $item)
                            <tr class="transition hover:bg-gray-50/70">
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="h-11 w-11 md:h-12 md:w-12 shrink-0 overflow-hidden rounded-xl bg-[#e8e4d8] shadow-xs">
                                            @if ($item->gambar)
                                                <img src="{{ asset('images/produk/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="flex h-full items-center justify-center text-[9px] md:text-[10px] text-gray-500 font-medium">Tanpa foto</div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate text-xs md:text-sm">{{ $item->nama_produk }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full bg-[#e8e4d8] px-2.5 py-0.5 md:px-3 md:py-1 text-[11px] md:text-xs font-semibold text-gray-800">
                                        {{ $item->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-right font-medium text-gray-900 whitespace-nowrap">
                                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-center whitespace-nowrap">
                                    @if ($item->stok > 10)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5 text-[11px] md:text-xs font-semibold">
                                            {{ $item->stok }}
                                        </span>
                                    @elseif ($item->stok > 0)
                                        <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 px-2 py-0.5 text-[11px] md:text-xs font-semibold">
                                            {{ $item->stok }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-50 text-red-600 px-2 py-0.5 text-[11px] md:text-xs font-semibold">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 md:px-5 py-3 md:py-3.5 text-right">
                                    <div class="inline-flex items-center gap-1.5 md:gap-2 justify-end">
                                        {{-- Tombol Edit --}}
                                        <a
                                            href="{{ route('admin.produk.edit', $item->id) }}"
                                            class="rounded-lg bg-[#e8e4d8] hover:bg-[#dcd7c8] text-gray-800 px-2.5 py-1.5 md:px-3 md:py-1.5 text-xs font-semibold transition duration-150"
                                        >
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk {{ $item->nama_produk }}?')">
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
                                <td colspan="6" class="px-4 md:px-6 py-10 md:py-12 text-center text-xs md:text-sm text-gray-500">
                                    Belum ada produk yang ditambahkan. Gunakan formulir di atas untuk menambahkan produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Script JavaScript untuk Preview Gambar Otomatis Saat Dipilih --}}
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
