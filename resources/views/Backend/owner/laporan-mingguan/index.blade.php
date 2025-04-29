@extends('Backend.main')

@section('title', 'Laporan Mingguan')
@section('page', 'Manajemen Laporan Mingguan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Laporan Mingguan</h6>
                    <div class="text-start ps-3">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addReportModal">
                            <i class="fas fa-plus"></i> Tambah Laporan Mingguan Baru
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
                                    Laporan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Minggu
                                    Ke</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total
                                    Penjualan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total
                                    Pengeluaran</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeklyReports as $index => $weeklyReport)
                            <tr>
                                <td><span class="text-xs font-weight-bold">{{ $index + 1 }}</span></td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ $weeklyReport->report->report_name }}</span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ $weeklyReport->week_number }}</span></td>
                                <td><span class="text-xs font-weight-bold">Rp
                                        {{ number_format($weeklyReport->total_sales, 2, ',', '.') }}</span></td>
                                <td><span class="text-xs font-weight-bold">Rp
                                        {{ number_format($weeklyReport->total_expenses, 2, ',', '.') }}</span></td>
                                <td class="align-middle">
                                    <a href="{{ route('weekly-reports.edit', $weeklyReport->id) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('weekly-reports.destroy', $weeklyReport->id) }}"
                                        method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> <i
                                                class="fas fa-trash-alt"></i></button>
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

<!-- Modal untuk Tambah Laporan Mingguan Baru -->
<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportModalLabel">Tambah Laporan Mingguan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('weekly-reports.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_id" class="form-label">Pilih Laporan</label>
                        <select class="form-control border" id="report_id" name="report_id" required>
                            <option value="">Pilih Laporan</option>
                            @foreach($reports as $report)
                            <option value="{{ $report->id }}">{{ $report->report_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="week_number" class="form-label">Minggu Ke</label>
                        <input type="number" class="form-control border" id="week_number" name="week_number" min="1"
                            max="4" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_sales" class="form-label">Total Penjualan</label>
                        <input type="number" class="form-control border" id="total_sales" name="total_sales" step="0.01"
                            required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_expenses" class="form-label">Total Pengeluaran</label>
                        <input type="number" class="form-control border" id="total_expenses" name="total_expenses"
                            step="0.01" required>
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
    return confirm('Apakah Anda yakin ingin menghapus laporan ini?');
}

// Menyembunyikan alert setelah beberapa detik
window.onload = function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove('show');
            successAlert.style.display = 'none';
        }, 5000); // 5 detik
    }
}
</script>

@endsection