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

    protected function tearDown(): void
    {
        // Bersihkan file uji coba di public/images/produk
        $testFiles = glob(public_path('images/produk/*_test_*.jpg'));
        if ($testFiles) {
            foreach ($testFiles as $file) {
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
        }

        parent::tearDown();
    }

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
        $this->assertFileExists(public_path('images/produk/'.$produk->gambar));

        // Hapus file yang terupload
        if (file_exists(public_path('images/produk/'.$produk->gambar))) {
            @unlink(public_path('images/produk/'.$produk->gambar));
        }
    }

    public function test_admin_can_update_product_image(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Makanan',
        ]);

        // Buat file lama di public/images/produk
        $oldFileName = time().'_test_old.jpg';
        $destination = public_path('images/produk');
        if (! file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        file_put_contents($destination.'/'.$oldFileName, 'old content');

        $produk = Produk::create([
            'nama_produk' => 'Roti Bakar',
            'harga' => 12000,
            'stok' => 10,
            'kategori_id' => $kategori->id,
            'gambar' => $oldFileName,
        ]);

        $this->assertFileExists($destination.'/'.$oldFileName);

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

        $this->assertNotEquals($oldFileName, $produk->gambar);
        $this->assertFileExists(public_path('images/produk/'.$produk->gambar));
        $this->assertFileDoesNotExist($destination.'/'.$oldFileName);

        // Hapus file yang terupload
        if (file_exists(public_path('images/produk/'.$produk->gambar))) {
            @unlink(public_path('images/produk/'.$produk->gambar));
        }
    }

    public function test_admin_can_delete_product_and_its_image(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Snack',
        ]);

        $fileName = time().'_test_delete.jpg';
        $destination = public_path('images/produk');
        if (! file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        file_put_contents($destination.'/'.$fileName, 'delete content');

        $produk = Produk::create([
            'nama_produk' => 'Keripik Singkong',
            'harga' => 10000,
            'stok' => 5,
            'kategori_id' => $kategori->id,
            'gambar' => $fileName,
        ]);

        $this->assertFileExists($destination.'/'.$fileName);

        $response = $this->actingAs($admin)->delete(route('admin.produk.destroy', $produk->id));

        $response->assertRedirect(route('admin.produk.index'));
        $this->assertDatabaseMissing('tb_produk', ['id' => $produk->id]);
        $this->assertFileDoesNotExist($destination.'/'.$fileName);
    }
}
