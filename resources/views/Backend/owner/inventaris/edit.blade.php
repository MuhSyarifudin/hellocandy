@extends('Backend.main')

@section('title', 'Edit Inventaris')
@section('page', 'Edit Inventaris')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Inventaris</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div class="text-white text-capitalize ps-3 alert alert-success fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="product_id" class="form-label">Produk</label>
                        <select class="form-control border" id="product_id" name="product_id" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ $product->id == $inventory->product_id ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 border p-3 rounded">
                        <label for="quantity_change" class="form-label">Jumlah Perubahan Stok</label>
                        <input type="number" class="form-control border" id="quantity_change" name="quantity_change"
                            value="{{ $inventory->quantity_change }}" required>
                    </div>

                    <div class="mb-3 border p-3 rounded">
                        <label for="reason" class="form-label">Alasan Perubahan</label>
                        <input type="text" class="form-control border" id="reason" name="reason"
                            value="{{ $inventory->reason }}" required>
                    </div>

                    <div class="mb-3 border p-3 rounded">
                        <label for="date" class="form-label">Tanggal Perubahan</label>
                        <input type="datetime-local" class="form-control border" id="date" name="date"
                            value="{{ \Carbon\Carbon::parse($inventory->date)->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection