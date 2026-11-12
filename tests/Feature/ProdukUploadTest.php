<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProdukUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_product_with_image(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Minuman',
        ]);

        $file = UploadedFile::fake()->image('test_kopi.jpg', 400, 400);

        $response = $this->actingAs($admin)->post(route('admin.produk.store'), [
            'nama_produk' => 'Kopi Susu',
            'harga' => 15000,
            'stok' => 20,
            'kategori_id' => $kategori->id,
            'produk_gambar' => $file,
        ]);

        $response->assertRedirect(route('admin.produk.index'));
        $response->assertSessionHas('pesan', 'Produk berhasil ditambah!');

        $this->assertDatabaseHas('tb_produk', [
            'nama_produk' => 'Kopi Susu',
            'harga' => 15000,
            'stok' => 20,
            'kategori_id' => $kategori->id,
        ]);

        $produk = Produk::first();
        $this->assertNotNull($produk->gambar);
        $this->assertStringStartsWith('data:image/', $produk->gambar);
        $this->assertStringContainsString(';base64,', $produk->gambar);
        $this->assertEquals($produk->gambar, $produk->gambar_url);
    }

    public function test_admin_can_update_product_image(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Makanan',
        ]);

        $oldBase64 = 'data:image/jpeg;base64,'.base64_encode('old content');

        $produk = Produk::create([
            'nama_produk' => 'Roti Bakar',
            'harga' => 12000,
            'stok' => 10,
            'kategori_id' => $kategori->id,
            'gambar' => $oldBase64,
        ]);

        $newFile = UploadedFile::fake()->image('test_new.jpg');

        $response = $this->actingAs($admin)->put(route('admin.produk.update', $produk->id), [
            'nama_produk' => 'Roti Bakar Coklat',
            'harga' => 14000,
            'stok' => 15,
            'kategori_id' => $kategori->id,
            'produk_gambar' => $newFile,
        ]);

        $response->assertRedirect(route('admin.produk.index'));
        $produk->refresh();

        $this->assertNotEquals($oldBase64, $produk->gambar);
        $this->assertStringStartsWith('data:image/', $produk->gambar);
        $this->assertStringContainsString(';base64,', $produk->gambar);
    }

    public function test_admin_can_delete_product(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Snack',
        ]);

        $produk = Produk::create([
            'nama_produk' => 'Keripik Singkong',
            'harga' => 10000,
            'stok' => 5,
            'kategori_id' => $kategori->id,
            'gambar' => 'data:image/jpeg;base64,'.base64_encode('sample content'),
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.produk.destroy', $produk->id));

        $response->assertRedirect(route('admin.produk.index'));
        $this->assertDatabaseMissing('tb_produk', ['id' => $produk->id]);
    }
}
