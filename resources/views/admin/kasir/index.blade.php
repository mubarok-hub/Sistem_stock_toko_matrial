@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Menejemen Transaksi</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.kasir.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ route('admin.kasir.destroy', $item->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $transaksis->links() }}
    </div>
@endsection
