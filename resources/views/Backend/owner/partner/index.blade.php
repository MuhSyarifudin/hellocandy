@extends('Backend.main')

@section('title', 'Manajemen Mitra')
@section('page', 'Daftar Mitra')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Mitra</h6>
                    <div class="text-start ps-3">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createPartnerModal">
                            <i class="fas fa-plus"></i> Tambah Mitra Baru
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

                <!-- Filter Form -->
                <form method="GET" action="{{ route('partners.index') }}" class="d-flex flex-wrap px-3 my-3">
                    <div class="d-flex align-items-center me-3">
                        <input type="text" name="search" class="form-control me-2 border border-2"
                            placeholder="Cari nomor telepon..." value="{{ request('search') }}"
                            style="max-width: 300px;">
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="form-check form-switch me-3">
                            <input class="form-check-input" type="checkbox" name="filter" value="customer"
                                id="customerOnlySwitch" {{ request('filter') === 'customer' ? 'checked' : '' }}>
                            <label class="form-check-label" for="customerOnlySwitch">Customer Saja</label>
                        </div>
                        <button type="submit" class="btn btn-primary px-3">Filter</button>
                    </div>
                </form>


                <!-- Tabel Data -->
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="partnersTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Mitra</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipe
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telepon
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partners as $index => $partner)
                            <tr>
                                <td>
                                    <span
                                        class="text-xs font-weight-bold">{{ $loop->iteration + ($partners->currentPage() - 1) * $partners->perPage() }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $partner->name }}</span>
                                </td>
                                <td class="type">
                                    <span class="text-xs font-weight-bold">{{ $partner->type }}</span>
                                </td>
                                <td class="phone">
                                    <span class="text-xs font-weight-bold">{{ $partner->phone }}</span>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('partners.edit', $partner->id) }}" class="btn btn-secondary"
                                        data-toggle="tooltip" data-original-title="Edit Mitra"> <i
                                            class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('partners.destroy', $partner->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                            data-original-title="Delete Mitra"> <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $partners->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Mitra -->
<div class="modal fade" id="createPartnerModal" tabindex="-1" aria-labelledby="createPartnerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white text-capitalize ps-3" id="createPartnerModalLabel">Tambah Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('partners.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="name" class="form-label">Nama Mitra</label>
                        <input type="text" class="form-control border" id="name" name="name" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control border" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="type" class="form-label">Tipe Mitra</label>
                        <select class="form-control border" id="type" name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="supplier">Supplier</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                                class="fas fa-times"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Konfirmasi Penghapusan -->
<script>
// Menghilangkan alert setelah 5 detik
setTimeout(() => {
    const alert = document.getElementById('success-alert');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500); // Hapus dari DOM
    }
}, 5000);

function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus mitra ini?');
}
</script>

@endsection