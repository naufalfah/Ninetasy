<?php

// Menentukan namespace untuk file controller ini agar dapat dipanggil sesuai struktur folder PSR-4 Laravel

namespace App\Http\Controllers;

// Mengimpor model DetailTransaksi untuk berinteraksi dengan tabel 'tb_detail_transaksi' di database
use App\Models\DetailTransaksi;
use App\Models\Kategori;
// Mengimpor model Produk untuk berinteraksi dengan tabel 'tb_produk' di database
use App\Models\Produk;
// Mengimpor model Transaksi untuk berinteraksi dengan tabel 'tb_transaksi' di database
use App\Models\Transaksi;
// Mengimpor class Request untuk menangkap data HTTP request (input form, header, dll) yang dikirim user
use Illuminate\Http\Request;
// Mengimpor DB Facade untuk menjalankan transaksi database (DB::transaction) agar data aman dan konsisten
use Illuminate\Support\Facades\DB;

// Mendefinisikan class TransaksiController yang mewarisi class dasar Controller
class TransaksiController extends Controller
{
    /**
     * Menampilkan halaman utama transaksi: daftar produk dan keranjang belanja saat ini.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'kategori_id' => ['nullable', 'integer', 'exists:tb_kategori,id'],
        ]);
        $search = trim($filters['search'] ?? '');
        $kategoriId = $filters['kategori_id'] ?? null;

        $produkQuery = Produk::join('tb_kategori', 'tb_produk.kategori_id', 'tb_kategori.id')
            ->select('tb_produk.*', 'tb_kategori.nama_kategori')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('tb_produk.nama_produk', 'like', '%' . $search . '%');
            })
            ->when($kategoriId, function ($query) use ($kategoriId) {
                $query->where('tb_produk.kategori_id', $kategoriId);
            })
            ->orderBy('tb_produk.id');

        $produk = $produkQuery->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();

        // Mengambil data keranjang belanja dari SESSION dengan key 'keranjang'
        // session()->get('keranjang', []):
        // Parameter ke-1 ('keranjang'): nama key yang dicari di dalam session.
        // Parameter ke-2 ([]): nilai default (array kosong) yang akan dipakai jika session 'keranjang' belum pernah dibuat / masih kosong.
        $keranjang = session()->get('keranjang', []);

        // Menginisialisasi variabel $total belanja awal dengan nilai 0
        $total = 0;

        // Melakukan perulangan untuk setiap item yang ada di dalam keranjang belanja
        foreach ($keranjang as $item) {
            // Menjumlahkan subtotal setiap produk ke dalam variabel akumulasi $total
            $total += $item['subtotal'];
        }

        // Menampilkan view 'pages.user.transaksi.index' sambil mengirimkan data $produk, $keranjang, dan $total menggunakan compact()
        return view('pages.user.transaksi.index', compact('produk', 'keranjang', 'total', 'kategori', 'search', 'kategoriId'));
    }

    /**
     * Menambahkan sebuah produk ke dalam keranjang belanja di dalam session berdasarkan ID produk.
     */
    public function tambah($id)
    {
        // Mencari produk di database berdasarkan ID; jika ID tidak ditemukan, otomatis melempar error 404 (Not Found)
        $produk = Produk::findOrFail($id);

        // Mengambil data keranjang saat ini dari session; jika belum ada, berikan array kosong []
        $keranjang = session()->get('keranjang', []);

        // Mengecek apakah stok produk di database kurang dari 1 (artinya produk sudah habis)
        if ($produk->stok < 1) {
            // Jika stok habis, kembalikan ke halaman sebelumnya dengan pesan peringatan sementara (flash message)
            return back()->with('pesan', 'Stok produk habis!');
        }

        // Mengecek apakah produk dengan ID ini sudah pernah dimasukkan ke dalam array keranjang sebelumnya
        if (isset($keranjang[$id])) {
            // Jika sudah ada di keranjang, cek apakah jumlah (qty) di keranjang sudah mencapai atau melebihi stok yang ada
            if ($keranjang[$id]['qty'] >= $produk->stok) {
                // Jika sudah melebihi stok, batalkan penambahan dan beri peringatan
                return back()->with('pesan', 'Jumlah melebihi stok!');
            }

            // Menambah jumlah kuantitas (qty) produk tersebut di keranjang sebanyak 1
            $keranjang[$id]['qty']++;

            // Menghitung ulang subtotal harga produk tersebut (qty terbaru dikali harga satuan)
            $keranjang[$id]['subtotal'] = $keranjang[$id]['qty'] * $keranjang[$id]['harga'];
        } else {
            // Jika produk BELUM ADA di keranjang, buat elemen baru di array $keranjang dengan index key berupa ID produk ($id)
            $keranjang[$id] = [
                'id' => $produk->id,                     // Menyimpan ID produk
                'nama_produk' => $produk->nama_produk, // Menyimpan nama produk
                'harga' => $produk->harga,               // Menyimpan harga satuan produk
                'gambar' => $produk->gambar,             // Menyimpan path gambar untuk thumbnail keranjang
                'qty' => 1,                                // Mengatur kuantitas (qty) awal sebanyak 1
                'subtotal' => $produk->harga,            // Mengatur subtotal awal sama dengan harga satuan (1 x harga)
            ];
        }

        // MENYIMPAN / MEMPERBARUI data array $keranjang ke dalam SESSION
        // session()->put('key', $value) akan menyimpan data $keranjang ke session storage server dengan label 'keranjang'
        session()->put('keranjang', $keranjang);

        // Mengalihkan kembali ke halaman sebelumnya (back) dan membawa flash session pesan sukses
        return back()->with('pesan', 'Produk berhasil ditambahkan!');
    }

