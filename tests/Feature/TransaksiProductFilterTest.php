<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiProductFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_search_products_by_name(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $kategori = Kategori::create(['nama_kategori' => 'Minuman']);

        Produk::create([
            'nama_produk' => 'Matcha Latte',
            'harga' => 18000,
            'stok' => 8,
            'kategori_id' => $kategori->id,
        ]);
        Produk::create([
            'nama_produk' => 'Kopi Susu',
            'harga' => 15000,
            'stok' => 5,
            'kategori_id' => $kategori->id,
        ]);

        $response = $this->actingAs($user)->get(route('user.transaksi.index', ['search' => 'Matcha']));

        $response->assertOk()
            ->assertViewHas('search', 'Matcha')
            ->assertViewHas('produk', fn($produk) => $produk->pluck('nama_produk')->all() === ['Matcha Latte']);
    }

    public function test_user_can_combine_search_and_category_filter(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $minuman = Kategori::create(['nama_kategori' => 'Minuman']);
        $makanan = Kategori::create(['nama_kategori' => 'Makanan']);

        Produk::create([
            'nama_produk' => 'Matcha Latte',
            'harga' => 18000,
            'stok' => 8,
            'kategori_id' => $minuman->id,
        ]);
        Produk::create([
            'nama_produk' => 'Matcha Cake',
            'harga' => 22000,
            'stok' => 4,
            'kategori_id' => $makanan->id,
        ]);
        Produk::create([
            'nama_produk' => 'Kopi Susu',
            'harga' => 15000,
            'stok' => 5,
            'kategori_id' => $minuman->id,
        ]);

        $response = $this->actingAs($user)->get(route('user.transaksi.index', [
            'search' => 'Matcha',
            'kategori_id' => $minuman->id,
        ]));

        $response->assertOk()
            ->assertViewHas('search', 'Matcha')
            ->assertViewHas('kategoriId', $minuman->id)
            ->assertViewHas('produk', fn($produk) => $produk->pluck('nama_produk')->all() === ['Matcha Latte']);
    }
}
