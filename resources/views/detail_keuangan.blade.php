@extends('layouts.admin')

@section('content')
<div class="container px-4">
    <!-- Tombol Kembali -->
    <a href="{{ route('keuangan.laporan', ['tahun' => session('keuangan_tahun'), 'bulan' => session('keuangan_bulan')]) }}" 
        class="btn btn-light shadow-sm p-2 mb-4 bg-light rounded font-weight-bold">
         <i class="fas fa-chevron-left"></i> Kembali
     </a>     

    <!-- Judul Halaman -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Detail Transaksi - Tanggal: {{ $tanggal }}</h4>
        </div>
        <div class="card-body">
            <!-- Tabel Detail Transaksi -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>No Pesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Data Pesanan</th>
                            <th>Total Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailPesanans as $pesanan)
                            <tr>
                                <td class="text-center">{{ $pesanan->id }}</td>
                                <td>{{ $pesanan->nama_pemesanan }}</td>
                                <td>
                                    @foreach($pesanan->detailPesanan as $detail)
                                        <div>
                                            <strong>{{ $detail->menu->nama }}</strong> 
                                            ({{ $detail->jumlah }} pcs) - 
                                            Rp{{ number_format($detail->harga_total, 0, ',', '.') }}
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    Rp{{ number_format($pesanan->detailPesanan->sum('harga_total'), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
