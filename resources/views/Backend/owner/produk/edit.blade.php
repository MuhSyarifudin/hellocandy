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
                @if (session('success'))
                <div id="success-alert" class="alert alert-success fade show text-white" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="price" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control border" id="price" name="price"
                            value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="purchase_price" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control border" id="purchase_price" name="purchase_price"
                            value="{{ old('purchase_price', $product->purchase_price) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control border" id="stock" name="stock"
                            value="{{ old('stock', $product->stock) }}" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="unit" class="form-label">Satuan</label>
                        <select class="form-control border" id="unit" name="unit" required>
                            <option value="">Pilih Jenis Satuan</option>
                            <option value="pcs" {{ 'pcs' == $product->unit ? 'selected' : '' }}>Pcs</option>
                            <option value="set" {{ 'set' == $product->unit ? 'selected' : '' }}>Set</option>
                            <option value="box" {{ 'box' == $product->unit ? 'selected' : '' }}>Box</option>
                            <option value="tangkai" {{ 'tangkai' == $product->unit ? 'selected' : '' }}>Tangkai</option>
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control border" id="description" name="description"
                            rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control border" id="image" name="image" accept="image/*">
                        <div id="imageFeedback" class="mt-2"></div> <!-- Area untuk peringatan -->
                    </div>
                    @if($product->image)
                    <div class="mt-3">
                        <p class="fw-bold">Gambar Saat Ini:</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar {{ $product->product_name }}"
                            class="img-fluid rounded shadow" style="max-width: 200px;">
                    </div>
                    @endif
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i>
                            Batal</a>
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


document.getElementById('image').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var feedback = document.getElementById('imageFeedback');

    // Reset feedback sebelumnya
    feedback.innerHTML = '';

    if (file) {
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif',
            'image/svg+xml'
        ]; // Jenis gambar yang diterima
        var maxSize = 2 * 1024 * 1024; // Maksimum ukuran gambar 2MB

        // Mengecek apakah tipe file sesuai dengan yang diharapkan
        if (!allowedTypes.includes(file.type)) {
            feedback.innerHTML =
                '<span class="text-danger">Hanya file gambar (JPEG, PNG, JPG, GIF, SVG) yang diperbolehkan.</span>';
        }
        // Mengecek apakah ukuran file lebih besar dari batas maksimum
        else if (file.size > maxSize) {
            feedback.innerHTML = '<span class="text-danger">Ukuran gambar terlalu besar. Maksimum 2MB.</span>';
        } else {
            feedback.innerHTML = '<span class="text-success">Gambar valid!</span>';
        }
    }
});
</script>


@endsection