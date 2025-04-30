@extends('Backend.main')

@section('title', 'Edit Penjualan')
@section('page', 'Edit Penjualan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Penjualan</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div id="success-alert" class="alert alert-success fade show text-white" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control border" id="date" name="date"
                            value="{{ old('date', $sale->date) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_amount" class="form-label">Total Penjualan (Rp)</label>
                        <input type="number" class="form-control border" id="total_amount" name="total_amount"
                            value="{{ old('total_amount', $sale->total_amount) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="payment_method_id" class="form-label">Metode Pembayaran</label>
                        <select class="form-control border" id="payment_method_id" name="payment_method_id" required>
                            <option value="" disabled>Pilih Metode Pembayaran</option>
                            @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}"
                                {{ old('payment_method_id', $sale->payment_method_id) == $method->id ? 'selected' : '' }}>
                                {{ $method->type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="user_id" class="form-label">Kasir</label>
                        <input type="text" class="form-control border" value="{{ $sale->user->username }}" readonly>
                        <input type="hidden" id="user_id" name="user_id" value="{{ $sale->user_id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i>
                            Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
</script>
@endsection