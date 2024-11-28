@extends('layouts.admin')

@section('content')
<div class="container py-1">
    <h1 class="text-start mb-5 font-weight-bold">Laporan Keuangan Bulanan</h1>

    <!-- Form Pilihan Tahun dan Bulan -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('keuangan.laporan') }}" class="row align-items-center">
                @csrf
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select class="form-select" name="tahun" id="tahun">
                            <option value="" selected disabled>Pilih Tahun</option>
                            @foreach ($tahunBulan as $tahun => $bulans)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select class="form-select" name="bulan" id="bulan">
                            <option value="" selected disabled>Pilih Bulan</option>
                            @if(isset($tahun) && isset($tahunBulan[$tahun]))
                                @foreach ($tahunBulan[$tahun] as $bulanItem)
                                    <option value="{{ str_pad($bulanItem->bulan, 2, '0', STR_PAD_LEFT) }}">
                                        {{ DateTime::createFromFormat('!m', $bulanItem->bulan)->format('F') }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Laporan dan Tabel -->
    @if(isset($laporan))
        <div class="card shadow-sm">
            <div class="card-header px-3 py-3 text-center bg-secondary text-white">
                <h5>Laporan Keuangan Bulan: {{ $bulanOptions[$bulan] }} {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="text-end mb-4">
                    <a href="{{ route('keuangan.download', ['tahun' => request('tahun'), 'bulan' => request('bulan')]) }}" 
                        class="btn btn-success">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah Transaksi</th>
                                <th>Penghasilan</th>
                                <th>Rincian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $data)
                                <tr>
                                    <td>{{ date('d M Y', strtotime($data->tanggal)) }}</td>
                                    <td class="text-center">{{ $data->jumlah_transaksi }}</td>
                                    <td class="text-end">Rp {{ number_format($data->penghasilan, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('keuangan.detail', ['tanggal' => $data->tanggal]) }}" class="btn btn-link text-primary">
                                            <i class="fas fa-info-circle"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
