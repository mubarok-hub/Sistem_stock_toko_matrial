@extends('layouts.app')

@section('content')
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Ada kesalahan saat mengisi form:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.update', $produk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kode Produk</label>
                <input type="text" name="kode_produk" value="{{ $produk->kode_produk }}" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="Semen & Perekat" {{ $produk->kategori == 'Semen & Perekat' ? 'selected' : '' }}>Semen &
                        Perekat</option>
                    <option value="Besi & Baja" {{ $produk->kategori == 'Besi & Baja' ? 'selected' : '' }}>Besi & Baja
                    </option>
                    <option value="Cat & Aksesoris" {{ $produk->kategori == 'Cat & Aksesoris' ? 'selected' : '' }}>Cat &
                        Aksesoris</option>
                    <option value="Alat Tukang" {{ $produk->kategori == 'Alat Tukang' ? 'selected' : '' }}>Alat Tukang
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label>Satuan</label>
                <input type="text" name="satuan" value="{{ $produk->satuan }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli" value="{{ $produk->harga_beli }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" value="{{ $produk->harga_jual }}" class="form-control" required>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
