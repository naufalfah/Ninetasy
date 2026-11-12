@extends('layouts.master')

@section('content')
    <main class="min-h-screen px-5 py-7 sm:px-8 lg:px-10">
        <div class="mx-auto max-w-5xl">
            <a href="{{ route('user.transaksi.riwayat') }}" class="mb-6 inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-white hover:text-gray-900">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"></path>
                </svg>
                Kembali ke riwayat
            </a>

            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Rincian pembelian</p>
                    <h1 class="mt-1 text-2xl font-semibold text-gray-900">Detail transaksi</h1>
                </div>
                <span class="rounded-full bg-[#e8e4d8] px-4 py-2 text-sm font-semibold text-gray-800">
                    #A{{ str_pad((string) $transaksi->id, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            <section class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
                <div class="rounded-2xl bg-white p-4 shadow-sm sm:p-5">
                    <p class="text-xs font-medium text-gray-500">Tanggal transaksi</p>
                    <p class="mt-2 text-sm font-semibold text-gray-900">{{ \Illuminate\Support\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</p>
                </div>
                <div class="rounded-2xl bg-white p-4 shadow-sm sm:p-5">
                    <p class="text-xs font-medium text-gray-500">Total belanja</p>
                    <p class="mt-2 text-sm font-semibold text-gray-900">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-2xl bg-white p-4 shadow-sm sm:p-5">
                    <p class="text-xs font-medium text-gray-500">Pembayaran dan kembalian</p>
                    <p class="mt-2 text-sm font-semibold text-gray-900">Rp{{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-gray-500">Kembalian Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 px-4 py-4 sm:px-6">
                    <div>
                        <h2 class="font-semibold text-gray-900">Produk yang dibeli</h2>
                        <p class="mt-1 text-xs text-gray-500">{{ $transaksi->detailTransaksi->count() }} item dalam transaksi ini</p>
                    </div>
                </div>

                <div class="hidden grid-cols-[minmax(0,1fr)_7rem_5rem_8rem] gap-4 bg-gray-50 px-6 py-3 text-xs font-medium text-gray-500 sm:grid">
                    <span>Produk</span>
                    <span class="text-right">Harga</span>
                    <span class="text-center">Qty</span>
                    <span class="text-right">Subtotal</span>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($transaksi->detailTransaksi as $item)
                        <div class="grid grid-cols-1 gap-3 px-4 py-4 sm:grid-cols-[minmax(0,1fr)_7rem_5rem_8rem] sm:items-center sm:gap-4 sm:px-6">
                            <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-[#e8e4d8] shadow-sm sm:h-14 sm:w-14">
                                    @if ($item->produk?->gambar)
                                        <img src="{{ $item->produk->gambar_url }}" alt="{{ $item->produk->nama_produk }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full items-center justify-center text-[10px] text-gray-500">Tanpa gambar</div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-900">{{ $item->produk?->nama_produk ?? 'Produk tidak tersedia' }}</p>
                                    <p class="mt-1 text-xs text-gray-500 sm:hidden">Rp{{ number_format($item->harga, 0, ',', '.') }} × {{ $item->qty }}</p>
                                </div>
                            </div>
                            <span class="hidden text-right text-xs text-gray-600 sm:block">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                            <span class="hidden text-center text-xs text-gray-600 sm:block">{{ $item->qty }}</span>
                            <div class="flex items-center justify-between pl-[3.75rem] sm:justify-end sm:pl-0">
                                <span class="text-xs text-gray-500 sm:hidden">Subtotal</span>
                                <span class="text-sm font-semibold text-gray-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-10 text-center text-sm text-gray-500">Tidak ada rincian produk.</p>
                    @endforelse
                </div>

                <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6">
                    <span class="text-sm font-semibold text-gray-700">Total transaksi</span>
                    <span class="text-base font-semibold text-gray-900">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </section>
        </div>
    </main>
@endsection