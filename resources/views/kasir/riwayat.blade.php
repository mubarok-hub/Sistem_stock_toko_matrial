@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Riwayat Transaksi</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>Rp {{ number_format($item->total_bayar) }}</td>
                        <td>
                            <a href="{{ route('kasir.riwayat.detail', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $transaksis->links() }}
    </div>
@endsection
