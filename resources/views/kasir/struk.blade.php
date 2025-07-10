@extends('layouts.app')

@section('content')
    <div class="container" id="print-area">
        <h4 class="text-center">TOKO BANGUNAN MAKMUR</h4>
        <p class="text-center">Jl. Contoh No. 123 - Telp. 0812-3456-7890</p>
        <hr>

        <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i') }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detailTransaksi as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h5>Total: Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</h5>
        <p>Bayar: Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p>
        <p>Kembalian: Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>

        <hr>
        <p class="text-center">Terima kasih telah berbelanja!</p>

        <div class="text-center mt-3">
            <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Struk</button>
            <a href="{{ route('kasir.index') }}" class="btn btn-secondary">🔙 Kembali ke Kasir</a>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            button,
            a {
                display: none;
            }
        }
    </style>
@endsection
