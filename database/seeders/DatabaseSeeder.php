<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('tb_produk')->insert([
            [
                'nama_produk' => 'Matcha',
                'harga' => '7000',
                'stok' => '12',
                'created_at' => now()
            ],
            [
                'nama_produk' => 'Kopi Susu',
                'harga' => '12000',
                'stok' => '23',
                'created_at' => now()
            ],
        ]);
    }
}
