@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Buat Transaksi Baru</h2>

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

    <form action="{{ route('kasir.transaksi.store') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h5>Daftar Produk</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="produkTable">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($produk)
                                <tr>
                                    <td>
                                        <input type="hidden" name="produk_id[]" value="{{ $produk->id }}" readonly>
                                        {{ $produk->nama_produk }}
                                    </td>
                                    <td>
                                        <input type="text" class="form-control harga" value="{{ number_format($produk->harga_jual, 0, ',', '.') }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control jumlah" min="1" max="{{ $produk->stok }}" value="1" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control subtotal" value="{{ number_format($produk->harga_jual, 0, ',', '.') }}" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada produk dipilih</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="produkSelect">Tambah Produk:</label>
                            <select id="produkSelect" class="form-control">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $p)
                                    <option value="{{ $p->id }}" data-harga="{{ $p->harga_jual }}" data-stok="{{ $p->stok }}" data-nama="{{ $p->nama_produk }}">{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="button" id="addProduct" class="btn btn-primary mt-4">Tambah Produk</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Informasi Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total">Total Harga:</label>
                            <input type="text" id="total" class="form-control" value="0" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bayar">Jumlah Bayar:</label>
                            <input type="number" name="bayar" id="bayar" class="form-control" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kembalian">Kembalian:</label>
                            <input type="text" id="kembalian" class="form-control" value="0" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success">Proses Transaksi</button>
                            <a href="{{ route('kasir.produk.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menghitung subtotal
        function calculateSubtotal(row) {
            const hargaText = row.querySelector('.harga').value.replace(/[^0-9]/g, '');
            const harga = parseInt(hargaText) || 0;
            const jumlah = parseInt(row.querySelector('.jumlah').value) || 0;
            const subtotal = harga * jumlah;

            row.querySelector('.subtotal').value = formatRupiah(subtotal);
            calculateTotal();

            return subtotal;
        }

        // Fungsi untuk menghitung total
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(function(subtotal) {
                const value = subtotal.value.replace(/[^0-9]/g, '');
                total += parseInt(value) || 0;
            });

            document.getElementById('total').value = formatRupiah(total);
            calculateKembalian();
        }

        // Fungsi untuk menghitung kembalian
        function calculateKembalian() {
            const totalText = document.getElementById('total').value.replace(/[^0-9]/g, '');
            const total = parseInt(totalText) || 0;
            const bayar = parseInt(document.getElementById('bayar').value) || 0;
            const kembalian = bayar - total;

            document.getElementById('kembalian').value = formatRupiah(kembalian);
        }

        // Fungsi format Rupiah
        function formatRupiah(angka) {
            let reverse = angka.toString().split('').reverse().join('');
            let ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return 'Rp' + ribuan;
        }

        // Event listener untuk perubahan jumlah
        document.querySelectorAll('.jumlah').forEach(function(input) {
            input.addEventListener('input', function() {
                calculateSubtotal(this.closest('tr'));
            });
        });

        // Event listener untuk perubahan bayar
        document.getElementById('bayar').addEventListener('input', calculateKembalian);

        // Event listener untuk tombol hapus baris
        document.querySelectorAll('.remove-row').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal();
            });
        });

        // Event listener untuk tombol tambah produk
        document.getElementById('addProduct').addEventListener('click', function() {
            const select = document.getElementById('produkSelect');
            const selectedOption = select.options[select.selectedIndex];

            if (!selectedOption.value) {
                alert('Silakan pilih produk terlebih dahulu');
                return;
            }

            const produkId = selectedOption.value;
            const produkNama = selectedOption.getAttribute('data-nama');
            const produkHarga = selectedOption.getAttribute('data-harga');
            const produkStok = selectedOption.getAttribute('data-stok');

            // Cek apakah produk sudah ada di tabel
            const existingRows = document.querySelectorAll('#produkTable tbody tr');
            for (let row of existingRows) {
                const existingId = row.querySelector('input[name="produk_id[]"]').value;
                if (existingId === produkId) {
                    alert('Produk sudah ditambahkan');
                    return;
                }
            }

            const tbody = document.querySelector('#produkTable tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <input type="hidden" name="produk_id[]" value="${produkId}" readonly>
                    ${produkNama}
                </td>
                <td>
                    <input type="text" class="form-control harga" value="${formatRupiah(produkHarga)}" readonly>
                </td>
                <td>
                    <input type="number" name="jumlah[]" class="form-control jumlah" min="1" max="${produkStok}" value="1" required>
                </td>
                <td>
                    <input type="text" class="form-control subtotal" value="${formatRupiah(produkHarga)}" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                </td>
            `;

            tbody.appendChild(newRow);

            // Tambahkan event listener ke elemen baru
            newRow.querySelector('.jumlah').addEventListener('input', function() {
                calculateSubtotal(this.closest('tr'));
            });

            newRow.querySelector('.remove-row').addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal();
            });

            // Reset select
            select.selectedIndex = 0;

            // Hitung ulang total
            calculateTotal();
        });

        // Hitung total saat halaman dimuat
        calculateTotal();
    });
</script>
@endpush
