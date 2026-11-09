<?php

// Mengimpor TransaksiController agar metode di dalamnya bisa dipanggil untuk menangani rute
use App\Http\Controllers\TransaksiController;
// Mengimpor class Route Facade untuk mendefinisikan rute web aplikasi
use Illuminate\Support\Facades\Route;

// Rute default bawaan Laravel: ketika user membuka URL akar ('/'), tampilkan tampilan welcome
Route::get('/', function () {
    return view('welcome');
});

// ==========================================
//  FITUR TRANSAKSI & KERANJANG (SESSION)
// ==========================================

// Menampilkan halaman kasir transaksi: mengambil produk dari DB dan keranjang dari session
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

// Menambahkan produk ke session keranjang berdasarkan ID produk (URL param {id})
Route::post('/transaksi/tambah/{id}', [TransaksiController::class, 'tambah'])->name('transaksi.tambah');

// Mengurangi 1 jumlah qty produk di session keranjang berdasarkan ID produk ({id})
Route::post('/transaksi/kurang/{id}', [TransaksiController::class, 'kurang'])->name('transaksi.kurang');

// Menambah 1 jumlah qty produk di session keranjang dengan pengecekan stok
Route::post('/transaksi/tambah-qty/{id}', [TransaksiController::class, 'tambahQty'])->name('transaksi.tambahQty');

// Menghapus suatu produk secara total dari session keranjang
Route::post('/transaksi/hapus/{id}', [TransaksiController::class, 'hapus'])->name('transaksi.hapus');

// Memproses checkout: validasi uang bayar, potong stok, simpan transaksi ke DB, dan hapus session keranjang
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');

// ==========================================
//  FITUR RIWAYAT TRANSAKSI (DATABASE)
// ==========================================

// Menampilkan riwayat transaksi yang tersimpan di tabel tb_transaksi
Route::get('/riwayat-transaksi', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');

// Menampilkan rincian/nota dari satu transaksi tertentu berdasarkan ID
Route::get('/riwayat-transaksi/{id}', [TransaksiController::class, 'detail'])->name('transaksi.detail');
