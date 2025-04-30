@extends('Backend.main')

@section('title', 'Pengeluaran')
@section('page', 'Manajemen Pengeluaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Pengeluaran</h6>
                    <div class="text-start ps-3">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                            <i class="fas fa-plus"></i> Tambah Pengeluaran
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Pengeluaran</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Jumlah</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Jenis Pembayaran</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengguna
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Catatan
                                </th>
                                @if ($role !== 'kasir')
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through expenses data -->
                            @foreach($expenses as $index => $expense)
                            <tr>
                                <td><span class="text-xs font-weight-bold">{{ $index + 1 }}</span></td>
                                <td><span class="text-xs font-weight-bold">{{ $expense->expense_name }}</span></td>
                                <td><span class="text-xs font-weight-bold">Rp.
                                        {{ number_format($expense->amount, 2) }}</span>
                                </td>
                                <td> <span class="text-xs font-weight-bold">{{ $expense->paymentType->name }}</span>
                                </td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y, H:i') }}</span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ $expense->user->username }}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-light text-white" data-bs-toggle="modal"
                                        data-bs-target="#noteModal{{ $expense->id }}">
                                        <i class="fas fa-sticky-note text-primary" style="font-size: 18px;"></i>
                                    </button>

                                    <!-- Modal Catatan -->
                                    <div class="modal fade" id="noteModal{{ $expense->id }}" tabindex="-1"
                                        aria-labelledby="noteModalLabel{{ $expense->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-gradient-primary text-white">
                                                    <h5 class="modal-title text-white"
                                                        id="noteModalLabel{{ $expense->id }}">
                                                        Catatan Pengeluaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-dark">{{ $expense->note ?? 'Tidak ada catatan' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                @if ($role !== 'kasir')
                                <td class="align-middle">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
                                            Delete</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $expenses->links() }}
                    <!-- Ini menambahkan tombol untuk navigasi -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Pengeluaran -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary ">
                <h5 class="modal-title text-white text-capitalize ps-3 " id="addExpenseModalLabel">Tambah Pengeluaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="expense_name" class="form-label">Nama Pengeluaran</label>
                        <input type="text" class="form-control border" id="expense_name" name="expense_name" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="amount" class="form-label">Jumlah</label>
                        <input type="number" class="form-control border" id="amount" name="amount" step="0.01" required>
                    </div>
                    <!-- Dropdown Jenis Pembayaran -->
                    <div class="mb-3 border p-3 rounded">
                        <label for="payment_type_id" class="form-label">Jenis Pembayaran</label>
                        <select class="form-control border" id="payment_type_id" name="payment_type_id" required>
                            <option value="">Pilih Jenis Pembayaran</option>
                            @foreach($paymentTypes as $paymentType)
                            <option value="{{ $paymentType->id }}">{{ $paymentType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control border" id="date" name="date" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <!--  Tambahkan input catatan -->
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control border" id="note" name="note" rows="3"
                            placeholder="Tulis catatan jika perlu..."></textarea>
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
    return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?');
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