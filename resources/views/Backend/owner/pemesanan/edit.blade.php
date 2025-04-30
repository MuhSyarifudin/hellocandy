@extends('Backend.main')

@section('title', 'Edit Pesanan')
@section('page', 'Edit Pesanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Edit Pesanan</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('guest_orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Produk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kategori</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td colspan="4" class="font-weight-bold">{{ $category->category_name }}</td>
                                </tr>
                                @foreach($category->products as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td>Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                                    <td>
                                        @php
                                        $existingProduct = $order->products->where('id', $product->id)->first();
                                        $quantity = $existingProduct ? $existingProduct->pivot->quantity : 0;
                                        @endphp
                                        <input type="number" name="products[{{ $product->id }}][quantity]"
                                            value="{{ $quantity }}" min="0" max="{{ $product->stock }}" required>
                                        <input type="hidden" name="products[{{ $product->id }}][id]"
                                            value="{{ $product->id }}">
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-between px-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan
                            Perubahan</button>
                        <a href="{{ route('guest_orders.index') }}" class="btn btn-secondary"><i
                                class="fas fa-times"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection