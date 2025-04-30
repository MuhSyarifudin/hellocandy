@extends('Backend.main')

@section('title', 'Edit Mitra')
@section('page', 'Edit Mitra')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Mitra</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div id="success-alert" class="alert alert-success fade show text-white" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <div class="table-responsive p-0">
                    <form action="{{ route('partners.update', $partner->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 border p-3 rounded">
                            <label for="name" class="form-label">Nama Mitra</label>
                            <input type="text" class="form-control border" id="name" name="name"
                                value="{{ old('name', $partner->name) }}" required>
                        </div>
                        <div class="mb-3 border p-3 rounded">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control border" id="phone" name="phone"
                                value="{{ old('phone', $partner->phone) }}" required>
                        </div>
                        <div class="mb-3 border p-3 rounded">
                            <label for="type" class="form-label">Tipe Mitra</label>
                            <select class="form-control border" id="type" name="type" required>
                                <option value="">Pilih Tipe </option>
                                <option value="supplier" {{ $partner->type == 'supplier' ? 'selected' : '' }}>Supplier
                                </option>
                                <option value="customer" {{ $partner->type == 'customer' ? 'selected' : '' }}>Customer
                                </option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <a href="{{ route('partners.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-times"></i> Batal</a>
                        </div>
                    </form>
                </div>
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
