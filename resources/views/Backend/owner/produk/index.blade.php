@extends('Backend.main')

@section('title', 'Produk')
@section('page', 'Daftar Produk')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Produk</h6>
                    <div class="text-start ps-3">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createProductModal">
                            Tambah Produk
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Produk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Deskripsi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                            <tr>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $product->product_name }}</span>
                                </td>
                                <td>
                                    <span
                                        class="text-xs font-weight-bold">{{ $product->category->category_name }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">Rp
                                        {{ number_format($product->price, 2, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $product->stock }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $product->description ?? '-' }}</span>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Produk -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary ">
                <h5 class="modal-title text-white text-capitalize ps-3 " id="createProductModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="product_name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control border" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-control border" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control border" id="price" name="price" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control border" id="stock" name="stock" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control border" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Konfirmasi Penghapusan -->
<script>
function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus produk ini?');
}
</script>
@endsection
