@extends('Backend.main')

@section('title', 'Edit Produk')
@section('page', 'Edit Produk')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Produk</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 border p-3 rounded">
                        <label for="product_name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control border" id="product_name" name="product_name"
                            value="{{ old('product_name', $product->product_name) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-control border" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control border" id="price" name="price"
                            value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control border" id="stock" name="stock"
                            value="{{ old('stock', $product->stock) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control border" id="description" name="description"
                            rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
