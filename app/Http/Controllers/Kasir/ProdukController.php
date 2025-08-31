<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kode_produk', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $produks = $query->paginate(10);

        // View khusus kasir
        return view('kasir.produk.index', compact('produks'))
               ->with('q', $request->q);
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('kasir.produk.show', compact('produk'));
    }
}
