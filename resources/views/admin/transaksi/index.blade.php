@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Riwayat Transaksi</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->id }}</td>
                            <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.transaksi.show', $trx->id) }}" class="btn btn-info btn-sm">Detail</a>
                                {{-- nanti bisa tambah tombol cetak struk di sini --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
