@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Transaksi Kasir</h1>

        <form action="{{ route('kasir.store') }}" method="POST">
            @csrf

            <table class="table table-bordered" id="kasir-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        {{-- <th>Kode Produk</th> --}}
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-body">
                    <tr>
                        <td>
                            <select name="produk_id[]" class="form-select produk-select select2-produk" required>

                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_jual }}">
                                        {{ $produk->nama_produk }} ({{ $produk->stok }} stok)
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        {{-- <td>
                            <select name="produk_id[]" class="form-select produk-select select2-produk" required>

                                <option value="">-- Kode Produk --</option>
                                @foreach ($kodes as $kode)
                                    <option value="{{ $kode->id }}" data-harga="{{ $kode->harga_jual }}">
                                        {{ $kode->nama_produk }} ({{ $kode->stok }} stok)
                                    </option>
                                @endforeach
                            </select>
                        </td> --}}
                        <td><input type="number" class="form-control harga_satuan" name="harga_satuan[]" readonly></td>
                        <td><input type="number" class="form-control jumlah" name="jumlah[]" value="1" min="1"
                                required></td>
                        <td><input type="number" class="form-control subtotal" name="subtotal[]" readonly></td>
                        <td><button type="button" class="btn btn-danger btn-hapus">Hapus</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-secondary" id="tambah-produk">+ Tambah Produk</button>
            <hr>
            <h4>Total: Rp <span id="total-harga">0</span></h4>
            <div class="mb-3">
                <label for="bayar" class="form-label">Bayar</label>
                <input type="number" class="form-control" name="bayar" id="bayar" required>
            </div>
            <div class="mb-3">
                <label for="kembalian" class="form-label">Kembalian</label>
                <input type="number" class="form-control" name="kembalian" id="kembalian" required>
            </div>
            <button type="submit" class="btn btn-primary">Cetak Struk</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function hitungSubtotal(row) {
                let harga = parseInt(row.querySelector('.harga_satuan').value) || 0;
                let jumlah = parseInt(row.querySelector('.jumlah').value) || 0;
                let subtotal = harga * jumlah;
                row.querySelector('.subtotal').value = subtotal;
                return subtotal;
            }

            function hitungTotal() {
                let total = 0;
                document.querySelectorAll('#produk-body tr').forEach(row => {
                    total += hitungSubtotal(row);
                });
                document.getElementById('total-harga').textContent = total.toLocaleString('id-ID');
            }

            document.getElementById('bayar').addEventListener('input', function() {
                let total = 0;
                document.querySelectorAll('#produk-body tr').forEach(row => {
                    total += parseInt(row.querySelector('.subtotal').value) || 0;
                });

                let bayar = parseInt(this.value) || 0;
                let kembalian = bayar - total;
                document.getElementById('kembalian').value = kembalian >= 0 ? kembalian.toLocaleString(
                    'id-ID') : '0';
            });

            document.getElementById('produk-body').addEventListener('change', function(e) {
                let row = e.target.closest('tr');

                if (e.target.classList.contains('produk-select')) {
                    let selected = e.target.options[e.target.selectedIndex];
                    row.querySelector('.harga_satuan').value = selected.dataset.harga;
                }

                hitungSubtotal(row);
                hitungTotal();
            });

            document.getElementById('produk-body').addEventListener('input', function(e) {
                if (e.target.classList.contains('jumlah')) {
                    let row = e.target.closest('tr');
                    hitungSubtotal(row);
                    hitungTotal();
                }
            });

            document.getElementById('tambah-produk').addEventListener('click', function() {
                let row = document.querySelector('#produk-body tr').cloneNode(true);
                row.querySelectorAll('input').forEach(input => input.value = '');
                row.querySelector('.produk-select').selectedIndex = 0;
                document.getElementById('produk-body').appendChild(row);

                // Reinitialize Select2 for the new row
                $(row).find('.select2-produk').select2({
                    placeholder: '-- Cari Produk (nama atau kode) --',
                    allowClear: true
                });
            });

            document.getElementById('produk-body').addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-hapus')) {
                    e.target.closest('tr').remove();
                    hitungTotal();
                }
            });
        });
        $(document).ready(function() {
            // Inisialisasi Select2 untuk semua elemen dengan class select2-produk
            $('.select2-produk').select2({
                placeholder: '-- Cari Produk (nama atau kode) --',
                allowClear: true
            });
        });
    </script>
@endsection
