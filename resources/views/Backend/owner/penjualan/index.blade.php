@extends('Backend.main')

@section('title', 'Sales')
@section('page', 'List Penjualan')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Daftar Penjualan</h6>
                    <div class="text-start ps-3">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createSaleModal">
                            <i class="fas fa-plus"></i> Tambah Penjualan
                        </button>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Total Penjualan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Metode
                                    Pembayaran</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pesanan
                                    Pelanggan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kasir
                                </th>
                                @if ($role !== 'kasir')
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Action
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through sales data -->
                            @foreach($sales as $index => $sale)
                            <!-- Menambahkan $index untuk nomor urut -->
                            <tr class="ml-2">
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $index + 1 }}</span>
                                    <!-- Menampilkan nomor urut -->
                                </td>
                                <td>
                                    <span
                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($sale->date)->format('d M Y, H:i') }}</span>
                                    <!-- Format tanggal -->
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">Rp
                                        {{ number_format($sale->total_amount, 2, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span
                                        class="text-xs font-weight-bold">{{ optional($sale->paymentMethod)->type ?? 'Tidak Diketahui' }}</span>
                                </td>
                                <td>
                                    @if ($sale->guestOrders->isNotEmpty())
                                    <ul>
                                        @foreach ($sale->guestOrders as $order)
                                        <li>{{ $order->order_number }} - <strong>Status:</strong> {{ $order->status }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <span class="text-muted">Tidak ada pesanan pelanggan</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $sale->user->username }}</span>
                                    <!-- Assuming you have a relationship -->
                                </td>
                                @if ($role !== 'kasir')
                                <td class="align-middle">
                                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-secondary"
                                        data-toggle="tooltip" data-original-title="Edit Sale"><i
                                            class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                            data-original-title="Delete Sale"><i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $sales->links() }}
                    <!-- Ini menambahkan tombol untuk navigasi -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Penjualan -->
<div class="modal fade" id="createSaleModal" tabindex="-1" aria-labelledby="createSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary ">
                <h5 class="modal-title text-white text-capitalize ps-3 " id="createSaleModalLabel">Tambah Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 border p-3 rounded">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control border" id="date" name="date" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="total_amount" class="form-label">Total Penjualan</label>
                        <input type="number" class="form-control border" id="total_amount" name="total_amount" required>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="payment_method_id" class="form-label">Metode Pembayaran</label>
                        <select class="form-control border" id="payment_method_id" name="payment_method_id" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="guest_order_id" class="form-label">Pesanan Tamu</label>
                        <select class="form-control border" id="guest_order_id" name="guest_order_id">
                            <option value="">Pilih Pesanan Tamu </option>
                            @foreach($guestOrders as $order)
                            <option value="{{ $order->id }}">{{ $order->order_number }} - Status: {{ $order->status }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 border p-3 rounded">
                        <label for="user_id" class="form-label">Kasir</label>
                        <input type="text" class="form-control border" value="{{ auth()->user()->username }}" readonly>
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
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
function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus penjualan ini?');
}

// Menghilangkan alert setelah 5 detik
setTimeout(() => {
    const alert = document.getElementById('success-alert');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500); // Hapus dari DOM
    }
}, 5000);
</script>
@endsection