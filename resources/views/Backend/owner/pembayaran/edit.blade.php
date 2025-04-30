@extends('Backend.main')

@section('title', 'Edit Metode Pembayaran')
@section('page', 'Edit Metode Pembayaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Metode Pembayaran</h6>
                </div>
            </div>
            <div class="card-body px-3 pb-2">
                @if (session('success'))
                <div id="success-alert" class="alert alert-success fade show text-white" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('payment_methods.update', $paymentMethod->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="method_name" class="form-label">Nama Metode Pembayaran</label>
                        <input type="text" name="method_name" id="method_name" class="form-control border"
                            value="{{ old('method_name', $paymentMethod->method_name) }}" required>
                        @error('method_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe Pembayaran</label>
                        <select name="type" id="type" class="form-control border" required>
                            <option value="DP 50%" {{ $paymentMethod->type == 'DP 50%' ? 'selected' : '' }}>DP 50%
                            </option>
                            <option value="Full" {{ $paymentMethod->type == 'Full' ? 'selected' : '' }}>Full</option>
                            <option value="QRIS" {{ $paymentMethod->type == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            <option value="Transfer" {{ $paymentMethod->type == 'Transfer' ? 'selected' : '' }}>Transfer
                            </option>
                        </select>
                        @error('type')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan
                            Perubahan</button>
                        <a href="{{ route('payment_methods.index') }}" class="btn btn-secondary"><i
                                class="fas fa-times"></i> Batal</a>
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
