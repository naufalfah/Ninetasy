{{-- Menggunakan template induk master layout dari folder resources/views/layouts/master.blade.php --}}
@extends('layouts.master')

{{-- Memulai bagian isi konten halaman --}}
@section('content')

    {{-- Judul halaman --}}
    <h1>Halaman Transaksi</h1>

    {{-- Tombol navigasi menuju halaman riwayat transaksi --}}
    <a href="{{ route('transaksi.riwayat') }}">
        Riwayat Transaksi
    </a>

    {{-- Menangkap dan menampilkan Flash Message dari Session (misal pesan sukses / pesan error stok) --}}
    {{-- session('pesan') membaca flash data yang dikirim controller lewat ->with('pesan', '...') --}}
    @if (session('pesan'))
        <p>{{ session('pesan') }}</p>
    @endif

    {{-- ====================================== --}}
    {{-- DAFTAR PRODUK YANG TERSEDIA DI DATABASE --}}
    {{-- ====================================== --}}
    <h3>Daftar Produk</h3>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            {{-- Melakukan perulangan untuk menampilkan setiap data produk dari variabel $produk --}}
            @forelse ($produk as $item)
                <tr>
                    {{-- $loop->iteration: nomor urut otomatis dari 1, 2, dst --}}
                    <td>{{ $loop->iteration }}</td>
                    {{-- Menampilkan nama produk --}}
                    <td>{{ $item->nama_produk }}</td>
                    {{-- Menampilkan harga produk dalam format mata uang rupiah --}}
                    <td>
                        Rp{{ number_format($item->harga, 0, ',', '.') }}
                    </td>
                    {{-- Menampilkan jumlah stok produk saat ini --}}
                    <td>{{ $item->stok }}</td>
                    <td>
                        {{-- Form POST untuk menambahkan produk ini ke dalam session keranjang belanja --}}
                        <form action="{{ route('transaksi.tambah', $item->id) }}" method="POST">
                            {{-- Token keamanan CSRF wajib ada pada form POST di Laravel --}}
                            @csrf
                            <button type="submit">Tambah</button>
                        </form>
                    </td>
                </tr>
            @empty
                {{-- Ditampilkan jika data produk di database masih kosong --}}
                <tr>
                    <td colspan="5">Data produk kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    {{-- ================================================ --}}
    {{-- DAFTAR KERANJANG BELANJA (DIBACA DARI SESSION)   --}}
    {{-- ================================================ --}}
    <h3>Keranjang Belanja</h3>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            {{-- Melakukan perulangan untuk setiap item yang tersimpan di dalam array session $keranjang --}}
            @forelse ($keranjang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['nama_produk'] }}</td>
                    <td>
                        Rp{{ number_format($item['harga'], 0, ',', '.') }}
                    </td>
                    <td>{{ $item['qty'] }}</td>
                    <td>
                        Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                    </td>
                    <td>
                        {{-- Tombol Kurang (-): Mengurangi 1 kuantitas produk di session keranjang --}}
                        <form action="{{ route('transaksi.kurang', $item['id']) }}" method="POST">
                            @csrf
                            <button type="submit">-</button>
                        </form>

                        {{-- Tombol Tambah (+): Menambah 1 kuantitas produk di session keranjang --}}
                        <form action="{{ route('transaksi.tambahQty', $item['id']) }}" method="POST">
                            @csrf
                            <button type="submit">+</button>
                        </form>

                        {{-- Tombol Hapus: Menghapus produk dari session keranjang --}}
                        <form action="{{ route('transaksi.hapus', $item['id']) }}" method="POST">
                            @csrf
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                {{-- Ditampilkan jika session keranjang masih kosong atau belum ada item --}}
                <tr>
                    <td colspan="6">Keranjang masih kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- =============================================== --}}
    {{-- PROSES PEMBAYARAN / CHECKOUT TRANSAKSI          --}}
    {{-- =============================================== --}}
    <h3>Pembayaran</h3>

    {{-- Menampilkan total belanja keseluruhan yang dihitung dari akumulasi subtotal session keranjang --}}
    <p>Total Belanja : {{ number_format($total, 0, ',', '.') }}</p>
    
    {{-- Form POST untuk memproses transaksi akhir (mengurangi stok & simpan ke DB) --}}
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <label for="">Uang Bayar</label>
        {{-- Input uang pembayaran pembeli --}}
        <input
            type="number"
            name="uang_bayar"
            id="uang_bayar"
            min="1"
            required
            placeholder="Masukkan uang pelanggan"
        >

        {{-- Tombol untuk submit pembayaran --}}
        <button type="submit">Bayar Sekarang</button>
    </form>

@endsection
