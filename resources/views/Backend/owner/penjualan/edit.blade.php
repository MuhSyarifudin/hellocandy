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
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Menambahkan metode PUT untuk pembaruan -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" id="date" name="date" value="{{ $sale->date}}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Total Penjualan (Rp)</label>
                        <input type="number" class="form-control" id="total_amount" name="total_amount"
                            value="{{ $sale->total_amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="" disabled>Pilih Metode Pembayaran</option>
                            <option value="cash" {{ $sale->payment_method == 'cash' ? 'selected' : '' }}>Tunai</option>
                            <option value="card" {{ $sale->payment_method == 'card' ? 'selected' : '' }}>Kartu Kredit
                            </option>
                            <option value="e-wallet" {{ $sale->payment_method == 'e-wallet' ? 'selected' : '' }}>
                                E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Kasir</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $sale->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection