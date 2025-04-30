@extends('Backend.main')

@section('title', 'Buat Pesanan Baru')
@section('page', 'Buat Pesanan Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Buat Pesanan Baru</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('guest_orders.store') }}" method="POST">
                    @csrf
                    <!-- Order Number dan Total Harga -->
                    <div class="d-flex justify-content-between mb-4 px-4">
                        <div class="form-group" style="flex: 1; margin-right: 10px;">
                            <label for="order_number" class="form-label">Order Number</label>
                            <input type="text" class="form-control" id="order_number"
                                value="{{ 'ORD' . strtoupper(uniqid()) }}" readonly>
                        </div>
                        <div class="form-group" style="flex: 1; margin-left: 10px;">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_price" value="Rp 0,00" readonly>
                        </div>
                    </div>

                    <!-- Pencarian Produk -->
                    <div class="d-flex justify-content-between mb-4 px-4 align-items-center">
                        <input type="text" id="search_product" class="form-control"
                            placeholder="Cari Produk berdasarkan Nama atau Kategori..."
                            style="width: 50%; margin-right: 10px; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                        <!-- Tombol Aksi -->
                        <div>
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-plus"></i> Buat
                                Pesanan</button>
                            <a href="{{ route('guest_orders.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-times"></i> Batal</a>
                        </div>
                    </div>

                    <!-- Produk Berdasarkan Kategori -->
                    @php
                    $colors = ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#d35400'];
                    @endphp

                    @foreach($categories as $index => $category)
                    <div class="category-section mb-4">
                        <h5 class="category-title">
                            <span class="badge badge-pill text-white px-3 py-2"
                                style="background-color: {{ $colors[$index % count($colors)] }};">
                                {{ $category->category_name }}
                            </span>
                        </h5>

                        @if($category->products->count() > 0)
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            @foreach($category->products as $product)
                            <div class="col product-item" data-category="{{ strtolower($category->category_name) }}">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->product_name }}</h5>
                                        <p class="card-text">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                                        <p class="text-muted">Stok: {{ $product->stock }}</p>

                                        <!-- Input Quantity -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <input type="number" name="products[{{ $product->id }}][quantity]"
                                                class="form-control product-quantity" min="0"
                                                max="{{ $product->stock }}" value="0" data-price="{{ $product->price }}"
                                                data-product-id="{{ $product->id }}" onchange="updateTotal()">
                                            <span id="total-price-{{ $product->id }}" class="total-price">Rp 0,00</span>
                                        </div>
                                        <input type="hidden" name="products[{{ $product->id }}][id]"
                                            value="{{ $product->id }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="card bg-light text-center p-4 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold text-muted"><i class="fas fa-box-open"></i> Tidak ada produk dalam
                                    kategori ini.</h5>
                                <p class="text-muted">Silakan pilih kategori lain atau cek kembali nanti.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </form> <!-- Ini adalah posisi yang benar untuk menutup form -->
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Perhitungan Total Harga -->
<script>
// Menghilangkan alert setelah 5 detik
setTimeout(() => {
    const alert = document.getElementById('success-alert');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 5000);

// Fungsi untuk menghitung total harga keseluruhan
function updateTotal() {
    const quantities = document.querySelectorAll('.product-quantity');
    const totalPriceElement = document.getElementById('total_price');
    let grandTotal = 0;

    quantities.forEach(function(input) {
        const quantity = parseInt(input.value) || 0;
        const price = parseFloat(input.getAttribute('data-price')) || 0;
        const totalPrice = quantity * price;

        // Update harga produk per item
        const productId = input.getAttribute('data-product-id');
        const totalPriceElement = document.getElementById('total-price-' + productId);
        totalPriceElement.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID', {
            minimumFractionDigits: 2
        });

        // Tambahkan ke total harga
        if (quantity > 0) {
            grandTotal += totalPrice;
        }
    });

    // Update total keseluruhan
    totalPriceElement.value = 'Rp ' + grandTotal.toLocaleString('id-ID', {
        minimumFractionDigits: 2
    });
}

// Pencarian produk berdasarkan nama atau kategori
document.getElementById('search_product').addEventListener('input', function(event) {
    const searchQuery = event.target.value.toLowerCase();
    const productItems = document.querySelectorAll('.product-item');

    productItems.forEach(function(item) {
        const productName = item.querySelector('.card-title').textContent.toLowerCase();
        const productCategory = item.getAttribute('data-category').toLowerCase();

        if (productName.includes(searchQuery) || productCategory.includes(searchQuery)) {
            item.style.display = 'block'; // Tampilkan produk yang cocok
        } else {
            item.style.display = 'none'; // Sembunyikan produk yang tidak cocok
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    updateTotal();
});
</script>

@endsection