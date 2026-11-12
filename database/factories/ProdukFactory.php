<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_produk' => fake()->words(2, true),
            'harga' => fake()->numberBetween(5000, 100000),
            'stok' => fake()->numberBetween(0, 100),
            'kategori_id' => Kategori::factory(),
        ];
    }
}
