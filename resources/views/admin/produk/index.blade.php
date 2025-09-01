@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Stok Gudang</h2>

        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary mb-3">+ Tambah Produk</a>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary mb-3">Transaksi</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produks as $produk)
                    <tr>
                        <td>{{ $produk->kode_produk }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->kategori }}</td>
                        <td>{{ $produk->satuan }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td>Rp{{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin mau hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada produk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $produks->appends(['q' => request('q')])->links() }}
        </div>
    </div>
@endsection
