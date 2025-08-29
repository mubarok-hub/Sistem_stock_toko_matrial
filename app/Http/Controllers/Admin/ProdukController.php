<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kode_produk' => 'required|string|max:50|unique:produks,kode_produk',
            'kategori' => 'required|string|max:100',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
        ]);

        Produk::create($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kode_produk' => 'required|string|max:50|unique:produks,kode_produk,' . $id,
            'kategori' => 'required|string|max:100',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
