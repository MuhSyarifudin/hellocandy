@extends('Backend.main')

@section('title', 'Laporan Bulanan')
@section('page', 'Manajemen Laporan Bulanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Laporan Bulanan</h6>
                    <div class="text-start ps-3">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addReportModal">
                            <i class="fas fa-plus"></i> Tambah Laporan Bulanan Baru
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
                                    Laporan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                    Laporan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipe
                                    Laporan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat
                                    Oleh</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $index => $report)
                            <tr>
                                <td><span class="text-xs font-weight-bold">{{ $index + 1 }}</span></td>
                                <td><span class="text-xs font-weight-bold">{{ $report->report_name }}</span></td>
                                <td><span class="text-xs font-weight-bold">
                                        <span class="badge
                        @if($report->status == 'draft') bg-warning
                        @elseif($report->status == 'diterbitkan') bg-success
                        @elseif($report->status == 'arsip') bg-danger @endif">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </span></td>
                                <td><span
                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($report->report_date)->format('d M Y, H:i') }}</span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ $report->report_type }}</span></td>
                                <td><span class="text-xs font-weight-bold">{{ $report->user->nama }}</span></td>
                                <td class="align-middle">
                                    <a href="{{ route('daily-reports.show', $report->id) }}" class="btn btn-info"><i
                                            class="fas fa-eye"></i> Show</a>
                                    @if ($role !== 'kasir')
                                    <a href="{{ route('daily-reports.edit', $report->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('daily-reports.destroy', $report->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> <i class="fas fa-trash-alt"></i>
                                            Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">

                    <!-- Ini menambahkan tombol untuk navigasi -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Laporan Baru -->
<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary ">
                <h5 class="modal-title text-white text-capitalize ps-3 " id="addReportModalLabel">Tambah Laporan Bulan
                    Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('daily-reports.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_date" class="form-label">Tanggal Laporan</label>
                        <input type="datetime-local" class="form-control border" id="report_date" name="report_date"
                            required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_name" class="form-label">Nama Laporan</label>
                        <input type="text" class="form-control border" id="report_name" name="report_name" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_type" class="form-label">Tipe Laporan</label>
                        <select class="form-control border" id="report_type" name="report_type" required>
                            <option value="" {{ old('report_type') == '' ? 'selected' : '' }}>Pilih Tipe Laporan
                            </option>
                            <option value="weekly" {{ old('report_type') == 'weekly' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="monthly" {{ old('report_type') == 'monthly' ? 'selected' : '' }}>Bulanan
                            </option>
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control border" id="status" name="status" required>
                            <option value="" {{ old('status') == 'draft' ? 'selected' : '' }}>Pilih Status</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Diterbitkan
                            </option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Arsip</option>
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control border" id="note" name="note" rows="3"></textarea>
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
    return confirm('Apakah Anda yakin ingin menghapus laporan ini?');
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
