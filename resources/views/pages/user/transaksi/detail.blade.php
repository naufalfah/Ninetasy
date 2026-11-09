@extends('layouts.master')

@section('content')

    <h1>Detail Transaksi</h1>

    <a href="{{ route('transaksi.riwayat') }}">
        Kembali ke Riwayat
    </a>

    {{-- INFORMASI TRANSAKSI --}}
    <h3>Informasi Pembayaran</h3>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID Transaksi</th>
            <td>{{ $transaksi->id }}</td>
        </tr>

        <tr>
            <th>Tanggal</th>
            <td>{{ $transaksi->tanggal_transaksi }}</td>
        </tr>

        <tr>
            <th>Total Belanja</th>
            <td>
                Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <th>Uang Bayar</th>
            <td>
                Rp{{ number_format($transaksi->uang_bayar, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <th>Kembalian</th>
            <td>
                Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    {{-- DAFTAR PRODUK --}}
    <h3>Produk yang Dibeli</h3>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($transaksi->detailTransaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $item->produk->nama_produk ?? 'Produk tidak tersedia' }}
                    </td>

                    <td>
                        Rp{{ number_format($item->harga, 0, ',', '.') }}
                    </td>

                    <td>{{ $item->qty }}</td>

                    <td>
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection