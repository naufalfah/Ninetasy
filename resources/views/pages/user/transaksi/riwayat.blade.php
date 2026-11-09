@extends('layouts.master')

@section('content')

    <h1>Riwayat Transaksi</h1>

    <a href="{{ route('transaksi.index') }}">
        Transaksi
    </a>

    <h3>Data Transaksi</h3>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Total Bayar</th>
                <th>Uang Bayar</th>
                <th>Kembalian</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->tanggal_transaksi }}</td>
                    <td>
                        Rp{{ number_format($item->total_bayar, 0, ',', '.') }}
                    </td>
                    <td>
                        Rp{{ number_format($item->uang_bayar, 0, ',', '.') }}
                    </td>
                    <td>
                        Rp{{ number_format($item->kembalian, 0, ',', '.') }}
                    </td>
                    <td>
                        <a href="{{ route('transaksi.detail', $item->id) }}">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection