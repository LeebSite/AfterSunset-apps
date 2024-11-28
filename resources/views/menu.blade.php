@extends('layouts.admin')

@section('content')
<div class="container py-2">
    <h1 class="mb-4 font-weight-bold">Daftar Menu</h1>

    <!-- Tombol Tambah Menu -->
    <button type="button" class="btn btn-success mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#addMenuModal">
        <i class="bi bi-plus-circle me-2"></i> Tambah Menu
    </button>

    <!-- Tabel Menu -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Gambar</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>   
            </tr>
        </thead>
        <tbody>
            @foreach($menu as $index => $menu)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><img src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama }}" style="height: 100px; object-fit: cover;"></td>
                    <td>{{ $menu->nama }}</td>
                    <td>{{ $menu->kategori ? $menu->kategori->nama : 'Kategori tidak tersedia' }}</td>
                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                            data-bs-target="#editMenuModal-{{ $menu->id }}">
                            <i class="bi bi-pencil-square"></i> Ubah
                        </button>

                        <!-- Tombol Hapus dengan Modal Konfirmasi -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                            data-bs-target="#deleteMenuModal-{{ $menu->id }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                <!-- Modal Tambah Menu -->
                <div class="modal fade" id="addMenuModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Menu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Menu</label>
                                        <input type="text" class="form-control" name="nama" required placeholder="Masukkan Nama Menu" oninvalid="this.setCustomValidity('Harap diisi !')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="number" class="form-control" name="harga" required placeholder="Masukkan Harga" oninvalid="this.setCustomValidity('Harap diisi !')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" class="form-control" name="gambar" required oninvalid="this.setCustomValidity('Harap diisi !')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori_id" class="form-label">Kategori</label>
                                        <select name="kategori_id" class="form-control" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategori as $kat)
                                                <option value="{{ $kat->id }}" 
                                                    {{ $menu->kategori_id == $kat->id ? 'selected' : '' }}>
                                                    {{ $kat->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Menu -->
                <div class="modal fade" id="editMenuModal-{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Menu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Menu</label>
                                        <input type="text" class="form-control" name="nama" value="{{ $menu->nama }}" required placeholder="Masukkan Nama Menu" oninvalid="this.setCustomValidity('Harap diisi !')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="number" class="form-control" name="harga" value="{{ $menu->harga }}" required placeholder="Masukkan Harga" oninvalid="this.setCustomValidity('Harap diisi !')" oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" class="form-control" name="gambar" >
                                        <small class="text-muted font-weight-light">*Kosongkan jika tidak ingin mengganti gambar</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori_id" class="form-label">Kategori</label>
                                        <select name="kategori_id" class="form-control" required oninvalid="this.setCustomValidity('Harap diisi !')" oninput="this.setCustomValidity('')">>
                                            @foreach($kategori as $item)
                                            <option value="{{ $item->id }}" 
                                                {{ $menu->kategori_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                            @endforeach                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus Menu -->
                <div class="modal fade" id="deleteMenuModal-{{ $menu->id }}" tabindex="-1" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMenuModalLabel">Konfirmasi Hapus Menu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus menu <strong>{{ $menu->nama }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    @if (session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pemberitahuan</h5>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                new bootstrap.Modal(document.getElementById('successModal')).show();
            @endif
        });
    </script>
@endsection