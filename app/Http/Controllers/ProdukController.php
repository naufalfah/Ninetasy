<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::join('tb_kategori', 'tb_produk.kategori_id', 'tb_kategori.id')
            ->select('tb_produk.*', 'tb_kategori.nama_kategori')
            ->orderBy('tb_produk.id')
            ->get();
        $kategori = Kategori::all();

        return view('pages.admin.produk.index', compact('produk', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdukRequest $request)
    {
        $produk = $request->validated();

        if ($request->hasFile('produk_gambar')) {
            $produk['gambar'] = $request->file('produk_gambar')->store('produk', 'public');
        }

        unset($produk['produk_gambar']);

        Produk::create($produk);

        return redirect(route('admin.produk.index'))->with('pesan', 'Produk berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();

        return view('pages.admin.produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukRequest $request, string $id)
    {
        $produkData = $request->validated();
        $produk = Produk::findOrFail($id);

        if ($request->hasFile('produk_gambar')) {
            $produkData['gambar'] = $request->file('produk_gambar')->store('produk', 'public');

            // Hapus file gambar lama jika ada
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
        }

        unset($produkData['produk_gambar']);

        $produk->update($produkData);

        return redirect(route('admin.produk.index'))->with('pesan', 'Data telah diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::find($id);

        if ($produk) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $produk->delete();
        }

        return redirect(route('admin.produk.index'))->with('pesan', 'Produk berhasil dihapus!');
    }
}
