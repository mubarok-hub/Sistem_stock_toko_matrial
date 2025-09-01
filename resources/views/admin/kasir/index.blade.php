@extends('layouts.app')

@section('content')
    <div class="container px-4">
        <h1 class="mt-4">Pencatatan Transaksi</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            {{-- Kolom Kiri: Form untuk Menambahkan Produk --}}
            <div class="col-md-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Produk
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kasir.transaksi.addToCart') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Pilih Produk</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->harga }}">
                                            {{ $product->nama }} (Stok: {{ $product->stok }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                    min="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-cart-plus me-1"></i> Tambah ke
                                Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Transaksi --}}
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-shopping-cart me-1"></i> Keranjang Belanja
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @forelse (session('cart', []) as $item)
                                        <tr>
                                            <td>{{ $item['nama'] }}</td>
                                            <td class="text-end">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $item['quantity'] }}</td>
                                            <td class="text-end">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('kasir.transaksi.removeFromCart', $item['id']) }}" class="btn btn-danger btn-sm">Hapus</a>
                                            </td>
                                        </tr>
                                        @php
                                            $total += $item['subtotal'];
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Keranjang kosong. Tambahkan
                                                produk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan Bawah: Pembayaran --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kasir.transaksi.checkout') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5>Total: <span id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </h5>
                                    <input type="hidden" name="total_bayar" value="{{ $total }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="bayar" class="form-label">Jumlah Dibayar</label>
                                    <input type="number" class="form-control" id="bayar" name="bayar" required
                                        min="{{ $total }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <h5>Kembalian: <span id="kembalian-display">Rp 0</span></h5>
                                    <input type="hidden" name="kembalian" id="kembalian-input">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-money-bill-wave me-1"></i> Selesaikan Transaksi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bayarInput = document.getElementById('bayar');
            const kembalianDisplay = document.getElementById('kembalian-display');
            const kembalianInput = document.getElementById('kembalian-input');
            const totalBayar = {{ $total }};

            bayarInput.addEventListener('input', function() {
                const bayar = parseFloat(this.value) || 0;
                const kembalian = bayar - totalBayar;

                kembalianDisplay.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
                kembalianInput.value = kembalian;
            });
        });
    </script>
@endsection
