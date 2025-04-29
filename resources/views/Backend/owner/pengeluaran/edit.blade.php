@extends('Backend.main')

@section('title', 'Edit Pengeluaran')
@section('page', 'Edit Pengeluaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Pengeluaran</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Menggunakan PUT atau PATCH untuk metode update -->

                        <div class="mb-3 border p-3 rounded">
                            <label for="expense_name" class="form-label">Nama Pengeluaran</label>
                            <input type="text" class="form-control border" id="expense_name" name="expense_name"
                                value="{{ old('expense_name', $expense->expense_name) }}" required>
                        </div>

                        <div class="mb-3 border p-3 rounded">
                            <label for="amount" class="form-label">Jumlah Pengeluaran</label>
                            <input type="number" step="0.01" class="form-control border" id="amount" name="amount"
                                value="{{ old('amount', $expense->amount) }}" required>
                        </div>

                        <div class="mb-3 border p-3 rounded">
                            <label for="date" class="form-label">Tanggal Pengeluaran</label>
                            <input type="datetime-local" class="form-control border" id="date" name="date"
                                value="{{ old('date', $expense->date->format('d-m-Y\H:i')) }}" required>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection