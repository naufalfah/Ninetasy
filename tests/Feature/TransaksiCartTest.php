<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_with_large_base64_image_to_cart_without_session_overflow(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $kategori = Kategori::create(['nama_kategori' => 'Minuman']);

        // Simulasi data base64 gambar yang besar
        $largeBase64 = 'data:image/jpeg;base64,'.base64_encode(str_repeat('A', 50000));

        $produk = Produk::create([
            'nama_produk' => 'Es Kopi Susu',
            'harga' => 15000,
            'stok' => 10,
            'kategori_id' => $kategori->id,
            'gambar' => $largeBase64,
        ]);

        $response = $this->actingAs($user)->post(route('user.transaksi.tambah', $produk->id));

        $response->assertRedirect();
        $response->assertSessionHas('pesan', 'Produk berhasil ditambahkan!');

        $keranjang = session('keranjang');
        $this->assertIsArray($keranjang);
        $this->assertArrayHasKey($produk->id, $keranjang);
        $this->assertEquals(1, $keranjang[$produk->id]['qty']);

        // Pastikan session tidak menyimpan data gambar base64 yang besar
        $this->assertArrayNotHasKey('gambar', $keranjang[$produk->id]);

        // Cek halaman index transaksi berhasil menampilkan produk dan thumbnail
        $indexResponse = $this->actingAs($user)->get(route('user.transaksi.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Es Kopi Susu');
    }
}
