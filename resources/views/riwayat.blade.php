@extends('layouts.admin')

@section('content')
<div class="container py-1">
    <h1 class="mb-4 font-weight-bold">Riwayat Pemesanan</h1>

    <div class="d-flex mb-3">
        <div class="ms-auto input-group" style="width: 300px;">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="search-name" class="form-control" placeholder="Cari nama pemesan">
            <button class="btn btn-primary button-cari" type="button" onclick="fetchResults()">Cari</button>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>No Pesanan</th>
                <th>Tanggal Transaksi</th>
                <th>Data Pesanan</th>
                <th>Total Pesanan</th>
            </tr>
        </thead>
        <tbody id="transaction-list">
            @foreach($pesanans as $pesanan)
            <tr>
                <td>{{ $pesanan->nama_pemesanan }}</td>
                <td>{{ $pesanan->id }}</td>
                <td>{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d-m-Y') }}</td>
                <td>
                    @foreach($pesanan->detailPesanan as $detail)
                        {{ $detail->menu->nama }} ({{ $detail->jumlah }} pcs) - Rp {{ number_format($detail->harga_total, 2) }}<br>
                    @endforeach
                </td>
                <td>Rp {{ number_format($pesanan->uang_dibayar - $pesanan->kembalian, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pesan Data Tidak Ditemukan -->
    <div id="no-results" class="text-center mt-4" style="display: none;">
        <i class="fas fa-times-circle text-danger" style="font-size: 3rem;"></i>
        <p class="text-danger">Transaksi tidak ditemukan</p>
    </div>

    <!-- Navigasi Halaman -->
    <div class="d-flex justify-content-end">
        {{ $pesanans->links('pagination::bootstrap-4') }}
    </div>
</div>

<script>
    let debounceTimer;

    document.getElementById('search-name').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchResults, 500);
    });

    function fetchResults() {
        let query = document.getElementById('search-name').value.trim();

        fetch(`/riwayat/search?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                let tableBody = document.getElementById('transaction-list');
                let noResults = document.getElementById('no-results');
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';

                    data.forEach(pesanan => {
                        let details = pesanan.detail_pesanan.map(detail => 
                            `${detail.menu.nama} (${detail.jumlah} pcs) - Rp ${parseFloat(detail.harga_total).toFixed(2)}`
                        ).join('<br>');

                        let row = `
                            <tr>
                                <td>${pesanan.nama_pemesanan}</td>
                                <td>${pesanan.id}</td>
                                <td>${new Date(pesanan.created_at).toLocaleDateString('id-ID')}</td>
                                <td>${details}</td>
                                <td>Rp ${parseFloat(pesanan.uang_dibayar - pesanan.kembalian).toFixed(2)}</td>
                            </tr>`;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                }
            });
    }
</script>
@endsection
