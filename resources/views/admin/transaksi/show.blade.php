@extends('layouts.app')

@section('styles')
    <!-- Custom styles for admin transaksi show -->
@endsection

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h4>Detail Transaksi</h4>
            </div>
            <div class="card-body">
                <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
                <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y H:i') }}</p>
                <p><strong>Total:</strong> Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
                <p><strong>Bayar:</strong> Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p>
                <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>

                <h5>Produk:</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->detailTransaksi as $detail)
                            <tr>
                                <td>{{ $detail->produk->nama_produk }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                    <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Custom scripts for admin transaksi show -->
@endsection