    /**
     * Mengurangi 1 jumlah (qty) produk yang ada di dalam keranjang belanja session.
     */
    public function kurang($id)
    {
        // Mengambil data keranjang belanja yang saat ini tersimpan di session
        $keranjang = session()->get('keranjang', []);

        // Mengecek apakah produk dengan ID tersebut tidak ada di dalam keranjang
        if (! isset($keranjang[$id])) {
            // Jika tidak ada di keranjang, langsung kembalikan ke halaman sebelumnya tanpa melakukan apa-apa
            return back();
        }

        // Mengurangi jumlah kuantitas (qty) produk di keranjang sebanyak 1
        $keranjang[$id]['qty']--;

        // Mengecek apakah jumlah qty setelah dikurangi menjadi 0 atau minus
        if ($keranjang[$id]['qty'] <= 0) {
            // Jika qty bernilai 0 atau kurang, hapus item produk tersebut sepenuhnya dari keranjang menggunakan unset()
            unset($keranjang[$id]);
        } else {
            // Jika qty masih lebih dari 0, hitung ulang subtotal harga (qty baru dikali harga satuan)
            $keranjang[$id]['subtotal'] = $keranjang[$id]['qty'] * $keranjang[$id]['harga'];
        }

        // MENYIMPAN KEMBALI perubahan array keranjang ke dalam SESSION dengan key 'keranjang'
        session()->put('keranjang', $keranjang);

        // Kembali ke halaman sebelumnya
        return back();
    }

