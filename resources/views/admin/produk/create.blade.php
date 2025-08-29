@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Tambah Produk</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Oops!</strong> Ada kesalahan saat mengisi form:
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.produk.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk"
                            value="{{ old('nama_produk') }}"required>
                    </div>

                    <div class="mb-3">
                        <label for="kode_produk" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control" name="kode_produk" value="{{ old('kode_produk') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" name="satuan" class="form-control" placeholder="kg, dus, sak, dll"
                            value="{{ old('satuan') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Semen & Perekat">Semen & Perekat</option>
                            <option value="Besi & Baja">Besi & Baja</option>
                            <option value="Cat & Aksesoris">Cat & Aksesoris</option>
                            <option value="Alat Tukang">Alat Tukang</option>
                            <!-- Tambahkan lainnya sesuai kebutuhan -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" value="{{ old('harga_beli') }}" name="harga_beli" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}" class="form-control"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
