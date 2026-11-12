@extends('layouts.admin')

@section('content')
    <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
        {{-- Header Dashboard --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard Admin</h1>
            <p class="mt-1 text-sm text-gray-500">Selamat datang di panel administrasi toko Ninetasy</p>
        </div>

        {{-- Grid Statistik Ringkasan --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Card Total Produk --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Produk</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-gray-900">{{ $produk }}</h2>
                        <p class="mt-1 text-xs text-gray-500">Item produk terdaftar</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-[#e8e4d8] flex items-center justify-center text-amber-900 shrink-0">
                        <img src="{{ asset('images/icon/produk.png') }}" class="w-6 h-6 object-contain" alt="">
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.produk.index') }}" class="text-xs font-semibold text-amber-900 hover:underline inline-flex items-center gap-1">
                        Kelola data produk &rarr;
                    </a>
                </div>
            </div>

            {{-- Card Pintasan Kategori --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Kelola</h2>
                        <p class="mt-1 text-xs text-gray-500">Klasifikasi & kelompok barang</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-[#e8e4d8] flex items-center justify-center text-amber-900 shrink-0">
                        <img src="{{ asset('images/icon/kategori.png') }}" class="w-6 h-6 object-contain" alt="">
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.kategori.index') }}" class="text-xs font-semibold text-amber-900 hover:underline inline-flex items-center gap-1">
                        Buka kategori &rarr;
                    </a>
                </div>
            </div>

            {{-- Card Pintasan Data Pengguna --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Kelola</h2>
                        <p class="mt-1 text-xs text-gray-500">Hak akses & peran user</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-[#e8e4d8] flex items-center justify-center text-amber-900 shrink-0">
                        <img src="{{ asset('images/icon/users.png') }}" class="w-6 h-6 object-contain" alt="">
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-amber-900 hover:underline inline-flex items-center gap-1">
                        Buka data user &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