    /**
     * Menambah 1 jumlah (qty) produk yang sudah ada di keranjang belanja dengan validasi stok.
     */
    public function tambahQty($id)
    {
        // Mengambil data keranjang dari session
        $keranjang = session()->get('keranjang', []);

        // Mengecek jika produk dengan ID ini tidak ada di keranjang
        if (! isset($keranjang[$id])) {
            // Langsung kembalikan ke halaman sebelumnya
            return back();
        }

        // Mencari data produk dari database berdasarkan ID untuk mengecek stok terkininya
        $produk = Produk::findOrFail($id);

        // Mengecek apakah kuantitas saat ini sudah mencapai batas jumlah stok yang tersedia di database
        if ($keranjang[$id]['qty'] >= $produk->stok) {
            // Jika sudah mencapai batas stok, batalkan penambahan dan kirimkan pesan peringatan
            return back()->with('pesan', 'Jumlah pembelian sudah mencapai stok');
        }

        // Jika stok masih cukup, tambahkan kuantitas (qty) produk di keranjang sebanyak 1
        $keranjang[$id]['qty']++;

        // Hitung ulang nilai subtotal produk (qty baru dikalikan dengan harga satuan)
        $keranjang[$id]['subtotal'] = $keranjang[$id]['qty'] * $keranjang[$id]['harga'];

        // MENYIMPAN perubahan array keranjang ke dalam SESSION
        session()->put('keranjang', $keranjang);

        // Mengembalikan pengguna ke halaman sebelumnya
        return back();
    }

    /**
     * Menghapus sebuah produk sepenuhnya dari keranjang belanja session.
     */
    public function hapus($id)
    {
        // Mengambil data keranjang dari session
        $keranjang = session()->get('keranjang', []);

        // Memastikan apakah produk memang ada di dalam keranjang belanja
        if (! isset($keranjang[$id])) {
            // Jika tidak ada di keranjang, kembali ke halaman sebelumnya
            return back();
        }

        // Menghapus elemen produk tersebut dari array keranjang berdasarkan ID produk
        unset($keranjang[$id]);

        // MENYIMPAN KEMBALI data keranjang yang telah dihapus itemnya ke dalam SESSION
        session()->put('keranjang', $keranjang);

        // Mengembalikan pengguna ke halaman sebelumnya
        return back();
    }

