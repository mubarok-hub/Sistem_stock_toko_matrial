@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
        <li class="breadcrumb-item active">Tambah Produk</li>
    </ol>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-1"></i>
                    Form Tambah Produk
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

                    <form action="{{ route('admin.produk.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                        value="{{ old('nama_produk') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="kode_produk" class="form-label">Kode Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    <input type="text" class="form-control" id="kode_produk" name="kode_produk" 
                                        value="{{ old('kode_produk') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kategori" class="form-label">Kategori</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <select name="kategori" id="kategori" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Semen & Perekat" {{ old('kategori') == 'Semen & Perekat' ? 'selected' : '' }}>Semen & Perekat</option>
                                        <option value="Besi & Baja" {{ old('kategori') == 'Besi & Baja' ? 'selected' : '' }}>Besi & Baja</option>
                                        <option value="Cat & Aksesoris" {{ old('kategori') == 'Cat & Aksesoris' ? 'selected' : '' }}>Cat & Aksesoris</option>
                                        <option value="Alat Tukang" {{ old('kategori') == 'Alat Tukang' ? 'selected' : '' }}>Alat Tukang</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="satuan" class="form-label">Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                    <input type="text" id="satuan" name="satuan" class="form-control" 
                                        placeholder="kg, dus, sak, dll" value="{{ old('satuan') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="stok" class="form-label">Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                                    <input type="number" id="stok" name="stok" value="{{ old('stok') }}" 
                                        class="form-control" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" id="harga_beli" name="harga_beli" 
                                        value="{{ old('harga_beli') }}" class="form-control" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="harga_jual" class="form-label">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" id="harga_jual" name="harga_jual" 
                                        value="{{ old('harga_jual') }}" class="form-control" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Produk
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
                    Informasi
                </div>
                <div class="card-body">
                    <p>Isi form dengan lengkap untuk menambah produk baru ke dalam sistem.</p>
                    <ul>
                        <li><strong>Kode Produk</strong> harus unik dan tidak boleh sama dengan produk lain</li>
                        <li><strong>Harga Beli</strong> adalah harga pembelian produk dari supplier</li>
                        <li><strong>Harga Jual</strong> adalah harga penjualan produk ke customer</li>
                        <li><strong>Stok</strong> adalah jumlah ketersediaan produk saat ini</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
