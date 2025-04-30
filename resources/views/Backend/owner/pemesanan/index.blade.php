@extends('Backend.main')

@section('title', 'Daftar Pesanan Customer')
@section('page', 'Daftar Pesanan Customer')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Pesanan Customer</h6>
                    <div class="text-start ps-3">
                        <a href="{{ route('guest_orders.create') }}" class="btn btn-light"><i class="fas fa-plus"></i>
                            Buat
                            Pesanan Baru</a>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Order
                                        Number</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama
                                        Customer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Metode
                                        Pembayaran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total
                                        Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                        Payment
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status Pengerjaan
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Dibuat
                                        Pada</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guestOrders as $index => $order)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $order->order_number }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                        <form action="{{ route('guest_orders.update_partner', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group">
                                                <select name="partner_id" class="form-control form-control-sm"
                                                    onchange="this.form.submit()">
                                                    <!-- Jika tidak ada partner (N/A), tampilkan option dengan 'N/A' -->
                                                    @if(!$order->partner)
                                                    <option value="0" selected>N/A</option>
                                                    <!-- Default when no partner is selected -->
                                                    @else
                                                    <!-- Jika ada partner, tampilkan customer terkait -->
                                                    <option value="{{ $order->partner_id }}" selected>
                                                        {{ $order->partner->name }}
                                                    </option>
                                                    <option value="0">N/A</option> <!-- Allow change to N/A -->
                                                    @endif

                                                    <!-- Tampilkan daftar partner lain -->
                                                    @foreach($partners as $partner)
                                                    @if($partner->id !== $order->partner_id)
                                                    <!-- Jangan tampilkan partner yang sudah terpilih -->
                                                    <option value="{{ $partner->id }}">
                                                        {{ $partner->name }}
                                                    </option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-edit text-primary"></i>
                                                </span>
                                            </div>
                                        </form>
                                        </p>
                                    </td>
                                    <td>
                                        <form action="{{ route('guest_orders.update_payment_method', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group">
                                                <select name="payment_methods_id" class="form-control form-control-sm"
                                                    onchange="this.form.submit()">
                                                    <!-- Opsi Tidak Diketahui -->
                                                    <option value="0"
                                                        {{ !$order->payment_methods_id ? 'selected' : '' }}>
                                                        Tidak Diketahui</option>

                                                    <!-- Opsi Metode Pembayaran dari daftar PaymentMethods -->
                                                    @foreach($paymentMethods as $method)
                                                    <option value="{{ $method->id }}"
                                                        {{ $order->payment_methods_id == $method->id ? 'selected' : '' }}>
                                                        {{ $method->type }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-edit text-primary"></i>
                                                </span>
                                            </div>
                                        </form>

                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($order->products->sum(function($product) {
                                        return $product->pivot->price * $product->pivot->quantity;
                                    }), 2, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-sm {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('guest_orders.update_payment_status', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group">
                                                <select name="is_payment_complete" class="form-control form-control-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="0"
                                                        {{ !$order->is_payment_complete ? 'selected' : '' }}>
                                                        Belum Dibayar</option>
                                                    <option value="1"
                                                        {{ $order->is_payment_complete ? 'selected' : '' }}>
                                                        Pembayaran Selesai</option>
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-edit text-primary"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('guest_orders.update_processing_status', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group">
                                                <select name="is_processing_complete"
                                                    class="form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="0"
                                                        {{ !$order->is_processing_complete ? 'selected' : '' }}>Belum
                                                        Dikerjakan</option>
                                                    <option value="1"
                                                        {{ $order->is_processing_complete ? 'selected' : '' }}>
                                                        Pengerjaan
                                                        Selesai</option>
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-edit text-primary"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $order->created_at->format('d-m-Y H:i') }}
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('guest_orders.show', $order->id) }}"
                                            class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>
                                        @if ($role !== 'kasir')
                                        <a href="{{ route('guest_orders.edit', $order->id) }}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                        <form action="{{ route('guest_orders.destroy', $order->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirmDelete();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>

                                        @endif
                                        <a href="{{ route('guest_orders.nota', $order->id) }}"
                                            class="btn btn-sm btn-secondary"> <i class="fas fa-print"></i> Cetak
                                            Nota</a>

                                    </td>
                                </tr>
                                @endforeach
                                @if($guestOrders->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">Tidak ada data pesanan.</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $guestOrders->links() }}
                        <!-- Ini menambahkan tombol untuk navigasi -->
                    </div>
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
        return confirm('Apakah Anda yakin ingin menghapus mitra ini?');
    }
    </script>

    @endsection