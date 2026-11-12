<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'name' => 'Naufal',
                'email' => 'naufal123@gmail.com',
                'password' => Hash::make('1223344'),
                'role' => 'admin',
            ],
            [
                'name' => 'User',
                'email' => 'user123@gmail.com',
                'password' => Hash::make('654321'),
                'role' => 'user',
            ],
        ]);

        // DB::table('tb_kategori')->insert([
        //     [
        //         'nama_kategori' => 'Makanan',
        //     ],
        //     [
        //         'nama_kategori' => 'Minuman',
        //     ],
        // ]);

        // DB::table('tb_produk')->insert([
        //     [
        //         'nama_produk' => 'Matcha',
        //         'harga' => '7000',
        //         'stok' => '12',
        //         'kategori_id' => 2,
        //         'created_at' => now(),
        //     ],
        //     [
        //         'nama_produk' => 'Kopi Susu',
        //         'harga' => '12000',
        //         'stok' => '23',
        //         'kategori_id' => 1,
        //         'created_at' => now(),
        //     ],
        // ]);

    }
}
