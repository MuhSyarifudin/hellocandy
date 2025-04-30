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
                        @if ($role !== 'kasir')
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createProductModal">
                            <i class="fas fa-plus"></i> Tambah Produk Baru
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (session('success'))
                <div id="success-alert" class="alert alert-success fade show text-white" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gambar
                                    Produk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Produk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga
                                </th>
                                @if ($role !== 'kasir')
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga
                                    Beli</th>
                                @endif
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Satuan
                                </th>
                                @if ($role !== 'kasir')
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Keuntungan (%)</th>
                                @endif
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
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->product_name }}" width="70" class="img-thumbnail">
                                    @else
                                    <span class="text-secondary text-xs">Tidak ada gambar</span>
                                    @endif
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
                                @if ($role !== 'kasir')
                                <td><span class="text-xs font-weight-bold">Rp
                                        {{ number_format($product->purchase_price, 2, ',', '.') }}</span></td>
                                @endif
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $product->stock }} / Qty</span>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ $product->unit }}</span></td>
                                @if ($role !== 'kasir')
                                <td>
                                    @if($product->purchase_price > 0)
                                    <span class="text-xs font-weight-bold">
                                        {{ number_format((($product->price - $product->purchase_price) / $product->purchase_price) * 100, 2, ',', '.') }}
                                        %
                                    </span>
                                    @else
                                    <span class="text-xs text-danger">N/A</span>
                                    @endif
                                </td>
                                @endif
                                <td class="align-middle">
                                    @if ($role !== 'kasir')
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info"> <i
                                            class="fas fa-eye"></i> Show</a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary"> <i
                                            class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i>
                                            Delete</button>
                                    </form>
                                    @else
                                    <span>Tidak ada Aksi</span>
                                    @endif
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
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="price" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control border" id="price" name="price" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="purchase_price" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control border" id="purchase_price" name="purchase_price"
                            required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control border" id="stock" name="stock" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="unit" class="form-label">Satuan</label>
                        <select class="form-control border" id="unit" name="unit" required>
                            <option value="">Pilih Jenis Satuan</option>
                            <option value="pcs">Pcs</option>
                            <option value="set">Set</option>
                            <option value="box">Box</option>
                            <option value="tangkai">Tangkai</option>
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control border" id="image" name="image" accept="image/*">
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control border" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                                class="fas fa-times"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Konfirmasi Penghapusan -->
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

function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus produk ini?');
}
</script>


@endsection