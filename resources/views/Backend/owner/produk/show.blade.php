@extends('Backend.main')

@section('title', 'Detail Produk')
@section('page', 'Detail Produk')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail Produk</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                            class="img-fluid rounded" style="max-width: 100%; height: 400px;">
                        @else
                        <span class="text-secondary">Tidak ada gambar</span>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $product->product_name }}</h4>
                        <p><strong>Kategori:</strong> {{ $product->category->category_name }}</p>
                        <p><strong>Harga Jual:</strong> Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                        <p><strong>Harga Beli:</strong> Rp {{ number_format($product->purchase_price, 2, ',', '.') }}
                        </p>
                        <p><strong>Stok:</strong> {{ $product->stock }}</p>
                        <p><strong>Satuan:</strong> {{ $product->unit }}</p>
                        <p><strong>Keuntungan:</strong>
                            @if($product->purchase_price > 0)
                            {{ number_format((($product->price - $product->purchase_price) / $product->purchase_price) * 100, 2, ',', '.') }}
                            %
                            @else
                            N/A
                            @endif
                        </p>
                        <p><strong>Deskripsi:</strong></p>
                        <p>{{ $product->description }}</p>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection