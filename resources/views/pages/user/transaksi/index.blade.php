@extends('layouts.master')
@section('content')
    <div class="w-full px-4 py-6 sm:px-6">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_18rem]">
            <section class="min-w-0">
                <form action="{{ route('user.transaksi.index') }}" method="GET" class="relative mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <label class="relative min-w-0 flex-1">
                        <span class="sr-only">Cari produk</span>
                        <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path stroke-linecap="round" d="m20 20-4-4"></path>
                        </svg>
                        <input type="search" name="search" value="{{ $search }}" placeholder="Cari produk..." class="w-full rounded-xl border-0 bg-white py-3 pl-12 pr-4 shadow-md shadow-black/10 outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-gray-300">
                    </label>

                    <details class="group relative shrink-0">
                        <summary aria-label="Filter kategori" title="Filter kategori" class="flex h-12 w-12 cursor-pointer list-none items-center justify-center rounded-xl bg-white text-gray-800 shadow-md shadow-black/10 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 [&::-webkit-details-marker]:hidden">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10m-7 6h4"></path>
                            </svg>
                            @if ($kategoriId)
                                <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-blue-600"></span>
                            @endif
                        </summary>

                        <div class="absolute right-0 top-full z-50 mt-2 w-64 rounded-2xl bg-white p-4 shadow-xl ring-1 ring-black/5">
                            <label for="kategori_id" class="mb-2 block text-sm font-semibold text-gray-800">Filter kategori</label>
                            <select id="kategori_id" name="kategori_id" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 outline-none focus:border-gray-400 focus:ring-2 focus:ring-gray-200">
                                <option value="">Semua kategori</option>
                                @foreach ($kategori as $kategoriItem)
                                    <option value="{{ $kategoriItem->id }}" {{ (string) $kategoriId === (string) $kategoriItem->id ? 'selected' : '' }}>
                                        {{ $kategoriItem->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="mt-3 flex items-center justify-between gap-3">
                                @if ($search !== '' || $kategoriId)
                                    <a href="{{ route('user.transaksi.index') }}" class="text-sm text-gray-500 hover:text-gray-900">Reset</a>
                                @else
                                    <span></span>
                                @endif
                                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">Terapkan</button>
                            </div>
                        </div>
                    </details>
                </form>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach ($produk as $item)
                            <div class="group z-10 hover:scale-99 hover:-translate-y-2 transition duration-300">
                                <form action="{{ route('user.transaksi.tambah', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cursor-pointer text-left">
                                        <div class="flex flex-col items-stretch bg-white rounded-4xl p-6 shadow-2xl shadow-black/50">
                                            <div class="overflow-hidden rounded-3xl aspect-3/2 relative">
                                                <div class="absolute right-2 top-2 px-2 bg-yellow-500 rounded-lg">
                                                    <p class="text-white font-semibold">{{ $item->harga >= 1000 ? ($item->harga / 1000) . 'K' : $item->harga }}</p>
                                                </div>
                                                <div class="absolute left-2 top-2 px-2">
                                                    @if ($item->stok == 0)
                                                        <p class="text-xs bg-black rounded text-white text-center p-1">Habis</p>
                                                    @else 
                                                        @if ($item->stok <= 15)
                                                            <p class="text-xs bg-red-500 rounded text-white text-center p-1">Hampir habis</p>
                                                        @endif
                                                    @endif
                                                </div>
                                                <img src="{{ $item->gambar_url }}" class="object-cover aspect-3/2" alt="Gambar_{{ $item->nama_produk }}">
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <h1 class="text-lg my-3 font-semibold">{{ $item->nama_produk }}</h1>
                                                <p>{{ $item->nama_kategori }}</p>
                                            </div>
                                            <p>Sisa : {{ $item->stok }}</p>
                                            <p class="text-sm text-center mt-6 opacity-70 group-hover:opacity-100 transition duration-300">Klik untuk menambahkan</p>
                                        </div>
                                    </button>
                                </form>
                            </div>
                @endforeach
                </div>
                @if ($produk->isEmpty())
                    <p class="rounded-2xl bg-white px-5 py-8 text-center text-sm text-gray-500 shadow-sm">
                        Produk tidak ditemukan. Coba ubah kata pencarian atau kategori.
                    </p>
                @endif
            </section>

            {{-- Keranjang --}}
            <aside class="flex max-h-[calc(100vh-2rem)] flex-col rounded-3xl bg-white p-5 shadow-xl shadow-black/10 lg:fixed lg:right-5 lg:top-16 lg:z-30 lg:w-[18rem] lg:max-h-[calc(100vh-5rem)]">
                <div class="shrink-0 border-b border-gray-300 pb-3">
                    <h1 class="text-xl font-semibold text-gray-900">Detail Transaksi</h1>
                    <p class="mt-1 text-sm text-gray-500">#{{ str_pad((string) (count($keranjang) + 1), 3, '0', STR_PAD_LEFT) }}</p>
                </div>

                @if (count($keranjang) > 0)
                    <div class="min-h-0 flex-1 divide-y divide-gray-200 overflow-y-auto">
                        @foreach ($keranjang as $item)
                            <div class="flex items-center gap-3 py-4">
                                <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-stone-100">
                                    @if (!empty($item['gambar_url']))
                                        <img src="{{ $item['gambar_url'] }}" class="h-full w-full object-cover" alt="{{ $item['nama_produk'] }}">
                                    @elseif (!empty($item['gambar']))
                                        <img src="{{ str_starts_with($item['gambar'], 'data:') || str_starts_with($item['gambar'], 'http') ? $item['gambar'] : asset('images/produk/' . $item['gambar']) }}" class="h-full w-full object-cover" alt="{{ $item['nama_produk'] }}">
                                    @else
                                        <div class="flex h-full items-center justify-center text-[10px] text-gray-400">Produk</div>
                                    @endif
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900">{{ $item['nama_produk'] }}</p>
                                    <p class="text-xs text-gray-500">Rp{{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <form action="{{ route('user.transaksi.kurang', $item['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" aria-label="Kurangi {{ $item['nama_produk'] }}" class="flex h-6 w-6 items-center justify-center rounded-full bg-stone-100 text-sm hover:bg-stone-200">−</button>
                                        </form>
                                        <span class="min-w-4 text-center text-xs">{{ $item['qty'] }}</span>
                                        <form action="{{ route('user.transaksi.tambahQty', $item['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" aria-label="Tambah {{ $item['nama_produk'] }}" class="flex h-6 w-6 items-center justify-center rounded-full bg-stone-100 text-sm hover:bg-stone-200">+</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="flex shrink-0 flex-col items-end gap-2">
                                    <form action="{{ route('user.transaksi.hapus', $item['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" aria-label="Hapus {{ $item['nama_produk'] }}" class="text-lg leading-none text-red-500 hover:text-red-700">×</button>
                                    </form>
                                    <p class="text-xs font-semibold text-gray-900">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="shrink-0 border-t border-gray-300 pt-4">
                        <div class="flex justify-between text-sm font-semibold">
                            <span>Subtotal</span>
                            <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('user.transaksi.store') }}" method="POST" class="mt-5">
                            @csrf
                            <label for="uang_bayar" class="mb-2 block text-sm font-semibold text-gray-800">Pembayaran tunai</label>
                            <div class="flex items-center rounded-xl border border-gray-300 px-3 focus-within:border-gray-500">
                                <span class="text-sm text-gray-500">Rp</span>
                                <input type="number" id="uang_bayar" name="uang_bayar" min="1" step="1" value="{{ old('uang_bayar') }}" placeholder="Masukkan uang bayar" required class="w-full border-0 bg-transparent px-2 py-3 text-sm outline-none focus:ring-0">
                            </div>
                            @error('uang_bayar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="mt-3 flex justify-between text-sm">
                                <span class="text-gray-600">Kembalian</span>
                                <span id="kembalian" data-total="{{ $total }}" class="font-medium">Rp0</span>
                            </div>

                            <button type="submit" class="mt-5 w-full rounded-xl bg-[#e8e4d8] px-4 py-3 text-sm font-semibold text-gray-900 transition hover:bg-[#dcd7c8] focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                                Bayar
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex flex-1 flex-col items-center justify-center py-10 text-center">
                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-stone-100 text-2xl text-gray-400">＋</div>
                        <p class="font-medium text-gray-700">Keranjang masih kosong</p>
                        <p class="mt-1 text-sm text-gray-500">Pilih produk untuk memulai transaksi.</p>
                    </div>
                @endif
            </aside>
        </div>
    </div>

    <script>
        const uangBayarInput = document.getElementById('uang_bayar');
        const kembalianLabel = document.getElementById('kembalian');

        if (uangBayarInput && kembalianLabel) {
            const formatRupiah = (amount) => new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(amount);

            const updateKembalian = () => {
                const total = Number(kembalianLabel.dataset.total);
                const uangBayar = Number(uangBayarInput.value || 0);
                kembalianLabel.textContent = formatRupiah(Math.max(uangBayar - total, 0));
            };

            uangBayarInput.addEventListener('input', updateKembalian);
            updateKembalian();
        }
    </script>
@endsection
