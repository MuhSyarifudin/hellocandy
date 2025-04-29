@extends('Backend.main')

@section('title', 'Edit Laporan Harian')
@section('page', 'Edit Laporan Harian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Laporan Harian</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('daily-reports.update', $report->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_name" class="form-label">Nama Laporan</label>
                        <input type="text" class="form-control border" id="report_name" name="report_name"
                            value="{{ old('report_name', $report->report_name) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="report_date" class="form-label">Tanggal Laporan</label>
                        <input type="datetime-local" class="form-control border" id="report_date" name="report_date"
                            value="{{ old('report_date', $report->report_date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control border" id="status" name="status" required>
                            <option value="draft" {{ $report->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="diterbitkan" {{ $report->status == 'diterbitkan' ? 'selected' : '' }}>
                                Diterbitkan</option>
                            <option value="arsip" {{ $report->status == 'arsip' ? 'selected' : '' }}>Arsip</option>
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control border" id="note" name="note"
                            rows="3">{{ old('note', $report->note) }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('daily-reports.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection