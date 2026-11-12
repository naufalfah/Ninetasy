@extends('layouts.master')

@section('content')
    <main class="min-h-screen px-5 py-7 sm:px-8 lg:px-10">
        <form action="{{ route('user.transaksi.riwayat') }}" method="GET" class="mb-8 max-w-xl">
            <label class="relative block">
                <span class="sr-only">Cari ID transaksi</span>
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path stroke-linecap="round" d="m20 20-4-4"></path>
                </svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari ID transaksi..." class="w-full rounded-xl border-0 bg-white py-3 pl-12 pr-4 text-sm shadow-md shadow-black/10 outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-gray-300">
            </label>
        </form>

        <section class="max-w-5xl">
            <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Riwayat transaksi</h1>
                    <p class="mt-1 text-sm text-gray-500">Daftar transaksi yang sudah dilakukan</p>
                </div>
                <a href="{{ route('user.transaksi.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-white hover:text-gray-900 sm:hidden">
                    Kembali ke transaksi
                </a>
            </div>

            <div class="grid grid-cols-[minmax(0,1fr)_5rem_6rem_4rem] gap-2 border-b border-gray-300 px-3 py-3 text-[10px] font-medium text-gray-500 sm:grid-cols-[minmax(0,1fr)_8rem_9rem_6rem] sm:gap-3 sm:px-5 sm:text-xs">
                <span>ID transaksi</span>
                <span class="text-center">Tanggal</span>
                <span class="text-right">Total harga</span>
                <span class="text-right">Detail</span>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse ($transaksi as $item)
                    <div class="grid grid-cols-[minmax(0,1fr)_5rem_6rem_4rem] items-center gap-2 bg-white px-3 py-4 transition hover:bg-gray-50 sm:grid-cols-[minmax(0,1fr)_8rem_9rem_6rem] sm:gap-3 sm:px-5">
                        <span class="truncate text-xs font-semibold text-gray-900 sm:text-sm">#A{{ str_pad((string) $item->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-center text-[10px] text-gray-500 sm:text-xs">{{ \Illuminate\Support\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</span>
                        <span class="text-right text-[10px] font-medium text-gray-700 sm:text-xs">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        <a href="{{ route('user.transaksi.detail', $item->id) }}" class="justify-self-end rounded-lg bg-[#e8e4d8] px-3 py-2 text-[10px] font-semibold text-gray-800 transition hover:bg-[#dcd7c8] sm:text-xs">
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center">
                        <p class="font-medium text-gray-700">{{ $search ? 'Transaksi tidak ditemukan' : 'Belum ada transaksi' }}</p>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $search ? 'Periksa kembali ID transaksi.' : 'Transaksi yang sudah dibayar akan tampil di sini.' }}
                        </p>
                    </div>
                @endforelse
            </div>

            @if ($transaksi->hasPages())
                <div class="mt-5">
                    {{ $transaksi->links() }}
                </div>
            @endif
        </section>
    </main>
@endsection