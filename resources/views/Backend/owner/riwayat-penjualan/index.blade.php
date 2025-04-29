@extends('Backend.main')

@section('title', 'List Riwayat Penjualan')
@section('page', 'List Riwayat Penjualan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">List Riwayat Penjualan</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Penjualan</th>
                                <th>Nama Produk</th>
                                <th>Jumlah Produk</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesDetails as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->sale_id }}</td>
                                <td>{{ $detail->product->product_name }}</td>
                                <td>{{ $detail->quantity }} Qty</td>
                                <td>Rp {{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
