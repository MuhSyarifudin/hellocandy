@extends('Backend.main')

@section('title', 'Edit Detail Laporan')
@section('page', 'Edit Detail Laporan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Detail Laporan</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('reports.update', $reportDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_id" class="form-label">ID Laporan</label>
                        <input type="number" class="form-control border" id="report_id" name="report_id"
                            value="{{ old('report_id', $reportDetail->report_id) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_sales" class="form-label">Total Penjualan</label>
                        <input type="number" class="form-control border" id="total_sales" name="total_sales"
                            value="{{ old('total_sales', $reportDetail->total_sales) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_expenses" class="form-label">Total Pengeluaran</label>
                        <input type="number" class="form-control border" id="total_expenses" name="total_expenses"
                            value="{{ old('total_expenses', $reportDetail->total_expenses) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="period_start" class="form-label">Periode Mulai</label>
                        <input type="datetime-local" class="form-control border" id="period_start" name="period_start"
                            value="{{ old('period_start', \Carbon\Carbon::parse($reportDetail->period_start)->format('Y-m-d\TH:i')) }}"
                            required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="period_end" class="form-label">Periode Akhir</label>
                        <input type="datetime-local" class="form-control border" id="period_end" name="period_end"
                            value="{{ old('period_end', \Carbon\Carbon::parse($reportDetail->period_end)->format('Y-m-d\TH:i')) }}"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection