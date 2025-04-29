@extends('Backend.main')

@section('title', 'Edit Laporan Mingguan')
@section('page', 'Edit Laporan Mingguan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Laporan Mingguan</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div class="alert alert-success fade show" role="alert" id="successAlert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form action="{{ route('weekly-reports.update', $weeklyReport->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_id" class="form-label">Pilih Laporan</label>
                        <select class="form-control border" id="report_id" name="report_id" required>
                            <option value="">Pilih Laporan</option>
                            @foreach($reports as $report)
                            <option value="{{ $report->id }}"
                                {{ $report->id == $weeklyReport->report_id ? 'selected' : '' }}>
                                {{ $report->report_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="week_number" class="form-label">Minggu Ke</label>
                        <input type="number" class="form-control border" id="week_number" name="week_number" min="1"
                            max="4" value="{{ $weeklyReport->week_number }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_sales" class="form-label">Total Penjualan</label>
                        <input type="number" class="form-control border" id="total_sales" name="total_sales" step="0.01"
                            value="{{ $weeklyReport->total_sales }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_expenses" class="form-label">Total Pengeluaran</label>
                        <input type="number" class="form-control border" id="total_expenses" name="total_expenses"
                            step="0.01" value="{{ $weeklyReport->total_expenses }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('weekly-reports.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Menyembunyikan alert setelah beberapa detik -->
<script>
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