@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
        <li class="breadcrumb-item active">Edit Produk</li>
    </ol>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Form Edit Produk: {{ $produk->nama_produk }}
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oops!</strong> Ada kesalahan saat mengisi form:
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                        value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="kode_produk" class="form-label">Kode Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    <input type="text" class="form-control" id="kode_produk" name="kode_produk" 
                                        value="{{ $produk->kode_produk }}" readonly>
                                </div>
                                <div class="form-text">Kode produk tidak dapat diubah</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kategori" class="form-label">Kategori</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <select name="kategori" id="kategori" class="form-select" required>
                                        <option value="Semen & Perekat" {{ $produk->kategori == 'Semen & Perekat' ? 'selected' : '' }}>Semen & Perekat</option>
                                        <option value="Besi & Baja" {{ $produk->kategori == 'Besi & Baja' ? 'selected' : '' }}>Besi & Baja</option>
                                        <option value="Cat & Aksesoris" {{ $produk->kategori == 'Cat & Aksesoris' ? 'selected' : '' }}>Cat & Aksesoris</option>
                                        <option value="Alat Tukang" {{ $produk->kategori == 'Alat Tukang' ? 'selected' : '' }}>Alat Tukang</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="satuan" class="form-label">Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                    <input type="text" id="satuan" name="satuan" class="form-control" 
                                        value="{{ old('satuan', $produk->satuan) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="stok" class="form-label">Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                                    <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" 
                                        class="form-control" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" id="harga_beli" name="harga_beli" 
                                        value="{{ old('harga_beli', $produk->harga_beli) }}" class="form-control" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="harga_jual" class="form-label">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" id="harga_jual" name="harga_jual" 
                                        value="{{ old('harga_jual', $produk->harga_jual) }}" class="form-control" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Produk
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tr>
                                <th>Kode Produk:</th>
                                <td>{{ $produk->kode_produk }}</td>
                            </tr>
                            <tr>
                                <th>Stok Saat Ini:</th>
                                <td>
                                    <span class="badge {{ $produk->stok <= 10 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $produk->stok }} {{ $produk->satuan }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Harga Beli:</th>
                                <td>Rp{{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual:</th>
                                <td>Rp{{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Keuntungan:</th>
                                <td>Rp{{ number_format($produk->harga_jual - $produk->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <hr>

                    <p><strong>Catatan:</strong></p>
                    <ul>
                        <li>Kode produk tidak dapat diubah karena sudah terhubung dengan data transaksi</li>
                        <li>Perubahan stok akan langsung mempengaruhi ketersediaan produk</li>
                        <li>Perubahan harga akan berlaku untuk transaksi selanjutnya</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
