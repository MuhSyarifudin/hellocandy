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
                            Tambah Pengeluaran
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div class="alert alert-success fade show" role="alert" id="successAlert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengguna
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through expenses data -->
                            @foreach($expenses as $index => $expense)
                            <tr>
                                <td><span class="text-xs font-weight-bold">{{ $index + 1 }}</span></td>
                                <td><span class="text-xs font-weight-bold">{{ $expense->expense_name }}</span></td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ number_format($expense->amount, 2) }}</span>
                                </td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y, H:i') }}</span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ $expense->user->username }}</span></td>
                                <td class="align-middle">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-secondary">
                                        Edit
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Pengeluaran -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Tambah Pengeluaran</h5>
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
                    <div class="mb-3 border p-3 rounded">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control border" id="date" name="date" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

// Menyembunyikan alert setelah beberapa detik
window.onload = function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove('show');
            successAlert.style.display = 'none';
        }, 5000); // Ganti 5000 dengan waktu yang diinginkan dalam milidetik (5000ms = 5 detik)
    }
}
</script>
@endsection