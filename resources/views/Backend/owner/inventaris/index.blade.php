@extends('Backend.main')

@section('title', 'Inventory')
@section('page', 'Inventory Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Inventaris</h6>
                    <div class="text-start ps-3">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
                            <i class="fas fa-plus"></i> Tambah Perubahan Stok
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div id="success-alert" class="alert alert-success fade show text-white" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produk
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jenis
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Perubahan Stok</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Keterangan
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengguna
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through inventory data -->
                            @foreach($inventories as $index => $inventory)
                            <tr>
                                <td><span class="text-xs font-weight-bold">{{ $index + 1 }}</span></td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ $inventory->product->product_name }}</span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ ucfirst($inventory->type) }}</span></td>
                                <td>
                                    <span
                                        class="text-xs font-weight-bold {{ $inventory->quantity_change > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $inventory->quantity_change > 0 ? '+' : '' }}{{ $inventory->quantity_change }}
                                    </span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ ucfirst($inventory->reason) }}</span></td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($inventory->date)->format('d M Y, H:i') }}</span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ $inventory->user->username }}</span></td>
                                <td class="align-middle">
                                    <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
                                            Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{  $inventories->links() }}
                    <!-- Ini menambahkan tombol untuk navigasi -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Inventaris -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary ">
                <h5 class="modal-title text-white text-capitalize ps-3 " id="addInventoryModalLabel">Tambah Perubahan
                    Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="product_id" class="form-label">Produk</label>
                        <select class="form-control border" id="product_id" name="product_id" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="type" class="form-label">Jenis</label>
                        <select class="form-control border" id="type" name="type" required>
                            <option value="">Pilih Jenis</option>
                            <option value="operasional">Operasional</option>
                            <option value="non-operasional">Non-Operasional</option>
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="quantity_change" class="form-label">Perubahan Stok</label>
                        <input type="number" class="form-control border" id="quantity_change" name="quantity_change"
                            required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="reason" class="form-label">Keterangan</label>
                        <input type="text" class="form-control border" id="reason" name="reason" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control border" id="date" name="date" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-times"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Konfirmasi Penghapusan -->
<script>
function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus perubahan stok ini?');
}

// Menghilangkan alert setelah 5 detik
setTimeout(() => {
    const alert = document.getElementById('success-alert');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500); // Hapus dari DOM
    }
}, 5000);
</script>
@endsection