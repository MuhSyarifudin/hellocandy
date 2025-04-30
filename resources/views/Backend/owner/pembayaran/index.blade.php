@extends('Backend.main')

@section('title', 'Metode Pembayaran')
@section('page', 'Daftar Metode Pembayaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Metode Pembayaran</h6>
                    <div class="text-start ps-3">
                        @if ($role !== 'kasir')
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createPaymentModal">
                            <i class="fas fa-plus"></i> Tambah Metode Pembayaran
                        </button>
                        @endif
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Metode</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipe
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat
                                </th>
                                @if ($role !== 'kasir')
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentMethods as $index => $method)
                            <tr>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $method->method_name }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $method->type }}</span>
                                </td>
                                <td>
                                    <span
                                        class="text-xs font-weight-bold">{{ $method->created_at->format('d-m-Y H:i') }}</span>
                                </td>
                                @if ($role !== 'kasir')
                                <td class="align-middle">
                                    <a href="{{ route('payment_methods.edit', $method->id) }}" class="btn btn-secondary"
                                        data-toggle="tooltip" data-original-title="Edit Metode">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('payment_methods.destroy', $method->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                            data-original-title="Delete Metode">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{   $paymentMethods->links() }}
                    <!-- Ini menambahkan tombol untuk navigasi -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Metode Pembayaran -->
<div class="modal fade" id="createPaymentModal" tabindex="-1" aria-labelledby="createPaymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary ">
                <h5 class="modal-title text-white text-capitalize ps-3 " id="createPaymentModalLabel">Tambah Metode
                    Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('payment_methods.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="method_name" class="form-label">Nama Metode Pembayaran</label>
                        <input type="text" class="form-control border" id="method_name" name="method_name" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="type" class="form-label">Tipe Pembayaran</label>
                        <select class="form-control border" id="type" name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="DP 50%">DP 50%</option>
                            <option value="Full">Full</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
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
    return confirm('Apakah Anda yakin ingin menghapus metode pembayaran ini?');
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