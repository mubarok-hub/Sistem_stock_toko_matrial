@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Stok Gudang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Stok Gudang</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-box me-1"></i>
                    Daftar Produk
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('kasir.transaksi.index') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-cash-register"></i> Transaksi
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">Kode</th>
                            <th width="20%">Nama Produk</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Satuan</th>
                            <th width="10%">Stok</th>
                            <th width="15%">Harga Jual</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $produk)
                            <tr>
                                <td>{{ $produk->kode_produk }}</td>
                                <td>{{ $produk->nama_produk }}</td>
                                <td>{{ $produk->kategori }}</td>
                                <td>{{ $produk->satuan }}</td>
                                <td>
                                    <span class="badge {{ $produk->stok <= 10 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $produk->stok }}
                                    </span>
                                </td>
                                <td>Rp{{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('kasir.transaksi.create', ['produk_id' => $produk->id]) }}" 
                                       class="btn btn-primary btn-sm" title="Beli">
                                        <i class="fas fa-shopping-cart"></i> Beli
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="py-3">
                                        <i class="fas fa-box-open fa-3x text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada produk</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $produks->appends(['q' => request('q')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