    /**
     * Memproses checkout / transaksi akhir: validasi bayar, kurangi stok, catat database, lalu hapus session keranjang.
     */
    public function store(Request $request)
    {
        // Mengambil data keranjang belanja dari session
        $keranjang = session()->get('keranjang', []);

        // Mengecek apakah keranjang belanja masih kosong (tidak ada item)
        if (empty($keranjang)) {
            // Jika kosong, batalkan proses dan kembalikan dengan pesan peringatan
            return back()->with('pesan', 'Keranjang masih kosong!');
        }

        // Memvalidasi data form yang dikirim user:
        // 'uang_bayar' wajib diisi (required), bertipe integer/angka, dan nilai minimalnya 1 (min:1)
        $request->validate([
            'uang_bayar' => 'required|integer|min:1',
        ]);

        // Menginisialisasi variabel penghitung total belanja mulai dari 0
        $total = 0;

        // Menghitung akumulasi total harga dari seluruh subtotal barang di dalam keranjang belanja
        foreach ($keranjang as $item) {
            $total += $item['subtotal'];
        }

        // Mengonversi input uang_bayar dari form request ke tipe integer (angka)
        $uangBayar = (int) $request->uang_bayar;

        // Mengecek apakah uang yang dibayarkan oleh pembeli kurang dari total belanja yang harus dibayar
        if ($uangBayar < $total) {
            // Jika uang bayar kurang, batalkan transaksi dan beri pesan kesalahan
            return back()->with('pesan', 'Uang pembayaran kurang!');
        }

        // Menghitung uang kembalian (uang yang diserahkan dikurangi total belanja)
        $kembalian = $uangBayar - $total;

        // Menggunakan blok try-catch untuk menangani kemungkinan adanya error selama eksekusi query database
        try {
            // DB::transaction menjamin proses penyimpanan data aman (ACID):
            // Jika semua query berhasil, semua perubahan disimpan permanen (commit).
            // Jika terjadi salah satu error / exception di tengah jalan, seluruh perubahan otomatis dibatalkan (rollback).
            DB::transaction(function () use (
                $keranjang,
                $total,
                $uangBayar,
                $kembalian
            ) {
                // Periksa ketersediaan stok riil dan kurangi stok setiap produk di database
                foreach ($keranjang as $item) {

                    // Mencari produk di database berdasarkan ID sekaligus menguncinya dengan lockForUpdate()
                    // lockForUpdate() mencegah proses request lain mengubah baris produk ini secara bersamaan (mencegah race condition)
                    $produk = Produk::where('id', $item['id'])
                        ->lockForUpdate()
                        ->first();

                    // Jika produk ternyata tidak ditemukan di database
                    if (! $produk) {
                        // Melempar error/exception agar transaksi di-rollback secara otomatis
                        throw new \Exception('Produk tidak ditemukan!');
                    }

                    // Mengecek apakah stok riil di database lebih sedikit dari jumlah qty yang dibeli
                    if ($produk->stok < $item['qty']) {
                        // Melempar error/exception agar transaksi di-rollback dan memunculkan pesan stok tidak cukup
                        throw new \Exception(
                            'Stok ' . $produk->nama_produk . ' tidak mencukupi!'
                        );
                    }

                    // Mengurangi nilai kolom 'stok' di tabel produk sebanyak jumlah qty yang dibeli
                    $produk->decrement('stok', $item['qty']);
                }

                // Menyimpan data ringkasan transaksi utama ke dalam tabel 'tb_transaksi'
                $transaksi = Transaksi::create([
                    'tanggal_transaksi' => now()->toDateString(), // Mengisi tanggal saat ini dalam format YYYY-MM-DD
                    'total_harga' => $total,                      // Menyimpan total nominal belanja
                    'uang_bayar' => $uangBayar,                   // Menyimpan nominal uang yang dibayarkan pelanggan
                    'kembalian' => $kembalian,                    // Menyimpan nominal uang kembalian pelanggan
                ]);

                // Menyimpan setiap rincian barang yang dibeli ke dalam tabel 'tb_detail_transaksi'
                foreach ($keranjang as $item) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,    // Mengaitkan ID transaksi utama yang baru dibuat (Foreign Key)
                        'produk_id' => $item['id'],          // ID produk yang dibeli
                        'qty' => $item['qty'],               // Kuantitas produk yang dibeli
                        'harga' => $item['harga'],           // Harga satuan saat transaksi dilakukan
                        'subtotal' => $item['subtotal'],     // Total harga untuk item tersebut (qty * harga)
                    ]);
                }
            });
        } catch (\Exception $e) {
            // Jika terjadi pengecualian/error di dalam blok transaksi, tangkap pesannya dan kirimkan kembali ke halaman sebelumnya
            return back()->with('pesan', $e->getMessage());
        }

        // MENGHAPUS / MENGOSONGKAN session keranjang setelah transaksi sukses disimpan ke database
        // session()->forget('keranjang') akan menghapus data dengan key 'keranjang' dari session agar keranjang kembali kosong
        session()->forget('keranjang');

        // Mengalihkan (redirect) pengguna ke halaman daftar transaksi dengan membawa flash message sukses
        return redirect()
            ->route('user.transaksi.index')
            ->with('pesan', 'Transaksi berhasil disimpan!');
    }

    /**
     * Menampilkan daftar riwayat seluruh transaksi yang tersimpan di database.
     */
    public function riwayat(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($filters['search'] ?? '');

        $transaksi = Transaksi::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.user.transaksi.riwayat', compact('transaksi', 'search'));
    }

    /**
     * Menampilkan halaman rincian / detail dari satu transaksi tertentu berdasarkan ID transaksi.
     */
    public function detail($id)
    {
        // Mencari 1 transaksi berdasarkan ID beserta relasi detailTransaksi dan data produknya
        // Jika ID transaksi tidak ditemukan, otomatis menampilkan halaman 404
        $transaksi = Transaksi::with('detailTransaksi.produk')
            ->findOrFail($id);

        // Mengirimkan data transaksi ke view 'pages.user.transaksi.detail'
        return view('pages.user.transaksi.detail', compact('transaksi'));
    }
}
