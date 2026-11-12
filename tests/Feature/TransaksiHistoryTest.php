<?php

namespace Tests\Feature;

use App\Models\DetailTransaksi;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_search_purchase_history_by_transaction_id(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $kategori = Kategori::create(['nama_kategori' => 'Minuman']);
        $matcha = Produk::create([
            'nama_produk' => 'Matcha Latte',
            'harga' => 18000,
            'stok' => 8,
            'kategori_id' => $kategori->id,
        ]);
        $kopi = Produk::create([
            'nama_produk' => 'Kopi Susu',
            'harga' => 15000,
            'stok' => 5,
            'kategori_id' => $kategori->id,
        ]);
        $transaksi = Transaksi::create([
            'tanggal_transaksi' => now()->toDateString(),
            'total_harga' => 33000,
            'uang_bayar' => 40000,
            'kembalian' => 7000,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'produk_id' => $matcha->id,
            'qty' => 1,
            'harga' => 18000,
            'subtotal' => 18000,
        ]);
        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'produk_id' => $kopi->id,
            'qty' => 1,
            'harga' => 15000,
            'subtotal' => 15000,
        ]);

        $response = $this->actingAs($user)->get(route('user.transaksi.riwayat', ['search' => (string) $transaksi->id]));

        $response->assertOk()
            ->assertViewHas('search', (string) $transaksi->id)
            ->assertViewHas('transaksi', fn($transaksiPage) => $transaksiPage->total() === 1
                && $transaksiPage->first()->id === $transaksi->id);
    }
}
