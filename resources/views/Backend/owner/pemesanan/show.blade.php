@extends('Backend.main')

@section('title', 'Detail Pesanan')
@section('page', 'Detail Pesanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail Pesanan</h6>
                </div>
            </div>
            <div class="card-body px-4 pb-2">
                <!-- Gunakan Flexbox untuk sejajarkan kedua kolom -->
                <div class="d-flex justify-content-between mb-4">
                    <!-- Kolom 1: Informasi Pelanggan -->
                    <div class="col-md-3">
                        <h6>Informasi Pelanggan</h6>
                        <p><strong>Nama:</strong> {{ $order->partner->name ?? 'N/A' }}</p>
                        <p><strong>Nomor Telepon:</strong> {{ $order->partner->phone ?? 'N/A' }}</p>
                        <p><strong>Alamat:</strong> {{ $order->customer_address }}</p>
                    </div>

                    <!-- Kolom 2: Informasi Pesanan -->
                    <div class="col-md-3">
                        <h6>Informasi Pesanan</h6>
                        <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
                        <p><strong>Tanggal Pemesanan:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                        <p><strong>Status Pesanan:</strong>
                            <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p><strong>Metode Pembayaran:</strong>
                            @if($order->payment_methods_id)
                            @php
                            $paymentMethod = \App\Models\PaymentMethod::find($order->payment_methods_id);
                            @endphp
                            {{ $paymentMethod ? $paymentMethod->type : 'Tidak Diketahui' }}
                            @else
                            Tidak Diketahui
                            @endif
                        </p>
                        <p><strong>Status Pembayaran:</strong>
                            {{ $order->is_payment_complete ? 'Pembayaran Selesai' : 'Belum Dibayar' }}
                        </p>
                    </div>
                </div>

                <!-- Produk Pesanan -->
                <div class="table-responsive mb-4">
                    <h6>Produk dalam Pesanan</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>Rp {{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>Rp
                                    {{ number_format($product->pivot->price * $product->pivot->quantity, 2, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total Harga -->
                <div
                    class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-lg bg-primary text-white">
                    <h5 class="text-white">Total Harga</h5>
                    <h4 class="text-white">Rp {{ number_format($order->products->sum(function($product) {
                        return $product->pivot->price * $product->pivot->quantity;
                    }), 2, ',', '.') }}</h4>
                </div>


                <!-- Catatan Pelanggan -->
                @if($order->note)
                <div class="mb-4">
                    <h6>Catatan Pelanggan</h6>
                    <p>{{ $order->note }}</p>
                </div>
                @endif

                <!-- Tombol Kembali -->
                <a href="{{ route('guest_orders.index') }}" class="btn btn-primary">Kembali ke Daftar Pesanan</a>
            </div>
        </div>
    </div>
</div>

@endsection