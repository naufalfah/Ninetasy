<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class HomeController extends Controller
{
    public function dashboard()
    {
        $produk = Produk::count();

        return view('pages.admin.dashboard', compact('produk'));
    }

    public function landing()
    {
        return view('pages.user.landing');
    }
}
