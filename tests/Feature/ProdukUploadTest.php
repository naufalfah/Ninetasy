<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProdukUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_product_with_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Minuman',
        ]);

        $file = UploadedFile::fake()->image('kopi.jpg', 400, 400);

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
        Storage::disk('public')->assertExists($produk->gambar);
    }

    public function test_admin_can_update_product_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Makanan',
        ]);

        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldFile->store('produk', 'public');

        $produk = Produk::create([
            'nama_produk' => 'Roti Bakar',
            'harga' => 12000,
            'stok' => 10,
            'kategori_id' => $kategori->id,
            'gambar' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $newFile = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($admin)->put(route('admin.produk.update', $produk->id), [
            'nama_produk' => 'Roti Bakar Coklat',
            'harga' => 14000,
            'stok' => 15,
            'kategori_id' => $kategori->id,
            'produk_gambar' => $newFile,
        ]);

        $response->assertRedirect(route('admin.produk.index'));
        $produk->refresh();

        $this->assertNotEquals($oldPath, $produk->gambar);
        Storage::disk('public')->assertExists($produk->gambar);
        Storage::disk('public')->assertMissing($oldPath);
    }
}
